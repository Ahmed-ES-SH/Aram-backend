<?php

namespace App\Modules\Payment\Services;

use App\Http\Services\NotificationService;
use App\Http\Traits\ApiResponse;
use App\Models\Invoice;
use App\Modules\Promotion\Models\PromoterRatio;
use App\Modules\Promotion\Models\PromotionActivity;
use App\Models\ProvisionalData;
use App\Modules\Service\Models\ServiceOrder;
use App\Modules\Service\Models\ServicePage;
use App\Modules\Payment\Models\Transaction;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProcessServiceDealPayment
{
    use ApiResponse;
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }


    public function processServiceDealPayment($data)
    {
        try {
            $user = $data->user();
            $notificationData = null;
            $sender = null;

            DB::transaction(function () use ($data, $user, &$notificationData, &$sender) {
                $provisionalData = ProvisionalData::where('uniqueId', $data['provisionalData_id'])
                    ->firstOrFail();


                $decodedMetadata = json_decode($provisionalData['metadata'], true);
                $service_id = $decodedMetadata['items']['id'];
                $activityId = $decodedMetadata['activity_id'] ?? null;


                $service = ServicePage::where('id', $service_id)->firstOrFail();
                $order = ServiceOrder::where('id', $provisionalData->service_order_id)->firstOrFail();
                $invoice = Invoice::where('invoice_number', $data['invoice_number'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $activity = $activityId
                    ? PromotionActivity::where('id', $activityId)->firstOrFail()
                    : null;


                $ratios = PromoterRatio::find(1);
                $order->update([
                    'payment_status' => 'paid',
                    'deal_status' => 'approved',
                    'invoice_id' => $invoice->id,
                    'subscription_status' => $service->type === 'one_time' ? null : 'active',
                    'subscription_start_time' => now(),
                    'subscription_end_time' => $service->type === 'one_time' ? null : now()->addDays(30),
                ]);

                $service->update([
                    'orders_count' => $service->orders_count + 1,
                ]);

                $invoice->update([
                    'status' => 'paid',
                    'payment_date' => now(),
                ]);


                Transaction::create([
                    "user_id" => $user->id,
                    "account_type" => $user->account_type,
                    "type" => "purchase",
                    "direction" => "out",
                    "amount" => $order->price_after_deal,
                    "status" => "completed",
                ]);

                if ($activity) {
                    $ip = $decodedMetadata['ip_address'] ?? ($data ? $data->ip() : null);
                    $device = $decodedMetadata['device_type'] ?? ($data ? $data->header('User-Agent') : null);

                    $activity->update([
                        'is_active' => true,
                        'commission_amount' => $ratios->purchase_ratio,
                        'country' => $decodedMetadata['country'] ?? null,
                        'ip_address' => $ip ?? null,
                        'device_type' => $device ?? null,
                        'activity_at' => now(),
                    ]);
                }


                $provisionalData->delete();

                // Prepare notification data for afterCommit
                $adminsIds = User::where('role', 'admin')->pluck('id')->toArray();
                $superAdminIds = User::where('role', 'super_admin')->pluck('id')->toArray();
                $allAdminIds = array_merge($adminsIds, $superAdminIds);
                $sender = User::where('id', 1)->where('role', 'admin')->first();

                $notificationData = [
                    'user_ids' => $allAdminIds,
                    'sender_type' => 'user',
                    'content' => "تم اتمام عملية الدفع الخاصة بالطلب ذو الرقم " . $invoice->invoice_number . "والذى يتعلق بالخدمه" . $service->slug,
                ];


                $this->notificationService->sendMultipleNotifications($notificationData, $sender);
            });


            return $this->successResponse("Service Deal Payment Processed Successfully.");
        } catch (Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
