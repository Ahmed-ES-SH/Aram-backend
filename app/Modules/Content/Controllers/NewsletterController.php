<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Modules\Content\Mail\NewsletterMail;
use App\Modules\Content\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class NewsletterController extends Controller
{

    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageservice)
    {
        $this->imageservice = $imageservice;
    }

    #[OA\Get(
        path: '/newsletters',
        summary: 'List all newsletters',
        tags: ['Newsletters'],
        responses: [
            new ListOkResponse('Newsletter'),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        $newsletters = Newsletter::latest()->get();
        return $this->successResponse($newsletters, 200);
    }

    #[OA\Post(
        path: '/newsletters',
        summary: 'Create a new newsletter (multipart)',
        tags: ['Newsletters'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'subject', type: 'string', maxLength: 255),
                        new OA\Property(property: 'content', type: 'string'),
                        new OA\Property(property: 'section_1_title', type: 'string'),
                        new OA\Property(property: 'section_1_description', type: 'string'),
                        new OA\Property(property: 'section_1_image', type: 'string', format: 'binary'),
                        new OA\Property(property: 'section_2_title', type: 'string'),
                        new OA\Property(property: 'section_2_description', type: 'string'),
                        new OA\Property(property: 'section_2_image', type: 'string', format: 'binary'),
                        new OA\Property(property: 'section_3_title', type: 'string'),
                        new OA\Property(property: 'section_3_description', type: 'string'),
                        new OA\Property(property: 'section_3_image', type: 'string', format: 'binary'),
                    ],
                ),
            ),
        ),
        responses: [
            new CreatedResponse('Newsletter created'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'section_1_title' => 'nullable|string|max:255',
            'section_1_description' => 'nullable|string',
            'section_1_image' => 'nullable|file|max:5096',
            'section_2_title' => 'nullable|string|max:255',
            'section_2_description' => 'nullable|string',
            'section_2_image' => 'nullable|file|max:5096',
            'section_3_title' => 'nullable|string|max:255',
            'section_3_description' => 'nullable|string',
            'section_3_image' => 'nullable|file|max:5096',
        ]);


        $newsletter = Newsletter::create($validated);

        $imageFields = ['section_1_image', 'section_2_image', 'section_3_image'];
        foreach ($imageFields as $field) {
            if ($request->has($field)) {
                $this->imageservice->ImageUploaderwithvariable($request, $newsletter, 'images/newsletters', $field);
            }
        }

        return $this->successResponse($newsletter, 201);
    }

    #[OA\Get(
        path: '/newsletters/{id}',
        summary: 'Show a single newsletter',
        tags: ['Newsletters'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Newsletter'),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        return $this->successResponse($newsletter, 200);
    }

    #[OA\Put(
        path: '/newsletters/{id}',
        summary: 'Update a newsletter (multipart)',
        tags: ['Newsletters'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'subject', type: 'string', maxLength: 255),
                        new OA\Property(property: 'content', type: 'string'),
                        new OA\Property(property: 'section_1_title', type: 'string'),
                        new OA\Property(property: 'section_1_description', type: 'string'),
                        new OA\Property(property: 'section_1_image', type: 'string', format: 'binary'),
                        new OA\Property(property: 'section_2_title', type: 'string'),
                        new OA\Property(property: 'section_2_description', type: 'string'),
                        new OA\Property(property: 'section_2_image', type: 'string', format: 'binary'),
                        new OA\Property(property: 'section_3_title', type: 'string'),
                        new OA\Property(property: 'section_3_description', type: 'string'),
                        new OA\Property(property: 'section_3_image', type: 'string', format: 'binary'),
                    ],
                ),
            ),
        ),
        responses: [
            new EntityOkResponse('Newsletter'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(Request $request, $id)
    {
        $newsletter = Newsletter::findOrFail($id);

        $validated = $request->validate([
            'subject' => 'sometimes|required|string|max:255',
            'content' => 'nullable|string',
            'section_1_title' => 'nullable|string|max:255',
            'section_1_description' => 'nullable|string',
            'section_1_image' => 'nullable|file|max:5096',
            'section_2_title' => 'nullable|string|max:255',
            'section_2_description' => 'nullable|string',
            'section_2_image' => 'nullable|file|max:5096',
            'section_3_title' => 'nullable|string|max:255',
            'section_3_description' => 'nullable|string',
            'section_3_image' => 'nullable|file|max:5096',
        ]);

        $newsletter->update($validated);

        $imageFields = ['section_1_image', 'section_2_image', 'section_3_image'];
        foreach ($imageFields as $field) {
            if ($request->has($field)) {
                $this->imageservice->ImageUploaderwithvariable($request, $newsletter, 'images/newsletters', $field);
            }
        }

        return $this->successResponse($newsletter, 200);
    }

    #[OA\Delete(
        path: '/newsletters/{id}',
        summary: 'Delete a newsletter',
        tags: ['Newsletters'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Newsletter deleted'),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return $this->successResponse(null, 200);
    }

    #[OA\Post(
        path: '/newsletters/{id}/send',
        summary: 'Send a newsletter to a list of emails',
        tags: ['Newsletters'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['emails'],
                properties: [
                    new OA\Property(property: 'emails', type: 'array', items: new OA\Items(type: 'string', format: 'email'), description: 'Array or JSON encoded string of emails'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Newsletter sent successfully'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function send(Request $request, $id)
    {
        $newsletter = Newsletter::findOrFail($id);

        $request->validate([
            'emails' => 'required',
        ]);

        $emails = $request->input('emails');

        if (is_string($emails)) {
            $emails = json_decode($emails, true);
        }


        foreach ($emails as $email) {
            Mail::to($email)->send(new NewsletterMail($newsletter));
        }

        return response()->json(['message' => 'Newsletter sent successfully']);
    }
}
