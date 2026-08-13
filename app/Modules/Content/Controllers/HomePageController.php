<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Modules\Content\Models\HomePage;
use App\Modules\Content\Models\WebsiteVideo;
use Exception;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class HomePageController extends Controller
{
    use ApiResponse;

    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }


    #[OA\Get(
        path: '/active-hero-section',
        summary: 'Check whether the hero section is active',
        tags: ['Home Page'],
        responses: [
            new OkResponse('Hero section active flag'),
            new ServerErrorResponse(),
        ],
    )]
    public function activeHeroSection()
    {
        try {
            $section = HomePage::findOrFail(1);
            $is_active = $section->column_30;
            return $this->successResponse($is_active, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/get-section/{id}',
        summary: 'Get a homepage section by id',
        tags: ['Home Page'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'limit_number', in: 'query', required: false, schema: new OA\Schema(type: 'integer', maximum: 30), example: 30),
            new OA\Parameter(name: 'main_page', in: 'query', required: false, schema: new OA\Schema(type: 'boolean')),
        ],
        responses: [
            new OkResponse('Section data'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getSection($id, Request $request)
    {
        try {
            $request->validate([
                'limit_number' => 'nullable|integer|min:1|max:30',
                'main_page' => 'nullable|boolean',
            ]);

            $limit = $request->input('limit_number', 30);

            $section = HomePage::findOrFail($id);

            if ($request->boolean('main_page')) {

                $Mainvideo = WebsiteVideo::where("video_id", 'main_page')->first();
                $demovideo = WebsiteVideo::where("video_id", 'demo_video')->first();

                $data = [
                    'id' => $section->id,
                    'main_video' => $Mainvideo,
                    'demo_video' => $demovideo,
                ];

                for ($i = 1; $i <= $limit; $i++) {
                    $column = 'column_' . $i;
                    $value = $section->$column;

                    $data[$column] = $this->isJson($value)
                        ? json_decode($value, true)
                        : $value;
                }

                return $this->successResponse($data, 200);
            }

            $data = [
                'id' => $section->id,
                'video' => $section->video, // always string (link)
                'image' => $section->image, // always string (link)
            ];

            // Add dynamic columns
            for ($i = 1; $i <= $limit; $i++) {
                $column = 'column_' . $i;
                $value = $section->$column;

                if ($this->isJson($value)) {
                    $data[$column] = json_decode($value, true);
                } else {
                    $data[$column] = $value;
                }
            }

            return $this->successResponse($data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/update-section/{id}',
        summary: 'Create or update a homepage section (admin, multipart)',
        security: [['sanctum' => []]],
        tags: ['Home Page'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'image', type: 'string', format: 'binary'),
                        new OA\Property(property: 'video', type: 'string', format: 'binary'),
                        new OA\Property(property: 'column_1', type: 'string', description: 'column_N values up to limit_number'),
                    ],
                ),
            ),
        ),
        responses: [
            new OkResponse('Section updated'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function updateSection(Request $request, $id)
    {
        try {
            // تحقق أساسي من الصورة
            $rules = [
                'image' => 'nullable|file|image|max:5048', // 5048 KB ≈ 5 MB
                'video' => 'nullable|max:30720', // 30 MB
            ];

            // لو فيه limit_number نضيف قواعد تحقق للأعمدة المطلوبة
            $limit = $request->query('limit_number', 0);

            for ($i = 1; $i <= $limit; $i++) {
                $rules['column_' . $i] = ['required']; // أي محتوى غير فاضي
            }

            $request->validate($rules);

            // تجهيز البيانات (استثناء الصورة لأنها هتتعامل لوحدها)
            $data = $request->except(['image', 'video']);

            // Update or Create
            $section = HomePage::updateOrCreate(
                ['id' => $id],
                $data
            );

            // معالجة الصورة إذا تم رفعها
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable(
                    $request,
                    $section,
                    'images/homepage',
                    'image'
                );
            }


            // معالجة الصورة إذا تم رفعها
            if ($request->hasFile('video')) {
                $this->imageservice->ImageUploaderwithvariable(
                    $request,
                    $section,
                    'videos/homepage',
                    'video'
                );
            } elseif ($request->has('video')) {
                $section->video = $request->video;
            }

            $section->save();

            return $this->successResponse($section, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    private function isJson($string): bool
    {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
