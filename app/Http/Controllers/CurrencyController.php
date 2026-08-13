<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Traits\ApiResponse;
use App\Models\Currency;
use Illuminate\Http\Request;

use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use OpenApi\Attributes as OA;

class CurrencyController extends Controller
{

    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/currencies',
        summary: 'List all currencies',
        tags: ['Currencies'],
        responses: [
            new ListOkResponse('Currency'),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $currencies = Currency::all();
            return $this->successResponse($currencies, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/dashboard/add-currency',
        summary: 'Create a new currency (admin)',
        security: [['sanctum' => []]],
        tags: ['Currencies'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CurrencyStoreRequest'),
        ),
        responses: [
            new CreatedResponse('Currency created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreCurrencyRequest $request)
    {
        try {
            $data = $request->validated();
            $currency = Currency::create($data);
            return $this->successResponse($currency, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/dashboard/currencies/{currencyId}',
        summary: 'Show a single currency (admin)',
        security: [['sanctum' => []]],
        tags: ['Currencies'],
        parameters: [
            new OA\Parameter(name: 'currencyId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Currency'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($currencyId)
    {
        try {
            $currency = Currency::findOrFail($currencyId);
            return $this->successResponse($currency, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/dashboard/update-currency/{currencyId}',
        summary: 'Update an existing currency (admin)',
        security: [['sanctum' => []]],
        tags: ['Currencies'],
        parameters: [
            new OA\Parameter(name: 'currencyId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CurrencyStoreRequest'),
        ),
        responses: [
            new EntityOkResponse('Currency'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateCurrencyRequest $request,  $currencyId)
    {
        try {
            $data = $request->validated();
            $currency = Currency::findOrFail($currencyId);
            $currency->update($data);
            return $this->successResponse($currency, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/dashboard/currencies/{currencyId}',
        summary: 'Delete a currency (admin)',
        security: [['sanctum' => []]],
        tags: ['Currencies'],
        parameters: [
            new OA\Parameter(name: 'currencyId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Currency deleted'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($currencyId)
    {
        try {
            $currency = Currency::findOrFail($currencyId);
            $currency->delete();
            return $this->successResponse($currency, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
