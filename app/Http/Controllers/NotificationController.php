<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Notification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class NotificationController extends Controller
{

    use ApiResponse;

    public function sendNotification(Request $request)
    {
        try {
            // تحقق من صحة البيانات
            $validated = $request->validate([
                'message' => 'required|string',
                'account_type' => 'required|string|in:user,User,organization,Organization', // تحقق من نوع الحساب
                'user_id' => 'required', // تأكد من وجود المستخدم
            ]);

            // إنشاء الإشعار
            $notification = new Notification();
            $notification->message = $validated['message'];
            $notification->account_type = $validated['account_type'];
            $notification->user_id = $validated['user_id'];
            $notification->is_read = 0;
            $notification->save();

            // إرسال الحدث باستخدام Pusher
            // إعداد Pusher
           $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                [
                    'cluster' => config('broadcasting.connections.pusher.cluster'),
                    'useTLS' => config('broadcasting.connections.pusher.useTLS'),
                ]
            );

            // إرسال البيانات إلى القناة
            $pusher->trigger('notifications', 'NotificationEvent', [
                'message' => $validated['message'],
                'user_id' => $request->user_id,
                'account_type' => $request->account_type,
                'is_read' => 0
            ]);

            return response()->json([
                'message' => 'Notification sent successfully',
                'notification' => $notification,
            ], 200);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return response()->json([
                'error' => 'Failed to send notification',
                'details' => $e->getMessage(),
            ], 500);
        }
    }




    public function SendMultipleNotifications(Request $request)
    {
        try {
            // تحقق من صحة البيانات
            $validated = $request->validate([
                'message' => 'required|string',
                'account_type' => 'required|string|in:user,User,organization,Organization',
                'user_ids' => 'required', // تحقق من أن user_ids مصفوفة
                // 'user_ids.*' => 'exists:users,id' // تحقق من أن جميع المعرفات موجودة في قاعدة البيانات
            ]);

            $userIds = json_decode($validated['user_ids']);

            // مصفوفة لتخزين الإشعارات الجديدة
            $notifications = [];

            // إنشاء الإشعارات لجميع المستخدمين
            foreach ($userIds as $userId) {
                $notifications[] = [
                    'message' => $validated['message'],
                    'account_type' => $validated['account_type'],
                    'user_id' => $userId,
                    'is_read' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // إدخال جميع الإشعارات دفعة واحدة
            Notification::insert($notifications);

            // إعداد Pusher
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                [
                    'cluster' => config('broadcasting.connections.pusher.cluster'),
                    'useTLS' => config('broadcasting.connections.pusher.useTLS'),
                ]
            );

            // إرسال الإشعار إلى جميع المستخدمين
            foreach ($userIds as $userId) {
                $pusher->trigger('notifications', 'NotificationEvent', [
                    'message' => $validated['message'],
                    'user_id' => $userId,
                    'account_type' => $validated['account_type'],
                    'is_read' => 0
                ]);
            }

            return response()->json([
                'message' => 'Notifications sent successfully',
                'notifications' => $notifications,
            ], 200);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return response()->json([
                'error' => 'Failed to send notifications',
                'details' => $e->getMessage(),
            ], 500);
        }
    }



    public function getTenNotifactions($user_id, $account_type)
    {
        try {
            $notifactions = Notification::where('user_id', $user_id)
                ->where('account_type', $account_type)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            return response()->json([
                'data' => $notifactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function NotifactionsByUserId($user_id, $account_type)
    {
        try {
            $notifactions = Notification::where('user_id', $user_id)
                ->where('account_type', $account_type)
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json([
                'data' => $notifactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id|string',
            'message' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        try {

            $notifaction = new Notification();
            $notifaction->user_id = $request->user_id;
            $notifaction->message = $request->message;
            $notifaction->save();
            return response()->json([
                'data' => $notifaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $notifaction = Notification::findOrFail($id);
            return response()->json([
                'data' => $notifaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'message' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        try {

            $notifaction =  Notification::findOrFail($id);
            $notifaction->message = $request->message;
            $notifaction->save();
            return response()->json([
                'data' => $notifaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function markAsRead($id, $account_type)
    {
        try {
            // الحصول على جميع الإشعارات الخاصة بالمستخدم بناءً على الـ id
            $notifications = Notification::where('user_id', $id)->where('account_type', $account_type)->get();

            // تكرار لحفظ كل إشعار بعد تعيينه كمقروء
            foreach ($notifications as $notification) {
                $notification->is_read = true;
                $notification->save(); // حفظ كل نموذج بشكل فردي
            }

            return response()->json([
                'message' => 'Notification marked as read successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unread notifications by user ID.
     */
    public function getUnreadNotificationsByUserId($user_id)
    {
        try {
            $notifications = Notification::where('user_id', $user_id)
                ->where('read', false)
                ->get();
            return response()->json([
                'data' => $notifications
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $notifaction = Notification::findOrFail($id);
            $notifaction->delete();
            return response()->json([
                'message' => 'notification deleted successfuly'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function notificationsIsUnread($user_id, $account_type)
    {
        try {
            // استرجاع الإشعارات الغير مقروءة
            $nots = Notification::where('user_id', $user_id)
                ->where('account_type', $account_type)
                ->where('is_read', false)
                ->get();

            // التحقق إذا كانت الإشعارات غير موجودة
            if ($nots->isEmpty()) {
                return response()->json(['message' => 'No unread notifications found'], 404);
            }

            // إرجاع الإشعارات الغير مقروءة
            return response()->json([
                'message' => 'Unread notifications found',
                'data' => $nots
            ], 200);
        } catch (\Exception $e) {
            // التعامل مع الأخطاء
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }
}
