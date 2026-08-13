<?php

namespace App\Modules\Organization\Controllers;
use App\Http\Controllers\Controller;

use OpenApi\Attributes as OA;
use App\Modules\Organization\Requests\StoreOrganizationReview;
use App\Http\Traits\ApiResponse;
use App\Modules\Organization\Models\OrganizationReview;
use Illuminate\Http\Request;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class OrganizationReviewController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/org-reviews/{id}',
        summary: 'Get paginated reviews for an organization',
        tags: ['Reviews'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Organization reviews with pagination'),
            new NotFoundResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function ReviewsForOrg($id)
    {
        try {
            $reviewsforOrg = OrganizationReview::where('organization_id', $id)
                ->orderBy('created_at', 'desc')
                ->with('user', function ($query) {
                    $query->select('id', 'name', 'image');
                })
                ->paginate(10);


            if ($reviewsforOrg->isEmpty()) {
                return response()->json(['message' => "No reviews Founded For THis Organization"], 404);
            }

            return response()->json([
                'data' => $reviewsforOrg->items(),
                'pagination' => [
                    'current_page' => $reviewsforOrg->currentPage(),
                    'last_page' => $reviewsforOrg->lastPage(),
                    'total' => $reviewsforOrg->total(),
                    'per_page' => $reviewsforOrg->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/org-reviews-numbers/{id}',
        summary: 'Get reviews statistics (counts and average rating)',
        tags: ['Reviews'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Reviews statistics'),
            new ServerErrorResponse(),
        ],
    )]
    public function ReviewsNumbers($id)
    {
        try {
            // حساب عدد المراجعات لكل تصنيف من النجوم (من 1 إلى 5)
            $reviewsData = OrganizationReview::where('organization_id', $id)
                ->selectRaw('stars, COUNT(*) as count')
                ->groupBy('stars')
                ->orderBy('stars', 'asc')
                ->pluck('count', 'stars');

            // حساب العدد الكلي لجميع التقييمات
            $totalReviews = $reviewsData->sum();

            // حساب مجموع القيم بناءً على التقييمات
            $totalStars = 0;
            $starsSummary = [];

            for ($i = 1; $i <= 5; $i++) {
                $count = $reviewsData[$i] ?? 0;
                $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 2) : 0;

                $starsSummary[$i] = [
                    'count' => $count,
                    'percentage' => $percentage
                ];

                // إضافة قيمة التقييم إلى المجموع
                $totalStars += $count * $i;
            }

            // حساب متوسط التقييم (إجمالي النجوم مقسوماً على عدد التقييمات)
            $averageRating = $totalReviews > 0 ? round($totalStars / $totalReviews, 2) : 0;

            // إرجاع الاستجابة
            return response()->json([
                'organization_id' => $id,
                'total_reviews' => $totalReviews,
                'average_rating' => $averageRating,
                'reviews_count_by_stars' => $starsSummary
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }





    #[OA\Post(
        path: '/add-review',
        summary: 'Add a review for an organization',
        security: [['sanctum' => []]],
        tags: ['Reviews'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['stars', 'head_line', 'content', 'user_id', 'organization_id'],
                properties: [
                    new OA\Property(property: 'stars', type: 'integer', minimum: 1, maximum: 5),
                    new OA\Property(property: 'head_line', type: 'string', maxLength: 255),
                    new OA\Property(property: 'content', type: 'string', minLength: 4),
                    new OA\Property(property: 'like_counts', type: 'integer', nullable: true, minimum: 0),
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'organization_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Review created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreOrganizationReview $request)
    {
        try {
            $data = $request->validated();
            $review = new OrganizationReview();
            $review->fill($data);
            $review->save();
            $reviewWithUser = $review->load('user');
            return $this->successResponse($reviewWithUser, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/delete-review/{id}',
        summary: 'Delete a review',
        security: [['sanctum' => []]],
        tags: ['Reviews'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Review deleted'),
            new NotFoundResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $review = OrganizationReview::findOrFail($id);
            $review->delete();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
