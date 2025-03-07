<?php

namespace App\Http\Controllers;

use App\Models\CardVisit;
use App\Models\User;
use Illuminate\Http\Request;

class CardVisitController extends Controller
{
    public function store(Request $request)
    {
        $user = User::where('user_code', $request->code)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // التحقق مما إذا كان نفس IP قد تم تسجيله مسبقًا لهذا المستخدم
        $ipExists = CardVisit::where('user_id', $user->id)
            ->where('ip_address', $request->ip())
            ->exists();

        if ($ipExists) {
            return response()->json(['message' => 'Visit already recorded'], 200);
        }

        // تسجيل الزيارة إذا لم تكن مسجلة مسبقًا
        CardVisit::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Visit recorded successfully'], 200);
    }


    public function getUsersWithvisitorsCount()
    {
        try {
            // جلب جميع المستخدمين مع عدد عمليات الشراء المكتملة وترتيبهم من الأعلى إلى الأقل مع التصفح
            $users = User::select('id', 'image', 'name', 'user_code')
                ->with('Cardvisitors')
                ->withCount('Cardvisitors')
                ->orderByDesc('Cardvisitors_count') // ترتيب تنازلي حسب عدد العمليات
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

    public function getVisitsByUserId($userId)
    {
        try {
            // جلب جميع عمليات الشراء للمستخدم مع شرط الحالة "مكتملة" مع التصفح
            $purchases = CardVisit::where('user_id', $userId) // البحث باستخدام id المستخدم
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

    public function getVisitCountByUserId($userId)
    {
        try {
            // حساب عدد الزيارات بناءً على id المستخدم
            $visitCount = CardVisit::where('user_id', $userId)->count();

            return response()->json([
                'user_id' => $userId,
                'count' => $visitCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getUserVisits($userId)
    {
        $visits = CardVisit::where('user_id', $userId)->count();
        return response()->json(['visits' => $visits]);
    }
}
