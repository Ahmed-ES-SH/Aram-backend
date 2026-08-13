<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Requests\Conversation\BlockUserRequest;
use App\Http\Requests\Conversation\GetConversationRequest;
use App\Http\Requests\Conversation\SetActiveConversationRequest;
use App\Http\Requests\Conversation\StoreConversationRequest;
use App\Modules\Conversation\Services\ConversationService;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\NoContentResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class ConversationController extends Controller
{
    use ApiResponse;

    protected $conversationService;

    /**
     * =========================================================================
     * Constructor: Dependency Injection for ConversationService
     * =========================================================================
     * Injects the ConversationService to handle business logic for conversations.
     */
    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    /**
     * =========================================================================
     * Store Conversation: Create or Retrieve Existing Conversation
     * =========================================================================
     * Creates a new conversation between participants or returns an existing one
     * if it already exists. Uses validated request data.
     */
    #[OA\Post(
        path: '/start-conversation',
        summary: 'Create a conversation between two participants or return the existing one',
        security: [['sanctum' => []]],
        tags: ['Conversations'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['participant_one_id', 'participant_one_type', 'participant_two_id', 'participant_two_type'],
                properties: [
                    new OA\Property(property: 'participant_one_id', type: 'integer'),
                    new OA\Property(property: 'participant_one_type', type: 'string', enum: ['user', 'organization']),
                    new OA\Property(property: 'participant_two_id', type: 'integer'),
                    new OA\Property(property: 'participant_two_type', type: 'string', enum: ['user', 'organization']),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Conversation created successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function StoreConversation(StoreConversationRequest $request)
    {
        try {
            $result = $this->conversationService->store($request->validated());
            $message = $result['created'] ? 'Conversation created successfully.' : 'Conversation already exists.';
            return $this->successResponse($result['conversation'], 201, $message);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * =========================================================================
     * Get Conversation: Retrieve Specific Conversation Details
     * =========================================================================
     * Fetches detailed information about a specific conversation, including
     * messages and participants, based on the provided conversation ID and
     * participant details.
     */
    #[OA\Get(
        path: '/conversation/show',
        summary: 'Get a conversation detail with messages and participants',
        security: [['sanctum' => []]],
        tags: ['Conversations'],
        parameters: [
            new OA\Parameter(name: 'conversation_id', in: 'query', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'participant_id', in: 'query', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'participant_type', in: 'query', required: true, schema: new OA\Schema(type: 'string', enum: ['user', 'organization'])),
        ],
        responses: [
            new OkResponse('Conversation detail'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getConversation(GetConversationRequest $request)
    {
        try {
            $data = $this->conversationService->getConversation(
                $request->conversation_id,
                $request->participant_id,
                $request->participant_type
            );
            return $this->successResponse($data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * =========================================================================
     * Get User Conversations: List All Conversations for a Participant
     * =========================================================================
     * Retrieves all conversations for a specific participant. If participant
     * details are not provided in the request, it falls back to the
     * authenticated user's information.
     */
    #[OA\Get(
        path: '/user/{id}/conversations',
        summary: 'List conversations for a participant (falls back to the authenticated user)',
        security: [['sanctum' => []]],
        tags: ['Conversations'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'Participant id (optional if authenticated)'),
        ],
        responses: [
            new OkResponse('Conversations'),
            new NoContentResponse(),
            new ErrorResponse(422, 'Participant not provided and user not authenticated'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getUserConversations(Request $request)
    {
        try {
            $participantId = $request->input('participant_id');
            $participantTypeShort = $request->input('participant_type');

            // Fallback to authenticated user if participant details are not provided
            if (!$participantId || !$participantTypeShort) {
                $user = $request->user();
                if (!$user) {
                    return $this->errorResponse('Participant not provided and user not authenticated', 422);
                }
                $participantId = $participantId ?? $user->id;
                $participantTypeShort = $participantTypeShort ?? ($user->account_type ?? 'user');
            }

            $conversations = $this->conversationService->getUserConversations($participantId, $participantTypeShort);

            if ($conversations->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->successResponse($conversations, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * =========================================================================
     * Set Active Conversation: Mark Conversation as Active for User
     * =========================================================================
     * Marks a specific conversation as the active conversation for the
     * authenticated user. This is useful for tracking the user's current
     * chat context.
     */
    #[OA\Post(
        path: '/active-conversation',
        summary: 'Mark a conversation as active for the authenticated user',
        security: [['sanctum' => []]],
        tags: ['Conversations'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['conversation_id'],
                properties: [
                    new OA\Property(property: 'conversation_id', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Conversation marked as active'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function setActiveConversation(SetActiveConversationRequest $request)
    {
        $user = $request->user();
        $this->conversationService->setActive($user->id, $user->account_type, $request->conversation_id);

        return response()->json([
            'message' => 'Conversation marked as active',
            'participant' => [
                'id' => $user->id,
                'type' => $user->account_type,
            ],
            'conversation_id' => $request->conversation_id
        ]);
    }

    /**
     * =========================================================================
     * Clear Active Conversation: Remove Active Conversation Status
     * =========================================================================
     * Clears the active conversation setting for the authenticated user,
     * effectively resetting their current chat context.
     */
    #[OA\Post(
        path: '/clear-active-conversation',
        summary: 'Clear the active conversation for the authenticated user',
        security: [['sanctum' => []]],
        tags: ['Conversations'],
        responses: [
            new OkResponse('Active conversation cleared'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function clearActiveConversation(Request $request)
    {
        $user = $request->user();
        $this->conversationService->clearActive($user->id, $user->account_type);

        return response()->json([
            'message' => 'Active conversation cleared',
            'participant' => [
                'id' => $user->id,
                'type' => $user->account_type,
            ]
        ]);
    }

    /**
     * =========================================================================
     * Block User: Block a User within a Conversation
     * =========================================================================
     * Blocks a specific user within a conversation, preventing them from
     * sending messages. Requires authentication and conversation context.
     */
    #[OA\Post(
        path: '/conversations/{conversationId}/block',
        summary: 'Block a user inside a conversation',
        security: [['sanctum' => []]],
        tags: ['Conversations'],
        parameters: [
            new OA\Parameter(name: 'conversationId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['blocked_user'],
                properties: [
                    new OA\Property(property: 'blocked_user', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new OkResponse('User has been blocked successfully'),
            new UnauthorizedResponse(),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function blockUser(BlockUserRequest $request)
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return $this->errorResponse('User not authenticated', 401);
            }

            $this->conversationService->blockUser($userId, $request->conversation_id, $request->blocked_user);

            return $this->successResponse('User has been blocked successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * =========================================================================
     * Unblock User: Unblock a Previously Blocked User
     * =========================================================================
     * Reverses the block action, allowing a previously blocked user to send
     * messages again within the conversation.
     */
    #[OA\Delete(
        path: '/conversations/{conversationId}/unblock',
        summary: 'Unblock a user inside a conversation',
        security: [['sanctum' => []]],
        tags: ['Conversations'],
        parameters: [
            new OA\Parameter(name: 'conversationId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['blocked_user'],
                properties: [
                    new OA\Property(property: 'blocked_user', type: 'integer'),
                ],
            ),
        ),
        responses: [
            new OkResponse('User has been unblocked successfully'),
            new UnauthorizedResponse(),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function unblockUser(BlockUserRequest $request)
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return $this->errorResponse('User not authenticated', 401);
            }

            $this->conversationService->unblockUser($userId, $request->conversation_id, $request->blocked_user);

            return $this->successResponse('User has been unblocked successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
