<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreorganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\organization;
use App\Models\ServiceCategory;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class OrganizationController extends Controller
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




    public function organizationsCount()
    {
        try {
            // افتراض أن هناك نموذج اسمه User
            $count = organization::count();

            // إرجاع استجابة ناجحة مع العدد
            return $this->successResponse($count, "Users count retrieved successfully", 200);
        } catch (\Exception $e) {
            // في حال حدوث خطأ، يتم إرجاع استجابة خطأ
            return $this->errorResponse("Failed to retrieve users count", ['message' => $e->getMessage()], 500);
        }
    }


    public function OrganizationsForSelectionTable()
    {
        try {
            $orgs = Organization::select('id', 'title_en', 'email', 'phone_number', 'icon', 'number_of_reservations', 'created_at')
                ->orderBy('created_at', 'desc')
                ->paginate(25);

            if ($orgs->isEmpty()) {
                return $this->successResponse([], 'No organizations found.', 200);
            }


            return response()->json([
                'data' => $orgs->items(),
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to retrieve organizations", ['message' => $e->getMessage()], 500);
        }
    }



    public function getOrganizationsIds()
    {
        try {
            $users = organization::pluck('id');
            return $this->successResponse($users, "Users IDs retrieved successfully", 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to retrieve users IDs", ['message' => $e->getMessage()], 500);
        }
    }


    public function index()
    {
        try {
            // جلب المنظمات مع الأقسام الخاصة بها استنادًا إلى categories_ids المخزنة في قاعدة البيانات
            $orgs = Organization::orderBy('created_at', 'desc')->paginate(8);

            // التحقق من وجود بيانات
            if ($orgs->isEmpty()) {
                return $this->successResponse([], 'No organizations found.', 200);
            }

            // جلب الأقسام المتوافقة مع الـ categories_ids لجميع المنظمات في الـ orgs
            $categoryIds = $orgs->pluck('categories_ids')->flatten()->unique();

            // تحويل الـ categories_ids إلى مصفوفة حقيقية في حال كانت سلسلة نصية
            $categoryIds = $categoryIds->map(function ($categoryId) {
                return json_decode($categoryId);
            })->flatten()->unique();

            // جلب الأقسام المتوافقة
            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // تحويل المصفوفة إلى Collection لاستخدام map
            $orgsWithCategories = collect($orgs->items())->map(function ($org) use ($categories) {
                // التأكد من أن categories_ids هي مصفوفة
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;

                if (!is_array($categoryIds)) {
                    $categoryIds = []; // تعيين مصفوفة فارغة إذا لم تكن صالحة
                }

                // إضافة الأقسام الخاصة بالمنظمة
                $org->categories = collect();

                foreach ($categoryIds as $categoryId) {
                    if ($categories->has($categoryId)) {
                        $org->categories->push($categories->get($categoryId));
                    }
                }

                return $org;
            });

            // إرجاع المنظمات مع الأقسام المرتبطة بها
            return response()->json([
                'data' => $orgsWithCategories,
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed error', ['message' => $e->getMessage()], 500);
        }
    }



    public function orgsByRateing()
    {
        try {
            // جلب المنظمات مع الأقسام الخاصة بها استنادًا إلى categories_ids المخزنة في قاعدة البيانات
            $orgs = Organization::where('status', 'published')->orderBy('rateing', 'desc')->paginate(8);

            // التحقق من وجود بيانات
            if ($orgs->isEmpty()) {
                return $this->errorResponse("Faild Error", ['mesage' => 'no organization found'], 404);
            }

            // جلب الأقسام المتوافقة مع الـ categories_ids لجميع المنظمات في الـ orgs
            $categoryIds = $orgs->pluck('categories_ids')->flatten()->unique();

            // تحويل الـ categories_ids إلى مصفوفة حقيقية في حال كانت سلسلة نصية
            $categoryIds = $categoryIds->map(function ($categoryId) {
                return json_decode($categoryId);
            })->flatten()->unique();

            // جلب الأقسام المتوافقة
            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // تحويل المصفوفة إلى Collection لاستخدام map
            $orgsWithCategories = collect($orgs->items())->map(function ($org) use ($categories) {
                // التأكد من أن categories_ids هي مصفوفة
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;

                if (!is_array($categoryIds)) {
                    $categoryIds = []; // تعيين مصفوفة فارغة إذا لم تكن صالحة
                }

                // إضافة الأقسام الخاصة بالمنظمة
                $org->categories = collect();

                foreach ($categoryIds as $categoryId) {
                    if ($categories->has($categoryId)) {
                        $org->categories->push($categories->get($categoryId));
                    }
                }

                return $org;
            });

            // إرجاع المنظمات مع الأقسام المرتبطة بها
            return response()->json([
                'data' => $orgsWithCategories,
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed error', ['message' => $e->getMessage()], 500);
        }
    }

    public function orgsbynumberofreservations()
    {
        try {
            // جلب المنظمات مع الأقسام الخاصة بها استنادًا إلى categories_ids المخزنة في قاعدة البيانات
            $orgs = Organization::orderBy('number_of_reservations', 'desc')->paginate(8);

            // التحقق من وجود بيانات
            if ($orgs->isEmpty()) {
                return $this->successResponse([], 'No organizations found.', 200);
            }

            // جلب الأقسام المتوافقة مع الـ categories_ids لجميع المنظمات في الـ orgs
            $categoryIds = $orgs->pluck('categories_ids')->flatten()->unique();

            // تحويل الـ categories_ids إلى مصفوفة حقيقية في حال كانت سلسلة نصية
            $categoryIds = $categoryIds->map(function ($categoryId) {
                return json_decode($categoryId);
            })->flatten()->unique();

            // جلب الأقسام المتوافقة
            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // تحويل المصفوفة إلى Collection لاستخدام map
            $orgsWithCategories = collect($orgs->items())->map(function ($org) use ($categories) {
                // التأكد من أن categories_ids هي مصفوفة
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;

                if (!is_array($categoryIds)) {
                    $categoryIds = []; // تعيين مصفوفة فارغة إذا لم تكن صالحة
                }

                // إضافة الأقسام الخاصة بالمنظمة
                $org->categories = collect();

                foreach ($categoryIds as $categoryId) {
                    if ($categories->has($categoryId)) {
                        $org->categories->push($categories->get($categoryId));
                    }
                }

                return $org;
            });

            // إرجاع المنظمات مع الأقسام المرتبطة بها
            return response()->json([
                'data' => $orgsWithCategories,
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed error', ['message' => $e->getMessage()], 500);
        }
    }



    public function organizationsByLocation($address)
    {
        try {
            // فك تشفير العنوان المستلم
            $decodedAddress = urldecode($address);

            // جلب جميع المؤسسات بدون Pagination
            $models = Organization::where('status', 'published')->orderBy('created_at', 'desc')->get();

            // تحويل المنظمات إلى Collection
            $orgs = collect($models);

            // استخراج جميع categories_ids من المنظمات وتوحيد القيم إلى أرقام
            $categoryIds = $orgs->pluck('categories_ids')->map(function ($categories) {
                return is_string($categories) ? json_decode($categories, true) : $categories;
            })->filter()->flatten()->map(fn($categoryId) => (int) $categoryId)->unique();

            // جلب الأقسام المتوافقة مع categories_ids
            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // تصفية المنظمات بناءً على العنوان باستخدام `mb_stripos`
            $filteredOrgs = $orgs->map(function ($org) use ($decodedAddress, $categories) {
                // تحويل location من JSON إلى كائن
                $location = json_decode($org->location);

                if ($location && isset($location->address)) {
                    // التحقق مما إذا كان العنوان يحتوي على النص المطلوب
                    if (mb_stripos($location->address, $decodedAddress) !== false) {
                        $org->categories = collect();
                        $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;

                        if (is_array($categoryIds) && !empty($categoryIds)) {
                            foreach ($categoryIds as $categoryId) {
                                if ($categories->has($categoryId)) {
                                    $org->categories->push($categories->get($categoryId));
                                }
                            }
                        }

                        return $org;
                    }
                }

                return null;
            })->filter();

            // تحقق إذا كانت البيانات المفلترة فارغة
            if ($filteredOrgs->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page' => 1,
                        'per_page' => 8,
                        'total' => 0,
                    ]
                ]);
            }

            // تطبيق Pagination على البيانات المفلترة
            $perPage = 8;
            $currentPage = request()->get('page', 1);
            $total = $filteredOrgs->count();
            $paginatedOrgs = $filteredOrgs->slice(($currentPage - 1) * $perPage, $perPage)->values();

            return response()->json([
                'data' => $paginatedOrgs,
                'pagination' => [
                    'current_page' => $currentPage,
                    'last_page' => ceil($total / $perPage),
                    'per_page' => $perPage,
                    'total' => $total,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed Error', 'error' => $e->getMessage()], 500);
        }
    }







    public function AllorganizationsByServiceCategory($id)
    {
        try {
            // جلب جميع الـ categories_ids فقط من الجدول
            $dataForFilter = Organization::orderBy('created_at', 'desc')->select('id', 'categories_ids')->get();

            // تصفية المنظمات التي تحتوي على الفئة المطلوبة
            $filteredIds = $dataForFilter->filter(function ($org) use ($id) {
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;
                return is_array($categoryIds) && in_array($id, $categoryIds);
            })->pluck('id'); // استخراج IDs فقط

            // جلب البيانات الكاملة للمنظمات التي تتوافق مع الفلتر
            $organizations = Organization::whereIn('id', $filteredIds)->orderBy('created_at', 'desc')->get();

            // جلب الأقسام المتوافقة مع categories_ids
            $categoryIds = $organizations->pluck('categories_ids')->map(function ($categories) {
                return is_string($categories) ? json_decode($categories, true) : $categories;
            })->filter()->flatten()->unique();

            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // إضافة الأقسام الخاصة بكل منظمة
            $organizations->each(function ($org) use ($categories) {
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;
                $org->categories = collect($categoryIds)->map(function ($categoryId) use ($categories) {
                    return $categories->get($categoryId);
                })->filter();
            });

            // تطبيق Pagination يدوي
            $perPage = 8; // عدد العناصر في كل صفحة
            $currentPage = request()->get('page', 1); // الحصول على رقم الصفحة من الطلب
            $paginatedOrgs = $organizations->slice(($currentPage - 1) * $perPage, $perPage)->values();

            // إرجاع الاستجابة مع المنظمات والـ pagination المناسب
            return response()->json([
                'data' => $paginatedOrgs,
                'pagination' => [
                    'current_page' => (int)$currentPage,
                    'last_page' => ceil($organizations->count() / $perPage),
                    'per_page' => $perPage,
                    'total' => $organizations->count(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }
    public function organizationsByServiceCategory($id)
    {
        try {
            // جلب جميع الـ categories_ids فقط من الجدول
            $dataForFilter = Organization::where('status', 'published')->orderBy('created_at', 'desc')->select('id', 'categories_ids')->get();

            if ($dataForFilter->isEmpty()) {
                return response()->json(['message' => 'No organizations found'], 404);
            }

            // تصفية المنظمات التي تحتوي على الفئة المطلوبة
            $filteredIds = $dataForFilter->filter(function ($org) use ($id) {
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;
                return is_array($categoryIds) && in_array($id, $categoryIds);
            })->pluck('id'); // استخراج IDs فقط

            // جلب البيانات الكاملة للمنظمات التي تتوافق مع الفلتر
            $organizations = Organization::whereIn('id', $filteredIds)->orderBy('created_at', 'desc')->get();

            // جلب الأقسام المتوافقة مع categories_ids
            $categoryIds = $organizations->pluck('categories_ids')->map(function ($categories) {
                return is_string($categories) ? json_decode($categories, true) : $categories;
            })->filter()->flatten()->unique();

            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // إضافة الأقسام الخاصة بكل منظمة
            $organizations->each(function ($org) use ($categories) {
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;
                $org->categories = collect($categoryIds)->map(function ($categoryId) use ($categories) {
                    return $categories->get($categoryId);
                })->filter();
            });

            // تطبيق Pagination يدوي
            $perPage = 8; // عدد العناصر في كل صفحة
            $currentPage = request()->get('page', 1); // الحصول على رقم الصفحة من الطلب
            $paginatedOrgs = $organizations->slice(($currentPage - 1) * $perPage, $perPage)->values();

            // إرجاع الاستجابة مع المنظمات والـ pagination المناسب
            return response()->json([
                'data' => $paginatedOrgs,
                'pagination' => [
                    'current_page' => (int)$currentPage,
                    'last_page' => ceil($organizations->count() / $perPage),
                    'per_page' => $perPage,
                    'total' => $organizations->count(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function getLocations($categoryId)
    {
        try {
            // جلب جميع المنظمات المنشورة مع تحديد الحقول المطلوبة
            $orgsQuery = Organization::where('status', 'published')
                ->select('id', 'location', 'categories_ids');

            // تصفية النتائج بناءً على الفئة المطلوبة
            $orgs = $orgsQuery->get()->filter(function ($org) use ($categoryId) {
                $categories = is_string($org->categories_ids)
                    ? json_decode(stripslashes($org->categories_ids), true)
                    : $org->categories_ids;

                return is_array($categories) && in_array($categoryId, $categories);
            });

            // تحويل النتائج إلى Collection وإزالة التكرارات
            $uniqueLocations = collect($orgs)->map(function ($org) {
                $decodedLocation = json_decode($org->location, true);
                return [
                    'id' => $org->id,
                    'address' => $decodedLocation['address'] ?? null,
                ];
            })->unique('address')->values();

            // تطبيق التصفح يدويًا على النتائج المصفاة
            $perPage = 30;
            $currentPage = request()->get('page', 1);
            $paginatedResults = new \Illuminate\Pagination\LengthAwarePaginator(
                $uniqueLocations->forPage($currentPage, $perPage),
                $uniqueLocations->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            // إرجاع البيانات مع معلومات التصفح
            return response()->json([
                'data' => $paginatedResults->items(),
                'pagination' => [
                    'total' => $paginatedResults->total(),
                    'per_page' => $paginatedResults->perPage(),
                    'current_page' => $paginatedResults->currentPage(),
                    'last_page' => $paginatedResults->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to get locations", ['message' => $e->getMessage()], 500);
        }
    }







    public function searchOrganizations($title)
    {
        try {

            // البحث في العمودين title_en و title_ar
            $organizations = Organization::where('status', 'published')->where('title_en', 'like', '%' . $title . '%')
                ->orWhere('title_ar', 'like', '%' . $title . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(8);

            // إرجاع الاستجابة مع النتائج والـ pagination
            return response()->json([
                'data' => $organizations->items(),
                'pagination' => [
                    'current_page' => $organizations->currentPage(),
                    'last_page' => $organizations->lastPage(),
                    'per_page' => $organizations->perPage(),
                    'total' => $organizations->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }






    public function activeorganizations()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $orgs = organization::where('active', true)->paginate(12);

            // التحقق إذا كانت البطاقات فارغة
            if ($orgs->isEmpty()) {
                return response()->json([
                    'message' => 'لا توجد بطاقات نشطة حالياً.'
                ], 404);
            }

            // جلب الأقسام المتوافقة مع الـ categories_ids لجميع المنظمات في الـ orgs
            // جلب الأقسام المتوافقة مع categories_ids
            $categoryIds = $orgs->pluck('categories_ids')->map(function ($categories) {
                return is_string($categories) ? json_decode($categories, true) : $categories;
            })->filter()->flatten()->unique();
            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // تحويل المصفوفة إلى Collection لاستخدام map
            $orgsWithCategories = collect($orgs->items())->map(function ($org) use ($categories) {
                // التأكد من أن categories_ids هي مصفوفة
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;

                if (!is_array($categoryIds)) {
                    $categoryIds = []; // تعيين مصفوفة فارغة إذا لم تكن صالحة
                }

                $org->categories = collect();

                foreach ($categoryIds as $categoryId) {
                    if ($categories->has($categoryId)) {
                        $org->categories->push($categories->get($categoryId));
                    }
                }

                return $org;
            });

            // إرسال البطاقات مع تفاصيل التصفح
            return response()->json([
                'data' => $orgsWithCategories, // إرسال البطاقات في الشكل الصحيح
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return $this->errorResponse('حدث خطأ أثناء جلب البطاقات النشطة', ['message' => $e->getMessage()], 500);
        }
    }


    public function publishedOrganizationswithSelectedData()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $orgs = organization::where('status', 'published')->select('id', 'icon', 'title_en', 'title_ar')->paginate(12);

            // التحقق إذا كانت البطاقات فارغة
            if ($orgs->isEmpty()) {
                return response()->json([
                    'message' => 'لا توجد منظمات نشطة حالياً.'
                ], 404);
            }



            // إرسال البطاقات مع تفاصيل التصفح
            return response()->json([
                'data' => $orgs->items(), // إرسال البطاقات في الشكل الصحيح
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return $this->errorResponse('حدث خطأ أثناء جلب البطاقات النشطة', ['message' => $e->getMessage()], 500);
        }
    }

    public function UploadCooperationFile($orgId, Request $request)
    {
        try {
            if (!$request->hasFile('cooperation_file')) {
                return response()->json(['message' => 'No file uploaded'], 400);
            }

            $pdfFile = $request->file('cooperation_file');

            // التحقق من أن الملف بصيغة PDF فقط
            if ($pdfFile->getClientOriginalExtension() !== 'pdf') {
                return response()->json(['message' => 'Only PDF files are allowed'], 400);
            }
            // التحقق من وجود المن��مة
            $org = Organization::findOrFail($orgId);
            $storagePath = 'uploads/pdfs';
            $old_pdf = $org->cooperation_file;

            if ($old_pdf) {
                $old_pdf_name = basename(parse_url($old_pdf, PHP_URL_PATH));
                $file_path = public_path($storagePath . '/' . $old_pdf_name);
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }
            }

            // -------------------------
            // إنشاء اسم الملف الجديد
            // -------------------------
            $originalName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $pdfFile->getClientOriginalExtension();
            $filename = $originalName . '_' . uniqid() . '.' . $extension;

            // حفظ الملف في المجلد المحدد
            $pdfFile->move(public_path($storagePath), $filename);

            // تحديث مسار الملف في قاعدة البيانات

            $org->cooperation_file = url('/') . '/' . $storagePath . '/' . $filename;
            $org->save();

            return response()->json([
                'message' => 'PDF uploaded successfully',
                'file_url' => $org->cooperation_file
            ], 200);

            // نوع الملف المرفق
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return $this->errorResponse('Fail Error', ['message' => $e->getMessage()], 500);
        }
    }


    public function downloadCooperationPDF($orgId)
    {
        try {
            // الحصول على المستخدم الحالي
            $org = organization::findOrFail($orgId);

            // التحقق من أن المستخدم لديه ملف PDF
            if (!$org || !$org->cooperation_file) {
                return response()->json(['message' => 'No PDF file found'], 404);
            }

            // استخراج اسم الملف من الرابط المخزن في قاعدة البيانات
            $pdfPath = parse_url($org->cooperation_file, PHP_URL_PATH);
            $filePath = public_path($pdfPath);

            // التحقق من أن الملف موجود فعليًا
            if (!File::exists($filePath)) {
                return response()->json(['message' => 'File not found'], 404);
            }

            // تحميل الملف مباشرةً
            return response()->download($filePath, basename($filePath));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to download PDF', 'error' => $e->getMessage()], 500);
        }
    }


    public function publishedOrganizations()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $orgs = organization::where('status', 'published')->paginate(12);

            // التحقق إذا كانت البطاقات فارغة
            if ($orgs->isEmpty()) {
                return response()->json([
                    'message' => 'لا توجد منظمات نشطة حالياً.'
                ], 404);
            }

            // جلب الأقسام المتوافقة مع الـ categories_ids لجميع المنظمات في الـ orgs
            // جلب الأقسام المتوافقة مع categories_ids
            $categoryIds = $orgs->pluck('categories_ids')->map(function ($categories) {
                return is_string($categories) ? json_decode($categories, true) : $categories;
            })->filter()->flatten()->unique();
            $categories = ServiceCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

            // تحويل المصفوفة إلى Collection لاستخدام map
            $orgsWithCategories = collect($orgs->items())->map(function ($org) use ($categories) {
                // التأكد من أن categories_ids هي مصفوفة
                $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;

                if (!is_array($categoryIds)) {
                    $categoryIds = []; // تعيين مصفوفة فارغة إذا لم تكن صالحة
                }

                $org->categories = collect();

                foreach ($categoryIds as $categoryId) {
                    if ($categories->has($categoryId)) {
                        $org->categories->push($categories->get($categoryId));
                    }
                }

                return $org;
            });

            // إرسال البطاقات مع تفاصيل التصفح
            return response()->json([
                'data' => $orgsWithCategories, // إرسال البطاقات في الشكل الصحيح
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return $this->errorResponse('حدث خطأ أثناء جلب البطاقات النشطة', ['message' => $e->getMessage()], 500);
        }
    }

    public function updateactiveorganization($id, $active)
    {
        try {
            // التحقق من وجود البطاقة
            $cardtype = organization::find($id);

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


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorganizationRequest $request)
    {
        try {
            $data = $request->validated();
            $org = new organization();
            $org->fill($data);

            if ($request->has('categories_ids')) {
                $org->categories_ids = json_encode($request->categories_ids);
            }

            if ($request->filled('password')) {
                $org->password = Hash::make($request->password);
            }
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $org, 'images/organizations/images');
            }
            if ($request->has('icon')) {
                $this->imageservice->ImageUploaderwithvariable($request, $org, 'images/organizations/icons', 'icon');
            }
            $org->save();
            return $this->successResponse($org, 'Organization Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // جلب المنظمة بناءً على الـ id
            $org = Organization::find($id);

            // التحقق من وجود المنظمة
            if (!$org) {
                return $this->errorResponse('Organization not found.', [], 404);
            }

            // جلب الأقسام المتوافقة مع الـ categories_ids الخاصة بالمنظمة
            $categoryIds = is_string($org->categories_ids) ? json_decode($org->categories_ids, true) : $org->categories_ids;

            if (!is_array($categoryIds)) {
                $categoryIds = []; // تعيين مصفوفة فارغة إذا لم تكن صالحة
            }

            $categories = ServiceCategory::whereIn('id', $categoryIds)->get();

            // إرفاق الأقسام بالمنظمة
            $org->categories = $categories;

            return response()->json([
                'data' => $org,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed error', ['message' => $e->getMessage()], 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $org = organization::with('category')->findOrFail($id);
            $org->fill($data);
            if ($request->has('password')) {
                $org->password = Hash::make($request->password);
            }
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $org, 'images/organizations/images');
            }
            if ($request->has('icon')) {
                $this->imageservice->ImageUploaderwithvariable($request, $org, 'images/organizations/icons', 'icon');
            }
            $org->save();
            return $this->successResponse($org, 'Organization Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }


    // public function getConfirmStatus ($id) {
    //     try {
    //         $org = organization::select('confirmation_status')->findOrFail($id);
    //     }catch (\Exception $e) {
    //         return $this->errorResponse("Fail Error" , ['message' => $e->getMessage()] , 500);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $org = organization::findOrFail($id);
            if ($org->image) {
                $this->imageservice->deleteOldImage($org, 'images/organizations/images');
            }
            if ($org->icon) {
                $this->imageservice->deleteOldImage($org, 'images/organizations/icons');
            }
            $org->delete();
            return $this->successResponse($org, 'Organization deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    public function checkOrgPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        try {
            $user = organization::findOrFail($id);

            if (Hash::check($request->password, $user->password)) {
                return $this->successResponse(['Message' => 'Password is Correct'], 'Done', 200);
            } else {
                return $this->errorResponse("Incorrect Password", ['message' => 'Password does not match'], 401);
            }
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to Check Password", ['message' => $e->getMessage()], 500);
        }
    }


    public function SearchByNameForOrganization($title)
    {
        try {
            $users = organization::where('title_en', 'like', '%' . $title . '%')->orWhere('title_ar', 'like', '%' . $title . '%') // تحسين البحث ليشمل الجزئي
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No Organizations Found With this Name.',
                ], 404); // يمكن إضافة كود الحالة HTTP 404
            }

            return response()->json([
                'data' => $users->items(), // `items` لجلب البيانات فقط
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", [
                'message' => $e->getMessage(),
            ], 500); // إرسال رسالة الخطأ مع كود الحالة 500
        }
    }

    public function getOrgsByVerifyStatus()
    {
        try {
            $orgs = Organization::select('id', 'title_en', 'email', 'created_at', 'icon', 'email_verified_at', 'cooperation_file')->orderByRaw('email_verified_at IS NULL, email_verified_at DESC')
                ->paginate(20);

            return response()->json([
                'data' => $orgs->items(),
                'pagination' => [
                    'current_page' => $orgs->currentPage(),
                    'last_page' => $orgs->lastPage(),
                    'per_page' => $orgs->perPage(),
                    'total' => $orgs->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", [
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
