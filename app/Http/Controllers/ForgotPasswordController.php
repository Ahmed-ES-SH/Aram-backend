<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validation->fails()) {
            return response()->json([$validation->errors()], 404);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email is not Found'
            ], 404);
        }

        // إنشاء رمز تحقق عشوائي
        $verificationCode = rand(100000, 999999);

        // حفظ الرمز في قاعدة البيانات
        $user->verification_code = $verificationCode;
        $user->save();

        // إرسال الرمز عبر البريد الإلكتروني
        Mail::to($user->email)->send(new VerificationCodePasswordMail($verificationCode));

        return response()->json([
            'message' => 'Verification code sent to your email.',
        ], 200);
    }


    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

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
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // تحديث كلمة المرور
        $user->password = Hash::make($request->password);
        $user->verification_code = null; // مسح رمز التحقق
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully.',
        ], 200);
    }
}
