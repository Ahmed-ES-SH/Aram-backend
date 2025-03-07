<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodePasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    // إرسال رمز التحقق
public function sendVerificationCode(Request $request)
{
    $validation = Validator::make($request->all(), [
        'email' => 'required|email'
    ]);

    if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors()], 404);
    }

    // Check if the email exists in the User model
    $user = User::where('email', $request->email)->first();

    // If not found, check in the Organization model
    if (!$user) {
        $user = organization::where('email', $request->email)->first();
    }

    // If still not found, return an error response
    if (!$user) {
        return response()->json([
            'message' => 'Email not found'
        ], 404);
    }

    // Generate a random verification code
    $verificationCode = rand(100000, 999999);

    // Save the verification code in the database
    $user->verification_code = $verificationCode;
    $user->save();

    // Send the verification code via email
    Mail::to($user->email)->send(new VerificationCodePasswordMail($verificationCode));

    return response()->json([
        'message' => 'Verification code sent to your email.',
    ], 200);
}



    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
        ]);

    

    // Check if the email exists in the User model
    $user = User::where('email', $request->email)->first();

    // If not found, check in the Organization model
    if (!$user) {
        $user = organization::where('email', $request->email)->first();
    }

    // If still not found, return an error response
    if (!$user) {
        return response()->json([
            'message' => 'Email not found'
        ], 404);
    }

        if ($user->verification_code == $request->code) {
            return response()->json([
                'message' => 'Code verified successfully.',
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid verification code.',
        ], 400);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


    // Check if the email exists in the User model
    $user = User::where('email', $request->email)->first();

    // If not found, check in the Organization model
    if (!$user) {
        $user = organization::where('email', $request->email)->first();
    }

    // If still not found, return an error response
    if (!$user) {
        return response()->json([
            'message' => 'Email not found'
        ], 404);
    }

        // تحديث كلمة المرور
        $user->password = Hash::make($request->password);
        $user->verification_code = null; // مسح رمز التحقق
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully.',
        ], 200);
    }
}
