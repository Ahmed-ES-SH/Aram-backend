<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSliderRequest;
use App\Models\slider;
use App\Traits\ApiResponse;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
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
            $sliders = slider::all();

            // تحقق إذا كانت البيانات فارغة
            if ($sliders->isEmpty()) {
                return $this->successResponse([], 'No sliders found', 404);
            }

            // إرجاع البيانات بنجاح
            return $this->successResponse($sliders, 'Data fetched successfully', 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ مع تفاصيل الاستثناء
            return $this->errorResponse('Failed to fetch data', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        // dd($request->validated());
        $data = $request->validated();
        try {
            $slider = new slider();
            $slider->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $slider, 'images/slider');
            }
            $slider->save();
            // إرجاع البيانات بنجاح
            return $this->successResponse($slider, 'Slider Created Successfully', 201);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ مع تفاصيل الاستثناء
            return $this->errorResponse('Failed to Create Slider', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(slider $slider, $id)
    {
        try {
            $slider = slider::findorFail($id);
            return $this->successResponse($slider, 'Slider Founded Successfully', 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ مع تفاصيل الاستثناء
            return $this->errorResponse('Failed to Found Slider', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSliderRequest $request, $id)
    {
        try {
            $slider =  slider::findOrFail($id);
            $slider->fill($request->validated());
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $slider, 'images/slider');
            }
            $slider->save();
            // إرجاع البيانات بنجاح
            return $this->successResponse($slider, 'Slider Created Successfully', 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ مع تفاصيل الاستثناء
            return $this->errorResponse('Failed to update Slider', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $slider =  slider::findOrFail($id);
            $this->imageservice->deleteOldImage($slider, 'images/slider');
            $slider->delete();
            // إرجاع البيانات بنجاح
            return $this->successResponse($slider, 'Slider deleted Successfully', 200);
        } catch (\Exception $e) {
            // إرجاع رسالة الخطأ مع تفاصيل الاستثناء
            return $this->errorResponse('Failed to delete Slider', ['message' => $e->getMessage()], 500);
        }
    }
}
