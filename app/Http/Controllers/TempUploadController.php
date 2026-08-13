<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadTempFileRequest;
use App\Http\Services\TempUploadService;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class TempUploadController extends Controller
{
    use ApiResponse;

    protected TempUploadService $tempUploadService;

    public function __construct(TempUploadService $tempUploadService)
    {
        $this->tempUploadService = $tempUploadService;
    }

    /**
     * Upload a single file to temporary storage.
     *
     * POST /api/uploads/temp
     *
     * @param UploadTempFileRequest $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/uploads/temp',
        summary: 'Upload a file to temporary storage',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['file'],
                    properties: [
                        new OA\Property(property: 'file', type: 'string', format: 'binary'),
                        new OA\Property(property: 'service_order_id', type: 'integer', nullable: true),
                    ],
                ),
            ),
        ),
        responses: [
            new CreatedResponse('File uploaded successfully'),
            new UnprocessableResponse('Upload failed'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function upload(UploadTempFileRequest $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $pendingFile = $this->tempUploadService->upload($file, $request->service_order_id);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => [
                    'id' => $pendingFile->uuid,
                    'original_name' => $pendingFile->original_name,
                    'mime_type' => $pendingFile->mime_type,
                    'size' => $pendingFile->size,
                    'expires_at' => $pendingFile->expires_at,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Delete a pending upload by UUID.
     *
     * DELETE /api/uploads/temp/{uuid}
     *
     * @param string $uuid
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/uploads/temp/{uuid}',
        summary: 'Delete a pending temporary upload',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OkResponse('File deleted successfully'),
            new NotFoundResponse('File not found or already attached'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(string $uuid): JsonResponse
    {
        $deleted = $this->tempUploadService->deleteByUuid($uuid);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'File not found or already attached.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully.',
        ]);
    }
}
