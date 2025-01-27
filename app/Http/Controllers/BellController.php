<?php

namespace App\Http\Controllers;

use App\Models\Bell;
use App\Models\organization;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BellController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // جلب البيانات مع ترتيب حسب تاريخ الإنشاء وإضافة العلاقة مع user
            $models = bell::orderBy('created_at', 'desc')
                ->paginate(25);

            // التحقق إذا كان الجدول فارغًا
            if ($models->isEmpty()) {
                return response()->json([
                    'message' => 'No bells available!'
                ], 404);
            }

            // تجهيز البيانات مع المستخدمين المرتبطين داخل كل فاتورة
            $bellsWithUsers = $models->map(function ($bell) {
                $user = $bell->account_type === 'User'
                    ? User::find($bell->user_id)
                    : organization::find($bell->user_id);

                // دمج بيانات المستخدم مع الفاتورة
                $bell->user = $user;

                return $bell;
            });

            // إرجاع البيانات مع معلومات التصفح (pagination)
            return response()->json([
                'data' => $bellsWithUsers,
                'pagination' => [
                    'current_page' => $models->currentPage(),
                    'last_page' => $models->lastPage(),
                    'per_page' => $models->perPage(),
                    'total' => $models->total(),
                ]
            ]);
        } catch (\Exception $e) {
            // إرجاع استجابة في حالة وجود خطأ
            return $this->errorResponse("Failed to retrieve data", [
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
            $bell = Bell::findOrFail($id);
            $user = $bell->account_type == 'User' ? User::findOrFail($bell->user_id) : organization::findOrfail($bell->user_id);
            $bell->user = $user;
            return $this->successResponse($bell, 'bell  founded', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Fail Error", ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bell $bell)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $bell = Bell::findOrFail($id);
            $bell->delete();
            return $this->successResponse($bell, 'bell deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Fail Error", ['message' => $e->getMessage()], 500);
        }
    }
}
