<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyDetailesRequest;
use App\Models\CompanyDetailes;
use App\Services\ImageService;
use App\Traits\ApiResponse;

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
            $imageFields = ['about_image', 'vision_image', 'goals_image', 'values_image'];
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
