<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Arma_Card;
use App\Models\CardType;
use App\Models\Copone;
use App\Models\copones_used;
use App\Models\CouponeOwner;
use App\Models\CouponUser;
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
                'account_type' => 'required|in:User,Organization',
                'coupon_id' => 'required|exists:copones,id'
            ]);

            $usersIdsArray = is_string($request->users_array) ? json_decode($request->users_array, true) : $request->users_array;
            $couponId = $request->coupon_id;
            $accountType = (string) $request->account_type; // تأكد من تحويله إلى نص

            if (empty($usersIdsArray)) {
                return response()->json([
                    'message' => 'No users provided.'
                ], 400);
            }

            // تجهيز بيانات الإدراج كمصفوفة
            $insertData = array_map(function ($userId) use ($couponId, $accountType) {
                return [
                    'user_id' => $userId,
                    'account_type' => (string) $accountType, // تأكد من أنها نصية
                    'coupon_id' => $couponId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $usersIdsArray);


            $insertOwnersData = array_map(function ($userId) use ($couponId, $accountType) {
                return [
                    'owner_id' => $userId,
                    'owner_type' => (string) $accountType, // تأكد من أنها نصية
                    'coupon_id' => $couponId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $usersIdsArray);

            // إدراج البيانات دفعة واحدة
            DB::table('coupon_user')->upsert($insertData, ['user_id', 'coupon_id', 'account_type'], ['updated_at']);
            DB::table('coupone_owners')->upsert($insertOwnersData, ['owner_id', 'coupon_id', 'owner_type'], ['updated_at']);

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

    public function CheckCopuneForFreeCard(Request $request)
    {
        try {
            // التحقق من البيانات المدخلة
            $validatedData =    $request->validate([
                'card_type_id' => 'required|exists:card_types,id',
                'copune_code' => 'required|string|exists:copones,code',
                'user_id' => 'required|exists:users,id',
                'account_type' => 'required|string',
            ]);

            // جلب بيانات الكوبون والبطاقة
            $coupon = Copone::where('code', $request->copune_code)->first();

            $isUserOwner = CouponeOwner::where('owner_id', $validatedData['user_id'])
                ->where('coupon_id', $coupon->id)
                ->where('owner_type', $validatedData['account_type'])
                ->first();


            $card = CardType::find($request->card_type_id);


            if (!$isUserOwner) { // ← التحقق بشكل صحيح إذا لم يتم العثور على سجل
                return $this->errorResponse("Failed Error", ['message' => 'User Not Owner of this Coupon'], 404);
            }

            // التحقق من وجود البطاقة
            if (!$card) {
                return $this->errorResponse("Failed Error", ['message' => 'Invalid Card Type'], 404);
            }

            // التحقق من وجود الكوبون
            if (!$coupon) {
                return $this->errorResponse("Failed Error", ['message' => 'Invalid Coupon Code'], 404);
            }


            // التأكد من أن الكوبون يعطي خصم 100%
            if ($coupon->discount_value != 100) {
                return $this->errorResponse("Failed Error", ['message' => 'Coupon is not Free'], 404);
            }


            if ($coupon->card_type_id != $request->card_type_id) {
                return $this->errorResponse("Failed Error", ['message' => 'Coupon is not for this Card Type'], 404);
            }





            // التحقق من أن المستخدم لم يستخدم الكوبون من قبل
            $existingCard = copones_used::where('user_id', $request->user_id)
                ->where('copone_id', $coupon->id)
                ->first();

            // إذا لم يكن هناك سجل، تعيين `current_usage` إلى 0
            $userusage = $existingCard->current_usage ?? 0;

            if ($coupon->usage_limit !== null && $coupon->usage_limit <= $userusage) {
                return $this->errorResponse("Failed Error", ['message' => 'Coupon usage limit exceeded', 'usage_limit' => $coupon->usage_limit], 400);
            }


            // إنشاء البطاقة للمستخدم
            Arma_Card::create([
                'user_id' => $request->user_id,
                'card_number' => null,
                'cvv' => null,
                'price' => $card->price,
                'issue_date' => $card->duration,
                'expiry_date' => null,
                'status' => 'inactive',
                'cardtype_id' => $request->card_type_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $coponeUsage = copones_used::firstOrNew(
                ['user_id' => $validatedData['user_id'], 'copone_id' => $coupon->id, 'card_type_id' => $coupon->card_type_id]
            );
            $coponeUsage->user_type = $validatedData['account_type'];
            $coponeUsage->usage_limit = $coupon->usage_limit;
            $coponeUsage->current_usage = $coponeUsage->current_usage + 1;
            $coponeUsage->save();

            return response()->json([
                'message' => 'The Card has been successfully created for the selected user.',
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }

    public function getCoponesForAccount($accountId, $type)
    {
        try {
            $copones = CouponUser::where('user_id', $accountId)
                ->where('account_type', $type) // ← التصحيح هنا
                ->orderBy('created_at', 'desc')
                ->with('coupon')
                ->paginate(15);

            if ($copones->isEmpty()) { // ← `isEmpty` بدلاً من `is_Empty`
                return $this->errorResponse(
                    "No Data Found",
                    ['message' => 'No Offers Found'],
                    404
                );
            }

            return response()->json([
                'data' => $copones->items(),
                'pagination' => [
                    'current_page' => $copones->currentPage(),
                    'last_page' => $copones->lastPage(),
                    'total' => $copones->total(),
                    'per_page' => $copones->perPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }
}
