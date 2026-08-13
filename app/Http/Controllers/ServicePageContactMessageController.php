<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceContactMessageRequest;
use App\Http\Services\NotificationService;
use App\Http\Traits\ApiResponse;
use App\Models\ServicePage;
use App\Models\ServicePageContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class ServicePageContactMessageController extends Controller
{

    use ApiResponse;
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    #[OA\Post(
        path: '/add-service-message',
        summary: 'Submit a contact message for a service page',
        tags: ['Service Pages'],
        responses: [
            new CreatedResponse('Message created'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreServiceContactMessageRequest $request)
    {
        try {

            $data = $request->validated();
            $service = ServicePageContactMessage::create($data);

            $adminsIds = User::where('role', 'admin')->pluck('id')->toArray();
            $sender = User::where('id', '1')->where('role', 'admin')->first();
            $service  = ServicePage::where('id', $data['service_page_id'])->select('slug')->first();


            $notificationData = [
                'user_ids' => $adminsIds,
                'sender_type' => 'user',
                'content' => "لديك رسالة جديدة من صفحة الخدمة " . $service->slug,
            ];

            $this->notificationService->sendMultipleNotifications($notificationData, $sender);

            return $this->successResponse($service, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }



    #[OA\Post(
        path: '/update-service-message/{message}',
        summary: 'Update a service page contact message (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'message', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Message updated'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(ServicePageContactMessage $messaage, Request $request)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,processing,completed',
            ]);

            $status = $request->status;

            $messaage->update([
                'status' => $status
            ]);

            return $this->successResponse($messaage, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }



    #[OA\Delete(
        path: '/delete-service-message/{message}',
        summary: 'Delete a service page contact message (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'message', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Message deleted'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(ServicePageContactMessage $messaage)
    {
        try {
            $messaage->delete();
            return $this->successResponse($messaage, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
