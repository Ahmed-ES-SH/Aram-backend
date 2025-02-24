<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ServiceController extends Controller
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
            // جلب الخدمات وترتيبها حسب تاريخ الإنشاء
            $services = Service::orderBy("created_at", 'desc')->paginate(9);
            $items = $services->items();
            $categoriesFounded = []; // مصفوفة لتخزين الفئات

            foreach ($items as $item) {
                $categories = json_decode($item->categories_id, true);
                if (is_array($categories)) { // التحقق من أن الفئات مصفوفة
                    foreach ($categories as $cat) {
                        $category = ServiceCategory::find($cat);
                        if ($category) {
                            $categoriesFounded[] = $category;
                        }
                    }
                }
            }

            if ($services->isEmpty()) {
                return response()->json([
                    'message' => "No Services Found"
                ], 404);
            }

            return response()->json([
                'data' => $items,
                'categories' => $categoriesFounded, // إضافة الفئات إلى الاستجابة
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }





    public function activeservices()
    {
        try {
            // جلب البطاقات النشطة مع التصفح (pagination)
            $cardtypes = Service::where('active', true)->paginate(12);

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


    public function getServiceByServicesCategory($id)
    {
        try {
            $services = Service::where('category_id', $id)->paginate(9);
            if ($services->isEmpty()) {
                return response()->json([
                    'message' => "No Services Found"
                ], 404);
            }

            return response()->json([
                'data' => $services->items(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function getServicesBySearch($text)
    {
        try {
            $services = Service::where('title_en', 'like', '%' . $text . '%')
                ->orwhere('title_ar', 'like', '%' . $text . '%')
                ->orwhere('description_en', 'like', '%' . $text . '%')
                ->orwhere('description_ar', 'like', '%' . $text . '%')
                ->paginate(9);
            return response()->json([
                'data' => $services->items(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function updateactiveservice($id, $active)
    {
        try {
            // التحقق من وجود البطاقة
            $cardtype = Service::find($id);

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
    public function store(StoreServiceRequest $request)
    {
        try {
            $data = $request->validated();
            $service = new Service();
            $service->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $service, 'images/services/images');
            }
            if ($request->has('icon')) {
                $this->imageservice->ImageUploaderwithvariable($request, $service, 'images/services/icons', 'icon');
            }
            $service->save();
            return $this->successResponse($service, 'Service Created Successfully', 201);
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
            $service = Service::findOrFail($id);
            return $this->successResponse($service, 'Service Founded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->fill($request->only(['title_en', 'title_ar', 'description_en', 'description_ar', 'category_id', 'features']));
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $service, 'images/services/images');
            }
            if ($request->has('icon')) {
                $this->imageservice->ImageUploaderwithvariable($request, $service, 'images/services/icons', 'icon');
            }
            $service->save();
            return $this->successResponse($service, 'Service Updated Successfully', 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating service: ' . $e->getMessage());
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            if ($service->image) {
                $this->imageservice->deleteOldImage($service, 'images/services/images');
            }
            if ($service->icon) {
                $this->imageservice->deleteOldImage($service, 'images/services/icons');
            }
            $service->delete();
            return $this->successResponse($service, 'Service deleted Successfully', 200);
        } catch (\Exception $e) {
            $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }
}
