<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAboutContentRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\About;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class AboutController extends Controller
{
    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageservice)
    {
        $this->imageservice = $imageservice;
    }





    #[OA\Get(
        path: '/details',
        summary: 'Get the about/company details',
        tags: ['Settings'],
        responses: [
            new OkResponse('Company details'),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $companydetailes = About::findOrFail(1);
            return $this->successResponse($companydetailes, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/get-cooperation-file',
        summary: 'Get the cooperation PDF file',
        tags: ['Settings'],
        responses: [
            new OkResponse('Cooperation PDF'),
            new ServerErrorResponse(),
        ],
    )]
    public function getcooperation_pdf()
    {
        try {
            $model = About::findOrFail(1);
            return $this->successResponse($model->cooperation_pdf, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Post(
        path: '/update-uploadcooperation-file',
        summary: 'Upload the cooperation PDF file (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'cooperation_pdf', type: 'string', format: 'binary'),
                    ],
                ),
            ),
        ),
        responses: [
            new OkResponse('Cooperation PDF uploaded'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function uploadcooperation_pdf(Request $request)
    {
        try {
            $model = About::findOrFail(1);
            $model->cooperation_pdf = $request->cooperation_pdf;
            $model->save();
            return $this->successResponse($model->cooperation_pdf, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/update-details',
        summary: 'Update the about/company details (admin, multipart)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        responses: [
            new OkResponse('Company details updated'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateAboutContentRequest $request)
    {
        try {
            $detailes = About::findOrFail(1);
            $data = $request->validated();
            $detailes->fill($data);

            // معالجة الصور
            $imageFields = ['first_section_image', 'second_section_image', 'thired_section_image', 'fourth_section_image', 'cooperation_pdf', 'logo'];
            foreach ($imageFields as $field) {
                if ($request->has($field)) {
                    $this->imageservice->ImageUploaderwithvariable($request, $detailes, 'images/companydetailes', $field);
                }
            }

            // حفظ البيانات
            $detailes->save();

            return $this->successResponse($detailes, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/get-logo',
        summary: 'Get the company logo',
        tags: ['Settings'],
        responses: [
            new OkResponse('Logo'),
            new ServerErrorResponse(),
        ],
    )]
    public function getLogo()
    {
        $logo = About::where('id', 1)->select('id', 'logo')->first();
        return $this->successResponse($logo, 200);
    }
}
