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
            'buyer_id' => 'required|exists:users,id',
            'buyer_type' => 'required|in:user,User,organization,Organization'
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
            'buyer_id' => $request->buyer_id, // إذا كان المستخدم مسجلاً
            'buyer_type' => $request->buyer_type, // إذا كان المستخدم مسجلاً
            'promo_code' => $request->promo_code,
            'amount' => $request->amount,
            'uniqId' => $unqieID
        ]);

        return response()->json(['message' => 'Purchase recorded successfully', 'data' => $purchase, 201]);
    }



    public function getUsersWithPurchaseTotalAndCount()
    {
        try {
            // جلب جميع المستخدمين مع مجموع المبالغ الخاصة بالعمليات المكتملة وعدد العمليات المكتملة وترتيبهم من الأعلى إلى الأقل مع التصفح
            $users = User::select('id', 'image', 'name', 'user_code')
                ->withSum(['purchases' => function ($query) {
                    $query->where('status', 'completed');
                }], 'amount') // إضافة مجموع المبالغ لكل مستخدم
                ->withCount(['purchases' => function ($query) {
                    $query->where('status', 'completed');
                }]) // إضافة عدد العمليات المكتملة لكل مستخدم
                ->orderByDesc('purchases_sum_amount') // ترتيب تنازلي حسب مجموع المبالغ
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
            // جلب عمليات الشراء للمستخدم مع الحالة "مكتملة"
            $purchases = Purchase::where('user_id', $userId)
                ->where('status', 'completed')
                ->with([
                    'user:id,name,image,user_code',
                    'buyerUser:id,name,image,account_type',
                    'buyerOrganization:id,title_en,icon,account_type',
                    'bell'
                ])
                ->select('id', 'bell_id', 'user_id', 'amount',  'buyer_id', 'buyer_type', 'status', 'created_at') // اختيار الحقول فقط
                ->paginate(20);

            // تعديل البيانات لإرجاع buyer المناسب فقط
            $purchases->getCollection()->transform(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'user_id' => $purchase->user_id,
                    'buyer_type' => $purchase->buyer_type,
                    'amount' => $purchase->amount,
                    'status' => $purchase->status,
                    'created_at' => $purchase->created_at,
                    'user' => $purchase->user,
                    'bell' => $purchase->bell,
                    'buyer' => $purchase->buyer_type === 'User' ? $purchase->buyerUser : $purchase->buyerOrganization,
                    'created_at' => $purchase->created_at,
                ];
            });

            return response()->json([
                'data' => $purchases->items(), // إرجاع العناصر فقط
                'pagination' => [
                    'current_page' => $purchases->currentPage(),
                    'per_page' => $purchases->perPage(),
                    'total' => $purchases->total(),
                    'last_page' => $purchases->lastPage(),
                ]
            ]); // إرجاع البيانات بعد التعديل
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
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
