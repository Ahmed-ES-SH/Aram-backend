<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Copone;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoponeController extends Controller
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
            // جلب العروض مع العلاقات المطلوبة
            $copones = Copone::orderBy('created_at', 'desc')
                ->with([
                    'organization:id,title_en,title_ar,image,icon',
                    'category:id,title_en,title_ar,image'
                ])
                ->paginate(15);

            // التحقق من وجود بيانات
            if ($copones->isEmpty()) {
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            // إعداد الاستجابة مع البيانات وترقيم الصفحات
            return response()->json([
                'data' => $copones->items(),
                'pagination' => [
                    'current_page' => $copones->currentPage(),
                    'last_page' => $copones->lastPage(),
                    'per_page' => $copones->perPage(),
                    'total' => $copones->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            // معالجة الأخطاء العامة
            return $this->errorResponse(
                "Failed to Load Data",
                ['message' => $e->getMessage()],
                500
            );
        }
    }

    public function sendCoponeToSelectedUsers(Request $request)
    {
        try {
            $request->validate([
                'users_array' => 'required',
                'coupon_id' => 'required|exists:copones,id'
            ]);

            $usersIdsArray = is_string($request->users_array) ? json_decode($request->users_array) : $request->users_array;
            $couponId = $request->coupon_id;

            foreach ($usersIdsArray as $userId) {
                DB::table('coupon_user')->updateOrInsert(
                    ['user_id' => $userId, 'coupon_id' => $couponId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            return response()->json([
                'message' => 'Coupon sent to selected users successfully!'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to send coupon", ['message' => $e->getMessage()], 500);
        }
    }


    public function coponesBySearch(Request $request)
    {
        try {
            // التحقق من صحة البيانات المدخلة
            $request->validate([
                'content_search' => 'required',
            ]);

            // تنظيف البحث
            $searchTerm = trim($request->content_search);



            // البحث الجزئي
            $searchPattern = "%{$searchTerm}%";

            // تنفيذ البحث بدون قيد على منظمة معينة
            $copones = Copone::where(function ($query) use ($searchPattern) {
                $query->where('title_en', 'like', $searchPattern)
                    ->orWhere('title_ar', 'like', $searchPattern)
                    ->orWhere('description_ar', 'like', $searchPattern)
                    ->orWhere('description_en', 'like', $searchPattern);
            })
                ->with([
                    'organization:id,title_en,title_ar,image,icon',
                    'category:id,title_en,title_ar,image'
                ])
                ->orderBy('created_at', 'desc') // ترتيب الأحدث أولاً
                ->paginate(25);

            // التحقق من وجود بيانات
            if ($copones->isEmpty()) {
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            // إعداد الاستجابة مع البيانات وترقيم الصفحات
            return response()->json([
                'data' => $copones->items(),
                'pagination' => [
                    'current_page' => $copones->currentPage(),
                    'last_page' => $copones->lastPage(),
                    'per_page' => $copones->perPage(),
                    'total' => $copones->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            // معالجة الأخطاء العامة
            return $this->errorResponse(
                "Failed to Load Data",
                ['message' => $e->getMessage()],
                500
            );
        }
    }

    public function coponesByCategory($id)
    {
        try {
            // جلب العروض مع العلاقات المطلوبة
            $copones = Copone::where('category_id', $id)->orderBy('created_at', 'desc')
                ->with([
                    'organization:id,title_en,title_ar,image,icon',
                    'category:id,title_en,title_ar,image'
                ])
                ->paginate(25);

            // التحقق من وجود بيانات
            if ($copones->isEmpty()) {
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            // إعداد الاستجابة مع البيانات وترقيم الصفحات
            return response()->json([
                'data' => $copones->items(),
                'pagination' => [
                    'current_page' => $copones->currentPage(),
                    'last_page' => $copones->lastPage(),
                    'per_page' => $copones->perPage(),
                    'total' => $copones->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            // معالجة الأخطاء العامة
            return $this->errorResponse(
                "Failed to Load Data",
                ['message' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request)
    {
        try {
            $data = $request->validated();
            $offer = new Copone();
            $offer->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $offer, 'images/offers');
            }
            $offer->save();
            return $this->successResponse($offer, "Offer Created Successfully", 201);
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
            $offer = Copone::with(['category', 'organization'])->findOrFail($id);
            return $this->successResponse($offer, 'offer Founded successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateOfferRequest $request)
    {
        try {
            $data = $request->validated();
            $offer = Copone::with([
                'organization:id,title_en,title_ar,icon',
                'category:id,image,title_en,title_ar'
            ])->findOrFail($id);
            $offer->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $offer, 'images/offers');
            }
            $offer->save();
            return $this->successResponse($offer, 'Offer Updated Successfully', 200);
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
            $offer = Copone::findOrFail($id);
            $this->imageservice->deleteOldImage($offer, 'images/offers');
            $offer->delete();
            return $this->successResponse([], 'Offer deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
}
