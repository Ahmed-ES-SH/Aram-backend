<?php

namespace App\Http\Controllers;

use App\Models\balance;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    use ApiResponse;


    public function getNumbersbyorganizationId($id, $type)
    {
        try {
            $column_name = $type == 'User' ? 'user_id' : 'organization_id';
            $numbers = balance::where($column_name, $id)->orderBy('created_at', 'desc')->firstOrFail();
            return response()->json([
                'data' => $numbers
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message', $e->getMessage()], 500);
        }
    }
}
