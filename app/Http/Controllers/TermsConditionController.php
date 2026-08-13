<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\TermsCondition;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class TermsConditionController extends Controller
{
    use ApiResponse;

    #[OA\Get(
        path: '/users-terms',
        summary: 'List user terms and conditions points',
        tags: ['Settings'],
        responses: [
            new ListOkResponse('PolicyPoint'),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $points = TermsCondition::all();
            return $this->successResponse($points, 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    // إضافة نقطة جديدة
    #[OA\Post(
        path: '/add-oranization-term',
        summary: 'Create an organization terms and conditions point (admin)',
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
            new CreatedResponse('Terms point created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    #[OA\Post(
        path: '/add-user-term',
        summary: 'Create a terms and conditions point (admin)',
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
            new CreatedResponse('Terms point created'),
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

        $policy = TermsCondition::create([
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
        ]);

        $policy->save();

        return response()->json($policy, 201);
    }

    // تعديل نقطة
    #[OA\Post(
        path: '/update-oranization-term/{id}',
        summary: 'Update an organization terms and conditions point (admin)',
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
            new OkResponse('Terms point updated'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    #[OA\Post(
        path: '/update-user-term/{id}',
        summary: 'Update a terms and conditions point (admin)',
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
            new OkResponse('Terms point updated'),
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

        $policy = TermsCondition::findOrFail($id);
        $policy->update([
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
        ]);

        $policy->save();

        return response()->json($policy);
    }

    // حذف نقطة
    #[OA\Delete(
        path: '/oranization-term/{id}',
        summary: 'Delete an organization terms and conditions point (admin)',
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
    #[OA\Delete(
        path: '/user-term/{id}',
        summary: 'Delete a terms and conditions point (admin)',
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
        $policy = TermsCondition::findOrFail($id);
        $policy->delete();

        return response()->json(['message' => 'Policy deleted successfully']);
    }
}
