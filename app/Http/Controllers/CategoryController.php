<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\category;
use App\Services\ImageService;
use App\Traits\ApiResponse;

class CategoryController extends Controller
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
            $categories = category::orderBy('created_at', 'desc')->paginate(50);
            if ($categories->isEmpty()) {
                return $this->successResponse([], 'No categories found', 404);
            }
            return response()->json([
                'data' => $categories->items(),
                'pagination' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = new category();
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $category, 'images/categories');
            }
            $category->save();
            return $this->successResponse($category, 'Category Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = category::findOrFail($id);
            return $this->successResponse($category, 'Find Catgeory Done .', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $category = category::findOrFail($id);
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $category, 'images/categories');
            }
            $category->save();
            return $this->successResponse($category, 'Category Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = category::findOrFail($id);
            $this->imageservice->deleteOldImage($category, 'images/categories');
            $category->delete();
            return $this->successResponse($category, 'Category deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }
}
