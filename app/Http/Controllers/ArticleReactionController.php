<?php

namespace App\Http\Controllers;

use App\Models\ArticleReactionCount;
use Illuminate\Http\Request;
use App\Models\UserArticleReaction;
use App\Models\Blog;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class ArticleReactionController extends Controller
{
    use ApiResponse;
    /**
     * إضافة تفاعل جديد
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addReaction(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'user_id' => 'required',
            'article_id' => 'required|integer|exists:blogs,id',
            'reaction_type' => 'required|string', // مثل 'like', 'dislike', 'love', etc.
        ]);

        $userCheck = UserArticleReaction::where('user_id', $request->user_id)->where('article_id', $request->article_id)->first();

        if ($userCheck) {
            return response()->json(['message' => 'user is already reacted']);
        }

        // بدء عملية الـ Transaction
        DB::beginTransaction();

        try {
            // إضافة التفاعل في جدول user_article_reactions
            $reaction = UserArticleReaction::create([
                'user_id' => $request->user_id,
                'article_id' => $request->article_id,
                'reaction_type' => $request->reaction_type,
            ]);

            // تحديث عدد التفاعلات في جدول article_reactions_count
            $reactionCount = ArticleReactionCount::firstOrCreate(
                ['article_id' => $request->article_id],
                ['likes' => 0, 'dislikes' => 0, 'loves' => 0, 'laughs' => 0]
            );

            // زيادة العدد بناءً على نوع التفاعل
            switch ($request->reaction_type) {
                case 'like':
                    $reactionCount->increment('likes');
                    break;
                case 'dislike':
                    $reactionCount->increment('dislikes');
                    break;
                case 'love':
                    $reactionCount->increment('loves');
                    break;
                case 'laugh':
                    $reactionCount->increment('laughs');
                    break;
                    // يمكنك إضافة المزيد من التفاعلات هنا
            }

            // حفظ التغييرات
            DB::commit();

            return response()->json([
                'message' => 'Reaction added successfully!',
                'reaction' => $reaction,
                'reaction_count' => $reactionCount,
            ], 201);
        } catch (\Exception $e) {
            // التراجع عن العملية في حالة حدوث خطأ
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to add reaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getUserReact($articleId, $userId)
    {
        try {
            $user = UserArticleReaction::where('user_id', $userId)->where('article_id', $articleId)->first();
            if ($user) {
                return response()->json(['user' => $user], 200);
            } else {
                return response()->json(['message' => 'User is not Reacted on this article'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * الحصول على تفاعلات مقال معين
     *
     * @param int $articleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArticleReactions($articleId)
    {
        // الحصول على التفاعلات
        try {
            $reactionCount = ArticleReactionCount::where('article_id', $articleId)->first();
            return $this->successResponse($reactionCount, 'Reactions Founded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * إزالة تفاعل
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeReaction(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'user_id' => 'required',
            'article_id' => 'required',
        ]);

        // بدء عملية الـ Transaction
        DB::beginTransaction();

        try {
            // البحث عن التفاعل وحذفه
            $reaction = UserArticleReaction::where('user_id', $request->user_id)
                ->where('article_id', $request->article_id)
                ->first();

            if ($reaction) {
                // تحديث عدد التفاعلات
                $reactionCount = ArticleReactionCount::where('article_id', $request->article_id)->first();
                if ($reactionCount) {
                    switch ($reaction->reaction_type) {
                        case 'like':
                            $reactionCount->decrement('likes');
                            break;
                        case 'dislike':
                            $reactionCount->decrement('dislikes');
                            break;
                        case 'love':
                            $reactionCount->decrement('loves');
                            break;
                        case 'laugh':
                            $reactionCount->decrement('laughs');
                            break;
                            // يمكنك إضافة المزيد من التفاعلات هنا
                    }
                }

                // حذف التفاعل
                $reaction->delete();

                DB::commit();

                return response()->json([
                    'message' => 'Reaction removed successfully!',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Reaction not found.',
                ], 404);
            }
        } catch (\Exception $e) {
            // التراجع عن العملية في حالة حدوث خطأ
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to remove reaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
