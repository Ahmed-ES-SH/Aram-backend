<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardTypeStoreRequest;
use App\Http\Requests\CardTypeUpdateRequest;
use App\Models\CardType;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CardTypeController extends Controller
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
            $cardtypes = CardType::orderBy('created_at', 'desc')->paginate(12);
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
    public function getCardsbyPromotionalNumber()
    {
        try {
            $cardtypes = CardType::select('id', 'image', 'title_en', 'number_of_promotional_purchases', 'category_id')->with('category:id,title_en,image')->orderBy('number_of_promotional_purchases', 'desc')->paginate(12);
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


    public function getCardsByCategory($categoryId)
    {
        try {
            $cards = CardType::where('category_id', $categoryId)->orderBy('created_at', 'desc')->paginate(12);
            if ($cards->total() === 0) { // أو يمكن استخدام count()
                return response()->json(['message' => 'No data found'], 404);
            }

            return response()->json([
                'data' => $cards->items(),
                'pagination' => [
                    'current_page' => $cards->currentPage(),
                    'last_page' => $cards->lastPage(),
                    'total' => $cards->total(),
                    'per_page' => $cards->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return $this->errorResponse('حدث خطأ أثناء جلب البطاقات النشطة', ['message' => $e->getMessage()], 500);
        }
    }


    public function activecards()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $cardtypes = CardType::where('active', true)->paginate(12);

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

    public function updateactivestate($id, $active)
    {
        try {
            // التحقق من وجود البطاقة
            $cardtype = CardType::find($id);

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
    public function store(CardTypeStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $cardtype = new CardType();
            $cardtype->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $cardtype, 'images/cardtypes');
            }
            $cardtype->save();
            return $this->successResponse($cardtype, 'Card Type Create Successfully', 200);
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
            $cardtype = CardType::findOrFail($id);
            return $this->successResponse($cardtype, 'Card Type Finded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(CardTypeUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $cardtype = CardType::findOrFail($id);
            $cardtype->fill($data);
            $this->imageservice->ImageUploader($request, $cardtype, 'images/cardtypes');
            $cardtype->save();
            return $this->successResponse($cardtype, 'Card Type updated Successfully', 200);
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
            $cardtype = CardType::findOrFail($id);
            $this->imageservice->deleteOldImage($cardtype, 'images/cardtypes');
            $cardtype->delete();
            return $this->successResponse($cardtype, 'Card Type deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }
}
