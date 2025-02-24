<?php

namespace App\Http\Controllers;

use App\Models\promotionalCard;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionalCardController extends Controller
{
    use ApiResponse;

    public function getStatics()
    {
        try {
            // جلب إحصائيات العمليات لكل مروج بشكل منفصل بناءً على البطاقة مع التصفح
            $statistics = PromotionalCard::select(
                'id',
                'bell_id',
                'card_id',
                'promoter_code',
                DB::raw('COUNT(id) as total_operations'),
                DB::raw('SUM(order_quantity) as total_order_quantity')
            )
                ->with([
                    'card:id,image,title_en',
                    'bell:id,amount',
                    'promoter:id,name,user_code,image'
                ]) // جلب بيانات المروج
                ->groupBy('id', 'bell_id', 'card_id', 'promoter_code') // تجميع البيانات لكل بطاقة ومروج
                ->orderByDesc('total_order_quantity')
                ->paginate(10); // تحديد 10 عناصر لكل صفحة

            return response()->json([
                'data' => $statistics->items(),
                'pagination' => [
                    'current_page' => $statistics->currentPage(),
                    'per_page' => $statistics->perPage(),
                    'total' => $statistics->total(),
                    'last_page' => $statistics->lastPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get statistics', ['message' => $e->getMessage()], 500);
        }
    }


    public function getOperationsCountByPromoterCode($promoterCode)
    {
        try {
            // جلب عدد العمليات لمروج معين باستخدام كود المروج
            $totalOperations = PromotionalCard::where('promoter_code', $promoterCode)
                ->count();

            return response()->json([
                'promoter_code' => $promoterCode,
                'total_operations' => $totalOperations
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get operations count', ['message' => $e->getMessage()], 500);
        }
    }



    public function getStaticsByCardId($cardId)
    {
        try {
            // جلب إحصائيات العمليات لكل مروج بشكل منفصل بناءً على البطاقة مع التصفح
            $statistics = PromotionalCard::select(
                'id',
                'bell_id',
                'card_id',
                'promoter_code',
                DB::raw('COUNT(id) as total_operations'),
                DB::raw('SUM(order_quantity) as total_order_quantity')
            )
                ->where('card_id', $cardId) // تصفية النتائج بناءً على card_id
                ->with([
                    'card:id,image,title_en',
                    'bell',
                    'promoter:id,name,user_code,image'
                ]) // جلب بيانات المروج
                ->groupBy('id', 'bell_id', 'card_id', 'promoter_code') // تجميع البيانات لكل بطاقة ومروج
                ->orderByDesc('total_order_quantity')
                ->paginate(10); // تحديد 10 عناصر لكل صفحة

            return response()->json([
                'data' => $statistics->items(),
                'pagination' => [
                    'current_page' => $statistics->currentPage(),
                    'per_page' => $statistics->perPage(),
                    'total' => $statistics->total(),
                    'last_page' => $statistics->lastPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get statistics', ['message' => $e->getMessage()], 500);
        }
    }
}
