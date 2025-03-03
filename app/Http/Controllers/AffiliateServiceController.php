<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAffiliateService;
use App\Http\Requests\UpdateAffiliateService;
use App\Models\AffiliateService;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AffiliateServiceController extends Controller
{
    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $affiliate_services = AffiliateService::orderBy('created_at', 'desc')
                ->with(['organization', 'category'])
                ->paginate(16);
            return response()->json([
                'data' => $affiliate_services->items(),
                'pagination' => [
                    'current_page' => $affiliate_services->currentPage(),
                    'last_page' => $affiliate_services->lastPage(),
                    'per_page' => $affiliate_services->perPage(),
                    'total' => $affiliate_services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
    public function getDataByCheckState($state)
    {
        try {
            $affiliate_services = AffiliateService::where('check_status', $state)->orderBy('created_at', 'desc')
                ->with(['organization', 'category'])
                ->paginate(16);

            if (empty($affiliate_services->items())) {
                return response()->json([
                    'success' => false,
                    'message' => 'No affiliate services found.',
                    'data' => []
                ], 404);
            }


            return response()->json([
                'data' => $affiliate_services->items(),
                'pagination' => [
                    'current_page' => $affiliate_services->currentPage(),
                    'last_page' => $affiliate_services->lastPage(),
                    'per_page' => $affiliate_services->perPage(),
                    'total' => $affiliate_services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    public function getAffiliateServicesByorganization($id)
    {
        try {
            $affiliate_services = AffiliateService::where('organization_id', $id)
                ->orderBy('created_at', 'desc')
                ->with(['organization', 'category'])
                ->paginate(16);
            return response()->json([
                'data' => $affiliate_services->items(),
                'pagination' => [
                    'current_page' => $affiliate_services->currentPage(),
                    'last_page' => $affiliate_services->lastPage(),
                    'per_page' => $affiliate_services->perPage(),
                    'total' => $affiliate_services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }



    public function getAffiliateServicesFororganizationBySearch($id, Request $request)
    {
        try {
            // تحقق من صحة البيانات المدخلة
            $request->validate([
                'content_search' => 'required|string', // على الأقل 3 أحرف
            ]);

            // البحث في الخدمات التابعة
            $searchTerm = '%' . $request->content_search . '%'; // إضافة علامات % للبحث الجزئي

            // استعلام البحث مع ضمان أن الخدمات تابعة للمنظمة المحددة
            $services = AffiliateService::where('organization_id', $id)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('title_en', 'like', $searchTerm)
                        ->orWhere('title_ar', 'like', $searchTerm)
                        ->orWhere('description_ar', 'like', $searchTerm)
                        ->orWhere('description_en', 'like', $searchTerm);
                })
                ->with('organization', function ($org) {
                    $org->select('id', 'icon', 'title_en', 'title_ar');
                })
                ->with('category')
                ->paginate(16);

            // التحقق من وجود نتائج
            if ($services->isEmpty()) {
                return response()->json(['message' => 'No services found.'], 404);
            }

            // إرجاع النتائج
            return response()->json([
                'data' => $services->items(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ في حالة حدوث استثناء
            return $this->errorResponse("Failed to search services", ['message' => $e->getMessage()], 500);
        }
    }

    public function getAffiliateServicesByCategory($id)
    {
        try {
            $services = AffiliateService::where('category_id', $id)
                ->where('status', true)
                ->orderBy('number_of_orders', 'desc')
                ->with('organization', function ($org) {
                    $org->select('id', 'icon', 'title_en', 'title_ar');
                })
                ->with('category')
                ->paginate(16);


            if ($services->isEmpty()) {
                return response()->json(['message' => "No Services available for this category"], 404);
            }

            // return response()->json([
            //     'data' => $services,

            // ], 200);
            return response()->json([
                'data' => $services->items(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }



    public function getAffiliateServicesByText(Request $request)
    {
        try {
            // تحقق من صحة البيانات المدخلة
            $request->validate([
                'content_search' => 'required|string', // على الأقل 3 أحرف
            ]);

            // البحث في الخدمات التابعة
            $searchTerm = '%' . $request->content_search . '%'; // إضافة علامات % للبحث الجزئي
            $services = AffiliateService::where('status', true)
                ->where('title_en', 'like', $searchTerm)
                ->orWhere('title_ar', 'like', $searchTerm)
                ->orWhere('description_ar', 'like', $searchTerm)
                ->orWhere('description_en', 'like', $searchTerm)
                ->with('organization', function ($org) {
                    $org->select('id', 'icon', 'title_en', 'title_ar');
                })
                ->with('category')
                ->paginate(16);

            // التحقق من وجود نتائج
            if ($services->isEmpty()) {
                return response()->json(['message' => 'No services found.'], 404);
            }

            // إرجاع النتائج
            return response()->json([
                'data' => $services->items(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ في حالة حدوث استثناء
            return $this->errorResponse("Failed to search services", ['message' => $e->getMessage()], 500);
        }
    }


    public function getPublishedAffiliatedServices()
    {
        try {
            $affiliate_services = AffiliateService::orderBy('number_of_orders', 'desc')
                ->where('status', true)
                ->with('organization', function ($org) {
                    $org->select('id', 'icon', 'title_en', 'title_ar');
                })
                ->with('category')
                ->paginate(16);
            return response()->json([
                'data' => $affiliate_services->items(),
                'pagination' => [
                    'current_page' => $affiliate_services->currentPage(),
                    'last_page' => $affiliate_services->lastPage(),
                    'per_page' => $affiliate_services->perPage(),
                    'total' => $affiliate_services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function getRandomPublishedAffiliatedServices()
    {
        try {
            $affiliate_services = AffiliateService::where('status', true)
                ->with('organization', function ($org) {
                    $org->select('id', 'icon', 'title_en', 'title_ar');
                })
                ->with('category')
                ->inRandomOrder() // 🔥 ترتيب عشوائي
                ->limit(8) // 🔥 جلب 8 عناصر فقط
                ->get();

            return response()->json([
                'data' => $affiliate_services,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAffiliateService $request)
    {
        try {
            $data = $request->validated();
            $affiliate_service = new AffiliateService();
            $affiliate_service->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $affiliate_service, 'images/affiliateServices');
            }
            $affiliate_service->save();
            return $this->successResponse($affiliate_service, 'Affiliate Service Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $affiliate_service = AffiliateService::with(['organization', 'category'])->findOrFail($id);
            $features_en = is_string($affiliate_service->features_en)  ? json_decode($affiliate_service->features_en, true) : $affiliate_service->features_en;
            $features_ar = is_string($affiliate_service->features_ar)  ? json_decode($affiliate_service->features_ar, true) : $affiliate_service->features_ar;
            $affiliate_service->features_en = $features_en;
            $affiliate_service->features_ar = $features_ar;
            return $this->successResponse($affiliate_service, 'Affiliate Service Founded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateAffiliateService $request)
    {
        try {
            $data = $request->validated();
            $affiliate_service = AffiliateService::findOrFail($id);
            $affiliate_service->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $affiliate_service, 'images/affiliateServices');
            }
            $affiliate_service->save();
            $features_en = is_string($affiliate_service->features_en)  ? json_decode($affiliate_service->features_en, true) : $affiliate_service->features_en;
            $features_ar = is_string($affiliate_service->features_ar)  ? json_decode($affiliate_service->features_ar, true) : $affiliate_service->features_ar;
            $affiliate_service->features_en = $features_en;
            $affiliate_service->features_ar = $features_ar;
            return $this->successResponse($affiliate_service, 'Affiliate Service Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $affiliate_service = AffiliateService::findOrFail($id);
            $this->imageservice->deleteOldImage($affiliate_service, 'images/affiliateServices');
            $affiliate_service->delete();
            return $this->successResponse([], 'Affiliate Service deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
}
