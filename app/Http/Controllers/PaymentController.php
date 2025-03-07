<?php

namespace App\Http\Controllers;

use App\Models\Arma_Card;
use App\Models\Bell;
use App\Models\Book;
use App\Models\organization;
use App\Models\ProvisionalData;
use App\Services\MyFatoorahService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessNotification;
use App\Models\balance;
use App\Models\CardType;
use App\Models\FinancialTransactions;
use App\Models\promotionalCard;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $myFatoorahService;

    public function __construct(MyFatoorahService $myFatoorahService)
    {
        $this->myFatoorahService = $myFatoorahService;
    }

    public function initiatePayment(Request $request)
    {
        $validated = $request->validate([
            'customerName' => 'required|string',
            'notificationOption' => 'required|string',
            'invoiceValue' => 'required|numeric',
            'currentUserId' => 'required|numeric',
            'cardsDetailes' => 'required',
            'currency' => 'required',
            'account_type' => 'required|in:user,User,organization',
            'purchase_id' => 'nullable',
        ]);


        $uniqueDataId = rand(1000, 9999);

        $cardsDetailes = $request->cardsDetailes;

        $ProvisionalData = ProvisionalData::create([
            'uniqueId' => $uniqueDataId,
            'cardsDetailes' => $cardsDetailes,
            'purchase_id' => null,
            'expire_at' => now()->addMinute(60)
        ]);

        if ($request->has('purchase_id')) {
            $ProvisionalData->purchase_id = $request->purchase_id;
        }

        $ProvisionalData->save();

        $data = [
            'InvoiceValue' => $validated['invoiceValue'],
            'currency' => $validated['currency'],
            'cardsDetailesId' => $uniqueDataId,
            'CustomerName' => $validated['customerName'],
            'currentUserId' => $validated['currentUserId'],
            'accountType' => $validated['account_type'],
            'NotificationOption' => $validated['notificationOption'],
            'Language' => 'EN', // يمكن ضبطها إلى AR إذا كانت باللغة العربية
            'CustomerEmail' => $request->input('customerEmail'),
        ];


        $response = $this->myFatoorahService->sendPayment($data);

        return response()->json($response);
    }


    public function initiatebookedPayment(Request $request)
    {
        $validated = $request->validate([
            'customerName' => 'required|string|max:255',
            'notificationOption' => 'required|string|max:50',
            'invoiceValue' => 'required|numeric|min:0',
            'currentUserId' => 'required|numeric',
            'customerEmail' => 'required|email|max:255',
            'book_day' => 'required|date',
            'book_time' => 'required',
            'expire_in' => 'required',
          'currency' => 'required',
            'additional_notes' => 'nullable|string|max:500',
            'user_id' => 'required|numeric',
            'organization_id' => 'required|numeric',
            'account_type' => 'required|in:user,User,organization,Organization'
        ]);

        $uniqueDataId = rand(1000, 9999);


        $bookData = [
            'book_day' => $validated['book_day'],
            'book_time' => $validated['book_time'],
            'expire_in' => $validated['expire_in'],
            'additional_notes' => $validated['additional_notes'],
            'user_id' => $validated['user_id'],
            'organization_id' => $validated['organization_id'],
        ];



        $data = [
            'InvoiceValue' => $validated['invoiceValue'],
            'CustomerName' => $validated['customerName'],
            'currentUserId' => $validated['currentUserId'],
            'accountType' => $validated['account_type'],
            'NotificationOption' => $validated['notificationOption'],
            'CustomerEmail' => $validated['customerEmail'],
            'uniqueDataId' => $uniqueDataId,
          'currency' => $validated['currency'],
            'Language' => 'EN', // يمكن ضبطها إلى AR إذا كانت باللغة العربية
        ];

        ProvisionalData::create([
            'uniqueId' => $uniqueDataId,
            'cardsDetailes' => json_encode($bookData),
            'expire_at' => now()->addMinute(60)
        ]);

        $response = $this->myFatoorahService->bookedPayment($data);

        return response()->json($response);
    }


    public function handleCallback(Request $request)
    {
        try {
            $paymentId = $request->query('paymentId');
            $accountType = $request->query('accountType');
            $cardsDetailesId = base64_decode($request->query('cardsDetailesId'));
            $userId = base64_decode($request->query('UserId'));
            $Amount = $request->query('InvoiceValue');
            $model = ProvisionalData::where('uniqueId', $cardsDetailesId)->first();
            $purchase_id = $model ? $model->purchase_id : null; // التأكد من وجود الـ model قبل الحصول على purchase_id

            // Check For Errors
            if (!$paymentId) {
                return response()->json(['message' => 'Payment ID is missing.']);
            }

            if (!$cardsDetailesId) {
                return response()->json(['message' => 'Card details ID is missing.']);
            }

            if (!$model) {
                return response()->json(['message' => 'No provisional data found for the provided card details ID.']);
            }

            $jsoncardsDetailes = json_decode($model->cardsDetailes);

            $response = $this->myFatoorahService->getPaymentStatus($paymentId);

            // End Check For variables Errors

            if ($response['IsSuccess'] && $response['Data']['InvoiceStatus'] === 'Paid') {
                try {
                    $cardsToInsert = [];
                    $cards = [];
                    foreach ($jsoncardsDetailes as $card) {
                        for ($i = 0; $i < $card->quantity; $i++) {
                            $cardsToInsert[] = [
                                'user_id' => $userId,
                                'card_number' => null,
                                'price' => $card->price,
                                'issue_date' => $card->duration,
                                'expiry_date' => null,
                                'cvv' => null,
                                'cardtype_id' => $card->id,
                            ];
                        }
                        $cards[] = ["id" => $card->id, "quantity" => $card->quantity];
                    }

                    // في حال عدم وجود purchase_id، استمر في العمليات التالية


                    // استمر في إدراج البطائق حتى في حالة غياب purchase_id
                    if (Arma_Card::insert($cardsToInsert)) {
                        $bell =  Bell::create([
                            'bell_items' => json_encode($jsoncardsDetailes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT),
                            'bell_type' => 'cards_bell',
                            'account_type' => $accountType,
                            'amount' => floatval($Amount),
                            'user_id' => intval($userId)
                        ]);
                        $bell->save();

                        if ($purchase_id  &&  $bell) {
                            $Purchase = Purchase::where('uniqId', $purchase_id)->first();
                            if ($Purchase) {
                                $Purchase->status = 'completed';
                                $Purchase->bell_id = $bell->id;
                                $Purchase->save();
                            }
                            $cardIds = array_column($cards, 'id');
                            $cardsFounded = CardType::whereIn('id', $cardIds)->get();
                            $promotionalCardsToInsert = [];
                            foreach ($cardsFounded as $cardType) {
                                foreach ($cards as $card) {
                                    if ($card['id'] == $cardType->id) {
                                        $cardType->number_of_promotional_purchases += $card['quantity'];
                                        $cardType->save();

                                        $promotionalCardsToInsert[] = [
                                            'card_id' => $card['id'],
                                            'bell_id' => $bell->id,
                                            'promoter_code' => $Purchase->promo_code,
                                            'order_quantity' => $card['quantity'],
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ];

                                        break; // لا داعي لمواصلة البحث بعد التحديث
                                    }
                                }
                            }

                            if (!empty($promotionalCardsToInsert)) {
                                promotionalCard::insert($promotionalCardsToInsert);
                            } else {
                                return response()->json(['message' => 'no cards.'], 400);
                            }
                        }
                    }

                    $model->delete();
                    return redirect()->to('https://aram-gulf.com/success?transactionId=' . $paymentId);
                } catch (\Exception $e) {
                    return response()->json([
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                return redirect()->to('https://aram-gulf.com/paymenterror');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }




    public function bookedPayment(Request $request)
    {
        try {
            $paymentId = $request->query('paymentId');
            $accountType = $request->query('accountType');
            $Amount = $request->query('InvoiceValue');
            $uniqueDataId = $request->query('uniqueDataId');



            // التحقق من المتغيرات الأساسية
            if (!$paymentId) {
                return response()->json(['message' => 'Payment ID is missing.'], 400);
            }

            if (!$uniqueDataId) {
                return response()->json(['message' => 'Invalid uniqueDataId.'], 400);
            }


            $response = $this->myFatoorahService->getPaymentStatus($paymentId);
            $model = ProvisionalData::where('uniqueId', $uniqueDataId)->first();
            $data = json_decode($model->cardsDetailes);


            // End Check For variables Errors

            if ($response['IsSuccess'] && $response['Data']['InvoiceStatus'] === 'Paid') {

                Book::create([
                    'book_day' => $data->book_day,
                    'book_time' => $data->book_time,
                    'expire_in' => $data->expire_in,
                    'additional_notes' => $data->additional_notes,
                    'user_id' => $data->user_id,
                    'organization_id' => $data->organization_id,
                ]);

                $organization = organization::select('id', 'title_en', 'email', 'number_of_reservations')
                    ->findOrFail($data->organization_id);
                $user = User::select('id', 'number_of_reservations')
                    ->findOrFail($data->user_id);


                $organization->number_of_reservations += 1;
                $organization->save();
                $user->number_of_reservations += 1;
                $user->save();
                // إرسال البريد
                try {
                    Mail::to($organization->email)->send(new PaymentSuccessNotification(
                        $organization->name,
                        [
                            'book_day' => $data->book_day,
                            'book_time' => $data->book_time,
                            'additional_notes' => $data->additional_notes,
                        ]
                    ));
                } catch (\Exception $mailException) {
                    Log::error("Failed to send email: " . $mailException->getMessage());
                }

                $bill = new Bell();
                $bill->bell_type = 'confirm_booked';
                $bill->bell_items = json_encode($data);
                $bill->account_type = $accountType;
                $bill->amount = floatval($Amount);
                $bill->user_id = intval($data->user_id);
                $bill->save();


                FinancialTransactions::create([
                    'bell_id' => $bill->id,
                    'bell_type' => 'confirm_booked',
                    'type_operation' => 'deposit',
                    'bell_items' => json_encode($data),
                    'account_type' => $accountType,
                    'amount' => floatval($Amount),
                    'balance_type' => 'pending_balance',
                    'user_id' => intval($data->user_id),
                    'organization_id' => intval($data->organization_id),
                ]);

                // تحديث الأرصدة تلقائيًا
                $balance = balance::where('organization_id', $data->organization_id)
                    ->firstOrNew([
                        'user_id' =>  null,
                        'organization_id' => $data->organization_id,
                    ]);

                $balance->total_balance += floatval($Amount);
                $balance->pending_balance += floatval($Amount);
                $balance->save();

                $model->delete();
                return redirect()->to('https://aram-gulf.com/success?transactionId='  . $paymentId . '&mail_statue=true');
              
            } else {
                return redirect()->to('https://aram-gulf.com/paymenterror');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getPaymentStatus(Request $request)
    {
        $validated = $request->validate([
            'paymentId' => 'required|string',
        ]);

        $response = $this->myFatoorahService->getPaymentStatus($validated['paymentId']);

        return response()->json($response);
    }
}
