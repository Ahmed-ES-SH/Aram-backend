<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    use ApiResponse;


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::find($request->user_id);
            $comment = new Comment();
            $comment->fill($data);
            $comment->save();
            return $this->successResponse(['comment' =>  $comment, 'user' => $user], 'Comment Added Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            return $this->successResponse($comment, 'Comment Finded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCommentRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $comment = Comment::findOrFail($id);
            $comment->fill($data);
            $comment->save();
            return $this->successResponse($comment, 'Comment Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            return $this->successResponse($comment, 'Comment deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }
}
