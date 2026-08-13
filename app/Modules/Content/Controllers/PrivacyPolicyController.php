<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Modules\Content\Models\PrivacyPolicy;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class PrivacyPolicyController extends Controller
{
    use ApiResponse;

    #[OA\Get(
        path: '/users-points',
        summary: 'List user privacy policy points',
        tags: ['Settings'],
        responses: [
            new ListOkResponse('PolicyPoint'),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $points = PrivacyPolicy::all();
            return $this->successResponse($points, 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    // إضافة نقطة جديدة
    #[OA\Post(
        path: '/add-user-point',
        summary: 'Create a privacy policy point (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['content_en', 'content_ar'],
                properties: [
                    new OA\Property(property: 'content_en', type: 'string'),
                    new OA\Property(property: 'content_ar', type: 'string'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Policy point created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(Request $request)
    {
        $request->validate([
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
        ]);

        $policy = PrivacyPolicy::create([
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
        ]);

        $policy->save();

        return response()->json($policy, 201);
    }

    // تعديل نقطة
    #[OA\Post(
        path: '/update-user-point/{id}',
        summary: 'Update a privacy policy point (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'content_en', type: 'string'),
                    new OA\Property(property: 'content_ar', type: 'string'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Policy point updated'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(Request $request, $id)
    {
        $request->validate([
            'content_en' => 'sometimes|string',
            'content_ar' => 'sometimes|string',
        ]);

        $policy = PrivacyPolicy::findOrFail($id);
        $policy->update([
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
        ]);

        $policy->save();

        return response()->json($policy);
    }

    // حذف نقطة
    #[OA\Delete(
        path: '/user-point/{id}',
        summary: 'Delete a privacy policy point (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Policy deleted successfully'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        $policy->delete();

        return response()->json(['message' => 'Policy deleted successfully']);
    }
}
