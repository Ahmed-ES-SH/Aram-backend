<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Models\blocked_user;
use App\Models\conversation;
use App\Models\message;
use App\Models\organization;
use App\Models\User;
use App\Traits\ApiResponse;
use Pusher\Pusher;

class MessageController extends Controller
{
    use ApiResponse;

    public function sendMessage(StoreMessage $request, $conversationId)
    {
        try {
            $data = $request->validated();
            $conversation = conversation::findOrFail($conversationId);
            $sender = $data['sender_type'] == 'User' ? User::findOrFail($data['sender_id']) : organization::findOrFail($data['sender_id']);
            $receiverId = $data['sender_id'];
            $receiverType = $data['sender_type'];



            // التحقق من أن المرسل جزء من المحادثة
            if (
                !in_array($data['sender_id'], [$conversation->participant_one_id, $conversation->participant_two_id]) ||
                !in_array($data['sender_type'], [$conversation->participant_one_type, $conversation->participant_two_type])
            ) {
                return response()->json(['error' => 'Unauthorized sender'], 403);
            }

            // إنشاء الرسالة
            $message = new Message();
            $message->fill([
                'message_type' => $data['message_type'],
                'sender_id' => $data['sender_id'],
                'sender_type' => $data['sender_type'],
                'conversation_id' => $conversationId,
            ]);

            // التعامل مع أنواع الرسائل المختلفة
            if ($data['message_type'] === 'text') {
                if (empty($data['content'])) {
                    return response()->json(['error' => 'Content is required for text messages'], 422);
                }
                $message->content = $data['content'];
            } elseif (in_array($data['message_type'], ['image', 'audio']) && $request->hasFile('file_path')) {
                $file = $data['file_path'];
                $storagePath = 'conversations/files';
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $originalName . '_' . uniqid() . '.' . $extension;
                $file->move(public_path($storagePath), $filename);
                $message->file_path = url('/') . '/' . $storagePath . '/' . $filename;
            } else {
                return response()->json(['error' => 'Invalid message type or missing file'], 422);
            }

            // إرسال الحدث باستخدام Pusher
            // إعداد Pusher

            // إعداد البيانات
            $pusher_data = [
                'content' => $data['content'] ?? null,
                'file_path' => $message->file_path ?? null,
                'sender_id' => $request->sender_id,
                'sender_type' => $request->sender_type,
                'conversation_id' => $conversationId,
                'message_type' =>  $data['message_type'],
                'created_at' => now(),
                'is_read' => 0,
            ];
         $pusher = new Pusher(
                config('broadcasting.connections.pusher_app_2.key'),
                config('broadcasting.connections.pusher_app_2.secret'),
                config('broadcasting.connections.pusher_app_2.app_id'),
                [
                    'cluster' => config('broadcasting.connections.pusher_app_2.cluster'),
                    'useTLS' => config('broadcasting.connections.pusher_app_2.useTLS'),
                ]
            );

            // إرسال البيانات إلى القناة
            $pusher->trigger('chat', 'ChatEvent', $pusher_data);

            $message->save();

            return $this->successResponse($message, 'Message sent successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }




    public function ConverstionMessagesReaded($conversationId)
    {
        try {
            message::where('conversation_id', $conversationId)
                ->update(['is_read' => true]);
            return $this->successResponse([], 'All Messages Is Readed', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
}
