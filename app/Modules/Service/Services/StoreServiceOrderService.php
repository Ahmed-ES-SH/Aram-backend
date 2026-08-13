<?php

namespace App\Modules\Service\Services;

use App\Modules\Service\Requests\StoreServiceOrderRequest;
use App\Http\Services\NotificationService;
use App\Models\Invoice;
use App\Modules\Promotion\Models\PromoterRatio;
use App\Modules\Promotion\Models\PromotionActivity;
use App\Modules\Service\Models\ServiceOrder;
use App\Modules\Service\Models\ServiceTracking;
use App\Modules\Service\Models\ServiceTrackingFile;
use App\Modules\User\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoreServiceOrderService
{
    protected $notificationService;
    private const UPLOAD_PATH = 'uploads/service-tracking';

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function store($data)
    {
        $order = null;

        $activityId = $data['activity_id'] ?? null;
        $activity = $activityId
            ? PromotionActivity::where('id', $activityId)->firstOrFail()
            : null;

        $ratios = PromoterRatio::find(1);

        $files = $data['files'];


        $decodedMetadata = is_string($data['metadata']) ? json_decode($data['metadata'], true) : $data['metadata'];

        DB::transaction(function () use ($activity, &$order, $files,  $data, $ratios, $decodedMetadata) {



            $order = ServiceOrder::create([
                'service_page_id' => $data['service_id'],
                'user_id' => $data['user_id'],
                'user_type' => $data['account_type'],
                'metadata' => $data['metadata']['metadata'],
                'status' => 'pending',
                'payment_status' => 'pending',
                'invoice_id' => null,
                'is_deal' => 1,
            ]);

            // Create service tracking
            $serviceTracking = ServiceTracking::create([
                'service_id' => $data['service_id'],
                'user_id' => $data['user_id'],
                'user_type' => $data['account_type'],
                'service_order_id' => $order->id,
                'invoice_id' => null,
                'status' => ServiceTracking::STATUS_PENDING,
                'current_phase' => ServiceTracking::PHASE_INITIATION,
                'metadata' => ['initial_setup' => true],
            ]);

            $storagePath = public_path(self::UPLOAD_PATH);

            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            foreach ($files as $file) {

                $filename = $this->generateUniqueFilename($file);
                $fullPath = 'uploads/service-tracking/' . $filename;

                $file->move($storagePath, $filename);
                $mimeType = mime_content_type($fullPath);
                $isImage = Str::startsWith($mimeType, 'image/');

                ServiceTrackingFile::create([
                    'service_tracking_id' => $serviceTracking->id,
                    'file_type' => $isImage ? 'design_file' : 'attachment',
                    'path' => env('BACK_END_URL') . '/' . $fullPath,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $mimeType,
                    'size' => filesize($fullPath),
                    'uploaded_by' => $data['user_id'],
                    'uploaded_by_type' => $data['account_type'],
                ]);
            }

            $order->update([
                'payment_status' => 'pending',
            ]);

            // Update activity
            if ($activity) {
                $ip = $decodedMetadata['ip_address'] ?? ($data['ip'] ? $data['ip'] : null);
                $device = $decodedMetadata['device_type'] ?? ($data['device'] ? $data['device'] : null);

                $activity->update([
                    'is_active' => false,
                    'commission_amount' => $ratios->purchase_ratio,
                    'country' => $decodedMetadata['country'] ?? null,
                    'ip_address' => $ip ?? null,
                    'device_type' => $device ?? null,
                    'activity_at' => now(),
                ]);
            }

            // Prepare notification data for afterCommit
            $adminsIds = User::where('role', 'admin')->pluck('id')->toArray();
            $superAdminIds = User::where('role', 'super_admin')->pluck('id')->toArray();
            $allAdminIds = array_merge($adminsIds, $superAdminIds);
            $sender = User::where('id', 1)->whereIn('role', ['admin', 'super_admin'])->first();

            $notificationData = [
                'user_ids' => $allAdminIds,
                'sender_type' => 'user',
                'content' => "تم ارسال طلب خدمة جديدة حيث تم طلب الخدمه : " . $decodedMetadata['slug'],
            ];

            $this->notificationService->sendMultipleNotifications($notificationData, $sender);
        });

        return $order;
    }



    public function createInvoice($data)
    {
        $invoice = null;
        $order = ServiceOrder::where('user_id', $data['user_id'])
            ->where('user_type', $data['user_type'])
            ->where('invoice_id', null)
            ->firstOrFail();


        if (!$order) {
            throw new \Exception('Order not found');
        }


        if ($order->invoice_id) {
            throw new \Exception('Order already has an invoice');
        }



        DB::transaction(function () use ($data, &$invoice,  &$order) {

            $invoice =   Invoice::create([
                'invoice_number' => uniqid('invoice_'),
                'total_invoice' => $data['total_invoice'],
                'invoice_type' => $data['invoice_type'],
                'before_discount' => $data['before_discount'] ?? null,
                'discount' => $data['discount'] ?? null,
                'ref_code' => $data['ref_code'] ?? null,
                'tax_amount' => $data['tax_value'] ?? null,
                'owner_id' => $data['user_id'],
                'owner_type' => $data['user_type'],
                'status' => 'pending',
                'currency' => "OMR",
                'payment_method' => "thawani",
            ]);


            $order->update([
                'invoice_id' => $invoice->id,
                'price_after_deal' => $data['total_invoice'],
                'deal_status' => "pending",
            ]);
        });

        return $invoice;
    }


    private function generateUniqueFilename(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        return $originalName . '_' . uniqid() . '.' . $extension;
    }
}
