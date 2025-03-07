<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Mail\AccaptedNotification;
use App\Models\Book;
use App\Models\organization;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessNotification;
use App\Mail\unAccaptedNotification;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class BookController extends Controller
{

    use ApiResponse;




    public function booksCount()
    {
        try {
            // افتراض أن هناك نموذج اسمه User
            $count = Book::count();

            // إرجاع استجابة ناجحة مع العدد
            return $this->successResponse($count, "Users count retrieved successfully", 200);
        } catch (\Exception $e) {
            // في حال حدوث خطأ، يتم إرجاع استجابة خطأ
            return $this->errorResponse("Failed to retrieve users count", ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index($id, $account_type)
    {
        try {
            $column = $account_type === 'User' ? 'user_id' : 'organization_id';
            $books = Book::where($column, $id)->orderBy('created_at', 'desc')->with('user')->with('organization')->get();
            return $this->successResponse($books, 'Founded Bookings', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function bookingsByStatue($state)
    {
        try {
            $books = Book::orderBy('created_at', 'desc')->where('status', $state)->paginate(20);
            return response()->json([
                'data' => $books->items(),
                'pagination' => [
                    'current_page' => $books->currentPage(),
                    'last_page' => $books->lastPage(),
                    'per_page' => $books->perPage(),
                    'total' => $books->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function updateBookStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:expired,done,waiting,acceptable,unacceptable'
        ]);
        try {
            $book = Book::findOrFail($id);
            $book->status = $validated['status'];
            $book->save();
            return $this->successResponse($book, 'Update Staute Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function sendAccaptedNotification($client_id, $organization_id, Request $request)
    {
        try {

            $validated = $request->validate([
                'message' => 'required|string',
                'account_type' => 'required|string|in:user,organization', // تحقق من نوع الحساب
                'book_day' => 'required|string',
                'book_time' => 'required|string',
                'additional_notes' => 'required|string',
            ]);

            $user = User::findOrFail($client_id);
            $organization = organization::findOrFail($organization_id);
            Mail::to($user->email)->send(new AccaptedNotification(
                $user->name,
                [
                    'organization_name' => $organization->title_en,
                    'book_day' => $request->book_day,
                    'book_time' => $request->book_time,
                    'additional_notes' => $request->additional_notes,
                ],
                $organization->email
            ));
            // إنشاء الإشعار
            $notification = new Notification();
            $notification->message = $validated['message'];
            $notification->account_type = $validated['account_type'];
            $notification->user_id = $client_id;
            $notification->is_read = 0;
            $notification->save();

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            // إرسال البيانات إلى القناة
            $pusher->trigger('notifications', 'NotificationEvent', [
                'message' => $validated['message'],
                'user_id' => $client_id,
                'account_type' => $request->account_type,
                'is_read' => 0
            ]);

            return response()->json(['message' => 'Notification sent successfully'], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
    public function sendUnAccaptedNotification($client_id, $organization_id, Request $request)
    {
        try {

            $validated = $request->validate([
                'message' => 'required|string',
                'account_type' => 'required|string|in:user,organization', // تحقق من نوع الحساب
                'book_day' => 'required|string',
                'book_time' => 'required|string',
                'additional_notes' => 'required|string',
            ]);

            $user = User::findOrFail($client_id);
            $organization = organization::findOrFail($organization_id);
            Mail::to($user->email)->send(new unAccaptedNotification(
                $user->name,
                [
                    'organization_name' => $organization->title_en,
                    'book_day' => $request->book_day,
                    'book_time' => $request->book_time,
                    'additional_notes' => $request->additional_notes,
                ],
                $organization->email
            ));
            // إنشاء الإشعار
            $notification = new Notification();
            $notification->message = $validated['message'];
            $notification->account_type = $validated['account_type'];
            $notification->user_id = $client_id;
            $notification->is_read = 0;
            $notification->save();

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            // إرسال البيانات إلى القناة
            $pusher->trigger('notifications', 'NotificationEvent', [
                'message' => $validated['message'],
                'user_id' => $client_id,
                'account_type' => $request->account_type,
                'is_read' => 0
            ]);

            return response()->json(['message' => 'Notification sent successfully'], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        try {
            $book = new Book();
            $data = $request->validated();
            $book->fill($data);

            $user = User::select('name', 'number_of_reservations')->findOrFail($request->user_id);
            $organization = Organization::select('title_en', 'email', 'id', 'number_of_reservations')
                ->findOrFail($request->organization_id);

            // زيادة عدد الحجوزات
            $organization->increment('number_of_reservations');
            $organization->save();
            $user->increment('number_of_reservations');
            $user->save();

            // حفظ الحجز
            $book->save();

            // إعداد البيانات
            $bookingDetails = [
                'book_day' => $data['book_day'],
                'book_time' => $data['book_time'],
                'additional_notes' => $data['additional_notes'],
            ];

            // إرسال البريد الإلكتروني
            try {
                Mail::to($organization->email)->send(new PaymentSuccessNotification($organization->title_en, $bookingDetails));
            } catch (\Exception $mailException) {
                Log::error("Failed to send email: " . $mailException->getMessage());
            }

            // إنشاء الإشعار
            $message = sprintf('تم إرسال طلب جديد اليك من %s', $user->name);
            Notification::create([
                'message' => $message,
                'account_type' => 'organization',
                'is_read' => 0,
                'user_id' => $request->organization_id,
            ]);

            // إعداد Pusher
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            // إرسال البيانات إلى القناة
            $pusher->trigger('notifications', 'NotificationEvent', [
                'message' => $message,
                'user_id' => $request->organization_id,
                'account_type' => 'organization',
                'is_read' => 0,
            ]);

            return $this->successResponse($book, 'The book has been successfully created.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }

    public function penddingBook(StoreBookRequest $request)
    {
        try {
            $book = new Book();
            $data = $request->validated();
            $book->fill($data);
            // حفظ الحجز
            $book->save();
            return $this->successResponse($book, 'The book has been successfully created.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $book = Book::findOrFail($id);
            return $this->successResponse($book, 'Founded Book Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $data = $request->validated();
            $book->fill($data);
            $book->save();
            return $this->successResponse($book, 'Book Is Updated', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return $this->successResponse([], 'Book Deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    public function destroyOneParty($id, $user_id = null, $organization_id = null)
    {
        try {
            // البحث عن الحجز بناءً على $id
            $book = Book::findOrFail($id);

            // تحديث الحجز بناءً على الطرف الذي يرغب في الحذف
            if ($user_id && $book->user_id == $user_id) {
                $book->user_id = null;
            }

            if ($organization_id && $book->organization_id == $organization_id) {
                $book->organization_id = null;
            }

            // إذا كانت كلا القيمتين null، يتم حذف الحجز بالكامل
            if (is_null($book->user_id) && is_null($book->organization_id)) {
                $book->delete();
                return $this->successResponse([], 'Book Deleted Permanently', 200);
            } else {
                // حفظ التحديث إذا لم يتم حذف الحجز بالكامل
                $book->save();
                return $this->successResponse([], 'Book Updated Successfully', 200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }



    public function checkBookedAppointments($id)
    {
        try {
            // جلب البيانات بناءً على المؤسسة والحالة
            $models = Book::where('organization_id', $id)
                ->where('status', 'waiting')
                ->orwhere('status', 'acceptable')
                ->orderBy('created_at', 'desc')
                ->get(['book_time', 'book_day']); // تحديد الحقول المطلوبة مباشرة

            // التحقق إذا كانت النماذج فارغة
            if ($models->isEmpty()) {
                return response()->json([
                    'message' => 'No data found'
                ], 404);
            }

            // إرجاع الاستجابة مع البيانات
            return response()->json([
                'data' => $models,
                'message' => 'All bookings with status "waiting \ acceptable" retrieved successfully',
            ], 200);
        } catch (\Exception $e) {
            // التعامل مع أي خطأ
            return response()->json([
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function changeBookedStatus()
    {
        try {
            // تحديد اليوم الحالي
            $currentDate = \Carbon\Carbon::now()->toDateString();  // الحصول على التاريخ الحالي بصيغة YYYY-MM-DD

            // جلب المواعيد التي تطابق اليوم الحالي والأيام التي سبقت اليوم الحالي
            $bookedAppointments = Book::where('status', 'waiting')
                ->whereDate('book_day', '<=', $currentDate)  // مقارنة التاريخ الحالي مع تاريخ الحجز بحيث يكون التاريخ قبل أو في اليوم الحالي
                ->get();

            // المرور على المواعيد المتوافقة
            foreach ($bookedAppointments as $appointment) {
                // تحديد الوقت الحالي مع المنطقة الزمنية المطلوبة
                $currentDateTime = \Carbon\Carbon::now()->addHour(3);  // يمكن تغيير المنطقة الزمنية حسب الحاجة

                // تحويل وقت انتهاء الصلاحية من قاعدة البيانات إلى وقت قابل للمقارنة
                $expireTime = \Carbon\Carbon::parse($appointment->expire_in);  // تحويل للمنطقة الزمنية المطلوبة

                // التحقق إذا كان الوقت الحالي قد تجاوز وقت انتهاء الصلاحية
                if ($currentDateTime->greaterThan($expireTime)) {
                    // تغيير الحالة إلى "expired"
                    $appointment->status = 'expired';
                    $appointment->save();
                }
            }

            // الرد بالنجاح
            return $this->successResponse([], 'Statuses updated successfully', 200);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، إرجاع رسالة خطأ
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }
}
