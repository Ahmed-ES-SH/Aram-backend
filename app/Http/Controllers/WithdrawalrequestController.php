<?php

namespace App\Http\Controllers;

use App\Models\balance;
use App\Models\FinancialTransactions;
use App\Models\organization;
use App\Models\User;
use App\Models\Withdrawalrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WithdrawalrequestController extends Controller
{
    /**
     * تقديم طلب سحب جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_type' => 'required|in:User,Organization,user,organization',
            'account_id' => 'required|integer',
            'paypal_email' => 'required|email',
            'amount' => 'required|numeric|min:10', // الحد الأدنى للسحب 10$
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // البحث عن الحساب والتأكد من الرصيد
        $account = $this->getAccount($request->account_type, $request->account_id);
        if (!$account) {
            return response()->json(['message' => 'الحساب غير موجود'], 404);
        }


        if ($request->amount > $account->available_balance) {
            return response()->json(['message' => 'الرصيد غير كافٍ'], 400);
        }



        // إنشاء طلب السحب
        $withdrawal = WithdrawalRequest::create([
            'account_type' => $request->account_type,
            'account_id' => $request->account_id,
            'paypal_email' => $request->paypal_email,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);


        FinancialTransactions::create([
            'bell_type' => 'withdraw_balance',
            'type_operation' => 'withdraw',
            'account_type' => $request->account_type,
            'amount' => $request->amount,
            'balance_type' => 'withdrawn_balance',
            'user_id' => $request->account_type == 'User' ?  $request->account_id : null,
            'organization_id' => $request->account_type == 'Organization' ?  $request->account_id : null,
            'status' => 'waiting'
        ]);

        $account->available_balance = $account->available_balance - $request->amount;
        $account->total_balance = $account->total_balance - $request->amount;
        $account->save();

        $data = ['withdrawal' => $withdrawal, 'account' => $account];

        return response()->json(['message' => 'تم إرسال طلب السحب بنجاح', 'data' => $data], 201);
    }

    /**
     * الموافقة على طلب السحب وتحديث حالة الطلب
     */
    public function approve($id, Request $request)
    {
        $withdrawal = WithdrawalRequest::find($id);
        if (!$withdrawal || $withdrawal->status !== 'pending') {
            return response()->json(['message' => 'الطلب غير موجود أو تمت معالجته مسبقًا'], 404);
        }

        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cloumn_name = $withdrawal->account_type == 'User' ? 'user_id' : 'organization_id';
        $financial_transactions = FinancialTransactions::where('account_type', $withdrawal->account_type)
            ->where($cloumn_name, $withdrawal->account_id)
            ->where('status', 'waiting')
            ->where('amount', $withdrawal->amount)
            ->first();



        if ($financial_transactions) {
            $financial_transactions->update([
                'status' => 'done',
            ]);
            $financial_transactions->save();
        } else {
            return response()->json(['message' => 'لم يتم العثور على المعاملة المالية'], 404);
        }

        // تحديث حالة الطلب
        $withdrawal->update([
            'status' => 'approved',
            'transaction_id' => $request->transaction_id,
        ]);

        return response()->json([
            'message' => 'تمت الموافقة على السحب بنجاح',
            'data' => [
                'withdrawal' => $withdrawal,
                'financial_transaction' => $financial_transactions,
            ]
        ]);
    }


    /**
     * رفض طلب السحب وتحديد سبب الرفض
     */
    public function reject($id, Request $request)
    {
        $withdrawal = WithdrawalRequest::find($id);
        if (!$withdrawal || $withdrawal->status !== 'pending') {
            return response()->json(['message' => 'الطلب غير موجود أو تمت معالجته مسبقًا'], 404);
        }

        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $accountbalance = $this->getAccount($withdrawal->account_type, $withdrawal->account_id);
        if (!$accountbalance) {
            return response()->json(['message' => 'الحساب غير موجود'], 404);
        }

        $accountbalance->available_balance +=    $withdrawal->amount;
        $accountbalance->total_balance +=   $withdrawal->amount;
        $accountbalance->save();


        $cloumn_name = $withdrawal->account_type == 'User' ? 'user_id' : 'organization_id';
        $financial_transactions = FinancialTransactions::where('account_type', $withdrawal->account_type)->where($cloumn_name, $withdrawal->account_id)->first();
        $financial_transactions->status = 'refused';
        $financial_transactions->save();
        // تحديث حالة الطلب بالرفض
        $withdrawal->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return response()->json(['message' => 'تم رفض الطلب', 'data' => $withdrawal]);
    }

    /**
     * جلب جميع طلبات السحب
     */
    public function index()
    {
        $withdrawals = WithdrawalRequest::orderBy('created_at', 'desc')->paginate(20);

        foreach ($withdrawals as $withdrawal) {
            $accountId = $withdrawal->account_id;
            $account_type = $withdrawal->account_type;

            // العثور على الحساب بناءً على نوع الحساب
            $account = $account_type == 'User' ? User::where('id', $accountId)->select('id', 'name', 'image')->first() : Organization::where('id', $accountId)->select('id', 'icon', 'title_en')->first();

            // إضافة البيانات الخاصة بالحساب إلى طلب السحب
            $withdrawal->user = $account;
        }

        return response()->json([
            'data' => $withdrawals->items(),
            'pagination' => [
                'current_page' => $withdrawals->currentPage(),
                'last_pages' => $withdrawals->lastPage(),
                'total' => $withdrawals->total(),
                'per_page' => $withdrawals->perPage(),
            ]
        ]);
    }


    /**
     * جلب تفاصيل طلب معين
     */
    public function show($id)
    {
        // العثور على طلب السحب بناءً على المعرف
        $withdrawal = WithdrawalRequest::find($id);

        if (!$withdrawal) {
            return response()->json(['message' => 'طلب السحب غير موجود'], 404);
        }

        // العثور على الحساب بناءً على نوع الحساب
        $accountId = $withdrawal->account_id;
        $account_type = $withdrawal->account_type;

        $account = $account_type == 'User'
            ? User::where('id', $accountId)->select('id', 'name', 'image')->first()
            : Organization::where('id', $accountId)->select('id', 'icon', 'title_en')->first();

        // إضافة البيانات الخاصة بالحساب إلى طلب السحب
        $withdrawal->user = $account;

        return response()->json([
            'data' => $withdrawal,
        ]);
    }

    /**
     * دالة مساعدة لجلب الحساب (سواء كان مستخدم أو منظمة)
     */
    private function getAccount($type, $id)
    {
        if ($type === 'User') {
            return balance::where('user_id', $id)->first();
        } elseif ($type === 'Organization') {
            return balance::where('organization_id',  $id)->first();
        }
        return null;
    }
}
