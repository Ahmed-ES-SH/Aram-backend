<?php

namespace App\Http\Controllers;

use App\Models\mainpage;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Hamcrest\Type\IsString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainpageController extends Controller
{

    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }

    public function about()
    {
        try {
            $aboutdetailes = mainpage::findOrFail(1);
            return $this->successResponse($aboutdetailes, 'done', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }


    public function getdetailes($id)
    {
        try {
            $aboutdetailes = mainpage::findOrFail($id);
            return $this->successResponse($aboutdetailes, 'done', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }


    public function getvideoscreen()
    {
        try {
            $detailes = mainpage::findOrFail(2);
            return $this->successResponse($detailes, 'done', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }


    public function updatevideoscreen(Request $request)
    {
        try {
            // العثور على تفاصيل الصفحة الرئيسية
            $detailes = mainpage::findOrFail(2);
            // التحقق من نوع الفيديو
            if ($request->hasFile('video')) {
                // إذا كان الفيديو ملفًا مرفوعًا
                $request->validate([
                    'video' => 'sometimes|nullable|file|mimes:mp4,mov,avi,wmv|max:51200', // 50 ميجا كحد أقصى
                ]);

                // رفع الملف باستخدام خدمة الرفع
                $this->imageservice->ImageUploaderwithvariable(
                    $request,
                    $detailes,
                    'video/mainpage',
                    'video'
                );
            } else {
                // إذا كان الفيديو رابطًا نصيًا
                $request->validate([
                    'video' => 'sometimes|nullable|url', // يجب أن يكون الرابط صالحًا
                ]);

                // تحديث الرابط النصي
                $detailes->video = $request->input('video');
            }

            $detailes->fill($request->only([
                'main_text_en',
                'main_text_ar',
                'second_text_en',
                'second_text_ar',
                'third_text_en',
                'third_text_ar',
                'forth_text_en',
                'forth_text_ar',
                'link_video',
                'main_screen'
            ]));
            // حفظ التحديثات
            $detailes->save();

            // الاستجابة الناجحة
            return $this->successResponse($detailes, 'Main screen video updated successfully', 200);
        } catch (\Exception $e) {
            // الاستجابة في حالة وجود خطأ
            return $this->errorResponse('Failed to update video', ['message' => $e->getMessage()], 500);
        }
    }




    public function getmainscreen()
    {
        try {
            // جلب جميع العناصر من قاعدة البيانات
            $state = mainpage::findOrFail(3);
            // إرجاع البيانات مع استجابة ناجحة
            return $this->successResponse($state, "Done", 200);
        } catch (\Exception $e) {
            // إرجاع استجابة في حال حدوث خطأ
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve main screen data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getallmainscreen()
    {
        try {
            // جلب جميع العناصر من قاعدة البيانات
            $state = mainpage::all();
            // إرجاع البيانات مع استجابة ناجحة
            return $this->successResponse($state, "Done", 200);
        } catch (\Exception $e) {
            // إرجاع استجابة في حال حدوث خطأ
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve main screen data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateMainscreen(Request $request, $id)
    {
        try {
            // التحقق من وجود الحقل الذي سيتم تحديثه في الـ request
            $validated = $request->validate([
                'main_screen' => 'required|boolean', // التأكد من أن الحقل هو قيمة منطقية
            ]);

            // تحديث جميع السجلات الأخرى إلى 0
            mainpage::where('main_screen', 1)->update(['main_screen' => 0]);

            // جلب العنصر المستهدف من قاعدة البيانات باستخدام الـ ID
            $mainpage = mainpage::findOrFail($id);

            // تحديث الحقل المطلوب
            $mainpage->main_screen = $request->main_screen;

            // حفظ التغييرات في قاعدة البيانات
            $mainpage->save();

            // إرجاع استجابة ناجحة
            return $this->successResponse($mainpage, "Main screen updated successfully.", 200);
        } catch (\Exception $e) {
            // إرجاع استجابة في حال حدوث خطأ
            return response()->json([
                'success' => false,
                'message' => 'Failed to update main screen data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }






    /**
     * Update the specified resource in storage.
     */
    public function updateabout(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'main_text_en' => "nullable|string",
            'main_text_ar' => "nullable|string",
            'second_text_en' => "nullable|string",
            'second_text_ar' => "nullable|string",
            'bg_color' => "nullable|string",
            'image' => 'nullable|file|image',
            'image_2' => 'nullable|file|image',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ]);
        }



        try {
            $aboutdetailes = mainpage::findOrFail(1);
            $aboutdetailes->main_text_en = $request->main_text_en;
            $aboutdetailes->main_text_ar = $request->main_text_ar;
            $aboutdetailes->second_text_en = $request->second_text_en;
            $aboutdetailes->second_text_ar = $request->second_text_ar;
            $aboutdetailes->bg_color = $request->bg_color;
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $aboutdetailes, 'images/mainpage');
            }
            if ($request->has('image_2')) {
                $this->imageservice->ImageUploaderwithvariable($request, $aboutdetailes, 'images/mainpage', 'image_2');
            }
            $aboutdetailes->save();
            return $this->successResponse($aboutdetailes, 'update done', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }
}
