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
    use ApiResponse ;
    protected $imageservice ;

        public function __construct(ImageService $imageService)
        {
            $this->imageservice = $imageService ;
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

    public function allowedAffiliateCards()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $cardtypes = Affiliate_cardType::where('status', 'allow')->paginate(12);

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
                $this->imageservice->ImageUploader($request , $card , 'images/affiliateCardTypes' );
             }
             $card->save();
             return $this->successResponse($card , 'Card Created Successfully' ,  201);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error" , ['message' => $e->getMessage()] , 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $cardType= Affiliate_cardType::findOrFail($id);
            return $this->successResponse($cardType , 'Card founded Successfully' , 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error" , ['message' => $e->getMessage()] , 500);
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
                $this->imageservice->ImageUploader($request , $card , 'images/affiliateCardTypes');
            }
            $card->save();
            return $this->successResponse($card , 'Card Updated Succsessfully' , 200);
        }catch (\Exception $e) {
            return $this->errorResponse("Faild Error" , ['message' => $e->getMessage()] , 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    try {
        $card = Affiliate_cardType::findOrFail($id);
        $this->imageservice->deleteOldImage($card , 'images/affiliateCardTypes');
        $card->delete();
        return $this->successResponse([] , 'Card Deleted Successfully' , 200);
    } catch (\Exception $e) {
        return $this->errorResponse('Faild Error' , ['message' => $e->getMessage()] , 500);
    }
    }
}
