<?php

namespace Database\Seeders;

use App\Models\ProvisionalData;
use App\Modules\Organization\Models\Organization;
use App\Modules\Service\Models\ServiceForm;
use App\Modules\Service\Models\ServiceFormField;
use App\Modules\Service\Models\ServiceFormSubmission;
use App\Modules\Service\Models\ServiceFormSubmissionValue;
use App\Modules\Service\Models\ServiceOrder;
use App\Modules\Service\Models\ServicePage;
use App\Modules\Service\Models\ServiceTracking;
use App\Modules\User\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('service_forms')->truncate();
        DB::table('service_form_fields')->truncate();
        DB::table('service_form_submissions')->truncate();
        DB::table('service_form_submission_values')->truncate();
        DB::table('service_orders')->truncate();
        DB::table('provisional_data')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $faker = Faker::create();

        $servicePages = ServicePage::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();
        $organizationIds = Organization::pluck('id')->toArray();
        $trackingIds = ServiceTracking::pluck('id')->toArray();
        $invoiceIds = DB::table('invoices')->pluck('id')->toArray();

        if (empty($servicePages) || empty($userIds)) {
            $this->command->warn('Missing service pages or users, skipping service flow seeding.');
            return;
        }

        // ========== 1. SERVICE FORMS (1-2 per service page) ==========
        $formIds = [];
        $fieldPool = []; // form_id => [field definitions]

        foreach ($servicePages as $pageIndex => $pageId) {
            $formCount = ($pageIndex % 2 === 0) ? 2 : 1;

            for ($f = 0; $f < $formCount; $f++) {
                $isActive = $f === 0;

                $form = ServiceForm::create([
                    'service_page_id' => $pageId,
                    'name_ar' => 'نموذج ' . ($f + 1) . ' لخدمة رقم ' . $pageId,
                    'name_en' => 'Service Form ' . ($f + 1) . ' for Page ' . $pageId,
                    'description_ar' => 'يرجى تعبئة الحقول أدناه لإتمام طلبك.',
                    'description_en' => 'Please fill out the fields below to complete your request.',
                    'version' => $f + 1,
                    'is_active' => $isActive,
                    'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => now(),
                ]);
                $formIds[] = $form->id;

                $fields = $this->buildFieldsForPage($pageId, $f);
                $fieldPool[$form->id] = $fields;

                foreach ($fields as $order => $field) {
                    ServiceFormField::create(array_merge($field, [
                        'service_form_id' => $form->id,
                        'order' => $order,
                        'created_at' => $form->created_at,
                        'updated_at' => now(),
                    ]));
                }
            }
        }

        $this->command->info('Service forms and fields seeded.');

        // ========== 2. SERVICE FORM SUBMISSIONS (~40) ==========
        $submissionIds = [];
        $statuses = ['pending', 'reviewed', 'approved', 'rejected'];

        for ($i = 0; $i < 40; $i++) {
            $formId = $faker->randomElement($formIds);
            $isUser = $faker->boolean(75);
            $trackingId = (!empty($trackingIds) && $faker->boolean(40))
                ? $faker->randomElement($trackingIds)
                : null;

            $submission = ServiceFormSubmission::create([
                'service_form_id' => $formId,
                'user_id' => $isUser ? $faker->randomElement($userIds) : $faker->randomElement($organizationIds),
                'user_type' => $isUser ? 'user' : 'organization',
                'status' => $statuses[array_rand($statuses)],
                'service_tracking_id' => $trackingId,
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now(),
            ]);
            $submissionIds[] = $submission->id;
        }

        $this->command->info('Service form submissions seeded.');

        // ========== 3. SERVICE FORM SUBMISSION VALUES ==========
        $allFields = DB::table('service_form_fields')->get();
        $allFieldsByForm = $allFields->groupBy('service_form_id');

        foreach ($submissionIds as $submissionId) {
            $formId = ServiceFormSubmission::find($submissionId)->service_form_id;
            $fields = $allFieldsByForm->get($formId, collect());

            foreach ($fields as $field) {
                ServiceFormSubmissionValue::create([
                    'submission_id' => $submissionId,
                    'field_id' => $field->id,
                    'value' => $this->fakeValueForField($field, $faker),
                    'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Service form submission values seeded.');

        // ========== 4. SERVICE ORDERS (~40) ==========
        $serviceOrderStatuses = ['pending', 'confirmed', 'in_progress', 'on_hold', 'completed', 'canceled', 'refunded'];
        $paymentStatuses = ['pending', 'paid', 'failed'];
        $ordersCount = 40;
        $createdOrderIds = [];

        for ($i = 0; $i < $ordersCount; $i++) {
            $isUser = $faker->boolean(75);
            $status = $serviceOrderStatuses[array_rand($serviceOrderStatuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            $isDeal = $faker->boolean(30);
            $invoiceId = ($paymentStatus === 'paid' && !empty($invoiceIds) && $faker->boolean(70))
                ? $faker->randomElement($invoiceIds)
                : null;

            $order = ServiceOrder::create([
                'user_id' => $isUser ? $faker->randomElement($userIds) : $faker->randomElement($organizationIds),
                'user_type' => $isUser ? 'user' : 'organization',
                'status' => $status,
                'deal_status' => $isDeal ? $faker->randomElement(['pending', 'approved', 'rejected']) : null,
                'price_after_deal' => $isDeal ? $faker->randomFloat(2, 50, 3000) : null,
                'subscription_status' => $faker->optional(0.5)->randomElement(['active', 'expired']),
                'payment_status' => $paymentStatus,
                'invoice_id' => $invoiceId,
                'service_page_id' => $faker->randomElement($servicePages),
                'metadata' => [
                    'notes' => $faker->optional(0.5)->sentence,
                    'priority' => $faker->optional(0.5)->randomElement(['low', 'medium', 'high']),
                ],
                'is_deal' => $isDeal,
                'subscription_start_time' => $faker->optional(0.4)->dateTimeBetween('-6 months', 'now'),
                'subscription_end_time' => $faker->optional(0.3)->dateTimeBetween('now', '+6 months'),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
            $createdOrderIds[] = $order->id;
        }

        $this->command->info('Service orders seeded.');

        // ========== 5. PROVISIONAL DATA ==========
        foreach (array_slice($createdOrderIds, 0, min(15, count($createdOrderIds))) as $orderId) {
            ProvisionalData::create([
                'uniqueId' => (string) Str::uuid(),
                'payment_id' => 'PAY-' . strtoupper(Str::random(10)),
                'ref_code' => $faker->optional(0.6)->bothify('RF-####-????'),
                'metadata' => json_encode([
                    'channel' => 'thawani',
                    'service_order_id' => $orderId,
                ]),
                'expire_at' => now()->addHours($faker->numberBetween(1, 24))->toDateTimeString(),
                'service_order_id' => $orderId,
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Provisional data seeded.');
    }

    protected function buildFieldsForPage(int $pageId, int $formIndex): array
    {
        $common = [
            [
                'field_key' => 'full_name',
                'field_type' => 'short_text',
                'label_ar' => 'الاسم الكامل',
                'label_en' => 'Full Name',
                'placeholder_ar' => 'أدخل اسمك الكامل',
                'placeholder_en' => 'Enter your full name',
                'is_required' => true,
                'validation_rules' => ['min_length' => 3, 'max_length' => 100],
            ],
            [
                'field_key' => 'email',
                'field_type' => 'email',
                'label_ar' => 'البريد الإلكتروني',
                'label_en' => 'Email Address',
                'placeholder_ar' => 'name@example.com',
                'placeholder_en' => 'name@example.com',
                'is_required' => true,
                'validation_rules' => [],
            ],
            [
                'field_key' => 'phone',
                'field_type' => 'phone',
                'label_ar' => 'رقم الهاتف',
                'label_en' => 'Phone Number',
                'placeholder_ar' => '+968 9X XXX XXXX',
                'placeholder_en' => '+968 9X XXX XXXX',
                'is_required' => true,
                'validation_rules' => ['pattern' => '^[+0-9\\s-]{8,20}$'],
            ],
            [
                'field_key' => 'service_description',
                'field_type' => 'long_text',
                'label_ar' => 'وصف الخدمة المطلوبة',
                'label_en' => 'Service Description',
                'placeholder_ar' => 'صف الخدمة التي تحتاجها بالتفصيل',
                'placeholder_en' => 'Describe the service you need in detail',
                'is_required' => false,
                'validation_rules' => ['min_length' => 10, 'max_length' => 2000],
            ],
            [
                'field_key' => 'budget',
                'field_type' => 'dropdown',
                'label_ar' => 'الميزانية المتوقعة',
                'label_en' => 'Expected Budget',
                'is_required' => true,
                'options' => [
                    'choices' => [
                        ['value' => 'below_500', 'label_ar' => 'أقل من 500', 'label_en' => 'Below 500'],
                        ['value' => '500_1000', 'label_ar' => '500 - 1000', 'label_en' => '500 - 1000'],
                        ['value' => '1000_5000', 'label_ar' => '1000 - 5000', 'label_en' => '1000 - 5000'],
                        ['value' => 'above_5000', 'label_ar' => 'أكثر من 5000', 'label_en' => 'Above 5000'],
                    ],
                ],
            ],
            [
                'field_key' => 'start_date',
                'field_type' => 'date',
                'label_ar' => 'تاريخ البدء المطلوب',
                'label_en' => 'Preferred Start Date',
                'is_required' => false,
                'validation_rules' => ['min_date' => 'today'],
            ],
        ];

        // A couple of page-specific extra fields
        $extras = [
            [
                'field_key' => 'number_of_items',
                'field_type' => 'number',
                'label_ar' => 'عدد القطع',
                'label_en' => 'Number of Items',
                'placeholder_ar' => 'مثال: 50',
                'placeholder_en' => 'e.g. 50',
                'is_required' => false,
                'validation_rules' => ['min_value' => 1, 'max_value' => 100000],
            ],
            [
                'field_key' => 'delivery_preference',
                'field_type' => 'radio',
                'label_ar' => 'طريقة التسليم',
                'label_en' => 'Delivery Preference',
                'is_required' => false,
                'options' => [
                    'choices' => [
                        ['value' => 'digital', 'label_ar' => 'رقمي', 'label_en' => 'Digital'],
                        ['value' => 'physical', 'label_ar' => 'مادي', 'label_en' => 'Physical'],
                        ['value' => 'both', 'label_ar' => 'كلاهما', 'label_en' => 'Both'],
                    ],
                ],
            ],
            [
                'field_key' => 'project_url',
                'field_type' => 'url',
                'label_ar' => 'رابط المشروع',
                'label_en' => 'Project URL',
                'placeholder_ar' => 'https://...',
                'placeholder_en' => 'https://...',
                'is_required' => false,
            ],
        ];

        $fields = array_merge($common, $formIndex === 0 ? $extras : array_slice($extras, 0, 1));
        // Re-index order sequentially
        return array_values($fields);
    }

    protected function fakeValueForField($field, $faker): string
    {
        switch ($field->field_type) {
            case 'email':
                return $faker->safeEmail;
            case 'phone':
                return '+968 ' . $faker->numerify('########');
            case 'number':
                return (string) $faker->numberBetween(1, 999);
            case 'url':
                return $faker->url;
            case 'date':
                return $faker->date('Y-m-d', '+3 months');
            case 'time':
                return $faker->time('H:i');
            case 'datetime':
                return $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s');
            case 'dropdown':
                return $faker->randomElement(['below_500', '500_1000', '1000_5000', 'above_5000']);
            case 'radio':
                return $faker->randomElement(['digital', 'physical', 'both']);
            case 'checkbox':
            case 'multi_select':
                return json_encode($faker->randomElements(['option_a', 'option_b', 'option_c'], 2));
            case 'file_upload':
            case 'image_upload':
                return 'uploads/service-forms/' . $faker->fileExtension;
            case 'long_text':
                return $faker->paragraph(2);
            default:
                return $faker->sentence(4);
        }
    }
}