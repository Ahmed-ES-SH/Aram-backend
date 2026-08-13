<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionAnswerRequest;
use App\Http\Traits\ApiResponse;
use App\Models\QuestionAnswer;


use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class QuestionAnswerController extends Controller
{

    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/all-faqs',
        summary: 'List all questions and answers (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        responses: [
            new PaginatedOkResponse('QuestionAnswer'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $Q_As = QuestionAnswer::orderBy('created_at', 'desc')->paginate(12);
            return  $this->paginationResponse($Q_As, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() // تصحيح اسم المفتاح
            ], 500); // إضافة كود الحالة 500
        }
    }


    #[OA\Get(
        path: '/approvedQuestions',
        summary: 'List approved (visible) questions and answers (paginated)',
        tags: ['Contact & FAQ'],
        responses: [
            new PaginatedOkResponse('QuestionAnswer'),
            new ServerErrorResponse(),
        ],
    )]
    public function approvedQuestions()
    {
        try {
            $approvedQuestions = QuestionAnswer::where('is_visible', true)
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return  $this->paginationResponse($approvedQuestions, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }




    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/add-faq',
        summary: 'Create a question and answer (admin)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        responses: [
            new CreatedResponse('Question answer created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreQuestionAnswerRequest $request)
    {
        try {
            $data = $request->validated();
            $Q_A = QuestionAnswer::create($data);
            return  $this->successResponse($Q_A, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/get-faq/{id}',
        summary: 'Show a single question and answer (admin)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('QuestionAnswer'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        try {
            $Q_A = QuestionAnswer::findOrFail($id);
            return $this->successResponse($Q_A, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/update-faq/{id}',
        summary: 'Update a question and answer (admin)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('QuestionAnswer'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(StoreQuestionAnswerRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $Q_A = QuestionAnswer::findOrFail($id);
            $Q_A->update($data);
            return $this->successResponse($Q_A, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500); // إضافة كود الحالة 500 للأخطاء العامة
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/delete-faq/{id}',
        summary: 'Delete a question and answer (admin)',
        security: [['sanctum' => []]],
        tags: ['Contact & FAQ'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Question and answer deleted successfully'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            // البحث عن السجل باستخدام المعرف
            $Q_A = QuestionAnswer::findOrFail($id);
            $Q_A->delete(); // حذف السجل
            return $this->successResponse([], 200, 'Question and answer deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
