<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransactions;
use App\Models\organization;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FinancialTransactionsController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function getDataById($id)
    {
        try {
            // جلب البيانات مع الترتيب والتقسيم للصفحات
            $models = FinancialTransactions::where('organization_id', $id)
                ->orderBy('created_at', 'desc')
                ->paginate(25);

            if ($models->isEmpty()) {
                return response()->json([
                    'message' => 'NO Data Available Yet .'
                ], 404);
            }

            // معالجة البيانات وإضافة معلومات المستخدم
            $data = $models->map(function ($line) {
                $user_type = $line->account_type;
                $user_id = $line->user_id;
                $line->bell_items = is_string($line->bell_items) ? json_decode($line->bell_items) : $line->bell_items;
                if ($user_id) {
                    $line->Bill_payer = $user_type === 'User'
                        ? User::where('id', $user_id)->select('id', 'name', 'image')->first()
                        : Organization::where('id', $user_id)->select('id', 'icon', 'title_en', 'title_ar')->first();
                }

                return $line;
            });

            // إرجاع البيانات بصيغة JSON
            return response()->json([
                'data' => $data,
                'pagination' => [
                    'current_page' => $models->currentPage(),
                    'last_page' => $models->lastPage(),
                    'per_page' => $models->perPage(),
                    'total' => $models->total(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed Error', ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialTransactions $financialTransactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialTransactions $financialTransactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialTransactions $financialTransactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialTransactions $financialTransactions)
    {
        //
    }
}
