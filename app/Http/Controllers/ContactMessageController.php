<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $Messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
            if ($Messages->isEmpty()) {
                return $this->successResponse([], 'No Messages found', 404);
            }
            return response()->json([
                'data' => $Messages->items(),
                'pagination' => [
                    'current_page' => $Messages->currentPage(),
                    'last_page' => $Messages->lastPage(),
                    'per_page' => $Messages->perPage(),
                    'total' => $Messages->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactMessageRequest $request)
    {
        try {
            $data = $request->validated();
            $message = new ContactMessage();
            $message->fill($data);
            $message->save();
            return $this->successResponse($message, "Message Send Successfully", 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            return $this->successResponse($message, 'Message Finded Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            if ($request->has('status')) {
                $message->status = $request->status;
                $message->save();
                return $this->successResponse($message, "Message Updated successfully", 200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->delete();
            return $this->successResponse($message, 'Message Deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }
}
