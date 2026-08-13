<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/todos',
        summary: 'List the current user todos',
        security: [['sanctum' => []]],
        tags: ['Todos'],
        responses: [
            new OkResponse('Todos'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        $todos = Todo::where('user_id', $request->user()->id)
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $todos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/todos',
        summary: 'Create a new todo',
        security: [['sanctum' => []]],
        tags: ['Todos'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', maxLength: 255),
                    new OA\Property(property: 'description', type: 'string'),
                    new OA\Property(property: 'priority', type: 'string', enum: ['low', 'medium', 'high']),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Todo created successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $todo = Todo::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            // Default to medium if not provided
            'priority' => $request->priority ?? 'medium',
            'is_completed' => false,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Todo created successfully',
            'data' => $todo,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/todos/{id}',
        summary: 'Show a single todo',
        security: [['sanctum' => []]],
        tags: ['Todos'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Todo'),
            new NotFoundResponse('Todo not found'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show(Request $request, $id)
    {
        $todo = Todo::where('user_id', $request->user()->id)->find($id);

        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Todo not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $todo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: '/todos/{id}',
        summary: 'Update a todo',
        security: [['sanctum' => []]],
        tags: ['Todos'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string', maxLength: 255),
                    new OA\Property(property: 'description', type: 'string'),
                    new OA\Property(property: 'is_completed', type: 'boolean'),
                    new OA\Property(property: 'priority', type: 'string', enum: ['low', 'medium', 'high']),
                ],
            ),
        ),
        responses: [
            new OkResponse('Todo updated successfully'),
            new NotFoundResponse('Todo not found'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(Request $request, $id)
    {
        $todo = Todo::where('user_id', $request->user()->id)->find($id);

        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Todo not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $todo->update($request->only(['title', 'description', 'is_completed', 'priority']));

        return response()->json([
            'status' => true,
            'message' => 'Todo updated successfully',
            'data' => $todo,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/todos/{id}',
        summary: 'Delete a todo',
        security: [['sanctum' => []]],
        tags: ['Todos'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Todo deleted successfully'),
            new NotFoundResponse('Todo not found'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(Request $request, $id)
    {
        $todo = Todo::where('user_id', $request->user()->id)->find($id);

        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Todo not found',
            ], 404);
        }

        $todo->delete();

        return response()->json([
            'status' => true,
            'message' => 'Todo deleted successfully',
        ]);
    }
}
