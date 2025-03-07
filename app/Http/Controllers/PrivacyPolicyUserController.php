<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicyUser;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PrivacyPolicyUserController extends Controller
{

    use ApiResponse;

    public function index()
    {
        try {
            $points = PrivacyPolicyUser::all();
            return $this->successResponse($points, "Founded All Points", 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    // إضافة نقطة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
        ]);

        $policy = PrivacyPolicyUser::create([
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
        ]);

        $policy->save();

        return response()->json($policy, 201);
    }

    // تعديل نقطة
    public function update(Request $request, $id)
    {
        $request->validate([
            'content_en' => 'sometimes|string',
            'content_ar' => 'sometimes|string',
        ]);

        $policy = PrivacyPolicyUser::findOrFail($id);
        $policy->update([
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
        ]);

        $policy->save();

        return response()->json($policy);
    }

    // حذف نقطة
    public function destroy($id)
    {
        $policy = PrivacyPolicyUser::findOrFail($id);
        $policy->delete();

        return response()->json(['message' => 'Policy deleted successfully']);
    }
}
