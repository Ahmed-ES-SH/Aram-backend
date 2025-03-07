<?php

namespace App\Http\Controllers;

use App\Models\organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class Authcontroller extends Controller
{



    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول باستخدام Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

// معالجة استجابة Google
public function handleGoogleCallback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // إنشاء كود مستخدم فريد
        do {
            $userCode = Str::random(10);
        } while (User::where('user_code', $userCode)->exists());

        // البحث عن المستخدم أو إنشائه إذا لم يكن موجودًا
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'social_id' => $googleUser->getId(),
                'social_type' => "google",
                'image' => $googleUser->getAvatar(),   
            ]
        );

        // تحديث بيانات المستخدم فقط إذا لم تكن لديه صورة مسبقًا
        if (!$user->image) {
            $user->update(['image' => $googleUser->getAvatar()]);
        }
      
      	if (!$user->wasRecentlyCreated) {
            $user->update(['user_code' => $user->user_code ?? $userCode]);
        }

        // إنشاء توكن الوصول
        $token = $user->createToken('auth_token')->plainTextToken;

        // التحقق مما إذا كان الطلب عبر JavaScript
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        // إعادة التوجيه إلى الواجهة الأمامية
        return redirect(config('app.frontend_url') . "/auth/callback?token=$token");

    } catch (\Exception $e) {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Google login failed',
                'error' => $e->getMessage(),
            ], 500);
        }

        // إعادة التوجيه مع رسالة خطأ
        return redirect(config('app.frontend_url') . "/auth/callback?error=" . urlencode($e->getMessage()));
    }
}



    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول باستخدام Google
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    // معالجة استجابة facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            do {
                $userCode = Str::random(10);
            } while (User::where('user_code', $userCode)->exists());
            // البحث عن المستخدم بناءً على البريد الإلكتروني أو إنشاؤه
            $user = User::firstOrCreate(
                ['email' => $facebookUser->getEmail()],
                [
                    'name' => $facebookUser->getName(),
                    'password' => Hash::make(Str::random(24)), // كلمة مرور عشوائية
                    'social_id' => $facebookUser->getId(), // حفظ facebook ID
                    'social_type' => "facebook",
                    'user_code' => $userCode
                ]
            );

            // إنشاء توكن وصول (API Token)
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'facebook login failed', 'error' => $e->getMessage()], 500);
        }
    }






    public function login(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validation = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 422);
            }

            // البحث في جدول المستخدمين
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                // إنشاء توكن للمستخدم
                $token = $user->createToken('auth_token', ['role:user'])->plainTextToken;

                return response()->json([
                    'message' => 'User login successful',
                    'user' => $user,
                    'token' => $token,
                    'type' => 'user',
                ], 200);
            }

            // البحث في جدول المنظمات
            $organization = organization::where('email', $request->email)->first();

            if ($organization && Hash::check($request->password, $organization->password)) {
                // إنشاء توكن للمنظمة
                $token = $organization->createToken('auth_token', ['role:organization'])->plainTextToken;

                return response()->json([
                    'message' => 'Organization login successful',
                    'organization' => $organization,
                    'token' => $token,
                    'type' => 'organization',
                ], 200);
            }

            // في حالة فشل تسجيل الدخول
            return response()->json(['message' => 'Invalid email or password'], 401);
        } catch (\Exception $e) {
            // في حالة وجود خطأ غير متوقع
            return response()->json(['message' => 'Login failed: ' . $e->getMessage()], 500);
        }
    }



    public function logout(Request $request)
    {
        try {
            // تحقق مما إذا كان المستخدم قد سجل الدخول بالفعل
            if (!$request->user()) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // إبطال التوكن الحالي
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (\Exception $e) {
            // إذا حدث خطأ ما، ارجع رسالة الخطأ مع كود الحالة 500
            return response()->json(['message' => 'Logout failed: ' . $e->getMessage()], 500);
        }
    }

    // دالة المستخدم الحالى
    public function currentUser(Request $request)
    {
        try {
            // استرجاع المستخدم الحالي باستخدام الحارس المناسب
            $user = $request->user();

            // تحقق مما إذا كان هناك مستخدم مسجل
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // التحقق من نوع المستخدم (هل هو مستخدم أو منظمة)
            if ($user instanceof \App\Models\User) {
                $userType = 'User';
            } elseif ($user instanceof \App\Models\Organization) {
                $userType = 'Organization';
            } else {
                $userType = 'Unknown';
            }

            return response()->json([
                'data' => $user,
                'user_type' => $userType
            ], 200);
        } catch (\Exception $e) {
            // إذا حدث خطأ ما، ارجع رسالة الخطأ مع كود الحالة 500
            return response()->json(['message' => 'Failed to retrieve user: ' . $e->getMessage()], 500);
        }
    }
}
