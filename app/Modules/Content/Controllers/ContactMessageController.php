<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Content\Requests\StoreContactMessageRequest;
use App\Http\Traits\ApiResponse;
use App\Modules\Content\Models\ContactMessage;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class ContactMessageController extends Controller
{

    use ApiResponse;

    #[OA\Get(
        path: '/contact-messages',
        summary: 'List contact messages (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        responses: [
            new PaginatedOkResponse('ContactMessage'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $Messages = ContactMessage::orderBy('created_at', 'desc')->paginate(30);
            if ($Messages->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Messages, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/add-contact-message',
        summary: 'Submit a contact message',
        tags: ['Contact & FAQ'],
        responses: [
            new CreatedResponse('Message created'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreContactMessageRequest $request)
    {
        try {
            $data = $request->validated();
            $message = new ContactMessage();
            $message->fill($data);
            $message->save();
            return $this->successResponse($message, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/contact-message/{id}',
        summary: 'Show a single contact message (admin)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ContactMessage'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            return $this->successResponse($message, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/update-contact-message/{id}',
        summary: 'Update a contact message status (admin)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Message updated'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(Request $request, $id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            if ($request->has('status')) {
                $message->status = $request->status;
                $message->save();
                return $this->successResponse($message,  200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/contact-message/{id}',
        summary: 'Delete a contact message (admin)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Message deleted'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->delete();
            return $this->successResponse($message, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
