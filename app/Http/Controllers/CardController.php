<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\Card;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CardController extends Controller
{

    use ApiResponse;

    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }

    /**
     * Display a listing of the resource.
     */

    #[OA\Get(
        path: '/dashboard/cards',
        summary: 'List all cards (admin, paginated, filterable)',
        security: [['sanctum' => []]],
        tags: ['Cards'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search in title/description'),
            new OA\Parameter(name: 'category_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'active', in: 'query', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'min_price', in: 'query', required: false, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_price', in: 'query', required: false, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'duration', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'number_of_promotional_purchases', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new PaginatedOkResponse('Card'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        try {
            $query = $request->input('query');
            $categoryId = $request->input('category_id');
            $active = $request->input('active');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $duration = $request->input('duration');
            $numberOfPromotionalPurchases = $request->input('number_of_promotional_purchases');

            $cardsQuery = Card::query()
                // ✅ Get counts for related benefits & keywords
                ->withCount(['keywords', 'benefits'])
                // ✅ Get the keywords themselves
                ->with(['keywords:id,title', 'category']);

            // ✅ Normalize Arabic columns for search
            $normalizedTitleSql = TextNormalizer::sqlNormalizeColumn('title');
            $normalizedDescriptionSql = TextNormalizer::sqlNormalizeColumn('description');

            // ✅ Search filter (if query is provided)
            if ($query) {
                $normalizedQuery = TextNormalizer::normalizeArabic($query);
                $cardsQuery->where(function ($q) use ($normalizedQuery, $normalizedTitleSql, $normalizedDescriptionSql) {
                    $q->whereRaw("$normalizedTitleSql LIKE ?", ["%$normalizedQuery%"])
                        ->orWhereRaw("$normalizedDescriptionSql LIKE ?", ["%$normalizedQuery%"]);
                });
            }

            // ✅ Category filter (if category_id is provided)
            if ($categoryId) {
                $cardsQuery->where('category_id', $categoryId);
            }

            // ✅ Active filter
            if ($request->has('active')) {
                $cardsQuery->where('active', $active);
            }

            // ✅ Price range filter
            if ($minPrice) {
                $cardsQuery->where('price', '>=', $minPrice);
            }
            if ($maxPrice) {
                $cardsQuery->where('price', '<=', $maxPrice);
            }

            // ✅ Duration filter
            if ($duration) {
                $cardsQuery->where('duration', $duration);
            }

            // ✅ Number of promotional purchases filter
            if ($numberOfPromotionalPurchases) {
                $cardsQuery->where('number_of_promotional_purchases', $numberOfPromotionalPurchases);
            }

            // ✅ Get results with pagination (12 per page)
            $cards = $cardsQuery
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return $this->paginationResponse($cards, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    #[OA\Get(
        path: '/public-cards',
        summary: 'List active public cards (paginated, filterable)',
        tags: ['Cards'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search in title/description'),
            new OA\Parameter(name: 'category_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'limit', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 12),
        ],
        responses: [
            new PaginatedOkResponse('Card'),
            new ServerErrorResponse(),
        ],
    )]
    public function publicCards(Request $request)
    {
        try {
            $query      = $request->input('query');
            $categoryId = $request->input('category_id');

            // Base query: active cards only
            $cardsQuery = Card::where('active', 1)
                ->withCount(['keywords', 'benefits']) // ✅ Count services & benefits
                ->with(['keywords:id,title']); // ✅ Return only keyword ID & name

            // ✅ Filter by category if provided
            if (!empty($categoryId)) {
                $cardsQuery->where('category_id', $categoryId);
            }

            // ✅ If search query provided
            if (!empty($query)) {
                $normalizedQuery = TextNormalizer::normalizeArabic($query);

                $normalizedTitle       = TextNormalizer::sqlNormalizeColumn('title');
                $normalizedDescription = TextNormalizer::sqlNormalizeColumn('description');

                $cardsQuery->where(function ($q) use ($normalizedQuery, $normalizedTitle, $normalizedDescription) {
                    $q->whereRaw("$normalizedTitle LIKE ?", ["%$normalizedQuery%"])
                        ->orWhereRaw("$normalizedDescription LIKE ?", ["%$normalizedQuery%"]);
                });
            }

            // ✅ Pagination (default 12 per page, or custom limit if provided)
            $limit = $request->input('limit', 12);

            $cards = $cardsQuery
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);

            // ✅ Append keyword count to each card
            $cards->getCollection()->transform(function ($card) {
                $card->keywords_count = $card->keywords->count();
                return $card;
            });

            return $this->paginationResponse($cards, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Get(
        path: '/eight-public-cards',
        summary: 'Get the first 8 active public cards',
        tags: ['Cards'],
        responses: [
            new ListOkResponse('Card'),
            new ServerErrorResponse(),
        ],
    )]
    public function EightCards(Request $request)
    {
        try {


            // Base query: active cards only
            $cardsQuery = Card::where('active', 1)
                ->with(['keywords:id,title', 'benefits']); // keep relations


            // ✅ Limit to 8 cards max
            $cards = $cardsQuery
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();

            return $this->successResponse($cards, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }





    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/dashboard/add-card',
        summary: 'Create a new card (admin)',
        security: [['sanctum' => []]],
        tags: ['Cards'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CardStoreRequest'),
            ),
        ),
        responses: [
            new CreatedResponse('Card created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreCardRequest $request)
    {
        try {
            $data = $request->validated();

            // ✅ Create new card
            $card = new Card();
            $card->fill($data);

            // ✅ Handle image upload if exists
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $card, 'images/cards', 'image');
            }

            $card->save();

            // ✅ Store benefits if provided
            if ($request->has('benefits') && is_array($request->benefits)) {
                foreach ($request->benefits as $benefit) {
                    $card->benefits()->create([
                        'title' => $benefit['title'] ?? null,
                    ]);
                }
            }

            // ✅ Store keywords if provided
            if ($request->has('keywords') && is_array($request->keywords)) {
                $keywordIds = array_map(function ($keyword) {
                    return $keyword['keyword_id'] ?? null;
                }, $request->keywords);

                // Remove nulls
                $keywordIds = array_filter($keywordIds);

                if (!empty($keywordIds)) {
                    $card->keywords()->attach($keywordIds);
                }
            }

            return $this->successResponse($card->load(['benefits', 'keywords']), 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/get-card/{id}',
        summary: 'Show a single card with its relations',
        tags: ['Cards'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Card'),
            new NotFoundResponse('Card not found'),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        try {
            // Get card with relations
            $card = Card::with(['benefits', 'keywords', 'category'])->withCount('benefits')->findOrFail($id);

            return $this->successResponse($card, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Card not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/dashboard/update-card/{id}',
        summary: 'Update an existing card (admin)',
        security: [['sanctum' => []]],
        tags: ['Cards'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CardStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('Card'),
            new NotFoundResponse('Card not found'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateCardRequest $request, $id)
    {
        try {
            $data = $request->validated();

            // Find card
            $card = Card::findOrFail($id);

            // Update card basic fields
            $card->fill($data);

            // Update image if provided
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $card, 'images/cards', 'image');
            }

            $card->save();

            // Update benefits if provided
            if ($request->has('benefits')) {
                // Delete old benefits
                $card->benefits()->delete();

                // Insert new benefits
                foreach ($request->benefits as $benefit) {
                    $card->benefits()->create([
                        'title' => $benefit['title'],
                    ]);
                }
            }

            // Update keywords if provided
            if ($request->has('keywords')) {
                // Extract IDs
                $keywordIds = collect($request->keywords)->pluck('id')->toArray();
                $card->keywords()->sync($keywordIds);
            }

            return $this->successResponse($card->load(['benefits', 'keywords']), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Card not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/dashboard/delete-card/{id}',
        summary: 'Delete a card (admin)',
        security: [['sanctum' => []]],
        tags: ['Cards'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Card deleted successfully'),
            new NotFoundResponse('Card not found'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {


            $card = Card::findOrFail($id);

            if ($card->image) {
                $this->imageservice->deleteOldImage($card, 'images/cards');
            }

            // Delete related benefits
            $card->benefits()->delete();

            // Detach related keywords
            $card->keywords()->detach();

            // Delete the main card
            $card->delete();

            return $this->successResponse(null, 200, 'Card deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
