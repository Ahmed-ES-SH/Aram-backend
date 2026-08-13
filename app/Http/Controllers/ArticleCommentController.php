<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Requests\StoreArticleComment;
use App\Http\Traits\ApiResponse;
use App\Models\ArticleComment;
use Exception;
use Illuminate\Http\Request;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\NoContentResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class ArticleCommentController extends Controller
{
    use ApiResponse;


    #[OA\Get(
        path: '/article-comments',
        summary: 'Get paginated comments for an article',
        security: [['sanctum' => []]],
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(name: 'article_id', in: 'query', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new PaginatedOkResponse('ArticleComment'),
            new NoContentResponse(),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function ArticleComments(Request $request)
    {
        try {
            $request->validate([
                'article_id' => 'required|exists:articles,id'
            ]);

            $comments = ArticleComment::where('article_id', $request->article_id)->with(['parent', 'user:id,name,image,email'])->paginate(8);

            if ($comments->total() == 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($comments, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Post(
        path: '/add-comment',
        summary: 'Add a comment to an article',
        security: [['sanctum' => []]],
        tags: ['Articles'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['content', 'user_id', 'article_id'],
                properties: [
                    new OA\Property(property: 'content', type: 'string', maxLength: 255),
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'parent_id', type: 'integer', nullable: true),
                    new OA\Property(property: 'article_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Comment created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreArticleComment $request)
    {
        try {
            $data = $request->validated();
            $comment = ArticleComment::create($data);
            return $this->successResponse($comment, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/update-comment/{id}',
        summary: 'Update an owned article comment',
        security: [['sanctum' => []]],
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['content'],
                properties: [
                    new OA\Property(property: 'content', type: 'string', maxLength: 500),
                ],
            ),
        ),
        responses: [
            new OkResponse('Comment updated'),
            new ErrorResponse(403, 'Comment does not exist or you do not have permission to edit it'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function updateComment(Request $request, $commentId)
    {
        try {
            $userId = auth()->id();
            $comment = ArticleComment::where('id', $commentId)->where('user_id', $userId)->first();

            if (!$comment) {
                return $this->errorResponse([
                    'ar' => 'التعليق غير موجود أو لا تملك الصلاحية لتعديله.',
                    'en' => 'The comment does not exist or you do not have permission to edit it.'
                ], 403);
            }

            $data = $request->validate([
                'content' => 'required|string|max:500'
            ]);

            $comment->update($data);

            return $this->successResponse($comment, 200);
        } catch (\Exception $e) {
            return $this->errorResponse([
                'ar' => 'حدث خطأ أثناء تحديث التعليق: ' . $e->getMessage(),
                'en' => 'An error occurred while updating the comment: ' . $e->getMessage()
            ], 500);
        }
    }



    #[OA\Post(
        path: '/like-comment/{id}',
        summary: 'Like an article comment',
        security: [['sanctum' => []]],
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Comment liked'),
            new ErrorResponse(400, 'You have already liked this comment'),
            new NotFoundResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function likeComment($commentId)
    {
        try {
            $userId = auth()->id(); // جلب معرف المستخدم المسجل حاليًا

            // التحقق مما إذا كان التعليق موجودًا
            $comment = ArticleComment::find($commentId);
            if (!$comment) {
                return $this->errorResponse([
                    'ar' => 'التعليق غير موجود.',
                    'en' => 'The comment does not exist.'
                ], 404);
            }

            // التحقق مما إذا كان المستخدم قد سجل إعجابه بالفعل
            if ($comment->likes()->where('user_id', $userId)->exists()) {
                return $this->errorResponse([
                    'ar' => 'لقد سجلت إعجابك بهذا التعليق من قبل.',
                    'en' => 'You have already liked this comment.'
                ], 400);
            }

            // إضافة الإعجاب إلى التعليق
            $comment->likes()->attach($userId);

            return $this->successResponse([
                'ar' => 'تم تسجيل إعجابك بالتعليق.',
                'en' => 'You have liked the comment.'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse([
                'ar' => 'حدث خطأ أثناء تسجيل الإعجاب: ' . $e->getMessage(),
                'en' => 'An error occurred while liking the comment: ' . $e->getMessage()
            ], 500);
        }
    }



    #[OA\Post(
        path: '/unlike-comment/{id}',
        summary: 'Remove the like from an article comment',
        security: [['sanctum' => []]],
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Comment unliked'),
            new ErrorResponse(400, 'You have not liked this comment before'),
            new NotFoundResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function unlikeComment($commentId)
    {
        try {
            $userId = auth()->id(); // جلب معرف المستخدم المسجل حاليًا

            // التحقق مما إذا كان التعليق موجودًا
            $comment = ArticleComment::find($commentId);
            if (!$comment) {
                return $this->errorResponse([
                    'ar' => 'التعليق غير موجود.',
                    'en' => 'The comment does not exist.'
                ], 404);
            }

            // التحقق مما إذا كان المستخدم قد سجل إعجابه من قبل
            if (!$comment->likes()->where('user_id', $userId)->exists()) {
                return $this->errorResponse([
                    'ar' => 'لم تسجل إعجابك بهذا التعليق من قبل.',
                    'en' => 'You have not liked this comment before.'
                ], 400);
            }

            // إلغاء الإعجاب
            $comment->likes()->detach($userId);

            return $this->successResponse([
                'ar' => 'تم إلغاء إعجابك بالتعليق.',
                'en' => 'You have unliked the comment.'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse([
                'ar' => 'حدث خطأ أثناء إلغاء الإعجاب: ' . $e->getMessage(),
                'en' => 'An error occurred while unliking the comment: ' . $e->getMessage()
            ], 500);
        }
    }
}
