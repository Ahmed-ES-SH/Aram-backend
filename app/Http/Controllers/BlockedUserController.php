<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Models\blocked_user;
use App\Models\organization;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BlockedUserController extends Controller
{

    use ApiResponse;

    public function blockUser(Request $request, $blocker_id, $blocker_type)
    {
        $request->validate([
            'blocked_id' => 'required|integer',
            'blocked_type' => 'required|string',
        ]);

        $blocker = $blocker_type == 'User' ? User::findOrFail($blocker_id) : organization::findOrFail($blocker_id);
        $blockedId = $request->input('blocked_id');
        $blockedType = $request->input('blocked_type');

        // التحقق من وجود الحظر
        $alreadyBlocked = blocked_user::where([
            'blocker_id' => $blocker->id,
            'blocker_type' => $blocker->account_type,
            'blocked_id' => $blockedId,
            'blocked_type' => $blockedType,
        ])->exists();

        if ($alreadyBlocked) {
            return response()->json(['message' => 'User is already blocked'], 400);
        }

        // إنشاء الحظر
        blocked_user::create([
            'blocker_id' => $blocker->id,
            'blocker_type' => $blocker_type,
            'blocked_id' => $blockedId,
            'blocked_type' => $blockedType,
        ]);

        return response()->json(['message' => 'User blocked successfully', 200]);
    }

    public function unblockUser(Request $request, $blocker_id, $blocker_type)
    {
        $request->validate([
            'blocked_id' => 'required|integer',
            'blocked_type' => 'required|string',
        ]);

        $blocker = $blocker_type == 'User' ? User::findOrFail($blocker_id) : organization::findOrFail($blocker_id);
        $blockedId = $request->input('blocked_id');
        $blockedType = $request->input('blocked_type');

        blocked_user::where([
            'blocker_id' => $blocker->id,
            'blocker_type' => $blocker_type,
            'blocked_id' => $blockedId,
            'blocked_type' => $blockedType,
        ])->delete();

        return response()->json(['message' => 'User unblocked successfully']);
    }

    public function CheckBlockedParty(StoreMessage $request)
    {
        try {
            $data = $request->validated();
            $sender = $data['sender_type'] == 'User' ? User::findOrFail($data['sender_id']) : organization::findOrFail($data['sender_id']);
            $receiverId = $data['sender_id'];
            $receiverType = $data['sender_type'];

            // التحقق من الحظر
            $isBlocked = blocked_user::where([
                ['blocker_id', $sender->id],
                ['blocker_type', get_class($sender)],
                ['blocked_id', $receiverId],
                ['blocked_type', $receiverType],
            ])->orWhere([
                ['blocker_id', $receiverId],
                ['blocker_type', $receiverType],
                ['blocked_id', $sender->id],
                ['blocked_type', get_class($sender)],
            ])->exists();

            if ($isBlocked) {
                return $this->successResponse([], 'Cannot send message, one of the users is blocked', 200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
}
