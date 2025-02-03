<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|exists:users,user_code',
            'amount' => 'required|numeric|min:1',
            'user_id' => 'required|exists:users,id'
        ]);

        // العثور على صاحب الكود
        $user = User::where('user_code', $request->promo_code)->first();

        if (!$user) {
            return response()->json(['message' => 'Promo code not found'], 404);
        }
        $unqieID = uniqid();
        // تسجيل عملية الشراء
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'buyer_id' => $request->user_id, // إذا كان المستخدم مسجلاً
            'promo_code' => $request->promo_code,
            'amount' => $request->amount,
            'uniqId' => $unqieID
        ]);

        return response()->json(['message' => 'Purchase recorded successfully', 'data' => $purchase, 201]);
    }



    public function getUsersWithPurchaseCount()
    {
        try {
            // جلب جميع المستخدمين مع عدد عمليات الشراء المكتملة وترتيبهم من الأعلى إلى الأقل مع التصفح
            $users = User::select('id', 'image', 'name', 'user_code')
                ->with(['purchases' => function ($query) {
                    $query->where('status', 'completed');
                }])
                ->withCount(['purchases' => function ($query) {
                    $query->where('status', 'completed');
                }])
                ->orderByDesc('purchases_count') // ترتيب تنازلي حسب عدد العمليات
                ->paginate(20); // عدد العناصر في كل صفحة

            // إضافة معلومات التصفح إلى الاستجابة
            return response()->json([
                'data' => $users->items(), // إرجاع العناصر فقط
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getPurchasesByUserId($userId)
    {
        try {
            // جلب جميع عمليات الشراء للمستخدم مع شرط الحالة "مكتملة" مع التصفح
            $purchases = Purchase::where('user_id', $userId) // البحث باستخدام id المستخدم
                ->where('status', 'completed') // شرط الحالة المكتملة
                ->paginate(20); // عدد العناصر في كل صفحة

            return response()->json([
                'data' => $purchases->items(), // إرجاع العناصر فقط
                'pagination' => [
                    'current_page' => $purchases->currentPage(),
                    'per_page' => $purchases->perPage(),
                    'total' => $purchases->total(),
                    'last_page' => $purchases->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function getPurchaseCountByUserId($userId)
    {
        try {
            // حساب عدد الزيارات بناءً على id المستخدم
            $visitCount = Purchase::where('user_id', $userId)->count();

            return response()->json([
                'user_id' => $userId,
                'count' => $visitCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
