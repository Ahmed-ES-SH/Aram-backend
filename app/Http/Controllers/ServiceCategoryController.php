<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\updateServiceCategoryRequest;
use App\Models\AffiliateService;
use App\Models\organization;
use App\Models\ServiceCategory;
use App\Services\ImageService;
use App\Traits\ApiResponse;

class ServiceCategoryController extends Controller
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
            $categories = ServiceCategory::orderBy('created_at', 'desc')->paginate(30);
            if ($categories->isEmpty()) {
                return $this->successResponse([], 'No categories found', 404);
            }
            return response()->json([
                'data' => $categories->items(),
                'pagination' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }




    public function getCountOrganizationsByCategory()
    {
        try {
            // جلب جميع الفئات
            $categories = ServiceCategory::all();

            // جلب جميع المنظمات النشطة مع categories_ids
            $organizations = Organization::where('active', true)->select('id', 'categories_ids')->get();

            // تحضير مصفوفة لتخزين النتائج
            $result = [];

            // حساب عدد المنظمات المصنفة
            $totalClassifiedOrganizations = 0;

            // حساب عدد المنظمات لكل فئة وإضافة بيانات الفئة
            foreach ($categories as $category) {
                $count = 0;

                foreach ($organizations as $organization) {
                    // تحويل categories_ids إلى مصفوفة إذا كانت نصية
                    $orgCategories = is_string($organization->categories_ids)
                        ? json_decode($organization->categories_ids, true)
                        : $organization->categories_ids;

                    // التحقق مما إذا كانت الفئة موجودة في categories_ids
                    if (is_array($orgCategories) && in_array($category->id, $orgCategories)) {
                        $count++;
                    }
                }

                // إضافة بيانات الفئة وعدد المنظمات إلى النتيجة
                $result[] = [
                    'id' => $category->id,
                    'image' => $category->image, // صورة الفئة
                    'title_en' => $category->title_en, // اسم الفئة بالإنجليزية
                    'title_ar' => $category->title_ar, // اسم الفئة بالعربية
                    'created_at' => $category->created_at, // تاريخ الإنشاء
                    'updated_at' => $category->updated_at, // تاريخ التحديث
                    'organizations_count' => $count, // عدد المنظمات المرتبطة
                ];

                // زيادة العدد الإجمالي للمنظمات المصنفة
                $totalClassifiedOrganizations += $count;
            }

            // إضافة العدد الإجمالي للمنظمات المصنفة إلى النتيجة
            $response = [
                'categories' => $result,
                'total_classified_organizations' => $totalClassifiedOrganizations,
            ];

            // إرجاع النتائج
            return $this->successResponse($response, 'Organizations count by category', 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ في حالة حدوث استثناء
            return $this->errorResponse('Failed to get organizations count', ['message' => $e->getMessage()], 500);
        }
    }


    public function getOrganizationsByCategory()
    {
        try {
            // جلب جميع الفئات
            $categories = ServiceCategory::orderBy('created_at', 'desc')->paginate(20);

            // جلب جميع المنظمات النشطة مع categories_ids
            $organizations = Organization::where('status', "published")->select('id', 'categories_ids')->get();

            // تحضير مصفوفة لتخزين النتائج
            $result = [];

            // حساب عدد المنظمات المصنفة
            $totalClassifiedOrganizations = 0;

            // حساب عدد المنظمات لكل فئة وإضافة بيانات الفئة
            foreach ($categories as $category) {
                $count = 0;

                foreach ($organizations as $organization) {
                    // تحويل categories_ids إلى مصفوفة إذا كانت نصية
                    $orgCategories = is_string($organization->categories_ids)
                        ? json_decode($organization->categories_ids, true)
                        : $organization->categories_ids;

                    // التحقق مما إذا كانت الفئة موجودة في categories_ids
                    if (is_array($orgCategories) && in_array($category->id, $orgCategories)) {
                        $count++;
                    }
                }

                // إضافة بيانات الفئة وعدد المنظمات إلى النتيجة
                $result[] = [
                    'id' => $category->id,
                    'image' => $category->image, // صورة الفئة
                    'title_en' => $category->title_en, // اسم الفئة بالإنجليزية
                    'title_ar' => $category->title_ar, // اسم الفئة بالعربية
                    'created_at' => $category->created_at, // تاريخ الإنشاء
                    'updated_at' => $category->updated_at, // تاريخ التحديث
                    'organizations_count' => $count, // عدد المنظمات المرتبطة
                ];

                // زيادة العدد الإجمالي للمنظمات المصنفة
                $totalClassifiedOrganizations += $count;
            }

            // إعداد الاستجابة
            $response = [
                'categories' => $result,
                'pagination' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                ],
                'total_classified_organizations' => $totalClassifiedOrganizations,
            ];

            // إرجاع النتائج
            return $this->successResponse($response, 'Organizations by category', 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ في حالة حدوث استثناء
            return $this->errorResponse('Failed to get organizations', ['message' => $e->getMessage()], 500);
        }
    }




    public function getCountAffiliateServicesByCategory()
    {
        try {
            // جلب جميع الفئات
            $categories = ServiceCategory::all();

            // جلب جميع الخدمات التابعة النشطة مع category_id
            $affiliateServices = AffiliateService::where('status', true)->select('id', 'category_id')->get();

            // تحضير مصفوفة لتخزين النتائج
            $result = [];

            // حساب عدد الخدمات المصنفة
            $totalClassifiedServices = 0;

            // حساب عدد الخدمات لكل فئة وإضافة بيانات الفئة
            foreach ($categories as $category) {
                $count = 0;

                foreach ($affiliateServices as $service) {
                    // التحقق مما إذا كانت الفئة مطابقة لـ category_id
                    if ($service->category_id === $category->id) {
                        $count++;
                    }
                }

                // إضافة بيانات الفئة وعدد الخدمات إلى النتيجة
                $result[] = [
                    'id' => $category->id,
                    'image' => $category->image, // صورة الفئة
                    'title_en' => $category->title_en, // اسم الفئة بالإنجليزية
                    'title_ar' => $category->title_ar, // اسم الفئة بالعربية
                    'created_at' => $category->created_at, // تاريخ الإنشاء
                    'updated_at' => $category->updated_at, // تاريخ التحديث
                    'services_count' => $count, // عدد الخدمات المرتبطة
                ];

                // زيادة العدد الإجمالي للخدمات المصنفة
                $totalClassifiedServices += $count;
            }

            // إضافة العدد الإجمالي للخدمات المصنفة إلى النتيجة
            $response = [
                'categories' => $result,
                'total_classified_services' => $totalClassifiedServices,
            ];

            // إرجاع النتائج
            return $this->successResponse($response, 'Affiliate services count by category', 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ في حالة حدوث استثناء
            return $this->errorResponse('Failed to get affiliate services count', ['message' => $e->getMessage()], 500);
        }
    }


    public function All()
    {
        try {
            $categories = ServiceCategory::all();
            if ($categories->isEmpty()) {
                return $this->successResponse([], 'No categories found', 404);
            }
            return response()->json([
                'data' => $categories,

            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = new ServiceCategory();
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $category, 'images/categories');
            }
            $category->save();
            return $this->successResponse($category, 'Category Created Successfully', 201);
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
            $category = ServiceCategory::findOrFail($id);
            return $this->successResponse($category, 'Find Catgeory Done .', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(updateServiceCategoryRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $category = ServiceCategory::findOrFail($id);
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $category, 'images/categories');
            }
            $category->save();
            return $this->successResponse($category, 'Category Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = ServiceCategory::findOrFail($id);
            $this->imageservice->deleteOldImage($category, 'images/categories');
            $category->delete();
            return $this->successResponse($category, 'Category deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }
}
