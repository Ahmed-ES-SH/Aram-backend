<?php

namespace App\Http\Controllers;

use App\Models\organization;
use App\Models\PromoterNewUser;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PromoterNewUserController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {

        $request->validate([
            'promoter_code' => 'required',
            'new_account_id' => 'required',
            'new_account_type' => 'required|in:User,Organization',
        ]);

        try {
            $promoterCode = $request->promoter_code;
            $user = User::where('user_code', $promoterCode)->first();
            if (!$user) {
                return $this->errorResponse('Invalid promoter code', ['message' => 'Invalid promoter code'], 400);
            }
            $newPromoter =  PromoterNewUser::create([
                'promoter_id' => $user->id,
                'promoter_code' => $request->promoter_code,
                'new_account_id' => $request->new_account_id,
                'new_account_type' => $request->new_account_type,
            ]);
            return $this->successResponse($newPromoter, 'done', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild to store', ['message' => $e->getMessage()], 500);
        }
    }


    public function getAllNewUsers($id)
    {
        try {
            $newUsers = PromoterNewUser::where('promoter_id', $id)
                ->with('newAccount')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            $Promoter = User::select('id', 'name', 'image')->findOrFail($id);
            $data = [];
            foreach ($newUsers->items() as $newUser) {
                $type = $newUser->new_account_type;
                $data[] = [
                    'id' => $newUser->new_account_id,
                    'new_user' => $type == 'User' ?
                        User::select('id', 'name', 'image', 'created_at')->findOrFail($newUser->new_account_id) :
                        organization::select('id', 'title_en', 'icon', 'created_at')->findOrFail($newUser->new_account_id),
                    'type' => $type,
                ];
            }


            if (empty($data)) {
                return response()->json(['message' => 'No new users found'], 404);
            }

            return response()->json([
                'data' => $data,
                'promoter' => $Promoter,
                'pagination' => [
                    'current_page' => $newUsers->currentPage(),
                    'last_page' => $newUsers->lastPage(),
                    'total' => $newUsers->total(),
                    'per_page' => $newUsers->perPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild to get all new users', ['message' => $e->getMessage()], 500);
        }
    }
  
  
     public function getAllNewUsersCount($id)
    {
        try {
            // حساب عدد المستخدمين الجدد
            $newUsersCount = PromoterNewUser::where('promoter_id', $id)->count();

            // جلب معلومات المروج
            $promoter = User::select('id', 'name', 'image')->findOrFail($id);

            // إذا لم يكن هناك مستخدمون جدد
            if ($newUsersCount === 0) {
                return response()->json(['message' => 'No new users found'], 404);
            }

            // إرجاع البيانات
            return response()->json([
                'count' => $newUsersCount,
                'promoter' => $promoter,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get all new users', ['message' => $e->getMessage()], 500);
        }
    }

    public function getCountNewUsersForPromoter()
    {
        try {
            // حساب عدد المستخدمين الجدد لكل مروج مع بيانات المروج
            $data = PromoterNewUser::select('users.id', 'users.name', 'users.image', 'users.user_code')
                ->join('users', 'users.id', '=', 'promoter_new_users.promoter_id')
                ->groupBy('promoter_new_users.promoter_id', 'users.id', 'users.name', 'users.image', 'users.user_code')
                ->selectRaw('COUNT(promoter_new_users.id) as count')
                ->orderByDesc('count')
                ->paginate(15);

            // التحقق من وجود بيانات
            if ($data->isEmpty()) {
                return response()->json(['message' => 'No data found'], 404);
            }

            return response()->json([
                'data' => $data->items(),
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'total' => $data->total(),
                    'per_page' => $data->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get count of new users for promoter', ['message' => $e->getMessage()], 500);
        }
    }
}
