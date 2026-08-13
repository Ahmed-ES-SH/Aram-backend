<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\Slide;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class SlideController extends Controller
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
    #[OA\Get(
        path: '/slides',
        summary: 'List all slides (admin)',
        security: [['sanctum' => []]],
        tags: ['Slides'],
        responses: [
            new ListOkResponse('Slide'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $slides = Slide::all();

            // Decode JSON fields if needed
            $slides->transform(function ($slide) {
                if (is_string($slide->title)) {
                    $slide->title = json_decode($slide->title, true);
                }

                if (is_string($slide->description)) {
                    $slide->description = json_decode($slide->description, true);
                }

                return $slide;
            });

            return $this->successResponse($slides, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Get(
        path: '/active-slides',
        summary: 'List active slides',
        tags: ['Slides'],
        responses: [
            new ListOkResponse('Slide'),
            new ServerErrorResponse(),
        ],
    )]
    public function activeSlides()
    {
        try {
            $slides = Slide::where('status', 'active')->get();

            // Decode JSON fields if needed
            $slides->transform(function ($slide) {
                if (is_string($slide->title)) {
                    $slide->title = json_decode($slide->title, true);
                }

                if (is_string($slide->description)) {
                    $slide->description = json_decode($slide->description, true);
                }

                return $slide;
            });

            return $this->successResponse($slides, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/add-slide',
        summary: 'Create a new slide (admin, multipart)',
        security: [['sanctum' => []]],
        tags: ['Slides'],
        responses: [
            new CreatedResponse('Slide created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreSlideRequest $request)
    {
        try {
            $data = $request->validated();
            $slide = Slide::create(collect($data)->except('image')->toArray());
            // معالجة الصورة إذا تم رفعها
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $slide, 'images/slides', 'image');
            }
            return $this->successResponse($slide, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/get-slide/{id}',
        summary: 'Show a single slide (admin)',
        security: [['sanctum' => []]],
        tags: ['Slides'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Slide'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        try {
            $slide = Slide::findOrFail($id);

            // Decode JSON fields if needed
            if (is_string($slide->title)) {
                $slide->title = json_decode($slide->title, true);
            }

            if (is_string($slide->description)) {
                $slide->description = json_decode($slide->description, true);
            }

            return $this->successResponse($slide, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/update-slide/{id}',
        summary: 'Update a slide (admin, multipart)',
        security: [['sanctum' => []]],
        tags: ['Slides'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Slide'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateSlideRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $slide = Slide::findOrFail($id);

            $slide->update(collect($data)->except('image')->toArray());

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $slide, 'images/slides', 'image');
            }

            // Decode JSON fields if needed
            if (is_string($slide->title)) {
                $slide->title = json_decode($slide->title, true);
            }

            if (is_string($slide->description)) {
                $slide->description = json_decode($slide->description, true);
            }

            return $this->successResponse($slide, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/delete-slide/{id}',
        summary: 'Delete a slide (admin)',
        security: [['sanctum' => []]],
        tags: ['Slides'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('slide deleted successfully'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $slide = Slide::findOrFail($id);
            if (filled($slide->image)) {
                $this->imageservice->deleteOldImage($slide, 'images/slides');
            }

            $slide->delete();

            return $this->successResponse([], 200, 'slide deleted successfully .');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
