<?php

namespace App\Modules\Article\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Modules\Article\Models\ArticleInteractions;
use App\Modules\Article\Models\UserArticleInteraction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class ArticleInteractionsController extends Controller
{
    use ApiResponse;


    #[OA\Post(
        path: '/check-user-interaction',
        summary: 'Check the current interaction type of a user on an article',
        security: [['sanctum' => []]],
        tags: ['Articles'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id', 'article_id'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'article_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Interaction type or null'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function checkUserInteraction(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'article_id' => 'required|exists:articles,id',
            ]);

            // Find interaction
            $interaction = UserArticleInteraction::where('user_id', $request->user_id)
                ->where('article_id', $request->article_id)
                ->first();

            if ($interaction) {
                return $this->successResponse([
                    'interaction_type' => $interaction->interaction_type
                ], 200);
            }

            return $this->successResponse([
                'interaction_type' => null,
                'message' => 'No interaction found for this user.'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/add-article-interaction',
        summary: 'Add a reaction to an article (love, like, dislike, laughter)',
        security: [['sanctum' => []]],
        tags: ['Articles'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['interaction_type', 'user_id', 'article_id'],
                properties: [
                    new OA\Property(property: 'interaction_type', type: 'string', enum: ['love', 'like', 'dislike', 'laughter']),
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'article_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Reaction added or updated'),
            new ErrorResponse(400, 'User already reacted with the same type'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function addInterAction(Request $request)
    {
        try {
            // Validate request
            $validation = Validator::make($request->all(), [
                'interaction_type' => 'required|in:love,like,dislike,laughter',
                'user_id' => 'required|exists:users,id',
                'article_id' => 'required|exists:articles,id',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse($validation->errors(), 422);
            }

            $interactionType = $request->interaction_type;

            // Get or create article interactions row
            $interaction = ArticleInteractions::firstOrCreate(
                ['article_id' => $request->article_id],
                ['loves' => 0, 'likes' => 0, 'dislikes' => 0, 'laughters' => 0]
            );

            // Check if user already reacted
            $existingInteraction = UserArticleInteraction::where('user_id', $request->user_id)
                ->where('article_id', $request->article_id)
                ->first();

            if ($existingInteraction) {
                if ($existingInteraction->interaction_type === $interactionType) {
                    // Same reaction → return error
                    return $this->errorResponse("User already reacted with the same type.", 400);
                }

                // Decrement old reaction
                $interaction->decrement(match ($existingInteraction->interaction_type) {
                    'love' => 'loves',
                    'like' => 'likes',
                    'dislike' => 'dislikes',
                    'laughter' => 'laughters'
                });

                // Increment new reaction
                $interaction->increment(match ($interactionType) {
                    'love' => 'loves',
                    'like' => 'likes',
                    'dislike' => 'dislikes',
                    'laughter' => 'laughters'
                });

                // Update user's reaction
                $existingInteraction->update(['interaction_type' => $interactionType]);

                return $this->successResponse($interaction, 201);
            }

            // If no previous reaction → create new
            $interaction->increment(match ($interactionType) {
                'love' => 'loves',
                'like' => 'likes',
                'dislike' => 'dislikes',
                'laughter' => 'laughters'
            });

            UserArticleInteraction::create([
                'user_id' => $request->user_id,
                'article_id' => $request->article_id,
                'interaction_type' => $interactionType
            ]);

            return $this->successResponse($interaction, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/update-article-interaction',
        summary: 'Change the reaction type of a user on an article',
        security: [['sanctum' => []]],
        tags: ['Articles'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['interaction_type', 'user_id', 'article_id'],
                properties: [
                    new OA\Property(property: 'interaction_type', type: 'string', enum: ['love', 'like', 'dislike', 'laughter']),
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'article_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Interaction updated'),
            new ErrorResponse(400, 'No changes detected in the interaction type'),
            new NotFoundResponse(),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function updateInteraction(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validation = Validator::make($request->all(), [
                'interaction_type' => 'required|in:love,like,dislike,laughter', // تصحيح التفاعل الجديد
                'user_id' => 'required|exists:users,id',
                'article_id' => 'required|exists:articles,id',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse($validation->errors(), 422);
            }

            // البحث عن التفاعل الحالي للمستخدم مع المقال
            $userInteraction = UserArticleInteraction::where('user_id', $request->user_id)
                ->where('article_id', $request->article_id)
                ->first();

            if (!$userInteraction) {
                return $this->errorResponse("لقد قمت بالتفاعل مع هذا المقال مره بالفعل .", 404);
            }

            $oldInteractionType = $userInteraction->interaction_type;
            $newInteractionType = $request->interaction_type;

            // إذا لم يغير المستخدم نوع التفاعل، لا داعي للتحديث
            if ($oldInteractionType === $newInteractionType) {
                return $this->errorResponse("No changes detected in the interaction type.", 400);
            }

            // تحديث عدد التفاعلات في جدول `ArticleInteractions`
            $interaction = ArticleInteractions::where('article_id', $request->article_id)->first();

            if (!$interaction) {
                return $this->errorResponse("Article interaction record not found.", 404);
            }

            // تقليل العدد من التفاعل السابق
            match ($oldInteractionType) {
                'love' => $interaction->decrement('loves'),
                'like' => $interaction->decrement('likes'),
                'dislike' => $interaction->decrement('dislikes'),
                'laughter' => $interaction->decrement('laughters'),
            };

            // زيادة العدد في التفاعل الجديد
            match ($newInteractionType) {
                'love' => $interaction->increment('loves'),
                'like' => $interaction->increment('likes'),
                'dislike' => $interaction->increment('dislikes'),
                'laughter' => $interaction->increment('laughters'),
            };

            // تحديث التفاعل في سجل المستخدم
            $userInteraction->update([
                'interaction_type' => $newInteractionType
            ]);

            return $this->successResponse($interaction, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Delete(
        path: '/cancel-article-interaction',
        summary: 'Remove a user reaction from an article',
        security: [['sanctum' => []]],
        tags: ['Articles'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id', 'article_id'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'article_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Interaction removed successfully'),
            new NotFoundResponse(),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function removeInteraction(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validation = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'article_id' => 'required|exists:articles,id',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse($validation->errors(), 422);
            }

            // البحث عن التفاعل الحالي للمستخدم مع المقال
            $userInteraction = UserArticleInteraction::where('user_id', $request->user_id)
                ->where('article_id', $request->article_id)
                ->first();

            if (!$userInteraction) {
                return $this->errorResponse("User has not reacted to this article.", 404);
            }

            $interactionType = $userInteraction->interaction_type;

            // البحث عن سجل التفاعلات في `ArticleInteractions`
            $interaction = ArticleInteractions::where('article_id', $request->article_id)->first();

            if (!$interaction) {
                return $this->errorResponse("Article interaction record not found.", 404);
            }

            // تقليل العدد من نوع التفاعل الحالي
            match ($interactionType) {
                'love' => $interaction->decrement('loves'),
                'like' => $interaction->decrement('likes'),
                'dislike' => $interaction->decrement('dislikes'),
                'laughter' => $interaction->decrement('laughters'),
            };

            // حذف التفاعل من جدول المستخدمين
            $userInteraction->delete();

            return $this->successResponse("Interaction removed successfully.", 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
