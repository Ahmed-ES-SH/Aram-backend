<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArmaCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Arma_Card;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArmaCardController extends Controller
{

    use ApiResponse;


    public function activeCardsCount()
    {
        try {
            // افتراض أن هناك نموذج اسمه User
            $count = Arma_Card::where('status', 'active')->count();

            // إرجاع استجابة ناجحة مع العدد
            return $this->successResponse($count, "Active cards count retrieved successfully", 200);
        } catch (\Exception $e) {
            // في حال حدوث خطأ، يتم إرجاع استجابة خطأ
            return $this->errorResponse("Failed to retrieve users count", ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function myCards($id)
    {
        try {
            $cards = Arma_Card::where('user_id', $id)->orderBy('created_at', 'desc')->with('user')->with('card_type')->get();
            return $this->successResponse($cards, 'Cards Founded Successfully', 200);
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
            $card = Arma_Card::findOrFail($id);
            return $this->successResponse($card, "Card Finded Successfully", 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function activeCard(Request $request, $id)
    {
        try {
            $card = Arma_Card::with(['user', 'card_type'])->findOrFail($id);

            // توليد رقم عشوائي مكون من 11 خانة
            do {
                $randnumbercard = random_int(1000000000000000, 9999999999999999); // توليد رقم مكون من 11 خانة
            } while (Arma_Card::where('card_number', $randnumbercard)->exists()); // التحقق إذا كان الرقم موجود مسبقًا


            // توليد رقم عشوائي مكون من 11 خانة
            do {
                $randomCvv = random_int(100, 999); // توليد رقم مكون من 11 خانة
            } while (Arma_Card::where('cvv', $randomCvv)->exists()); // التحقق إذا كان الرقم موجود مسبقًا

            // تعيين رقم البطاقة والبيانات الأخرى
            $card->card_number = $randnumbercard;
            $card->issue_date = now()->addHours(3);
            $card->created_at = now()->addHours(3);
            $card->expiry_date = now()->addMonths($request->duration);
            $card->status = 'active';
            $card->cvv = $randomCvv;
            $card->save();

            return $this->successResponse($card, 'Card Activated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to Update Card', ['message' => $e->getMessage()], 500);
        }
    }


    public function updateExpiredCards()
    {
        try {
            // الحصول على الكروت التي انتهت صلاحيتها
            $expiredCards = Arma_Card::where('status', 'active')
                ->whereDate('expiry_date', '<', now())
                ->get();

            // تحديث حالة الكروت إلى "expired"
            foreach ($expiredCards as $card) {
                $card->update(['status' => 'expired']);
            }

            // إرجاع استجابة بنجاح العملية
            return $this->successResponse(
                "Expired cards updated successfully",
                ['updated_count' => $expiredCards->count()],
                200
            );
        } catch (\Exception $e) {
            // إرجاع استجابة في حالة وجود خطأ
            return $this->errorResponse(
                "Failed to update expired cards",
                ['message' => $e->getMessage()],
                500
            );
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $card = Arma_Card::findOrFail($id);
            $card->delete();
            return $this->successResponse($card, "Card Updated Successfully", 201);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
}
