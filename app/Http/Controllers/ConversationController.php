<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversation;
use App\Models\conversation;
use App\Models\organization;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function getConversation($id, $user_id, $account_type)
    {
        try {
            // التحقق من صحة $account_type
            if (!in_array($account_type, ['User', 'Organization'])) {
                return $this->errorResponse('Invalid account type', [], 400);
            }

            // جلب المحادثة
            $conversation = Conversation::findOrFail($id);

            // التحقق من أن المستخدم الحالي ليس ضمن الأطراف التي حذفت المحادثة
            $requestingPartyId = $user_id;
            $deletedBy = collect($conversation->deleted_by);

            if ($deletedBy->contains(fn($item) => $item['id'] == $requestingPartyId && $item['type'] == $account_type)) {
                return $this->errorResponse('You have removed this conversation', [], 403);
            }

            // تحديد بيانات الطرف الآخر
            $otherParty = $conversation->participant_one_type === $account_type && $conversation->participant_one_id == $requestingPartyId
                ? ['id' => $conversation->participant_two_id, 'type' => $conversation->participant_two_type]
                : ['id' => $conversation->participant_one_id, 'type' => $conversation->participant_one_type];

            $firstParty =  $account_type == "User" ? User::findOrFail($user_id) : organization::findOrFail($user_id);

            // جلب بيانات الطرف الآخر بناءً على النوع
            $otherPartyData = $otherParty['type'] === 'User'
                ? User::find($otherParty['id'])
                : organization::find($otherParty['id']);

            // إضافة بيانات الطرف الآخر إلى استجابة المحادثة
            $conversationData = $conversation->toArray();
            $conversationData['other_party'] = $otherPartyData;
            $conversationData['first_party'] = $firstParty;

            return $this->successResponse($conversationData, 'Conversation Founded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed Error', ['message' => $e->getMessage()], 500);
        }
    }


    public function getUserConversationsWithLastMessage($user_id, $account_type)
    {
        try {
            // التحقق من صحة $account_type
            if (!in_array($account_type, ['User', 'Organization'])) {
                return $this->errorResponse('Invalid account type', [], 400);
            }

            // جلب المحادثات المتصلة بحساب المستخدم
            $conversations = Conversation::where(function ($query) use ($user_id, $account_type) {
                // التحقق من كون المستخدم طرفًا في المحادثة
                $query->where('participant_one_id', $user_id)
                    ->where('participant_one_type', $account_type)
                    ->orWhere('participant_two_id', $user_id)
                    ->orWhere('participant_two_type', $account_type);
            })->with(['messages' => function ($query) {
                // جلب آخر رسالة لكل محادثة
                $query->latest();
            }])
                ->get();

            // معالج لتخزين آخر رسالة من كل محادثة وإضافة بيانات الرسائل غير المقروءة
            $conversationData = $conversations->map(function ($conversation) use ($user_id, $account_type) {
                // التحقق مما إذا كان المستخدم قد حذف المحادثة
                $requestingPartyId = $user_id;
                $deletedBy = collect($conversation->deleted_by);

                // التحقق من حالة الحذف
                if ($deletedBy->contains(fn($item) => $item['id'] == $requestingPartyId && $item['type'] == $account_type)) {
                    // إذا تم حذف المحادثة من قبل المستخدم، نقوم بإرجاع استجابة خطأ
                    return $this->errorResponse('You have removed this conversation', [], 403);
                }

                // جلب آخر رسالة للمحادثة إذا كانت موجودة
                $lastMessage = $conversation->messages->first();
                $conversation->last_message = $lastMessage ? $lastMessage->content : null;
                $conversation->last_message_type = $lastMessage ? $lastMessage->message_type : null;
                $conversation->last_message_time = $lastMessage ? $lastMessage->created_at : null;

                // تحديد بيانات الأطراف في المحادثة
                $otherParty = $conversation->participant_one_type === $account_type && $conversation->participant_one_id == $user_id
                    ? ['id' => $conversation->participant_two_id, 'type' => $conversation->participant_two_type]
                    : ['id' => $conversation->participant_one_id, 'type' => $conversation->participant_one_type];

                // جلب بيانات الطرف الآخر
                $otherPartyData = $otherParty['type'] === 'User'
                    ? User::find($otherParty['id'])
                    : organization::find($otherParty['id']);

                // إضافة بيانات الطرف الآخر إلى المحادثة
                $conversation->other_party = $otherPartyData;

                // التحقق من الرسائل غير المقروءة
                $unreadMessagesCount = $conversation->messages->filter(function ($message) use ($user_id, $account_type) {
                    // التحقق من أن الرسالة موجهة للمستخدم ولم يتم قراءتها
                    return !$message->is_read && $message->sender_id == $user_id && $message->sender_type == $account_type;
                })->count();

                // إضافة عدد الرسائل غير المقروءة إلى المحادثة
                $conversation->unread_messages_count = $unreadMessagesCount;

                return $conversation;
            });

            return $this->successResponse($conversationData, 'Conversations Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed Error', ['message' => $e->getMessage()], 500);
        }
    }



    public function getConversationMessages($id, $user_id, $account_type)
    {
        try {
            $conversation = conversation::findOrFail($id);
            $requestingPartyId = $user_id;
            $deletedBy = collect($conversation->deleted_by);


            // التحقق من حالة الحذف
            if ($deletedBy->contains(fn($item) => $item['id'] == $requestingPartyId && $item['type'] == $account_type)) {
                // إذا تم حذف المحادثة من قبل المستخدم، نقوم بإرجاع استجابة خطأ
                return $this->errorResponse('You have removed this conversation', [], 403);
            }

            $messages = $conversation->messages()
                ->orderBy('created_at', 'desc') // ترتيب تنازلي لجلب أحدث الرسائل
                ->paginate(30);

            // إعادة ترتيب الرسائل تصاعديًا
            $sortedMessages = $messages->getCollection()->sortBy('created_at')->values();
            // تحديد بيانات الأطراف في المحادثة
            $otherParty = $conversation->participant_one_type === $account_type && $conversation->participant_one_id == $user_id
                ? ['id' => $conversation->participant_two_id, 'type' => $conversation->participant_two_type]
                : ['id' => $conversation->participant_one_id, 'type' => $conversation->participant_one_type];

            // جلب بيانات الطرف الآخر
            $otherPartyData = $otherParty['type'] === 'User'
                ? User::find($otherParty['id'])
                : Organization::find($otherParty['id']);

            // إضافة بيانات الطرف الآخر إلى المحادثة
            $conversation->other_party = $otherPartyData;

            return response()->json([
                'status' => 'success',
                'conversation' => $conversation,
                'messages' => $sortedMessages, // الرسائل الحالية
                'pagination' => [
                    'current_page' => $messages->currentPage(),
                    'last_page' => $messages->lastPage(),
                    'total' => $messages->total(),
                    'per_page' => $messages->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }




   public function makeConversation(StoreConversation $request)
{
    try {
        $data = $request->validated();

        // منع المستخدم من بدء محادثة مع نفسه
        if ($data['participant_one_id'] === $data['participant_two_id'] && 
            $data['participant_one_type'] === $data['participant_two_type']) {
            return $this->errorResponse('You cannot start a conversation with yourself.', [], 400);
        }

        // التحقق من وجود محادثة سابقة بين الأطراف
        $existingConversation = Conversation::where(function ($query) use ($data) {
            $query->where('participant_one_id', $data['participant_one_id'])
                ->where('participant_one_type', $data['participant_one_type'])
                ->where('participant_two_id', $data['participant_two_id'])
                ->where('participant_two_type', $data['participant_two_type']);
        })->orWhere(function ($query) use ($data) {
            $query->where('participant_one_id', $data['participant_two_id'])
                ->where('participant_one_type', $data['participant_two_type'])
                ->where('participant_two_id', $data['participant_one_id'])
                ->where('participant_two_type', $data['participant_one_type']);
        })->first();

        if ($existingConversation) {
            return $this->successResponse($existingConversation, 'Conversation already exists', 200);
        }

        // إنشاء محادثة جديدة إذا لم تكن موجودة
        $conversation = new Conversation();
        $conversation->fill($data);
        $conversation->save();

        return $this->successResponse($conversation, 'Conversation Created Successfully', 200);
    } catch (\Exception $e) {
        return $this->errorResponse('Failed Error', ['message' => $e->getMessage()], 500);
    }
}





    public function destroyConversationFromOneParty($id, $user_id, $account_type)
    {
        try {
            // التحقق من صحة $account_type
            if (!in_array($account_type, ['User', 'Organization'])) {
                return $this->errorResponse('Invalid account type', [], 400);
            }

            // الحصول على المحادثة
            $conversation = Conversation::findOrFail($id);

            // تحديد الطرف الذي يطلب الحذف
            $requestingPartyId = $user_id; // المعرف الحالي

            $deletedBy = $conversation->deleted_by ?? [];

            // إضافة الطرف إلى قائمة المحذوفين
            $deletedBy[] = [
                'id' => $requestingPartyId,
                'type' => $account_type,
            ];

            // حفظ الحذف
            $conversation->deleted_by = $deletedBy;
            $conversation->save();

            // إذا كان كلا الطرفين قد حذفا المحادثة، يتم حذفها نهائيًا
            if (count($deletedBy) >= 2) {
                $conversation->delete();
                return $this->successResponse([], 'Conversation deleted completely', 200);
            }

            return $this->successResponse([], 'Conversation removed for one party', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }



    public function blokedOtherParty($id, $user_id, $account_type)
    {
        try {
            // التحقق من صحة $account_type
            if (!in_array($account_type, ['User', 'Organization'])) {
                return $this->errorResponse('Invalid account type', [], 400);
            }

            // الحصول على المحادثة
            $conversation = Conversation::findOrFail($id);

            if ($user_id != $conversation->participant_one_id && $user_id != $conversation->participant_two_id) {
                return response()->json([
                    'message' => "Sorry, you are not a member in this conversation"
                ]);
            }

            // الطرف الذي يطلب الحظر
            $requestingPartyId = $user_id;

            // تحديد نوع الطرف الذي يطلب الحظر
            $requestingPartyType = $account_type;

            // تحديد الطرف الآخر في المحادثة
            $otherPartyId = $conversation->participant_one_id == $requestingPartyId
                ? $conversation->participant_two_id
                : $conversation->participant_one_id;

            $otherPartyType = $conversation->participant_one_id == $requestingPartyId
                ? $conversation->participant_two_type
                : $conversation->participant_one_type;

            $blocked_by = $conversation->blocked_by ?? [];

            // التحقق من أن الشخص غير موجود بالفعل في قائمة الحظر
            foreach ($blocked_by as $blockedParty) {
                if (
                    $blockedParty['blocker_id'] == $otherPartyId &&
                    $blockedParty['blocker_type'] == $otherPartyType
                ) {
                    return response()->json([
                        'message' => "This party is already blocked"
                    ], 400);
                }
            }

            // إضافة الطرف إلى قائمة الحظر
            $blocked_by[] = [
                'blocker_id' => $otherPartyId,
                'blocker_type' => $otherPartyType,
                'blocked_by_id' => $requestingPartyId,
                'blocked_by_type' => $requestingPartyType,
            ];

            // حفظ قائمة الحظر
            $conversation->blocked_by = $blocked_by;
            $conversation->save();

            return $this->successResponse([], 'Conversation blocked for one party', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function unblockOtherParty($id, $user_id, $account_type)
    {
        try {
            // التحقق من صحة $account_type
            if (!in_array($account_type, ['User', 'Organization'])) {
                return $this->errorResponse('Invalid account type', [], 400);
            }

            // الحصول على المحادثة
            $conversation = Conversation::findOrFail($id);

            // التحقق من أن المستخدم عضو في المحادثة
            if ($user_id != $conversation->participant_one_id && $user_id != $conversation->participant_two_id) {
                return response()->json([
                    'message' => "Sorry, you are not a member in this conversation"
                ]);
            }

            // الطرف الذي يطلب فك الحظر
            $requestingPartyId = $user_id;
            $requestingPartyType = $account_type;

            $blocked_by = $conversation->blocked_by ?? [];

            // التحقق من أن المستخدم موجود في قائمة الحظر
            $updatedBlockedBy = array_filter($blocked_by, function ($blockedParty) use ($requestingPartyId, $requestingPartyType) {
                return !(
                    $blockedParty['blocked_by_id'] == $requestingPartyId &&
                    $blockedParty['blocked_by_type'] == $requestingPartyType
                );
            });

            // التحقق إذا لم يتم العثور على الطرف في قائمة الحظر
            if (count($updatedBlockedBy) === count($blocked_by)) {
                return response()->json([
                    'message' => "No block record found for this user"
                ], 400);
            }

            // تحديث قائمة الحظر
            $conversation->blocked_by = array_values($updatedBlockedBy);
            $conversation->save();

            return $this->successResponse([], 'Block removed successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }




    public function checkBlockedConversation($conversationId, $userId, $type)
    {
        try {
            // العثور على المحادثة
            $conversation = Conversation::find($conversationId);

            if (!$conversation) {
                return response()->json(['message' => 'Conversation not found'], 404);
            }

            $blockedBy = collect($conversation->blocked_by);

            // التحقق إذا كان المستخدم قام بحظر الطرف الآخر
            $hasBlocked = $blockedBy->first(function ($block) use ($userId, $type) {
                return $block['blocked_by_id'] == $userId && $block['blocked_by_type'] == $type;
            });

            if ($hasBlocked) {
                return response()->json([
                    'message' => 'You have blocked the other party',
                    'blocker' => [
                        'id' => $hasBlocked['blocked_by_id'], // ID المستخدم الذي قام بالحظر
                        'type' => $hasBlocked['blocked_by_type'], // نوع المستخدم الذي قام بالحظر
                    ],
                    'blocked' => [
                        'id' => $hasBlocked['blocker_id'], // ID المستخدم المحظور
                        'type' => $hasBlocked['blocker_type'], // نوع المستخدم المحظور
                    ],
                ], 200);
            }

            // التحقق إذا كان المستخدم محظورًا
            $isBlocked = $blockedBy->first(function ($block) use ($userId, $type) {
                return $block['blocker_id'] == $userId && $block['blocker_type'] == $type;
            });

            if ($isBlocked) {
                return response()->json([
                    'message' => 'You are blocked',
                    'blocker' => [
                        'id' => $isBlocked['blocked_by_id'], // ID المستخدم الذي قام بالحظر
                        'type' => $isBlocked['blocked_by_type'], // نوع المستخدم الذي قام بالحظر
                    ],
                    'blocked' => [
                        'id' => $isBlocked['blocker_id'], // ID المستخدم المحظور
                        'type' => $isBlocked['blocker_type'], // نوع المستخدم المحظور
                    ],
                ], 403);
            }

            return response()->json([
                'message' => 'Not blocked',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
