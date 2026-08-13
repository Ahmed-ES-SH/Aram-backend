<?php

namespace App\Modules\Organization\Controllers;
use App\Http\Controllers\Controller;

use App\Modules\Organization\Services\CreateOrganizationService;
use App\Modules\Organization\Services\DeleteOrganizationService;
use App\Modules\Organization\Services\FetchOrganizationsData;
use App\Modules\Organization\Services\UpdateOrganizationService;
use App\Modules\Organization\Requests\StoreOrganizationRequest;
use App\Modules\Organization\Requests\StoreOrganiztionWithOfferRequest;
use App\Modules\Organization\Requests\UpdateOrganizationRequest;
use App\Http\Traits\ApiResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\RefOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Modules\Organization\Models\Organization;
use Exception;
use OpenApi\Attributes as OA;

class OrganizationController extends Controller
{
    use ApiResponse;

    protected $createOrganizationService;
    protected $updateOrganizationService;
    protected $fetchOrganizationService;
    protected $deleteOrganizationService;

    public function __construct(
        CreateOrganizationService $createOrganizationService,
        UpdateOrganizationService $updateOrganizationService,
        FetchOrganizationsData $fetchOrganizationService,
        DeleteOrganizationService $deleteOrganizationService
    ) {
        $this->createOrganizationService = $createOrganizationService;
        $this->updateOrganizationService = $updateOrganizationService;
        $this->fetchOrganizationService = $fetchOrganizationService;
        $this->deleteOrganizationService = $deleteOrganizationService;
    }

    // ===============================
    // Case 1: Get total organizations count
    // ===============================
    #[OA\Get(
        path: '/organizations-count',
        summary: 'Get total organizations count',
        tags: ['Organizations'],
        responses: [
            new OkResponse('Total organizations count'),
            new ServerErrorResponse(),
        ],
    )]
    public function organizationsCount()
    {
        $count = Organization::count();
        return $this->successResponse($count, 200);
    }

    // ===============================
    // Case 2: Get all organization IDs
    // ===============================
    #[OA\Get(
        path: '/dashboard/organizations-ids',
        summary: 'Get all organization ids (admin)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        responses: [
            new OkResponse('List of organization ids'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getOrganizationsIds()
    {
        $users = Organization::pluck('id');
        return $this->successResponse($users, 200);
    }

    // ===============================
    // Case 3: Get public organization IDs
    // ===============================
    #[OA\Get(
        path: '/get-public-organizations-ids',
        summary: 'Get public organization ids',
        tags: ['Organizations'],
        responses: [
            new OkResponse('List of public organization ids'),
            new ServerErrorResponse(),
        ],
    )]
    public function getPublicOrganizationsIds()
    {
        return $this->fetchOrganizationService->getPublicOrganizationsIds();
    }

    // ===============================
    // Case 4: Get organization with selected fields
    // ===============================
    #[OA\Get(
        path: '/dashboard/organizations-with-selected-data',
        summary: 'List organizations with selected fields (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new PaginatedOkResponse('Organization'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function organizationWithSelectedData(Request $request)
    {
        return $this->fetchOrganizationService->organizationWithSelectedData($request);
    }

    // ===============================
    // Case 5: Get list of organizations
    // ===============================
    #[OA\Get(
        path: '/dashboard/organizations',
        summary: 'List all organizations (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new PaginatedOkResponse('Organization'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        return $this->fetchOrganizationService->index($request);
    }

    // ===============================
    // Case 6: Get active organizations
    // ===============================
    #[OA\Get(
        path: '/active-organizations',
        summary: 'List active organizations (paginated)',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'state', in: 'query', required: true, schema: new OA\Schema(type: 'boolean'), example: true),
        ],
        responses: [
            new PaginatedOkResponse('Organization'),
            new ServerErrorResponse(),
        ],
    )]
    public function activeOrganizations(Request $request)
    {
        return $this->fetchOrganizationService->activeOrganizations($request);
    }


    // ===============================
    // Case 7: Get published organizations with selected fields
    // ===============================
    #[OA\Get(
        path: '/public-organizations-with-selected-data',
        summary: 'List published organizations with selected fields (paginated)',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new PaginatedOkResponse('Organization'),
            new ServerErrorResponse(),
        ],
    )]
    public function publishedOrganizationswithSelectedData(Request $request)
    {
        return $this->fetchOrganizationService->publishedOrganizationswithSelectedData($request);
    }

    // ===============================
    // Case 8: Get top 10 public organizations
    // ===============================
    #[OA\Get(
        path: '/top-public-organizations',
        summary: 'Get the top 10 public organizations',
        tags: ['Organizations'],
        responses: [
            new ListOkResponse('Organization'),
            new ServerErrorResponse(),
        ],
    )]
    public function TopTenPublicOrganizations()
    {
        return $this->fetchOrganizationService->TopTenPublicOrganizations();
    }

    // ===============================
    // Case 9: Get published organizations
    // ===============================
    #[OA\Get(
        path: '/public-organizations',
        summary: 'List published organizations (paginated)',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new PaginatedOkResponse('Organization'),
            new ServerErrorResponse(),
        ],
    )]
    public function publishedOrganizations(Request $request)
    {
        return $this->fetchOrganizationService->publishedOrganizations($request);
    }

    // ===============================
    // Case 10: Store new organization
    // ===============================
    #[OA\Post(
        path: '/add-organization',
        summary: 'Create a new organization (protected)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/OrganizationStoreRequest'),
            ),
        ),
        responses: [
            new CreatedResponse('Organization created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreOrganizationRequest $request)
    {
        try {
            $organization = $this->createOrganizationService->store($request);
            return $this->successResponse($organization, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // ===============================
    // Case 11: Store organization with offer
    // ===============================
    #[OA\Post(
        path: '/register-org',
        summary: 'Register an organization together with its first offer',
        tags: ['Organizations'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/OrganizationStoreRequest'),
            ),
        ),
        responses: [
            new CreatedResponse('Organization and offer created'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function StoreOgranizationWithOffer(StoreOrganiztionWithOfferRequest $request)
    {
        try {
            $createData = $this->createOrganizationService->StoreOgranizationWithOffer($request);
            return $this->successResponse([
                "organization" => $createData['organization'],
                "offer" => $createData['offer']
            ], 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // ===============================
    // Case 12: Validate unique email
    // ===============================
    #[OA\Post(
        path: '/validate-org-email',
        summary: 'Validate that an email is available',
        tags: ['Organizations'],
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
            new OkResponse('Email is available'),
            new UnprocessableResponse('Email already taken'),
            new ServerErrorResponse(),
        ],
    )]
    public function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:organizations,email|unique:users,email'
        ]);

        return $this->successResponse([], 200);
    }

    // ===============================
    // Case 13: Get organization's working hours
    // ===============================
    #[OA\Get(
        path: '/organization-time-work/{id}',
        summary: 'Get an organization working hours',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Working hours'),
            new NotFoundResponse('Organization not found'),
            new ServerErrorResponse(),
        ],
    )]
    public function getOrgTimeWork($id)
    {
        return $this->fetchOrganizationService->getOrgTimeWork($id);
    }


    // ===============================
    // Case 14: Show single organization details
    // ===============================
    #[OA\Get(
        path: '/organizations/{id}',
        summary: 'Show a single organization with relations',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Organization'),
            new NotFoundResponse('Organization not found'),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        try {
            $organization = Organization::with(['subCategories', 'categories', 'keywords', 'benefits'])->findOrFail($id);
            $category = $organization->categories->first();
            $organization['category'] = $category;

            if (is_string($organization->location)) {
                $organization->location = json_decode($organization->location);
            }

            return $this->successResponse($organization, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // ===============================
    // Case 15: Update organization
    // ===============================
    #[OA\Post(
        path: '/update-organization/{id}',
        summary: 'Update an organization (protected)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/OrganizationStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('Organization'),
            new NotFoundResponse('Organization not found'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateOrganizationRequest $request, $id)
    {
        $organization = $this->updateOrganizationService->updateOrganization($request, $id);
        return $this->successResponse($organization, 200);
    }

    // ===============================
    // Case 16: Delete organization
    // ===============================
    #[OA\Delete(
        path: '/delete-organization/{id}',
        summary: 'Delete an organization (protected)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Organization deleted'),
            new NotFoundResponse('Organization not found'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        return $this->deleteOrganizationService->destroy($id);
    }


    // public function multiDestroy(Request $request)
    // {
    //     $request->validate([
    //         'ids' => 'required',
    //         'ids.*' => 'required|exists:organizations,id'
    //     ]);

    //     $ids = $request->input('ids');

    //     // إذا كانت ids نص JSON
    //     if (is_string($ids)) {
    //         $ids = json_decode($ids, true);
    //     }

    //     foreach ($ids as $id) {
    //         $this->deleteOrganizationService->destroy($id);
    //     }

    //     return response()->json([
    //         'message' => 'Organizations deleted successfully'
    //     ], 200);
    // }


    #[OA\Get(
        path: '/all-org-without-times',
        summary: 'Get ids of organizations without working hours',
        tags: ['Organizations'],
        responses: [
            new OkResponse('List of organization ids'),
            new ServerErrorResponse(),
        ],
    )]
    public function getAllOrgsWithoutTimes()
    {
        $orgs = Organization::where('open_at', null)->where('close_at', null)->pluck('id')->toArray();
        return $this->successResponse($orgs, 200);
    }

    // ===============================
    // Case 17: Check organization password
    // ===============================
    #[OA\Post(
        path: '/ckeck-organization-password/{id}',
        summary: 'Check an organization password (protected)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['password'],
                properties: [
                    new OA\Property(property: 'password', type: 'string', format: 'password'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Password is correct'),
            new UnauthorizedResponse('Password does not match'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function checkOrgPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        try {
            $org = Organization::findOrFail($id);

            if (Hash::check($request->password, $org->password)) {
                return $this->successResponse(['Message' => 'Password is Correct'], 'Done', 200);
            } else {
                return $this->errorResponse("Incorrect Password", 401);
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // ===============================
    // Case 18: Get organization locations
    // ===============================
    #[OA\Get(
        path: '/organizations-locations',
        summary: 'Get organization locations',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OkResponse('List of locations'),
            new ServerErrorResponse(),
        ],
    )]
    public function getLocations(Request $request)
    {
        return $this->fetchOrganizationService->getLocations($request);
    }

    // ===============================
    // Case 18: Get OrganizationsForSelectionTable
    // ===============================
    #[OA\Get(
        path: '/dashboard/organizations-table',
        summary: 'Get organizations for selection tables (admin)',
        security: [['sanctum' => []]],
        tags: ['Organizations'],
        responses: [
            new OkResponse('Organizations for selection'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    #[OA\Get(
        path: '/organizations-for-selection-table',
        summary: 'Get organizations for selection tables',
        tags: ['Organizations'],
        responses: [
            new OkResponse('Organizations for selection'),
            new ServerErrorResponse(),
        ],
    )]
    public function OrganizationsForSelectionTable()
    {
        return $this->fetchOrganizationService->OrganizationsForSelectionTable();
    }



    #[OA\Get(
        path: '/categories-for-org/{organization}',
        summary: 'Get the categories of an organization',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new ListOkResponse('Category'),
            new NotFoundResponse('Organization not found'),
            new ServerErrorResponse(),
        ],
    )]
    public function categoriesForOrg(Organization $organization)
    {
        $orgCats = $organization->select('id')->with('categories:id,title_en,title_ar,icon_name')->first();
        $data = $orgCats->categories;

        return $this->successResponse($data, 200);
    }
}
