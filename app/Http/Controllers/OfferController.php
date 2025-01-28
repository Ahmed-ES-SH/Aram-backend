<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfferController extends Controller
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
            $offers = Offer::orderBy('created_at', 'desc')
                ->with([
                    'organization:id,title_en,title_ar,image,icon',
                    'category:id,title_en,title_ar,image'
                ])
                ->paginate(15);

            // التحقق من وجود بيانات
            if ($offers->isEmpty()) {
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            // إعداد الاستجابة مع البيانات وترقيم الصفحات
            return response()->json([
                'data' => $offers->items(),
                'pagination' => [
                    'current_page' => $offers->currentPage(),
                    'last_page' => $offers->lastPage(),
                    'per_page' => $offers->perPage(),
                    'total' => $offers->total(),
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

    public function offersByorganization($id)
    {
        try {
            // جلب العروض مع العلاقات المطلوبة
            $offers = Offer::where('organization_id', $id)->orderBy('created_at', 'desc')
                ->with([
                    'organization:id,title_en,title_ar,image,icon',
                    'category:id,title_en,title_ar,image'
                ])
                ->paginate(25);

            // التحقق من وجود بيانات
            if ($offers->isEmpty()) {
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            // إعداد الاستجابة مع البيانات وترقيم الصفحات
            return response()->json([
                'data' => $offers->items(),
                'pagination' => [
                    'current_page' => $offers->currentPage(),
                    'last_page' => $offers->lastPage(),
                    'per_page' => $offers->perPage(),
                    'total' => $offers->total(),
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
    public function offersBySearch($id, Request $request)
    {
        try {
            // تحقق من صحة البيانات المدخلة
            $request->validate([
                'content_search' => 'required|string', // على الأقل 3 أحرف
            ]);

            // البحث في الخدمات التابعة
            $searchTerm = '%' . $request->content_search . '%'; // إضافة علامات % للبحث الجزئي

            // استعلام البحث مع ضمان أن الخدمات تابعة للمنظمة المحددة
            $offers = Offer::where('organization_id', $id)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('title_en', 'like', $searchTerm)
                        ->orWhere('title_ar', 'like', $searchTerm)
                        ->orWhere('description_ar', 'like', $searchTerm)
                        ->orWhere('description_en', 'like', $searchTerm);
                })->with([
                    'organization:id,title_en,title_ar,image,icon',
                    'category:id,title_en,title_ar,image'
                ])->paginate(25);

            // التحقق من وجود بيانات
            if ($offers->isEmpty()) {
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            // إعداد الاستجابة مع البيانات وترقيم الصفحات
            return response()->json([
                'data' => $offers->items(),
                'pagination' => [
                    'current_page' => $offers->currentPage(),
                    'last_page' => $offers->lastPage(),
                    'per_page' => $offers->perPage(),
                    'total' => $offers->total(),
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
    public function offersByCategory($id)
    {
        try {
            // جلب العروض مع العلاقات المطلوبة
            $offers = Offer::where('category_id', $id)->orderBy('created_at', 'desc')
                ->with([
                    'organization:id,title_en,title_ar,image,icon',
                    'category:id,title_en,title_ar,image'
                ])
                ->paginate(25);

            // التحقق من وجود بيانات
            if ($offers->isEmpty()) {
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            // إعداد الاستجابة مع البيانات وترقيم الصفحات
            return response()->json([
                'data' => $offers->items(),
                'pagination' => [
                    'current_page' => $offers->currentPage(),
                    'last_page' => $offers->lastPage(),
                    'per_page' => $offers->perPage(),
                    'total' => $offers->total(),
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





    public function updateOfferStatuses()
    {
        try {
            // جلب جميع السجلات التي تجاوز تاريخ البداية (start_date) التاريخ الحالي
            $records = Offer::where('start_date', '<=', Carbon::now())
                ->get();

            // تحقق من عدد العروض التي تم تحديث حالتها
            $activatedCount = 0;
            $expiredCount = 0;

            // تحديث status بناءً على التاريخ
            foreach ($records as $record) {
                // إذا كان وقت العرض قد جاء ولم ينته بعد
                if (Carbon::now()->lt($record->end_date) && $record->status != 'active') {
                    $record->status = 'active'; // تفعيل العرض
                    $activatedCount++;
                }
                // إذا كان وقت العرض قد انتهى
                elseif (Carbon::now()->gt($record->end_date) && $record->status != 'expired') {
                    $record->status = 'expired'; // وضع العرض في الحالة "منتهي"
                    $expiredCount++;
                }
                // حفظ التحديثات
                $record->save();
            }

            // إرجاع استجابة مع عدد العروض التي تم تفعيلها أو انتهائها
            if ($activatedCount > 0 && $expiredCount > 0) {
                return response()->json([
                    'message' => "تم تفعيل $activatedCount عرض(عروض) وانهاء $expiredCount عرض(عروض) بنجاح"
                ]);
            } elseif ($activatedCount > 0) {
                return response()->json(['message' => "تم تفعيل $activatedCount عرض(عروض) بنجاح"]);
            } elseif ($expiredCount > 0) {
                return response()->json(['message' => "تم انهاء $expiredCount عرض(عروض) بنجاح"]);
            } else {
                return response()->json(['message' => 'لا توجد عروض لتحديث حالتها']);
            }
        } catch (\Exception $e) {
            // في حال حدوث خطأ، إرجاع استجابة تحتوي على الخطأ
            return response()->json([
                'error' => 'حدث خطأ أثناء تحديث الحالة',
                'message' => $e->getMessage()
            ], 500); // كود الحالة 500 يعني خطأ في الخادم
        }
    }


    public function trendingOffers()
    {
        try {
            // Fetch top 10 trending offers
            $offers = Offer::orderBy('number_of_uses', 'desc')
                ->with(['organization', 'category'])
                ->take(10)
                ->get();

            // Check if offers are empty
            if ($offers->isEmpty()) {
                return response()->json([
                    'message' => 'No Offers Found.'
                ], 404); // Use 404 for "Not Found"
            }

            // Return success response
            return $this->successResponse($offers, 'Offers Found Successfully', 200);
        } catch (\Exception $e) {
            // Return error response
            return $this->errorResponse("Failed to retrieve offers", ['error' => $e->getMessage()], 500);
        }
    }



    public function getPublishedOffers()
    {
        try {
            $offers = Offer::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->with(['category', 'organization'])
                ->paginate(15);


            if ($offers->isEmpty()) {
                return $this->errorResponse("No Data Found", ['message' => 'No Offers Founded'], 404);
            }

            return response()->json([
                'data' =>  $offers,
                'pagination' => [
                    'current_page' => $offers->currentPage(),
                    'last_page' => $offers->lastPage(),
                    'per_page' => $offers->perPage(),
                    'total' => $offers->total(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }



    public function checkExpiredOffers()
    {
        try {
            // استرداد العروض المنتهية الصلاحية
            $expiredOffers = Offer::where('is_active', true)
                ->whereDate('end_date', '<', now())
                ->get(['id', 'is_active', 'start_date', 'end_date']);


            foreach ($expiredOffers as $offer) {
                $offer->update(['is_active' => false]);
                $offer->save();
            }
            $offersCount = $expiredOffers->count();
            return response()->json(['expired_offers_count' => $offersCount], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request)
    {
        try {
            $data = $request->validated();
            $offer = new Offer();
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
            $offer = Offer::with(['category', 'organization'])->findOrFail($id);
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
            $offer = Offer::findOrFail($id);
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
            $offer = Offer::findOrFail($id);
            $this->imageservice->deleteOldImage($offer, 'images/offers');
            $offer->delete();
            return $this->successResponse([], 'Offer deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
}
