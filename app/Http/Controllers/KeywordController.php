<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Traits\ApiResponse;
use App\Models\Keyword;
use Illuminate\Http\Request;

use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use OpenApi\Attributes as OA;

class KeywordController extends Controller
{

    use ApiResponse;


    #[OA\Get(
        path: '/keywords',
        summary: 'List all keywords, or search by query',
        tags: ['Keywords'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search in keyword title'),
        ],
        responses: [
            new ListOkResponse('Keyword'),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        try {
            $query = $request->get('query');

            // ✅ إذا تم إرسال query → بحث
            if (!empty($query)) {
                // Normalize the input query
                $normalizedQuery = TextNormalizer::normalizeArabic($query);

                // ✅ SQL normalization expressions for columns
                $normalizedTitle = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(title, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";

                $keywords = Keyword::whereRaw("$normalizedTitle LIKE ?", ['%' . $normalizedQuery . '%'])->get();

                return $this->successResponse($keywords, 200);
            }

            // ✅ إذا لم يتم إرسال query → رجع كل النتائج
            $keywords = Keyword::all();
            return $this->successResponse($keywords, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/add-keyword',
        summary: 'Create a new keyword (admin)',
        security: [['sanctum' => []]],
        tags: ['Keywords'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', maxLength: 255, example: 'Premium'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Keyword created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255|unique:keywords,title',
            ]);

            $keyword = Keyword::create($request->only('title'));

            return $this->successResponse($keyword, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    #[OA\Post(
        path: '/delete-keyword',
        summary: 'Delete a keyword (admin)',
        security: [['sanctum' => []]],
        tags: ['Keywords'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['keyword_id'],
                properties: [
                    new OA\Property(property: 'keyword_id', type: 'integer', example: 1),
                ],
            ),
        ),
        responses: [
            new OkResponse('The keyword deleted successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'keyword_id' => 'required|exists:keywords,id',
            ]);

            Keyword::findOrFail($request->keyword_id)->delete();

            return $this->successResponse(null, 200, 'The keyword deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
