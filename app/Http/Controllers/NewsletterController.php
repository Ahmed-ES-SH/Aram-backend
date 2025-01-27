<?php

namespace App\Http\Controllers;

use App\Models\member;
use Illuminate\Http\Request;
use App\Mail\NewsletterEmail;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Mail;

class NewsletterController  extends Controller
{

    use ApiResponse;

    public function index()
    {
        try {
            $members = member::orderBy('created_at', 'desc')->paginate(15);

            if ($members->isEmpty()) {
                return response()->json([
                    'message' => 'No Members Available !'
                ], 404);
            }


            return response()->json([
                'data' => $members->items(),
                'pagination' => [
                    'current_page' => $members->currentPage(),
                    'last_page' => $members->lastPage(),
                    'per_page' => $members->perPage(),
                    'total' => $members->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }



    /**
     * اشتراك في النشرة البريدية
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:members,email',
        ]);

        member::create(['email' => $request->email]);

        return response()->json(['message' => 'Subscription successful!'], 201);
    }

    /**
     * إرسال النشرة البريدية
     */
    public function sendNewsletter(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $subscribers = member::all();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterEmail([
                'subject' => $request->subject,
                'content' => $request->content,
            ]));
        }

        return response()->json(['message' => 'Newsletter sent successfully!'], 200);
    }


    public function unsubscribe($id)
    {
        try {
            $member = member::findOrFail($id);
            $member->delete();
            return $this->successResponse([], 'Member Deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Error', ['message' => $e->getMessage()], 500);
        }
    }
}
