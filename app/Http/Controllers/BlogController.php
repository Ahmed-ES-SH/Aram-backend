<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\ArticleReactionCount;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\organization;
use App\Models\User;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{

    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageservice)
    {
        $this->imageservice = $imageservice;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // جلب المدونات مع العلاقات وتطبيق Pagination
            $blogs = Blog::orderBy('created_at', 'desc')
                ->with('category', 'author') // جلب الفئات والمؤلفين
                ->withCount('comments') // حساب عدد التعليقات
                ->paginate(8);

            // معالجة العناصر لحساب عدد التفاعلات
            $blogsWithReactions = $blogs->getCollection()->map(function ($blog) {
                // جلب عدد التفاعلات من جدول article_reactions_count
                $reaction = DB::table('article_reactions_count')
                    ->where('article_id', $blog->id)
                    ->first();

                $reactionsCount = $reaction ? $reaction->total_reactions : 0; // القيمة الافتراضية 0
                $blog->reactions_count = $reactionsCount; // إضافة عدد التفاعلات
                return $blog;
            });

            // تحديث مجموعة النتائج بعد التعديل
            $blogs->setCollection($blogsWithReactions);

            // إرجاع البيانات مع معلومات الترقيم
            return response()->json([
                'data' => $blogs->items(),
                'pagination' => [
                    'current_page' => $blogs->currentPage(),
                    'last_page' => $blogs->lastPage(),
                    'per_page' => $blogs->perPage(),
                    'total' => $blogs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed error", ['message' => $e->getMessage()], 500);
        }
    }



    public function TopTenArticles()
    {
        try {
            // جلب المقالات مرتبة حسب عدد التفاعلات (الإعجابات) مع الفئات والمؤلفين وعدد التعليقات
            $blogs = Blog::with('category', 'author')
                ->withCount('comments') // حساب عدد التعليقات لكل مقال
                ->join('article_reactions_count', 'blogs.id', '=', 'article_reactions_count.article_id') // الانضمام لجلب عدد التفاعلات
                ->orderByDesc('article_reactions_count.likes') // ترتيب المقالات بناءً على عدد التفاعلات
                ->take(10) // تحديد أول 10 مقالات فقط
                ->get();

            // حساب عدد التفاعلات وتخزينها في متغير
            $blogsWithReactions = $blogs->map(function ($blog) {
                // جلب عدد التفاعلات من جدول article_reactions_count
                $reaction = DB::table('article_reactions_count')->where('article_id', $blog->id)->first();
                $reactionsCount = $reaction ? $reaction->total_reactions : 0; // إذا لم توجد تفاعلات، القيمة الافتراضية 0

                // إضافة عدد التفاعلات كجزء من بيانات المقال (لكن داخل المتغير فقط)
                $blog->reactions_count = $reactionsCount;
                return $blog;
            });

            return response()->json([
                'data' => $blogsWithReactions, // المقالات مع البيانات المطلوبة
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to fetch top articles", ['message' => $e->getMessage()], 500);
        }
    }


    public function getArticlesBySearch($text)
    {
        try {
            $services = Blog::select(
                'blogs.id as blog_id',
                'blogs.title_en',
                'blogs.title_ar',
                'blogs.image',
                'blogs.category_id',
                'article_reactions_count.total_reactions'
            )
                ->where('blogs.title_en', 'like', '%' . $text . '%')
                ->orWhere('blogs.title_ar', 'like', '%' . $text . '%')
                ->orWhere('blogs.content_en', 'like', '%' . $text . '%')
                ->orWhere('blogs.content_ar', 'like', '%' . $text . '%')
                ->join('article_reactions_count', 'blogs.id', '=', 'article_reactions_count.article_id')
                ->with('category')
                ->orderByDesc('article_reactions_count.total_reactions')
                ->paginate(20);

            return response()->json([
                'data' => $services->items(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function getArticlesByCategory($id)
    {
        try {
            $services = Blog::select(
                'blogs.id as blog_id',
                'blogs.author_id',
                'blogs.title_en',
                'blogs.title_ar',
                'blogs.content_en',
                'blogs.content_ar',
                'blogs.image',
                'blogs.category_id',
                'article_reactions_count.total_reactions'
            )
                ->where('blogs.category_id', $id) // البحث بناءً على category_id
                ->join('article_reactions_count', 'blogs.id', '=', 'article_reactions_count.article_id')
                ->with(['category', 'author'])
                ->withCount('comments')
                ->orderByDesc('article_reactions_count.total_reactions')
                ->paginate(20);

            return response()->json([
                'data' => $services->items(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function activearticals()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $articals = Blog::where('active', true)->with('author')->paginate(12);

            // التحقق إذا كانت البطاقات فارغة
            if ($articals->isEmpty()) {
                return response()->json([
                    'message' => 'لا توجد مقالات نشطة حالياً.'
                ], 404);
            }

            // إرسال البطاقات مع تفاصيل التصفح
            return response()->json([
                'data' => $articals->items(), // إرسال البطاقات في الشكل الصحيح
                'pagination' => [
                    'current_page' => $articals->currentPage(),
                    'last_page' => $articals->lastPage(),
                    'per_page' => $articals->perPage(),
                    'total' => $articals->total(),
                ]
            ]);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return $this->errorResponse('حدث خطأ أثناء جلب المقالات النشطة', ['message' => $e->getMessage()], 500);
        }
    }

    public function updateactiveartical($id, $active)
    {
        try {
            // التحقق من وجود البطاقة
            $cardtype = Blog::find($id);

            if (!$cardtype) {
                return response()->json([
                    'message' => 'البطاقة غير موجودة'
                ], 404);
            }

            // التحقق من القيمة الجديدة لـ 'active' (يجب أن تكون true أو false)
            $newActiveState = filter_var($active, FILTER_VALIDATE_BOOLEAN);

            // تحديث حالة النشاط
            $cardtype->active = $newActiveState;
            $cardtype->save();

            return response()->json([
                'message' => 'تم تحديث حالة البطاقة بنجاح',
                'data' => $cardtype
            ], 200);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return response()->json([
                'message' => 'حدث خطأ أثناء تحديث حالة البطاقة',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function paginateComments($blogId)
    {
        try {
            // جلب المقال باستخدام التعليقات
            $blog = Blog::with('comments')->findOrFail($blogId);

            // التحقق من وجود تعليقات للمقال
            if ($blog->comments->isEmpty()) {
                return $this->successResponse([], 'No comments available for this article', 200);
            }

            // استخدام Pagination على التعليقات (30 تعليق لكل صفحة)
            $comments = $blog->comments()->paginate(30);

            return $this->successResponse([
                'data' => $comments->items(),
                'pagination' => [
                    'current_page' => $comments->currentPage(),
                    'last_page' => $comments->lastPage(),
                    'per_page' => $comments->perPage(),
                    'total' => $comments->total(),
                ]
            ], 'Comments paginated successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Blog not found', ['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed error', ['message' => $e->getMessage()], 500);
        }
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        try {
            $data = $request->validated();
            $artical = new Blog();
            $artical->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $artical, 'images/articals');
            }
            $artical->save();
            return $this->successResponse($artical, 'Artical Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // جلب المقال مع الفئة والمؤلف (بدون تحميل التعليقات الآن)
            $blog = Blog::with(['category', 'author'])->find($id);

            // التحقق إذا كان المقال موجودًا
            if (!$blog) {
                return response()->json([
                    'message' => 'Blog not found'
                ], 404);
            }

            // جلب التعليقات الخاصة بالمقال مع Pagination
            $reactionCount = ArticleReactionCount::where('article_id', $id)->first();
            return response()->json([
                'data' => [
                    'blog' => $blog,
                    'reaction_count' => $reactionCount,
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed error", ['message' => $e->getMessage()], 500);
        }
    }


    public function getComments($article_id)
    {
        try {
            $models = Comment::where('article_id', $article_id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $comments = $models->items();
            $commentsWithUsers = [];

            foreach ($comments as $comment) {
                $user_id = $comment->user_id;
                $user_type = $comment->user_type;
                try {
                    $user = $user_type == "User" || $user_type == "user" ? User::findOrFail($user_id) : Organization::findOrFail($user_id);
                    $comment->user = $user;
                    $commentsWithUsers[] = $comment;
                } catch (\Exception $e) {
                    // تجاهل التعليق إذا لم يتم العثور على المستخدم أو المنظمة
                    continue;
                }
            }

            return response()->json([
                'data' => $commentsWithUsers,
                'pagination' => [
                    'current_page' => $models->currentPage(),
                    'last_page' => $models->lastPage(),
                    'per_page' => $models->perPage(),
                    'total' => $models->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show_dash($id)
    {
        try {
            $article = Blog::findOrFail($id);
            return $this->successResponse($article, 'Finded Article SuccessFully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $artical = Blog::findOrFail($id);
            $artical->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $artical, 'images/articals');
            }
            $artical->save();
            return $this->successResponse($artical, 'Artical Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $artical = Blog::findOrFail($id);
            $this->imageservice->deleteOldImage($artical, 'images/articals');
            $artical->delete();
            return $this->successResponse($artical, 'Artical deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }


    public function getcount($id)
    {
        try {
            // البحث عن المقالة بناءً على المعرف
            $article = Blog::findOrFail($id);

            // التحقق من وجود الحقول المطلوبة
            if (!isset($article->views) || !isset($article->likes)) {
                throw new \Exception("The article data is missing required fields.");
            }

            // جلب عدد التعليقات باستخدام علاقة comments
            $commentsCount = $article->comments()->count();  // الحصول على عدد التعليقات للمقال

            $data = [
                'views_count' => $article->views,  // عدد المشاهدات
                'likes_count' => $article->likes,  // عدد الإعجابات
                'comments_count' => $commentsCount,  // عدد التعليقات
            ];

            return $this->successResponse($data, 'Data about numbers', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Article not found', ['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed Error', ['message' => $e->getMessage()], 500);
        }
    }




    public function updateViews($id)
    {
        try {
            $article = Blog::findOrFail($id);

            // زيادة عدد المشاهدات بمقدار 1
            $article->increment('views');

            return $this->successResponse(['views_count' => $article->views], 'Views updated successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Article not found', ['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update views', ['message' => $e->getMessage()], 500);
        }
    }


    public function RandomFiveArticles()
    {
        try {
            // جلب 5 مقالات بشكل عشوائي مع الفئات والمؤلفين وعدد التعليقات
            $blogs = Blog::with('category', 'author')
                ->withCount('comments') // حساب عدد التعليقات لكل مقال
                ->inRandomOrder()
                ->take(12)
                ->get();

            // حساب عدد التفاعلات وتخزينها في متغير
            $blogsWithReactions = $blogs->map(function ($blog) {
                // جلب عدد التفاعلات من جدول article_reactions_count
                $reaction = DB::table('article_reactions_count')->where('article_id', $blog->id)->first();
                $reactionsCount = $reaction ? $reaction->total_reactions : 0; // إذا لم توجد تفاعلات، القيمة الافتراضية 0

                // إضافة عدد التفاعلات كجزء من بيانات المقال (لكن داخل المتغير فقط)
                $blog->reactions_count = $reactionsCount;
                return $blog;
            });

            return response()->json([
                'data' => $blogsWithReactions, // المقالات مع البيانات المطلوبة
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed error", ['message' => $e->getMessage()], 500);
        }
    }
}
