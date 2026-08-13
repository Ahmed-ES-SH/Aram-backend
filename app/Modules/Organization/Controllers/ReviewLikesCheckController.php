<?php

namespace App\Modules\Organization\Controllers;
use App\Http\Controllers\Controller;

use OpenApi\Attributes as OA;
use App\Modules\Organization\Models\organizationReview;
use App\Modules\Organization\Models\ReviewLikesCheck;
use Illuminate\Http\Request;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class ReviewLikesCheckController extends Controller
{


    #[OA\Post(
        path: '/react-review',
        summary: 'React (like) to a review',
        tags: ['Reviews'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id', 'organization_id', 'review_id'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'organization_id', type: 'integer'),
                    new OA\Property(property: 'review_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('User reacted successfully'),
            new OkResponse('Already reacted to this review'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'organization_id' => 'required|exists:organizations,id',
                'review_id' => 'required|exists:organization_reviews,id',
            ]);

            // تحقق مما إذا كان المستخدم قد تفاعل مع المراجعة من قبل
            $existingReaction = ReviewLikesCheck::where('user_id', $request->user_id)
                ->where('review_id', $request->review_id)
                ->first();

            if ($existingReaction) {
                // إذا كان هناك تفاعل سابق، إرجاع رسالة تفيد بذلك
                return response()->json([
                    'message' => 'User has already reacted to this review.'
                ]);
            }

            // إذا لم يكن قد تفاعل مسبقًا، يتم حفظ التفاعل الجديد
            $check = new ReviewLikesCheck();
            $check->user_id = $request->user_id;
            $check->review_id = $request->review_id;
            $check->organization_id = $request->organization_id;
            $check->save();

            $review = organizationReview::findOrFail($request->review_id);
            $review->like_counts += 1;
            $review->save();

            return response()->json([
                'data' => $check,
                'message' => 'User reacted successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    #[OA\Get(
        path: '/review-like-user/{orgId}/{userId}',
        summary: 'Get review ids the user liked for an organization',
        tags: ['Reviews'],
        parameters: [
            new OA\Parameter(name: 'orgId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'userId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Liked review ids'),
            new ServerErrorResponse(),
        ],
    )]
    public function GetReviewsForUser($orgId, $userId)
    {
        try {
            $reviews = ReviewLikesCheck::where('organization_id', $orgId)
                ->where('user_id', $userId)
                ->pluck('review_id'); // يجلب المعرّفات فقط كمصفوفة

            return response()->json(['data' =>  $reviews], 200); // إرجاع البيانات كمصفوفة مباشرة
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/review-like/{reviewId}/{userId}',
        summary: 'Remove a review reaction',
        tags: ['Reviews'],
        parameters: [
            new OA\Parameter(name: 'reviewId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'userId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Reaction removed'),
            new NotFoundResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($reviewId, $userId)
    {
        try {
            // تحقق من وجود التفاعل الخاص بالمراجعة والمستخدم
            $check = ReviewLikesCheck::where('review_id', $reviewId)
                ->where('user_id', $userId) // تأكد من معرّف المستخدم
                ->first();

            // إذا لم يوجد تفاعل، أعد رسالة خطأ
            if (!$check) {
                return response()->json(['message' => 'No reaction found to remove.'], 404);
            }

            // ابحث عن المراجعة وحدث العداد
            $review = organizationReview::findOrFail($reviewId);
            if ($review->like_counts > 0) {
                $review->like_counts -= 1;
                $review->save();
            }

            // احذف التفاعل من جدول التفاعلات
            $check->delete();

            // إرجاع رسالة نجاح
            return response()->json(['message' => 'User successfully removed their reaction.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
