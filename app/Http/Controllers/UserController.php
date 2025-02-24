<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Mail\VerificationCodeMail;
use App\Mail\VerifyEmail;
use App\Models\organization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\ApiResponse;
use App\Models\User;
use App\Services\ImageService;

class UserController extends Controller
{
    use ApiResponse;

    protected $imageservice;


    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }





    public function verifyEmail($type, $id, Request $request)
    {
        // البحث عن المستخدم أو المنظمة بناءً على النوع
        $user = $type == 'User'
            ? User::find($id)
            : Organization::find($id);

        if (!$user) {
            return response()->json(['message' => 'الحساب غير موجود.'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'تم تفعيل الحساب مسبقًا.'], 400);
        }

        if ($user->email_verification_token !== $request->token) {
            return response()->json(['message' => 'رمز التحقق غير صالح.'], 400);
        }

        // تحديث حالة الحساب وتفعيل البريد
        $user->email_verified_at = now();
        $user->email_verification_token = null; // إزالة التوكن بعد الاستخدام
        $user->save();

        // إعادة التوجيه إلى الموقع بعد التفعيل
        return redirect('https://aram-gulf.com')->with('success', 'تم تفعيل حسابك بنجاح!');
    }



    public function resendVerificationEmail($type, Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);



        $user = $type == 'User' ? User::where('email', $request->email)->first() : organization::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User Not Found .'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'تم تفعيل الحساب مسبقًا.'], 400);
        } else {
            // إنشاء رمز تحقق جديد
            $user->email_verification_token = sha1(time());
            $user->save();
            // إرسال البريد الإلكتروني من جديد
            Mail::to($user->email)->send(new VerifyEmail($user));
            return response()->json(['message' => 'تم إرسال رابط التفعيل إلى بريدك الإلكتروني.']);
        }
    }




    public function usersCount()
    {
        try {
            // افتراض أن هناك نموذج اسمه User
            $count = User::count();

            // إرجاع استجابة ناجحة مع العدد
            return $this->successResponse($count, "Users count retrieved successfully", 200);
        } catch (\Exception $e) {
            // في حال حدوث خطأ، يتم إرجاع استجابة خطأ
            return $this->errorResponse("Failed to retrieve users count", ['message' => $e->getMessage()], 500);
        }
    }

    public function getUsersIds()
    {
        try {
            $users = User::pluck('id');
            return $this->successResponse($users, "Users IDs retrieved successfully", 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to retrieve users IDs", ['message' => $e->getMessage()], 500);
        }
    }



    public function index()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->paginate(15);
            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No Users Available !'
                ], 404);
            }
            return response()->json([
                'data' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    public function getUserCoupons($userId)
    {
        try {
            $user = User::find($userId);

            // التحقق من وجود المستخدم
            if (!$user) {
                return $this->errorResponse('User not found', ['message' => 'No user found with the given ID'], 404);
            }
            $userCoupons = $user->coupons()
                ->with([
                    'organization' => function ($query) {
                        $query->select('id', 'image', 'icon', 'title_en', 'title_ar');
                    },
                    'category' => function ($query) {
                        $query->select('id', 'image', 'title_en', 'title_ar');
                    }
                ])
                ->paginate(12);

            // إضافة معلومات الـ pagination إلى الاستجابة
            $paginationDetails = [
                'total' => $userCoupons->total(),         // العدد الإجمالي للعناصر
                'current_page' => $userCoupons->currentPage(),  // الصفحة الحالية
                'per_page' => $userCoupons->perPage(),     // عدد العناصر في كل صفحة
                'last_page' => $userCoupons->lastPage(),   // الصفحة الأخيرة
                'from' => $userCoupons->firstItem(),       // العنصر الأول في الصفحة الحالية
                'to' => $userCoupons->lastItem(),          // العنصر الأخير في الصفحة الحالية
            ];
            return response()->json([
                'data' => $userCoupons->items(),
                'pagination' => $paginationDetails
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Error", ['message' => $e->getMessage()], 500);
        }
    }

    public function usersByNumberOfReservations()
    {
        try {
            $users = User::orderBy('number_of_reservations', 'desc')->paginate(15);
            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No Users Available !'
                ], 404);
            }
            return response()->json([
                'data' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild error', ['message' => $e->getMessage()], 500);
        }
    }

    // إنشاء مستخدم جديد
    public function store(StoreUserRequest $request)
    {
        try {

            $user = new User();
            $user->fill($request->only(['name', 'email', 'phone_number', 'role', 'user_gender', 'user_birthdate']));
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $user, 'images/users');
            }
            do {
                $userCode = Str::random(10);
            } while (User::where('user_code', $userCode)->exists());

            $user->user_code = $userCode;
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User created successfully.',
                'data' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse('User Not Created', ['message' => $e->getMessage()], 500);
        }
    }

    // عرض تفاصيل مستخدم محدد
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->location = is_string($user->location) ? json_decode($user->location) : $user->location;
            return $this->successResponse($user, "User Founded Successfully", 200);
        } catch (\Exception $e) {
            return $this->errorResponse('User Not Founded', ['message' => $e->getMessage()], 404);
        }
    }

    // تحديث بيانات مستخدم
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        try {
            $user->fill($data);
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->has('image')) {
                $this->imageservice->ImageUploader($request, $user, 'images/users');
            }

            $user->save();
            return $this->successResponse($user, 'User Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Faild Update', ['message' => $e->getMessage()], 500);
        }
    }

    // حذف مستخدم
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $old_image = $user->image;
            $storagePath = "images/users";
            if ($old_image) {
                $old_image_name = basename(parse_url($old_image, PHP_URL_PATH));
                $file_path = public_path($storagePath . '/' . $old_image_name);
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }
            }
            $user->delete();

            return $this->successResponse([], "User Deleted Successfully", 204);
        } catch (\Exception $e) {
            return $this->errorResponse("Faild Delete", ['message' => $e->getMessage()], 500);
        }
    }



    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        try {
            // البحث عن المستخدم حسب البريد الإلكتروني
            $user = User::where('email', $request->email)->firstOrFail();

            // إنشاء كود تحقق عشوائي
            $verificationCode = Str::random(6);

            // إرسال البريد الإلكتروني
            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

            return response()->json([
                'message' => 'Verification code sent successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send verification code.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        try {
            $user = User::findOrFail($id);

            if (Hash::check($request->password, $user->password)) {
                return $this->successResponse(['Message' => 'Password is Correct'], 'Done', 200);
            } else {
                return $this->errorResponse("Incorrect Password", ['message' => 'Password does not match'], 401);
            }
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to Check Password", ['message' => $e->getMessage()], 500);
        }
    }

    public function SearchByNameForUser($name)
    {
        try {
            $users = User::where('name', 'like', '%' . $name . '%') // تحسين البحث ليشمل الجزئي
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No Users Found With this Name.',
                ], 404); // يمكن إضافة كود الحالة HTTP 404
            }

            return response()->json([
                'data' => $users->items(), // `items` لجلب البيانات فقط
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse("Failed Error", [
                'message' => $e->getMessage(),
            ], 500); // إرسال رسالة الخطأ مع كود الحالة 500
        }
    }
}
