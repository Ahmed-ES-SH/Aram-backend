<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriberRequest;
use App\Models\Subscriber;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(50);

            if ($subscribers->isEmpty()) {
                return response()->json([
                    'message' => 'No Subscribers Available !'
                ], 404);
            }

            return response()->json([
                'data' => $subscribers->items(),
                'pagination' => [
                    'current_page' => $subscribers->currentPage(),
                    'last_page' => $subscribers->lastPage(),
                    'per_page' => $subscribers->perPage(),
                    'total' => $subscribers->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriberRequest $request)
    {
        try {
            $data = $request->validated();
            $subscriber = new Subscriber();
            $subscriber->fill($data);
            $subscriber->save();
            return $this->successResponse($subscriber, "Subscriber Created Successfully", 201);
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
            $subscriber =  Subscriber::findOrFail($id);
            return $this->successResponse($subscriber, "Subscriber Founded Successfully", 201);
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
            $subscriber =  Subscriber::findOrFail($id);
            if ($request->has('is_active')) {
                $subscriber->is_active = $request->is_active;
            }
            $subscriber->save();
            return $this->successResponse($subscriber, "Subscriber Updated Successfully", 201);
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
            $subscriber =  Subscriber::findOrFail($id);
            $subscriber->delete();
            return $this->successResponse($subscriber, "Subscriber Deleted Successfully", 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }
}
