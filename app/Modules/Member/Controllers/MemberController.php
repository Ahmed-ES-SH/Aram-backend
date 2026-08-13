<?php

namespace App\Modules\Member\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Modules\Member\Models\Member;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class MemberController extends Controller
{
    use ApiResponse;

    #[OA\Get(
        path: '/members',
        summary: 'List subscribed members (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Newsletters'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search by email'),
        ],
        responses: [
            new PaginatedOkResponse('Member'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        try {
            $request->validate([
                'query' => 'nullable|string',
            ]);

            $members = Member::query();

            if ($request->filled('query')) {
                $search = $request->input('query');
                $members->where('email', 'LIKE', "%{$search}%");
            }

            $members = $members->paginate(20);

            if ($members->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($members, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }





    #[OA\Get(
        path: '/get-members-emails',
        summary: 'Get all subscribed member emails (admin)',
        security: [['sanctum' => []]],
        tags: ['Newsletters'],
        responses: [
            new OkResponse('List of emails'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getMembersEmails()
    {
        try {
            $membersEmails = Member::pluck('email')->toArray();

            return $this->successResponse($membersEmails, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * اشتراك في النشرة البريدية
     */
    #[OA\Post(
        path: '/subscribe',
        summary: 'Subscribe an email to the newsletter',
        tags: ['Newsletters'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Subscription successful'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:members,email',
        ]);

        Member::create(['email' => $request->email]);

        return response()->json(['message' => 'Subscription successful!'], 201);
    }




    #[OA\Delete(
        path: '/unsubscribe/{id}',
        summary: 'Delete a subscribed member (admin)',
        security: [['sanctum' => []]],
        tags: ['Newsletters'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Member Deleted Successfully'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function unsubscribe($id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();
            return $this->successResponse([],  200, 'Member Deleted Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
