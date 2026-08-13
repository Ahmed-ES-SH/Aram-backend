<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\PromoterRatio;
use Illuminate\Http\Request;
use Exception;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class PromoterRatioController extends Controller
{
    use ApiResponse;


    #[OA\Get(
        path: '/get-ratios',
        summary: 'Get the promoter ratios (admin)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
        responses: [
            new OkResponse('Promoter ratios'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getRatiosRatio()
    {
        try {
            $ratios = PromoterRatio::findOrFail(1);
            return $this->successResponse($ratios, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Put(
        path: '/update-ratios',
        summary: 'Update the promoter ratios (admin)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'signup_ratio', type: 'number'),
                    new OA\Property(property: 'purchase_ratio', type: 'number'),
                    new OA\Property(property: 'visit_ratio', type: 'number'),
                    new OA\Property(property: 'service_ratio', type: 'number'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Ratios updated'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function updateRatiosRatio(Request $request)
    {
        try {
            $request->validate([
                'signup_ratio' => 'sometimes|numeric',
                'purchase_ratio' => 'sometimes|numeric',
                'visit_ratio' => 'sometimes|numeric',
                'service_ratio' => 'sometimes|numeric',
            ]);

            $ratios = PromoterRatio::findOrFail(1);
            $ratios->update($request->only('signup_ratio', 'purchase_ratio', 'visit_ratio', 'service_ratio'));
            return $this->successResponse($ratios, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
