<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFooterListLinkRequest;
use App\Http\Traits\ApiResponse;
use App\Models\FooterLink;
use App\Models\FooterList;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class FooterLinkController extends Controller
{
    use ApiResponse;

    #[OA\Post(
        path: '/add-link',
        summary: 'Create a new footer link (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        responses: [
            new CreatedResponse('Link created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreFooterListLinkRequest $request)
    {
        try {
            $data = $request->validated();
            $link = FooterLink::create($data);
            return $this->successResponse($link, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/all-lists',
        summary: 'Get all footer lists with their links',
        tags: ['Settings'],
        responses: [
            new ListOkResponse('FooterLink'),
            new ServerErrorResponse(),
        ],
    )]
    public function getLinksByList()
    {
        try {
            $lists = FooterList::with('links')->get();
            return $this->successResponse($lists, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/get-link/{id}',
        summary: 'Show a single footer link (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('FooterLink'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($linkId)
    {
        try {
            $link = FooterLink::findOrFail($linkId);
            return $this->successResponse($link, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/update-link/{id}',
        summary: 'Update a footer link (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('FooterLink'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(StoreFooterListLinkRequest $request, $linkId)
    {
        try {
            $data = $request->validated();
            $link = FooterLink::findOrFail($linkId);
            $link->update($data);
            return $this->successResponse($link, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Delete(
        path: '/delete-link/{id}',
        summary: 'Delete a footer link (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Link deleted'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($linkId)
    {
        try {
            $link = FooterLink::findOrFail($linkId);
            $link->delete();
            return $this->successResponse($link, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
