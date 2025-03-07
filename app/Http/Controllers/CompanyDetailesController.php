<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyDetailesRequest;
use App\Models\CompanyDetailes;
use App\Services\ImageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanyDetailesController extends Controller
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
            $companydetailes = CompanyDetailes::findOrFail(1);
            return $this->successResponse($companydetailes, 'done', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function uploadPDF(Request $request)
    {
        try {
            // التحقق من أن الملف موجود
            if (!$request->hasFile('file')) {
                return response()->json(['message' => 'No file uploaded'], 400);
            }

            $pdfFile = $request->file('file');

            // التحقق من أن الملف بصيغة PDF فقط
            if ($pdfFile->getClientOriginalExtension() !== 'pdf') {
                return response()->json(['message' => 'Only PDF files are allowed'], 400);
            }

            // -------------------------
            // حذف الملف القديم إن وجد
            // -------------------------
            $storagePath = 'uploads/pdfs';
            $companydetailes = CompanyDetailes::findOrFail(1);
            $old_pdf = $companydetailes->cooperation_pdf; // احصل على رابط الملف القديم من قاعدة البيانات

            if ($old_pdf) {
                $old_pdf_name = basename(parse_url($old_pdf, PHP_URL_PATH));
                $file_path = public_path($storagePath . '/' . $old_pdf_name);
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }
            }

            // -------------------------
            // إنشاء اسم الملف الجديد
            // -------------------------
            $originalName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $pdfFile->getClientOriginalExtension();
            $filename = $originalName . '_' . uniqid() . '.' . $extension;

            // حفظ الملف في المجلد المحدد
            $pdfFile->move(public_path($storagePath), $filename);

            // تحديث مسار الملف في قاعدة البيانات

            $companydetailes->cooperation_pdf = url('/') . '/' . $storagePath . '/' . $filename;
            $companydetailes->save();

            return response()->json([
                'message' => 'PDF uploaded successfully',
                'file_url' => $companydetailes->cooperation_pdf
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload PDF', 'error' => $e->getMessage()], 500);
        }
    }


    public function downloadUserPDF()
    {
        try {
            // الحصول على المستخدم الحالي
            $companydetailes = CompanyDetailes::findOrFail(1);

            // التحقق من أن المستخدم لديه ملف PDF
            if (!$companydetailes || !$companydetailes->cooperation_pdf) {
                return response()->json(['message' => 'No PDF file found'], 404);
            }

            // استخراج اسم الملف من الرابط المخزن في قاعدة البيانات
            $pdfPath = parse_url($companydetailes->cooperation_pdf, PHP_URL_PATH);
            $filePath = public_path($pdfPath);

            // التحقق من أن الملف موجود فعليًا
            if (!File::exists($filePath)) {
                return response()->json(['message' => 'File not found'], 404);
            }

            // تحميل الملف مباشرةً
            return response()->download($filePath, basename($filePath));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to download PDF', 'error' => $e->getMessage()], 500);
        }
    }




    public function getSocialMediaInfo()
    {
        try {
            $data = CompanyDetailes::select(
                'whatsapp_number',
                'gmail_account',
                'facebook_account',
                'x_account',
                'youtube_account',
                'instgram_account',
                'snapchat_account',
            )->findOrFail(1);
            return $this->successResponse($data, 'Data Founded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    public function getWhatsappNumber()
    {
        try {
            $number = CompanyDetailes::select('whatsapp_number')->findOrFail(1);
            return $this->successResponse($number, 'whatsapp number Founded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCompanyDetailesRequest $request)
    {
        try {
            $detailes = CompanyDetailes::findOrFail(1);
            $data = $request->validated();
            $detailes->fill($data);

            // معالجة الصور
            $imageFields = ['first_section_image', 'second_section_image', 'thired_section_image', 'fourth_section_image'];
            foreach ($imageFields as $field) {
                if ($request->has($field)) {
                    $this->imageservice->ImageUploaderwithvariable($request, $detailes, 'images/companydetailes', $field);
                }
            }

            // معالجة الفيديو
            if ($request->has('main_video')) {
                $mainVideo = $request->input('main_video');

                if ($request->hasFile('main_video')) {
                    // إذا كان ملف، يتم رفعه
                    $videoFile = $request->file('main_video');
                    $filename = 'video_' . date('YmdHis') . '.' . $videoFile->getClientOriginalExtension();
                    $videoFile->move(public_path('videos/companydetailes'), $filename);
                    $videoUrl = url('videos/companydetailes/' . $filename);

                    // تخزين الرابط في الحقل
                    $detailes->main_video = $videoUrl;
                } else {
                    // إذا كان رابط، يتم تخزينه مباشرة
                    $detailes->main_video = $mainVideo;
                }
            }

            // حفظ البيانات
            $detailes->save();

            return $this->successResponse($detailes, 'Data Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", ['message' => $e->getMessage()], 500);
        }
    }
}
