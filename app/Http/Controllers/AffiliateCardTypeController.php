<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAffiliateCardTypeRequest;
use App\Http\Requests\UpdateAffiliateCardTypeRequest;
use App\Models\Affiliate_cardType;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AffiliateCardTypeController extends Controller
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
            $cardtypes = Affiliate_cardType::orderBy('created_at', 'desc')->paginate(12);

            if ($cardtypes->isEmpty()) {
                return response()->json([
                    'message' => 'No cardtypes Available!'
                ], 404);
            }

            // تحويل القيم النصية إلى JSON عند الحاجة
            $cardtypes->transform(function ($cardType) {
                $cardType->features_en = $this->decodeJson($cardType->features_en);
                $cardType->features_ar = $this->decodeJson($cardType->features_ar);
                return $cardType;
            });

            return response()->json([
                'data' => $cardtypes->items(),
                'pagination' => [
                    'current_page' => $cardtypes->currentPage(),
                    'last_page' => $cardtypes->lastPage(),
                    'per_page' => $cardtypes->perPage(),
                    'total' => $cardtypes->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed Error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * فك ترميز JSON إذا كان نصًا
     */
    private function decodeJson($value)
    {
        return is_string($value) ? json_decode($value, true) : $value;
    }

    public function AffiliateCardTypeBySearch(Request $request)
    {
        try {
            $request->validate([
                'content_search' => 'required|string'
            ]);
            $searchTerm = '%' . $request->content_search . '%';
            $cardtypes = Affiliate_cardType::where('title_en', 'like', $searchTerm)
                ->orWhere('title_ar', 'like', $searchTerm)
                ->orWhere('description_ar', 'like', $searchTerm)
                ->orWhere('description_en', 'like', $searchTerm)->orderBy('created_at', 'desc')->paginate(12);
            if ($cardtypes->isEmpty()) {
                return response()->json([
                    'message' => 'No cardtypes Available !'
                ], 404);
            }
            return response()->json([
                'data' => $cardtypes->items(),
                'pagination' => [
                    'current_page' => $cardtypes->currentPage(),
                    'last_page' => $cardtypes->lastPage(),
                    'per_page' => $cardtypes->perPage(),
                    'total' => $cardtypes->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }


    public function getAffiliateCardsFororganizationBySearch($id, Request $request)
    {
        try {
            // تحقق من صحة البيانات المدخلة
            $request->validate([
                'content_search' => 'required|string', // على الأقل 3 أحرف
            ]);

            // البحث في الخدمات التابعة
            $searchTerm = '%' . $request->content_search . '%'; // إضافة علامات % للبحث الجزئي

            // استعلام البحث مع ضمان أن الخدمات تابعة للمنظمة المحددة
            $cards = Affiliate_cardType::where('organization_id', $id)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('title_en', 'like', $searchTerm)
                        ->orWhere('title_ar', 'like', $searchTerm)
                        ->orWhere('description_ar', 'like', $searchTerm)
                        ->orWhere('description_en', 'like', $searchTerm);
                })->paginate(12);

            // التحقق من وجود نتائج
            if ($cards->isEmpty()) {
                return response()->json(['message' => 'No cards found.'], 404);
            }

            // إرجاع النتائج
            return response()->json([
                'data' => $cards->items(),
                'pagination' => [
                    'current_page' => $cards->currentPage(),
                    'last_page' => $cards->lastPage(),
                    'per_page' => $cards->perPage(),
                    'total' => $cards->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ في حالة حدوث استثناء
            return $this->errorResponse("Failed to search cards", ['message' => $e->getMessage()], 500);
        }
    }

    public function AffiliateCardtypesForOrganization($id)
    {
        try {
            $cards = Affiliate_cardType::where('organization_id', $id)
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            if ($cards->isEmpty()) {
                return response()->json([
                    'message' => 'No Cards Found'
                ], 404);
            }

            // تحويل البيانات إلى الشكل الصحيح
            $data = $cards->map(function ($card) {
                $card->features_en = is_string($card->features_en) ? json_decode($card->features_en, true) : $card->features_en;
                $card->features_ar = is_string($card->features_ar) ? json_decode($card->features_ar, true) : $card->features_ar;
                return $card;
            });

            return response()->json([
                'data' => $data,
                'pagination' => [
                    'current_page' => $cards->currentPage(),
                    'last_page' => $cards->lastPage(),
                    'per_page' => $cards->perPage(),
                    'total' => $cards->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }



    public function allowedAffiliateCards()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $cardtypes = Affiliate_cardType::where('status', 'allow')->paginate(16);

            // التحقق إذا كانت البطاقات فارغة
            if ($cardtypes->isEmpty()) {
                return response()->json([
                    'message' => 'لا توجد بطاقات نشطة حالياً.'
                ], 404);
            }

            // إرسال البطاقات مع تفاصيل التصفح
            return response()->json([
                'data' => $cardtypes->items(), // إرسال البطاقات في الشكل الصحيح
                'pagination' => [
                    'current_page' => $cardtypes->currentPage(),
                    'last_page' => $cardtypes->lastPage(),
                    'per_page' => $cardtypes->perPage(),
                    'total' => $cardtypes->total(),
                ]
            ]);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return $this->errorResponse('حدث خطأ أثناء جلب البطاقات النشطة', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAffiliateCardTypeRequest $request)
    {
        try {
            $data = $request->validated();
            $card = new Affiliate_cardType();
            $card->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $card, 'images/affiliateCardTypes');
            }
            $card->save();
            return $this->successResponse($card, 'Card Created Successfully',  201);
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
            $cardType = Affiliate_cardType::findOrFail($id);
            return $this->successResponse($cardType, 'Card founded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateAffiliateCardTypeRequest $request)
    {
        try {
            $data = $request->validated();
            $card = Affiliate_cardType::findOrFail($id);
            $card->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $card, 'images/affiliateCardTypes');
            }
            $card->save();
            $card->features_en = is_string($card->features_en) ? json_decode($card->features_en, true) : $card->features_en;
            $card->features_ar = is_string($card->features_ar) ? json_decode($card->features_ar, true) : $card->features_ar;
            return $this->successResponse($card, 'Card Updated Succsessfully', 200);
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
            $card = Affiliate_cardType::findOrFail($id);
            $this->imageservice->deleteOldImage($card, 'images/affiliateCardTypes');
            $card->delete();
            return $this->successResponse([], 'Card Deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }
}
