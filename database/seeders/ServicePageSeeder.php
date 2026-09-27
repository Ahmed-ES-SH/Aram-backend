<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Service\Models\ServicePage;
use App\Modules\Service\Models\ServicePageHeroSection;
use App\Modules\Service\Models\ServicePageProblemSection;
use App\Modules\Service\Models\ServicePageProblemItem;
use App\Modules\Service\Models\ServicePageSolutionSection;
use App\Modules\Service\Models\ServicePageSolutionFeature;
use App\Modules\Service\Models\ServicePageGalleryImage;
use App\Modules\Service\Models\ServicePageStat;
use App\Modules\Service\Models\ServicePageTestimonial;
use App\Modules\Service\Models\ServicePageCtaSection;
use App\Modules\Service\Models\ServiceTracking;
use App\Modules\Service\Models\ServiceTrackingFile;
use App\Modules\Service\Models\ServiceForm;
use App\Modules\Service\Models\ServiceFormField;
use App\Modules\Service\Models\ServicePageContactMessage;
use App\Modules\User\Models\User;
use App\Modules\Organization\Models\Organization;
use Illuminate\Support\Facades\DB;

class ServicePageSeeder extends Seeder
{

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        ServicePage::truncate();
        ServicePageHeroSection::truncate();
        ServicePageProblemSection::truncate();
        ServicePageProblemItem::truncate();
        ServicePageSolutionSection::truncate();
        ServicePageSolutionFeature::truncate();
        ServicePageGalleryImage::truncate();
        ServicePageStat::truncate();
        ServicePageTestimonial::truncate();
        ServicePageCtaSection::truncate();
        ServiceTracking::truncate();
        ServiceTrackingFile::truncate();
        ServiceForm::truncate();
        ServiceFormField::truncate();
        ServicePageContactMessage::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $user = User::first();
        $organization = Organization::first();

        foreach ($this->serviceDefinitions() as $definition) {
            $this->seedService($definition, $user, $organization);
        }
    }

    /**
     * Seed a single service page and all of its related sections/records.
     */
    private function seedService(array $d, ?User $user, ?Organization $organization): void
    {
        $servicePage = ServicePage::create([
            'slug' => $d['slug'],
            'is_active' => true,
            'price' => $d['price'],
            'price_before_discount' => $d['price_before_discount'],
            'type' => $d['type'],
            'payment_type' => $d['payment_type'],
            'status' => 'active',
            'order' => $d['order'],
            'category_id' => $d['category_id'],
            'whatsapp_number' => $d['whatsapp_number'],
            'orders_count' => $d['orders_count'],
        ]);

        $this->seedHero($servicePage, $d['hero']);
        $this->seedProblem($servicePage, $d['problem']);
        $this->seedSolution($servicePage, $d['solution']);
        $servicePage->galleryImages()->createMany($d['gallery']);
        $servicePage->stats()->createMany($d['stats']);
        $servicePage->testimonials()->createMany($d['testimonials']);
        $servicePage->ctaSection()->create($d['cta']);

        $this->seedForm($servicePage, $d['form_name_ar'], $d['form_name_en']);

        $this->seedTrackings($servicePage, $d['trackings'], $user, $organization);

        if (!empty($d['contact_messages'])) {
            $servicePage->contactMessages()->createMany($d['contact_messages']);
        }
    }

    private function seedHero(ServicePage $page, array $d): void
    {
        $page->heroSection()->create([
            'badge_ar' => $d['badge_ar'],
            'badge_en' => $d['badge_en'],
            'title_ar' => $d['title_ar'],
            'title_en' => $d['title_en'],
            'subtitle_ar' => $d['subtitle_ar'],
            'subtitle_en' => $d['subtitle_en'],
            'description_ar' => $d['description_ar'],
            'description_en' => $d['description_en'],
            'watch_btn_ar' => $d['watch_btn_ar'],
            'watch_btn_en' => $d['watch_btn_en'],
            'explore_btn_ar' => $d['explore_btn_ar'],
            'explore_btn_en' => $d['explore_btn_en'],
            'hero_image' => $d['hero_image'],
            'background_image' => $d['background_image'],
        ]);
    }

    private function seedProblem(ServicePage $page, array $d): void
    {
        $section = $page->problemSection()->create([
            'title_ar' => $d['title_ar'],
            'title_en' => $d['title_en'],
            'subtitle_ar' => $d['subtitle_ar'],
            'subtitle_en' => $d['subtitle_en'],
        ]);

        $section->items()->createMany($d['items']);
    }

    private function seedSolution(ServicePage $page, array $d): void
    {
        $section = $page->solutionSection()->create([
            'title_ar' => $d['title_ar'],
            'title_en' => $d['title_en'],
            'subtitle_ar' => $d['subtitle_ar'],
            'subtitle_en' => $d['subtitle_en'],
            'cta_text_ar' => $d['cta_text_ar'],
            'cta_text_en' => $d['cta_text_en'],
        ]);

        $section->features()->createMany($d['features']);
    }

    private function seedForm(ServicePage $page, string $nameAr, string $nameEn): void
    {
        $form = $page->form()->create([
            'name_ar' => $nameAr,
            'name_en' => $nameEn,
            'description_ar' => 'يرجى تعبئة الحقول أدناه لإتمام طلبك.',
            'description_en' => 'Please fill out the fields below to complete your request.',
            'version' => 1,
            'is_active' => true,
        ]);

        $form->fields()->createMany($this->formFields());
    }

    private function seedTrackings(ServicePage $page, array $trackings, ?User $user, ?Organization $organization): void
    {
        foreach ($trackings as $entry) {
            $ownerId = $entry['user_type'] === 'user' ? $user?->id : $organization?->id;

            if ($ownerId === null) {
                continue;
            }

            $data = [
                'user_id' => $ownerId,
                'user_type' => $entry['user_type'],
                'status' => $entry['status'],
                'current_phase' => $entry['phase'],
                'metadata' => $entry['metadata'],
            ];

            if (isset($entry['start_days_ago'])) {
                $data['start_time'] = now()->subDays($entry['start_days_ago']);
            }

            if (isset($entry['end_days_ago'])) {
                $data['end_time'] = now()->subDays($entry['end_days_ago']);
            }

            $tracking = $page->trackings()->create($data);

            foreach ($entry['files'] ?? [] as $file) {
                $this->seedTrackingFile($tracking, $file['url'], $file['filename']);
            }
        }
    }

    /**
     * Helper to seed a tracking file from a URL.
     */
    private function seedTrackingFile(ServiceTracking $tracking, string $url, string $filename)
    {
        $storagePath = 'uploads/service-tracking';
        if (!file_exists(public_path($storagePath))) {
            mkdir(public_path($storagePath), 0777, true);
        }

        $fullPath = public_path($storagePath . '/' . $filename);

        // Download file if it doesn't exist to avoid repeated downloads
        if (!file_exists($fullPath)) {
            $content = @file_get_contents($url);
            if ($content) {
                file_put_contents($fullPath, $content);
            } else {
                // Fallback if download fails: create a dummy file
                file_put_contents($fullPath, 'Dummy content for ' . $filename);
            }
        }

        // Create record
        ServiceTrackingFile::create([
            'service_tracking_id' => $tracking->id,
            'disk' => 'public_path',
            'path' => $storagePath . '/' . $filename,
            'file_type' => 'attachment',
            'original_name' => $filename,
            'mime_type' => mime_content_type($fullPath),
            'size' => filesize($fullPath),
            'uploaded_by' => $tracking->user_id,
            'uploaded_by_type' => $tracking->user_type,
        ]);
    }

    /**
     * Build an Unsplash image URL.
     */
    private function img(string $photoId, int $width = 1600): string
    {
        return "https://images.unsplash.com/photo-{$photoId}?auto=format&fit=crop&w={$width}&q=80";
    }

    /**
     * Portrait avatar URLs (alternating male/female by index).
     */
    private function avatar(int $index): string
    {
        $avatars = [
            0 => $this->img('1507003211169-0a1dd7228f2d', 400),
            1 => $this->img('1494790108377-be9c29b29330', 400),
            2 => $this->img('1500648767791-00dcc994a43e', 400),
            3 => $this->img('1438761681033-6461ffad8d80', 400),
        ];

        return $avatars[$index % 4];
    }

    /**
     * Shared form fields used by every service page form.
     * Exercises every column of the service_form_fields table.
     */
    private function formFields(): array
    {
        return [
            [
                'field_key' => 'full_name',
                'field_type' => 'short_text',
                'label_ar' => 'الاسم الكامل',
                'label_en' => 'Full Name',
                'placeholder_ar' => 'أدخل اسمك الكامل',
                'placeholder_en' => 'Enter your full name',
                'is_required' => true,
                'validation_rules' => ['min_length' => 3, 'max_length' => 100],
                'options' => null,
                'visibility_logic' => null,
                'order' => 0,
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
                'options' => null,
                'visibility_logic' => null,
                'order' => 1,
            ],
            [
                'field_key' => 'phone',
                'field_type' => 'phone',
                'label_ar' => 'رقم الهاتف',
                'label_en' => 'Phone Number',
                'placeholder_ar' => '+968 9X XXX XXXX',
                'placeholder_en' => '+968 9X XXX XXXX',
                'is_required' => true,
                'validation_rules' => ['pattern' => '^[+0-9\s-]{8,20}$'],
                'options' => null,
                'visibility_logic' => null,
                'order' => 2,
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
                'options' => null,
                'visibility_logic' => null,
                'order' => 3,
            ],
            [
                'field_key' => 'budget',
                'field_type' => 'dropdown',
                'label_ar' => 'الميزانية المتوقعة',
                'label_en' => 'Expected Budget',
                'placeholder_ar' => null,
                'placeholder_en' => null,
                'is_required' => true,
                'validation_rules' => [],
                'options' => [
                    'choices' => [
                        ['value' => 'below_500', 'label_ar' => 'أقل من 500', 'label_en' => 'Below 500'],
                        ['value' => '500_1000', 'label_ar' => '500 - 1000', 'label_en' => '500 - 1000'],
                        ['value' => '1000_5000', 'label_ar' => '1000 - 5000', 'label_en' => '1000 - 5000'],
                        ['value' => 'above_5000', 'label_ar' => 'أكثر من 5000', 'label_en' => 'Above 5000'],
                    ],
                ],
                'visibility_logic' => null,
                'order' => 4,
            ],
            [
                'field_key' => 'start_date',
                'field_type' => 'date',
                'label_ar' => 'تاريخ البدء المطلوب',
                'label_en' => 'Preferred Start Date',
                'placeholder_ar' => null,
                'placeholder_en' => null,
                'is_required' => false,
                'validation_rules' => ['min_date' => 'today'],
                'options' => null,
                'visibility_logic' => null,
                'order' => 5,
            ],
            [
                'field_key' => 'number_of_items',
                'field_type' => 'number',
                'label_ar' => 'عدد القطع',
                'label_en' => 'Number of Items',
                'placeholder_ar' => 'مثال: 50',
                'placeholder_en' => 'e.g. 50',
                'is_required' => false,
                'validation_rules' => ['min_value' => 1, 'max_value' => 100000],
                'options' => null,
                'visibility_logic' => null,
                'order' => 6,
            ],
            [
                'field_key' => 'delivery_preference',
                'field_type' => 'radio',
                'label_ar' => 'طريقة التسليم',
                'label_en' => 'Delivery Preference',
                'placeholder_ar' => null,
                'placeholder_en' => null,
                'is_required' => false,
                'validation_rules' => [],
                'options' => [
                    'choices' => [
                        ['value' => 'digital', 'label_ar' => 'رقمي', 'label_en' => 'Digital'],
                        ['value' => 'physical', 'label_ar' => 'مادي', 'label_en' => 'Physical'],
                        ['value' => 'both', 'label_ar' => 'كلاهما', 'label_en' => 'Both'],
                    ],
                ],
                'visibility_logic' => ['depends_on' => 'budget', 'condition' => 'equals', 'value' => 'above_5000'],
                'order' => 7,
            ],
            [
                'field_key' => 'project_url',
                'field_type' => 'url',
                'label_ar' => 'رابط المشروع',
                'label_en' => 'Project URL',
                'placeholder_ar' => 'https://...',
                'placeholder_en' => 'https://...',
                'is_required' => false,
                'validation_rules' => [],
                'options' => null,
                'visibility_logic' => null,
                'order' => 8,
            ],
        ];
    }

    /**
     * Data-driven definitions for all 8 service pages.
     */
    private function serviceDefinitions(): array
    {
        return [
            [
                'slug' => 'nfc-cards',
                'price' => 29.99,
                'price_before_discount' => 49.99,
                'type' => 'subscription',
                'payment_type' => 'direct',
                'order' => 1,
                'category_id' => 1,
                'whatsapp_number' => '+966500000001',
                'orders_count' => 120,
                'form_name_ar' => 'نموذج طلب بطاقة NFC',
                'form_name_en' => 'NFC Card Request Form',
                'hero' => [
                    'badge_ar' => 'الحل الجديد من التسويق الذكي',
                    'badge_en' => 'New Smart Marketing Solution',
                    'title_ar' => 'لمسة واحدة..',
                    'title_en' => 'One Touch..',
                    'subtitle_ar' => 'عالم من الفرص',
                    'subtitle_en' => 'A World of Opportunities',
                    'description_ar' => 'استبدل البطاقات الورقية ببطاقات NFC الذكية وشارك معلوماتك بلمسة واحدة',
                    'description_en' => 'Replace paper cards with smart NFC cards and share your information with one touch',
                    'watch_btn_ar' => 'شاهد الفيديو',
                    'watch_btn_en' => 'Watch Video',
                    'explore_btn_ar' => 'اكتشف المزيد',
                    'explore_btn_en' => 'Explore More',
                    'hero_image' => $this->img('1556742049-0cfed4f6a45d'),
                    'background_image' => $this->img('1518770660439-4636190af475'),
                ],
                'problem' => [
                    'title_ar' => 'المشكلة التي نحلها',
                    'title_en' => 'The Problem We Solve',
                    'subtitle_ar' => 'البطاقات الورقية التقليدية لها العديد من العيوب',
                    'subtitle_en' => 'Traditional paper cards have many drawbacks',
                    'items' => [
                        [
                            'icon' => 'star',
                            'title_ar' => 'صعوبة التحديث',
                            'title_en' => 'Difficult to Update',
                            'description_ar' => 'عند تغيير أي معلومة، عليك طباعة بطاقات جديدة',
                            'description_en' => 'When any information changes, you have to print new cards',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'book',
                            'title_ar' => 'غير صديقة للبيئة',
                            'title_en' => 'Not Eco-Friendly',
                            'description_ar' => 'ملايين البطاقات الورقية تُلقى سنوياً',
                            'description_en' => 'Millions of paper cards are thrown away annually',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'dollar',
                            'title_ar' => 'تكلفة متكررة',
                            'title_en' => 'Recurring Cost',
                            'description_ar' => 'تكاليف الطباعة المتكررة تتراكم مع الوقت',
                            'description_en' => 'Recurring printing costs accumulate over time',
                            'order' => 2,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'الحل الذكي',
                    'title_en' => 'The Smart Solution',
                    'subtitle_ar' => 'بطاقات NFC الذكية توفر لك كل ما تحتاجه',
                    'subtitle_en' => 'Smart NFC cards provide everything you need',
                    'cta_text_ar' => 'اطلب الآن',
                    'cta_text_en' => 'Order Now',
                    'features' => [
                        [
                            'feature_key' => 'business-card',
                            'icon' => 'FaIdCard',
                            'color' => 'bg-blue-500',
                            'title_ar' => 'بطاقة أعمال رقمية',
                            'title_en' => 'Digital Business Card',
                            'description_ar' => 'شارك جميع معلومات الاتصال بلمسة واحدة',
                            'description_en' => 'Share all contact information with one touch',
                            'preview_image' => $this->img('1556742049-0cfed4f6a45d'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'smart-menu',
                            'icon' => 'FaUtensils',
                            'color' => 'bg-yellow-500',
                            'title_ar' => 'قائمة ذكية للمطاعم',
                            'title_en' => 'Smart Menu for Restaurants',
                            'description_ar' => 'قوائم طعام رقمية تفاعلية',
                            'description_en' => 'Interactive digital food menus',
                            'preview_image' => $this->img('1551650975-87deedd944c3'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'google-review',
                            'icon' => 'FaGoogle',
                            'color' => 'bg-green-500',
                            'title_ar' => 'تقييمات جوجل',
                            'title_en' => 'Google Reviews',
                            'description_ar' => 'احصل على تقييمات فورية من عملائك',
                            'description_en' => 'Get instant reviews from your customers',
                            'preview_image' => $this->img('1543286386-713bdd548da4'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'social-media',
                            'icon' => 'FaShareAlt',
                            'color' => 'bg-purple-500',
                            'title_ar' => 'روابط وسائل التواصل',
                            'title_en' => 'Social Media Links',
                            'description_ar' => 'اربط جميع حساباتك الاجتماعية',
                            'description_en' => 'Link all your social accounts',
                            'preview_image' => $this->img('1517430816045-df4b7de11d1d'),
                            'order' => 3,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1556742049-0cfed4f6a45d'), 'alt_ar' => 'بطاقة NFC احترافية', 'alt_en' => 'Professional NFC Card', 'order' => 0],
                    ['path' => $this->img('1551650975-87deedd944c3'), 'alt_ar' => 'استخدام البطاقة', 'alt_en' => 'Using the Card', 'order' => 1],
                    ['path' => $this->img('1517430816045-df4b7de11d1d'), 'alt_ar' => 'تصاميم متنوعة', 'alt_en' => 'Various Designs', 'order' => 2],
                ],
                'stats' => [
                    ['number' => '24/7', 'label_ar' => 'دعم متواصل', 'label_en' => 'Continuous Support', 'order' => 0],
                    ['number' => '100k+', 'label_ar' => 'عميل راضٍ', 'label_en' => 'Satisfied Customers', 'order' => 1],
                    ['number' => '100%', 'label_ar' => 'ضمان الجودة', 'label_en' => 'Quality Guarantee', 'order' => 2],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'أحمد محمد',
                        'name_en' => 'Ahmed Mohammed',
                        'text_ar' => 'خدمة ممتازة! البطاقة غيرت طريقة تواصلي مع العملاء بشكل كامل',
                        'text_en' => 'Excellent service! The card completely changed how I connect with clients',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'سارة العلي',
                        'name_en' => 'Sara Al-Ali',
                        'text_ar' => 'تصميم أنيق وسهولة في الاستخدام. أنصح الجميع بتجربتها',
                        'text_en' => 'Elegant design and easy to use. I recommend everyone to try it',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'ماذا يقول عملاؤنا',
                    'testimonial_title_en' => 'What Our Clients Say',
                    'cta_title_ar' => 'ابدأ رحلتك الرقمية اليوم',
                    'cta_title_en' => 'Start Your Digital Journey Today',
                    'cta_subtitle_ar' => 'انضم إلى آلاف العملاء الذين وثقوا بنا',
                    'cta_subtitle_en' => 'Join thousands of customers who trusted us',
                    'cta_button1_ar' => 'اطلب الآن',
                    'cta_button1_en' => 'Order Now',
                    'cta_button2_ar' => 'تواصل معنا',
                    'cta_button2_en' => 'Contact Us',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'initiation',
                        'metadata' => [
                            'notes' => 'Customer requested custom design',
                            'priority' => 'normal',
                        ],
                        'files' => [
                            ['url' => $this->img('1556742049-0cfed4f6a45d'), 'filename' => 'requirements.png'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'in_progress',
                        'phase' => 'execution',
                        'start_days_ago' => 3,
                        'metadata' => [
                            'notes' => 'Design approved, production started',
                            'priority' => 'high',
                        ],
                        'files' => [
                            ['url' => $this->img('1543286386-713bdd548da4'), 'filename' => 'design_draft_v1.png'],
                            ['url' => $this->img('1518770660439-4636190af475'), 'filename' => 'contract.png'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'completed',
                        'phase' => 'delivery',
                        'start_days_ago' => 10,
                        'end_days_ago' => 2,
                        'metadata' => [
                            'notes' => 'Successfully delivered',
                            'delivery_method' => 'express',
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 1,
                        'metadata' => [
                            'notes' => 'Bulk order - 50 cards',
                            'priority' => 'high',
                            'quantity' => 50,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'initiation',
                        'metadata' => [
                            'notes' => 'Corporate branding requested',
                            'priority' => 'normal',
                            'quantity' => 100,
                        ],
                    ],
                ],
                'contact_messages' => [
                    ['name' => 'John Doe', 'email' => 'contact1@example.com', 'phone' => '+966500000001', 'message' => 'I am interested in this service.', 'status' => 'completed'],
                    ['name' => 'Jane Smith', 'email' => 'contact2@example.com', 'phone' => '+966500000002', 'message' => 'Please contact me for more details.', 'status' => 'pending'],
                ],
            ],
            [
                'slug' => 'mobile-app-development',
                'price' => 4999.99,
                'price_before_discount' => 6999.99,
                'type' => 'one_time',
                'payment_type' => 'after_deal',
                'order' => 2,
                'category_id' => 2,
                'whatsapp_number' => '+966500000002',
                'orders_count' => 45,
                'form_name_ar' => 'نموذج طلب تطبيق جوال',
                'form_name_en' => 'Mobile App Request Form',
                'hero' => [
                    'badge_ar' => 'الحل الأمثل للرقمنة',
                    'badge_en' => 'Optimal Digitization Solution',
                    'title_ar' => 'تطبيقات جوال متميزة',
                    'title_en' => 'Premium Mobile Applications',
                    'subtitle_ar' => 'تغيير تجربة العملاء',
                    'subtitle_en' => 'Transforming Customer Experience',
                    'description_ar' => 'نطور تطبيقات جوال مبتكرة تلبي احتياجات عملك وتواكب التطور التكنولوجي',
                    'description_en' => 'We develop innovative mobile applications that meet your business needs and keep pace with technological development',
                    'watch_btn_ar' => 'شاهد أعمالنا',
                    'watch_btn_en' => 'Watch Our Work',
                    'explore_btn_ar' => 'تعرف على المزايا',
                    'explore_btn_en' => 'See Features',
                    'hero_image' => $this->img('1512941937669-90a1b58e7e9c'),
                    'background_image' => $this->img('1517430816045-df4b7de11d1d'),
                ],
                'problem' => [
                    'title_ar' => 'التحديات التي نواجهها',
                    'title_en' => 'Challenges We Address',
                    'subtitle_ar' => 'التطبيقات التقليدية تواجه العديد من المشاكل',
                    'subtitle_en' => 'Traditional applications face many problems',
                    'items' => [
                        [
                            'icon' => 'star',
                            'title_ar' => 'بطء الأداء',
                            'title_en' => 'Poor Performance',
                            'description_ar' => 'تطبيقات بطيئة تؤثر على تجربة المستخدم',
                            'description_en' => 'Slow applications that affect user experience',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'book',
                            'title_ar' => 'تصميم غير جذاب',
                            'title_en' => 'Unattractive Design',
                            'description_ar' => 'واجهات مستخدم قديمة لا تجذب العملاء',
                            'description_en' => 'Outdated user interfaces that don\'t attract customers',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'dollar',
                            'title_ar' => 'تكاليف صيانة عالية',
                            'title_en' => 'High Maintenance Costs',
                            'description_ar' => 'تكاليف صيانة وتحديث مستمرة',
                            'description_en' => 'Continuous maintenance and update costs',
                            'order' => 2,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'حلولنا المتكاملة',
                    'title_en' => 'Our Integrated Solutions',
                    'subtitle_ar' => 'تطبيقات ذكية تلبي كل متطلباتك',
                    'subtitle_en' => 'Smart applications that meet all your requirements',
                    'cta_text_ar' => 'ابدأ مشروعك الآن',
                    'cta_text_en' => 'Start Your Project Now',
                    'features' => [
                        [
                            'feature_key' => 'ios-apps',
                            'icon' => 'FaApple',
                            'color' => 'bg-gray-800',
                            'title_ar' => 'تطبيقات iOS',
                            'title_en' => 'iOS Applications',
                            'description_ar' => 'تطبيقات متوافقة مع أجهزة آبل بجودة عالية',
                            'description_en' => 'High-quality applications compatible with Apple devices',
                            'preview_image' => $this->img('1551650975-87deedd944c3'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'android-apps',
                            'icon' => 'FaAndroid',
                            'color' => 'bg-green-500',
                            'title_ar' => 'تطبيقات أندرويد',
                            'title_en' => 'Android Applications',
                            'description_ar' => 'حلول متكاملة لمنصة أندرويد',
                            'description_en' => 'Integrated solutions for Android platform',
                            'preview_image' => $this->img('1512941937669-90a1b58e7e9c'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'cross-platform',
                            'icon' => 'FaMobile',
                            'color' => 'bg-blue-500',
                            'title_ar' => 'تطبيقات متعددة المنصات',
                            'title_en' => 'Cross-Platform Applications',
                            'description_ar' => 'حل واحد يعمل على جميع المنصات',
                            'description_en' => 'One solution works on all platforms',
                            'preview_image' => $this->img('1526406915894-7bcd65f60845'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'ui-ux',
                            'icon' => 'FaPalette',
                            'color' => 'bg-purple-500',
                            'title_ar' => 'تصميم واجهات متقدمة',
                            'title_en' => 'Advanced UI/UX Design',
                            'description_ar' => 'تصاميم جذابة وسهلة الاستخدام',
                            'description_en' => 'Attractive and user-friendly designs',
                            'preview_image' => $this->img('1558655146-9f40138edfeb'),
                            'order' => 3,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1551650975-87deedd944c3'), 'alt_ar' => 'واجهة تطبيق جوال', 'alt_en' => 'Mobile App Interface', 'order' => 0],
                    ['path' => $this->img('1526406915894-7bcd65f60845'), 'alt_ar' => 'تصميم تطبيق', 'alt_en' => 'App Design', 'order' => 1],
                    ['path' => $this->img('1512941937669-90a1b58e7e9c'), 'alt_ar' => 'تطبيق في العمل', 'alt_en' => 'App in Action', 'order' => 2],
                ],
                'stats' => [
                    ['number' => '500+', 'label_ar' => 'تطبيق تم تطويره', 'label_en' => 'Apps Developed', 'order' => 0],
                    ['number' => '98%', 'label_ar' => 'رضا العملاء', 'label_en' => 'Client Satisfaction', 'order' => 1],
                    ['number' => '24/7', 'label_ar' => 'دعم فني', 'label_en' => 'Technical Support', 'order' => 2],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'خالد السعيد',
                        'name_en' => 'Khaled Al-Saeed',
                        'text_ar' => 'التطبيق الذي طوروه لشركتنا زاد من مبيعاتنا بنسبة 40%',
                        'text_en' => 'The app they developed for our company increased our sales by 40%',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'نورة القحطاني',
                        'name_en' => 'Nora Al-Qahtani',
                        'text_ar' => 'فريق محترف ونتائج تتجاوز التوقعات',
                        'text_en' => 'Professional team and results that exceed expectations',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'تجارب عملائنا',
                    'testimonial_title_en' => 'Our Clients Experiences',
                    'cta_title_ar' => 'حوّل فكرتك إلى تطبيق واقعي',
                    'cta_title_en' => 'Turn Your Idea into a Real Application',
                    'cta_subtitle_ar' => 'نحن هنا لتحقيق رؤيتك الرقمية',
                    'cta_subtitle_en' => 'We are here to realize your digital vision',
                    'cta_button1_ar' => 'احصل على استشارة مجانية',
                    'cta_button1_en' => 'Get Free Consultation',
                    'cta_button2_ar' => 'اطلب عرض سعر',
                    'cta_button2_en' => 'Request a Quote',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Client needs e-commerce mobile app',
                            'platform' => 'both',
                            'priority' => 'high',
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 15,
                        'metadata' => [
                            'notes' => 'UI/UX design approved, starting development phase',
                            'progress' => '30%',
                            'deadline' => now()->addDays(45)->toDateString(),
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 60,
                        'end_days_ago' => 5,
                        'metadata' => [
                            'notes' => 'App successfully published on App Store and Play Store',
                            'rating' => '5 stars',
                            'downloads' => '5000+',
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 30,
                        'metadata' => [
                            'notes' => 'Enterprise app for internal use - testing phase',
                            'users_count' => 250,
                            'modules' => ['attendance', 'tasks', 'reports'],
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Banking app with high security requirements',
                            'priority' => 'urgent',
                            'budget' => 75000,
                        ],
                    ],
                ],
                'contact_messages' => [
                    ['name' => 'John Doe', 'email' => 'contact1@example.com', 'phone' => '+966500000002', 'message' => 'I am interested in this service.', 'status' => 'completed'],
                    ['name' => 'Jane Smith', 'email' => 'contact2@example.com', 'phone' => '+966500000003', 'message' => 'Please contact me for more details.', 'status' => 'pending'],
                ],
            ],
            [
                'slug' => 'ecommerce-solutions',
                'price' => 2999.99,
                'price_before_discount' => 4499.99,
                'type' => 'subscription',
                'payment_type' => 'direct',
                'order' => 3,
                'category_id' => 3,
                'whatsapp_number' => '+966500000003',
                'orders_count' => 80,
                'form_name_ar' => 'نموذج طلب متجر إلكتروني',
                'form_name_en' => 'E-commerce Store Request Form',
                'hero' => [
                    'badge_ar' => 'منصة التجارة الإلكترونية الشاملة',
                    'badge_en' => 'Complete E-commerce Platform',
                    'title_ar' => 'متجرك الإلكتروني',
                    'title_en' => 'Your Online Store',
                    'subtitle_ar' => 'بين يديك',
                    'subtitle_en' => 'At Your Fingertips',
                    'description_ar' => 'أنشئ متجرك الإلكتروني المتكامل بأحدث التقنيات وأفضل الحلول التسويقية',
                    'description_en' => 'Build your integrated online store with the latest technologies and best marketing solutions',
                    'watch_btn_ar' => 'جولة المتجر',
                    'watch_btn_en' => 'Store Tour',
                    'explore_btn_ar' => 'المزايا المتكاملة',
                    'explore_btn_en' => 'Full Features',
                    'hero_image' => $this->img('1441984904996-e0b6ba687e04'),
                    'background_image' => $this->img('1441986300917-64674bd600d8'),
                ],
                'problem' => [
                    'title_ar' => 'معوقات البيع عبر الإنترنت',
                    'title_en' => 'Online Selling Obstacles',
                    'subtitle_ar' => 'تحديات تواجه المتاجر التقليدية',
                    'subtitle_en' => 'Challenges facing traditional stores',
                    'items' => [
                        [
                            'icon' => 'star',
                            'title_ar' => 'منصات معقدة',
                            'title_en' => 'Complex Platforms',
                            'description_ar' => 'صعوبة في إدارة المتجر والمنتجات',
                            'description_en' => 'Difficulty in managing store and products',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'book',
                            'title_ar' => 'تكاليف خفية',
                            'title_en' => 'Hidden Costs',
                            'description_ar' => 'رسوم إضافية غير متوقعة تزيد التكلفة',
                            'description_en' => 'Unexpected additional fees increase costs',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'dollar',
                            'title_ar' => 'ضعف المبيعات',
                            'title_en' => 'Poor Sales',
                            'description_ar' => 'تصميم غير محفز للشراء وغياب الاستراتيجيات التسويقية',
                            'description_en' => 'Non-stimulating design for purchases and absence of marketing strategies',
                            'order' => 2,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'حلولنا المتكاملة',
                    'title_en' => 'Our Integrated Solutions',
                    'subtitle_ar' => 'كل ما تحتاجه لنجاح متجرك الإلكتروني',
                    'subtitle_en' => 'Everything you need for your online store success',
                    'cta_text_ar' => 'أنشئ متجرك الآن',
                    'cta_text_en' => 'Create Your Store Now',
                    'features' => [
                        [
                            'feature_key' => 'responsive-design',
                            'icon' => 'FaDesktop',
                            'color' => 'bg-blue-600',
                            'title_ar' => 'تصميم متجاوب',
                            'title_en' => 'Responsive Design',
                            'description_ar' => 'يعمل على جميع الأجهزة والشاشات',
                            'description_en' => 'Works on all devices and screens',
                            'preview_image' => $this->img('1441986300917-64674bd600d8'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'payment-gateways',
                            'icon' => 'FaCreditCard',
                            'color' => 'bg-green-600',
                            'title_ar' => 'بوابات دفع متعددة',
                            'title_en' => 'Multiple Payment Gateways',
                            'description_ar' => 'مدى، فيزا، أبل باي، وغيرها',
                            'description_en' => 'Mada, Visa, Apple Pay, and others',
                            'preview_image' => $this->img('1556742049-0cfed4f6a45d'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'inventory-management',
                            'icon' => 'FaWarehouse',
                            'color' => 'bg-orange-500',
                            'title_ar' => 'إدارة مخزون ذكية',
                            'title_en' => 'Smart Inventory Management',
                            'description_ar' => 'تتبع المخزون تلقائياً وإشعارات النفاد',
                            'description_en' => 'Automatic inventory tracking and low stock alerts',
                            'preview_image' => $this->img('1472851294608-062f824d29cc'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'seo-optimized',
                            'icon' => 'FaSearch',
                            'color' => 'bg-purple-600',
                            'title_ar' => 'تحسين محركات البحث',
                            'title_en' => 'SEO Optimized',
                            'description_ar' => 'تصدر نتائج البحث وجذب عملاء جدد',
                            'description_en' => 'Rank high in search results and attract new customers',
                            'preview_image' => $this->img('1460925895917-afdab827c52f'),
                            'order' => 3,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1483985988355-763728e1935b'), 'alt_ar' => 'واجهة متجر إلكتروني', 'alt_en' => 'E-commerce Store Interface', 'order' => 0],
                    ['path' => $this->img('1441984904996-e0b6ba687e04'), 'alt_ar' => 'صفحة المنتج', 'alt_en' => 'Product Page', 'order' => 1],
                    ['path' => $this->img('1472851294608-062f824d29cc'), 'alt_ar' => 'تجربة التسوق', 'alt_en' => 'Shopping Experience', 'order' => 2],
                ],
                'stats' => [
                    ['number' => '1000+', 'label_ar' => 'متجر ناجح', 'label_en' => 'Successful Stores', 'order' => 0],
                    ['number' => '50%', 'label_ar' => 'زيادة في المبيعات', 'label_en' => 'Sales Increase', 'order' => 1],
                    ['number' => '30 دقيقة', 'label_ar' => 'تشغيل فوري', 'label_en' => 'Instant Setup', 'order' => 2],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'محمد العتيبي',
                        'name_en' => 'Mohammed Al-Otaibi',
                        'text_ar' => 'زادت مبيعات متجري بنسبة 300% بعد إنشاء المتجر الإلكتروني',
                        'text_en' => 'My store sales increased by 300% after creating the online store',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'فاطمة الزهراني',
                        'name_en' => 'Fatima Al-Zahrani',
                        'text_ar' => 'منصة سهلة الاستخدام مع دعم فني ممتاز على مدار الساعة',
                        'text_en' => 'Easy-to-use platform with excellent 24/7 technical support',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                    [
                        'name_ar' => 'عبدالله القصيبي',
                        'name_en' => 'Abdullah Al-Qusaibi',
                        'text_ar' => 'الحلول التسويقية المدمجة ساعدتني في الوصول لعملاء جدد',
                        'text_en' => 'The integrated marketing solutions helped me reach new customers',
                        'rating' => 5,
                        'avatar' => $this->avatar(2),
                        'order' => 2,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'قصص نجاح عملائنا',
                    'testimonial_title_en' => 'Our Clients Success Stories',
                    'cta_title_ar' => 'ابدأ رحلتك في عالم التجارة الإلكترونية',
                    'cta_title_en' => 'Start Your E-commerce Journey',
                    'cta_subtitle_ar' => 'انضم إلى آلاف التجار الناجحين',
                    'cta_subtitle_en' => 'Join thousands of successful merchants',
                    'cta_button1_ar' => 'احصل على عرض خاص',
                    'cta_button1_en' => 'Get Special Offer',
                    'cta_button2_ar' => 'استشارة مجانية',
                    'cta_button2_en' => 'Free Consultation',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Customer wants basic fashion store',
                            'products_count' => 50,
                            'budget' => 3500,
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 7,
                        'metadata' => [
                            'notes' => 'Electronics store with 200+ products',
                            'progress' => '40%',
                            'features' => ['multi-vendor', 'arabic_support', 'loyalty_program'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 45,
                        'end_days_ago' => 10,
                        'metadata' => [
                            'notes' => 'Online grocery store with delivery system',
                            'monthly_sales' => 50000,
                            'active_users' => 1200,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 20,
                        'metadata' => [
                            'notes' => 'B2B wholesale platform for industrial supplies',
                            'target_companies' => 500,
                            'integration' => ['erp', 'crm', 'accounting'],
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Multi-language store for international market',
                            'languages' => ['ar', 'en', 'fr'],
                            'currencies' => ['SAR', 'USD', 'EUR'],
                            'budget' => 25000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 120,
                        'end_days_ago' => 30,
                        'metadata' => [
                            'notes' => 'Luxury fashion brand e-commerce platform',
                            'quarterly_revenue' => 1500000,
                            'social_media_integration' => true,
                        ],
                    ],
                ],
                'contact_messages' => [
                    ['name' => 'John Doe', 'email' => 'contact1@example.com', 'phone' => '+966500000003', 'message' => 'I am interested in this service.', 'status' => 'processing'],
                    ['name' => 'Jane Smith', 'email' => 'contact2@example.com', 'phone' => '+966500000004', 'message' => 'Please contact me for more details.', 'status' => 'completed'],
                ],
            ],
            [
                'slug' => 'digital-marketing',
                'price' => 1999.99,
                'price_before_discount' => 2999.99,
                'type' => 'one_time',
                'payment_type' => 'after_deal',
                'order' => 4,
                'category_id' => 4,
                'whatsapp_number' => '+966500000004',
                'orders_count' => 95,
                'form_name_ar' => 'نموذج طلب حملة تسويقية',
                'form_name_en' => 'Marketing Campaign Request Form',
                'hero' => [
                    'badge_ar' => 'الحل التسويقي المتكامل',
                    'badge_en' => 'Integrated Marketing Solution',
                    'title_ar' => 'التسويق الرقمي',
                    'title_en' => 'Digital Marketing',
                    'subtitle_ar' => 'يصل عملك للعالم',
                    'subtitle_en' => 'Takes Your Business Global',
                    'description_ar' => 'حلول تسويقية مبتكرة تزيد من وصولك للعملاء وتحقق أعلى العوائد على الاستثمار',
                    'description_en' => 'Innovative marketing solutions that increase your reach to customers and achieve the highest ROI',
                    'watch_btn_ar' => 'نتائج حملاتنا',
                    'watch_btn_en' => 'Campaign Results',
                    'explore_btn_ar' => 'خططنا التسويقية',
                    'explore_btn_en' => 'Our Plans',
                    'hero_image' => $this->img('1460925895917-afdab827c52f'),
                    'background_image' => $this->img('1533750349088-cd871a92f312'),
                ],
                'problem' => [
                    'title_ar' => 'تحديات التسويق التقليدي',
                    'title_en' => 'Traditional Marketing Challenges',
                    'subtitle_ar' => 'لماذا تفشل الحملات التسويقية؟',
                    'subtitle_en' => 'Why Do Marketing Campaigns Fail?',
                    'items' => [
                        [
                            'icon' => 'star',
                            'title_ar' => 'تكاليف عالية',
                            'title_en' => 'High Costs',
                            'description_ar' => 'الإعلانات التقليدية مكلفة ولا تضمن وصولاً دقيقاً',
                            'description_en' => 'Traditional ads are expensive and don\'t guarantee accurate reach',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'book',
                            'title_ar' => 'صعوبة القياس',
                            'title_en' => 'Difficulty in Measurement',
                            'description_ar' => 'عدم القدرة على تتبع النتائج بدقة',
                            'description_en' => 'Inability to accurately track results',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'dollar',
                            'title_ar' => 'ضعف التفاعل',
                            'title_en' => 'Weak Engagement',
                            'description_ar' => 'الجمهور لا يتفاعل مع الحملات التقليدية',
                            'description_en' => 'Audience doesn\'t engage with traditional campaigns',
                            'order' => 2,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'حلولنا الرقمية',
                    'title_en' => 'Our Digital Solutions',
                    'subtitle_ar' => 'استراتيجيات تسويقية ذكية تحقق النتائج',
                    'subtitle_en' => 'Smart Marketing Strategies That Deliver Results',
                    'cta_text_ar' => 'ابدأ حملتك الآن',
                    'cta_text_en' => 'Start Your Campaign Now',
                    'features' => [
                        [
                            'feature_key' => 'seo-services',
                            'icon' => 'FaSearch',
                            'color' => 'bg-blue-600',
                            'title_ar' => 'تحسين محركات البحث',
                            'title_en' => 'SEO Services',
                            'description_ar' => 'تصدر نتائج البحث الأولى وزيادة الزيارات العضوية',
                            'description_en' => 'Rank first in search results and increase organic traffic',
                            'preview_image' => $this->img('1460925895917-afdab827c52f'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'social-media',
                            'icon' => 'FaHashtag',
                            'color' => 'bg-pink-500',
                            'title_ar' => 'إدارة وسائل التواصل',
                            'title_en' => 'Social Media Management',
                            'description_ar' => 'إدارة متكاملة لحساباتك على جميع المنصات',
                            'description_en' => 'Integrated management of your accounts on all platforms',
                            'preview_image' => $this->img('1543286386-713bdd548da4'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'content-marketing',
                            'icon' => 'FaEdit',
                            'color' => 'bg-green-500',
                            'title_ar' => 'التسويق بالمحتوى',
                            'title_en' => 'Content Marketing',
                            'description_ar' => 'إنشاء محتوى جذاب يحول الزوار إلى عملاء',
                            'description_en' => 'Creating engaging content that converts visitors into customers',
                            'preview_image' => $this->img('1551288049-bebda4e38f71'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'google-ads',
                            'icon' => 'FaChartLine',
                            'color' => 'bg-yellow-500',
                            'title_ar' => 'إعلانات جوجل',
                            'title_en' => 'Google Ads',
                            'description_ar' => 'حملات إعلانية مستهدفة تحقق أعلى عائد استثمار',
                            'description_en' => 'Targeted ad campaigns that achieve the highest ROI',
                            'preview_image' => $this->img('1533750349088-cd871a92f312'),
                            'order' => 3,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1551288049-bebda4e38f71'), 'alt_ar' => 'تحليلات التسويق الرقمي', 'alt_en' => 'Digital Marketing Analytics', 'order' => 0],
                    ['path' => $this->img('1533750349088-cd871a92f312'), 'alt_ar' => 'حملة إعلانية ناجحة', 'alt_en' => 'Successful Ad Campaign', 'order' => 1],
                    ['path' => $this->img('1543286386-713bdd548da4'), 'alt_ar' => 'إدارة وسائل التواصل', 'alt_en' => 'Social Media Management', 'order' => 2],
                ],
                'stats' => [
                    ['number' => '500+', 'label_ar' => 'حملة ناجحة', 'label_en' => 'Successful Campaigns', 'order' => 0],
                    ['number' => '300%', 'label_ar' => 'زيادة في المبيعات', 'label_en' => 'Sales Increase', 'order' => 1],
                    ['number' => '24/7', 'label_ar' => 'تحليل وتقارير', 'label_en' => 'Analysis & Reports', 'order' => 2],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'وليد الشمري',
                        'name_en' => 'Waleed Al-Shammari',
                        'text_ar' => 'حملاتهم التسويقية زادت مبيعات متجري الإلكتروني بنسبة 400% في 3 أشهر',
                        'text_en' => 'Their marketing campaigns increased my online store sales by 400% in 3 months',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'هناء الرشيد',
                        'name_en' => 'Hana Al-Rashid',
                        'text_ar' => 'فريق محترف يقدم تقارير مفصلة وتحليلات دقيقة تساعد في اتخاذ القرارات',
                        'text_en' => 'Professional team that provides detailed reports and accurate analytics that help in decision making',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                    [
                        'name_ar' => 'سعود الفهد',
                        'name_en' => 'Saud Al-Fahad',
                        'text_ar' => 'استراتيجيتهم في التسويق بالمحتوى حولت مدونتنا إلى مصدر رئيسي للعملاء',
                        'text_en' => 'Their content marketing strategy turned our blog into a major source of customers',
                        'rating' => 5,
                        'avatar' => $this->avatar(2),
                        'order' => 2,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'نجاحات عملائنا تتحدث',
                    'testimonial_title_en' => 'Our Clients Success Speaks',
                    'cta_title_ar' => 'ارتقِ بتسويق عملك إلى مستوى جديد',
                    'cta_title_en' => 'Elevate Your Business Marketing to a New Level',
                    'cta_subtitle_ar' => 'احصل على خطة تسويقية مخصصة لعملك',
                    'cta_subtitle_en' => 'Get a customized marketing plan for your business',
                    'cta_button1_ar' => 'اطلب خطة تسويقية',
                    'cta_button1_en' => 'Request Marketing Plan',
                    'cta_button2_ar' => 'استشارة مجانية',
                    'cta_button2_en' => 'Free Consultation',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Client needs SEO for new website',
                            'keywords' => 50,
                            'competitors' => 5,
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 15,
                        'metadata' => [
                            'notes' => 'Instagram & TikTok campaign for fashion brand',
                            'platforms' => ['instagram', 'tiktok'],
                            'budget' => 5000,
                            'progress' => '65%',
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 90,
                        'end_days_ago' => 30,
                        'metadata' => [
                            'notes' => 'Google Ads campaign for real estate company',
                            'roi' => '350%',
                            'leads_generated' => 450,
                            'conversion_rate' => '12%',
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 45,
                        'metadata' => [
                            'notes' => 'Complete digital marketing overhaul for manufacturing company',
                            'services' => ['seo', 'social_media', 'content', 'email_marketing'],
                            'team_size' => 5,
                            'budget' => 75000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'New product launch campaign across all digital channels',
                            'product' => 'Smart Home Device',
                            'target_markets' => ['KSA', 'UAE', 'Qatar'],
                            'budget' => 100000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 180,
                        'end_days_ago' => 60,
                        'metadata' => [
                            'notes' => '6-month brand awareness campaign for tech startup',
                            'brand_mentions' => 25000,
                            'social_reach' => '2.5M',
                            'website_traffic_increase' => '180%',
                        ],
                    ],
                ],
                'contact_messages' => [
                    ['name' => 'John Doe', 'email' => 'contact1@example.com', 'phone' => '+966500000004', 'message' => 'I am interested in this service.', 'status' => 'processing'],
                    ['name' => 'Jane Smith', 'email' => 'contact2@example.com', 'phone' => '+966500000005', 'message' => 'Please contact me for more details.', 'status' => 'completed'],
                ],
            ],
            [
                'slug' => 'web-development',
                'price' => 3999.99,
                'price_before_discount' => 5499.99,
                'type' => 'one_time',
                'payment_type' => 'after_deal',
                'order' => 5,
                'category_id' => 5,
                'whatsapp_number' => '+966500000005',
                'orders_count' => 60,
                'form_name_ar' => 'نموذج طلب تطوير موقع',
                'form_name_en' => 'Website Development Request Form',
                'hero' => [
                    'badge_ar' => 'الحل التقني المتكامل',
                    'badge_en' => 'Complete Technical Solution',
                    'title_ar' => 'تطوير المواقع',
                    'title_en' => 'Web Development',
                    'subtitle_ar' => 'مواقع احترافية',
                    'subtitle_en' => 'Professional Websites',
                    'description_ar' => 'نطور مواقع إلكترونية متكاملة تلبي احتياجات عملك وتواكب أحدث التقنيات',
                    'description_en' => 'We develop integrated websites that meet your business needs and keep pace with the latest technologies',
                    'watch_btn_ar' => 'شاهد موقعنا',
                    'watch_btn_en' => 'See Our Sites',
                    'explore_btn_ar' => 'مزايا التطوير',
                    'explore_btn_en' => 'Dev Features',
                    'hero_image' => $this->img('1504384308090-c894fdcc538d'),
                    'background_image' => $this->img('1498050108023-c5249f4df085'),
                ],
                'problem' => [
                    'title_ar' => 'مشاكل المواقع التقليدية',
                    'title_en' => 'Traditional Website Problems',
                    'subtitle_ar' => 'لماذا تفشل العديد من المواقع؟',
                    'subtitle_en' => 'Why Do Many Websites Fail?',
                    'items' => [
                        [
                            'icon' => 'FaExclamationTriangle',
                            'title_ar' => 'تصميم غير جذاب',
                            'title_en' => 'Unattractive Design',
                            'description_ar' => 'واجهات مستخدم قديمة لا تناسب العصر الرقمي',
                            'description_en' => 'Outdated user interfaces not suitable for the digital age',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'FaMobileAlt',
                            'title_ar' => 'عدم التوافق مع الجوال',
                            'title_en' => 'Mobile Incompatibility',
                            'description_ar' => 'مواقع لا تعمل بشكل صحيح على الهواتف الذكية',
                            'description_en' => 'Websites that don\'t work properly on smartphones',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'FaTachometerAlt',
                            'title_ar' => 'بطء الأداء',
                            'title_en' => 'Slow Performance',
                            'description_ar' => 'سرعة تحميل بطيئة تؤثر على تجربة المستخدم',
                            'description_en' => 'Slow loading speeds that affect user experience',
                            'order' => 2,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'حلولنا التقنية',
                    'title_en' => 'Our Technical Solutions',
                    'subtitle_ar' => 'مواقع متطورة تلبي جميع المتطلبات',
                    'subtitle_en' => 'Advanced Websites That Meet All Requirements',
                    'cta_text_ar' => 'طور موقعك الآن',
                    'cta_text_en' => 'Develop Your Website Now',
                    'features' => [
                        [
                            'feature_key' => 'responsive-design',
                            'icon' => 'FaDesktop',
                            'color' => 'bg-blue-600',
                            'title_ar' => 'تصميم متجاوب',
                            'title_en' => 'Responsive Design',
                            'description_ar' => 'يعمل على جميع الأجهزة والشاشات المختلفة',
                            'description_en' => 'Works on all devices and different screens',
                            'preview_image' => $this->img('1461749280684-dccba630e2f6'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'seo-optimized',
                            'icon' => 'FaSearch',
                            'color' => 'bg-green-600',
                            'title_ar' => 'تحسين لمحركات البحث',
                            'title_en' => 'SEO Optimized',
                            'description_ar' => 'بناء سليم يساعد في تصدر نتائج البحث',
                            'description_en' => 'Proper structure that helps rank in search results',
                            'preview_image' => $this->img('1504384308090-c894fdcc538d'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'fast-loading',
                            'icon' => 'FaRocket',
                            'color' => 'bg-red-500',
                            'title_ar' => 'سرعة فائقة',
                            'title_en' => 'Super Fast',
                            'description_ar' => 'تحميل سريع يحسن تجربة المستخدم وترتيب الموقع',
                            'description_en' => 'Fast loading improves user experience and site ranking',
                            'preview_image' => $this->img('1531297484001-80022131f5a1'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'secure-websites',
                            'icon' => 'FaLock',
                            'color' => 'bg-yellow-600',
                            'title_ar' => 'مواقع آمنة',
                            'title_en' => 'Secure Websites',
                            'description_ar' => 'حماية متقدمة ضد الاختراقات والهجمات',
                            'description_en' => 'Advanced protection against hacks and attacks',
                            'preview_image' => $this->img('1518770660439-4636190af475'),
                            'order' => 3,
                        ],
                        [
                            'feature_key' => 'cms-integration',
                            'icon' => 'FaCog',
                            'color' => 'bg-purple-600',
                            'title_ar' => 'أنظمة إدارة محتوى',
                            'title_en' => 'CMS Integration',
                            'description_ar' => 'سهولة إدارة المحتوى بدون خبرة برمجية',
                            'description_en' => 'Easy content management without programming experience',
                            'preview_image' => $this->img('1555066931-4365d14bab8c'),
                            'order' => 4,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1461749280684-dccba630e2f6'), 'alt_ar' => 'واجهة موقع حديث', 'alt_en' => 'Modern Website Interface', 'order' => 0],
                    ['path' => $this->img('1531297484001-80022131f5a1'), 'alt_ar' => 'تصميم موقع متجاوب', 'alt_en' => 'Responsive Website Design', 'order' => 1],
                    ['path' => $this->img('1555066931-4365d14bab8c'), 'alt_ar' => 'لوحة تحكم الموقع', 'alt_en' => 'Website Dashboard', 'order' => 2],
                ],
                'stats' => [
                    ['number' => '1000+', 'label_ar' => 'موقع تم تطويره', 'label_en' => 'Websites Developed', 'order' => 0],
                    ['number' => '99.9%', 'label_ar' => 'وقت تشغيل', 'label_en' => 'Uptime', 'order' => 1],
                    ['number' => '24/7', 'label_ar' => 'دعم فني', 'label_en' => 'Technical Support', 'order' => 2],
                    ['number' => '50%', 'label_ar' => 'توفير في التكلفة', 'label_en' => 'Cost Saving', 'order' => 3],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'فهد العنزي',
                        'name_en' => 'Fahad Al-Anzi',
                        'text_ar' => 'الموقع الذي طوروه لشركتنا زاد من مبيعاتنا عبر الإنترنت بنسبة 300%',
                        'text_en' => 'The website they developed for our company increased our online sales by 300%',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'أمل الحربي',
                        'name_en' => 'Amal Al-Harbi',
                        'text_ar' => 'فريق محترف يقدم حلولاً تقنية متكاملة مع متابعة ممتازة',
                        'text_en' => 'Professional team that provides integrated technical solutions with excellent follow-up',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                    [
                        'name_ar' => 'تركي المطيري',
                        'name_en' => 'Turki Al-Mutairi',
                        'text_ar' => 'سرعة التنفيذ وجودة العمل تفوق التوقعات، أنصح بالتعامل معهم',
                        'text_en' => 'The speed of execution and quality of work exceed expectations, I recommend dealing with them',
                        'rating' => 5,
                        'avatar' => $this->avatar(2),
                        'order' => 2,
                    ],
                    [
                        'name_ar' => 'لطيفة السبيعي',
                        'name_en' => 'Latifa Al-Subaie',
                        'text_ar' => 'لوحة التحكم سهلة الاستخدام حتى للمبتدئين في التعامل مع المواقع',
                        'text_en' => 'The control panel is easy to use even for beginners in dealing with websites',
                        'rating' => 5,
                        'avatar' => $this->avatar(3),
                        'order' => 3,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'ثقة عملائنا',
                    'testimonial_title_en' => 'Our Clients Trust',
                    'cta_title_ar' => 'طور موقعك الإلكتروني باحترافية',
                    'cta_title_en' => 'Develop Your Website Professionally',
                    'cta_subtitle_ar' => 'احصل على موقع إلكتروني يمثل عملك بأفضل صورة',
                    'cta_subtitle_en' => 'Get a website that represents your business in the best way',
                    'cta_button1_ar' => 'اطلب عرض سعر',
                    'cta_button1_en' => 'Request a Quote',
                    'cta_button2_ar' => 'استشارة مجانية',
                    'cta_button2_en' => 'Free Consultation',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Personal blog website with custom design',
                            'pages' => 10,
                            'features' => ['blog', 'contact', 'portfolio'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 20,
                        'metadata' => [
                            'notes' => 'E-commerce website for fashion products',
                            'products' => 150,
                            'progress' => '70%',
                            'technologies' => ['laravel', 'vuejs', 'mysql'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 60,
                        'end_days_ago' => 15,
                        'metadata' => [
                            'notes' => 'Corporate website for consulting company',
                            'traffic_increase' => '250%',
                            'conversion_rate' => '8%',
                            'maintenance' => 'monthly',
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 40,
                        'metadata' => [
                            'notes' => 'Enterprise employee portal with multiple modules',
                            'users' => 500,
                            'modules' => ['hr', 'finance', 'projects', 'reports'],
                            'budget' => 120000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Online learning platform with video courses',
                            'courses' => 100,
                            'students' => 5000,
                            'features' => ['video_streaming', 'quizzes', 'certificates'],
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 180,
                        'end_days_ago' => 45,
                        'metadata' => [
                            'notes' => 'Government services portal with high security standards',
                            'daily_visitors' => 10000,
                            'services_count' => 50,
                            'satisfaction_rate' => '95%',
                        ],
                    ],
                ],
                'contact_messages' => [
                    ['name' => 'John Doe', 'email' => 'contact1@example.com', 'phone' => '+966500000005', 'message' => 'I am interested in this service.', 'status' => 'processing'],
                    ['name' => 'Jane Smith', 'email' => 'contact2@example.com', 'phone' => '+966500000006', 'message' => 'Please contact me for more details.', 'status' => 'completed'],
                ],
            ],
            [
                'slug' => 'web-development-v2',
                'price' => 3999.99,
                'price_before_discount' => 5499.99,
                'type' => 'subscription',
                'payment_type' => 'direct',
                'order' => 5,
                'category_id' => 5,
                'whatsapp_number' => null,
                'orders_count' => 25,
                'form_name_ar' => 'نموذج طلب تطوير موقع',
                'form_name_en' => 'Website Development Request Form',
                'hero' => [
                    'badge_ar' => 'الحل التقني المتكامل',
                    'badge_en' => 'Complete Technical Solution',
                    'title_ar' => 'تطوير المواقع',
                    'title_en' => 'Web Development',
                    'subtitle_ar' => 'مواقع احترافية',
                    'subtitle_en' => 'Professional Websites',
                    'description_ar' => 'نطور مواقع إلكترونية متكاملة تلبي احتياجات عملك وتواكب أحدث التقنيات',
                    'description_en' => 'We develop integrated websites that meet your business needs and keep pace with the latest technologies',
                    'watch_btn_ar' => 'شاهد موقعنا',
                    'watch_btn_en' => 'See Our Sites',
                    'explore_btn_ar' => 'مزايا التطوير',
                    'explore_btn_en' => 'Dev Features',
                    'hero_image' => $this->img('1504384308090-c894fdcc538d'),
                    'background_image' => $this->img('1498050108023-c5249f4df085'),
                ],
                'problem' => [
                    'title_ar' => 'مشاكل المواقع التقليدية',
                    'title_en' => 'Traditional Website Problems',
                    'subtitle_ar' => 'لماذا تفشل العديد من المواقع؟',
                    'subtitle_en' => 'Why Do Many Websites Fail?',
                    'items' => [
                        [
                            'icon' => 'FaExclamationTriangle',
                            'title_ar' => 'تصميم غير جذاب',
                            'title_en' => 'Unattractive Design',
                            'description_ar' => 'واجهات مستخدم قديمة لا تناسب العصر الرقمي',
                            'description_en' => 'Outdated user interfaces not suitable for the digital age',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'FaMobileAlt',
                            'title_ar' => 'عدم التوافق مع الجوال',
                            'title_en' => 'Mobile Incompatibility',
                            'description_ar' => 'مواقع لا تعمل بشكل صحيح على الهواتف الذكية',
                            'description_en' => 'Websites that don\'t work properly on smartphones',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'FaTachometerAlt',
                            'title_ar' => 'بطء الأداء',
                            'title_en' => 'Slow Performance',
                            'description_ar' => 'سرعة تحميل بطيئة تؤثر على تجربة المستخدم',
                            'description_en' => 'Slow loading speeds that affect user experience',
                            'order' => 2,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'حلولنا التقنية',
                    'title_en' => 'Our Technical Solutions',
                    'subtitle_ar' => 'مواقع متطورة تلبي جميع المتطلبات',
                    'subtitle_en' => 'Advanced Websites That Meet All Requirements',
                    'cta_text_ar' => 'طور موقعك الآن',
                    'cta_text_en' => 'Develop Your Website Now',
                    'features' => [
                        [
                            'feature_key' => 'responsive-design',
                            'icon' => 'FaDesktop',
                            'color' => 'bg-blue-600',
                            'title_ar' => 'تصميم متجاوب',
                            'title_en' => 'Responsive Design',
                            'description_ar' => 'يعمل على جميع الأجهزة والشاشات المختلفة',
                            'description_en' => 'Works on all devices and different screens',
                            'preview_image' => $this->img('1461749280684-dccba630e2f6'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'seo-optimized',
                            'icon' => 'FaSearch',
                            'color' => 'bg-green-600',
                            'title_ar' => 'تحسين لمحركات البحث',
                            'title_en' => 'SEO Optimized',
                            'description_ar' => 'بناء سليم يساعد في تصدر نتائج البحث',
                            'description_en' => 'Proper structure that helps rank in search results',
                            'preview_image' => $this->img('1504384308090-c894fdcc538d'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'fast-loading',
                            'icon' => 'FaRocket',
                            'color' => 'bg-red-500',
                            'title_ar' => 'سرعة فائقة',
                            'title_en' => 'Super Fast',
                            'description_ar' => 'تحميل سريع يحسن تجربة المستخدم وترتيب الموقع',
                            'description_en' => 'Fast loading improves user experience and site ranking',
                            'preview_image' => $this->img('1531297484001-80022131f5a1'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'secure-websites',
                            'icon' => 'FaLock',
                            'color' => 'bg-yellow-600',
                            'title_ar' => 'مواقع آمنة',
                            'title_en' => 'Secure Websites',
                            'description_ar' => 'حماية متقدمة ضد الاختراقات والهجمات',
                            'description_en' => 'Advanced protection against hacks and attacks',
                            'preview_image' => $this->img('1518770660439-4636190af475'),
                            'order' => 3,
                        ],
                        [
                            'feature_key' => 'cms-integration',
                            'icon' => 'FaCog',
                            'color' => 'bg-purple-600',
                            'title_ar' => 'أنظمة إدارة محتوى',
                            'title_en' => 'CMS Integration',
                            'description_ar' => 'سهولة إدارة المحتوى بدون خبرة برمجية',
                            'description_en' => 'Easy content management without programming experience',
                            'preview_image' => $this->img('1555066931-4365d14bab8c'),
                            'order' => 4,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1461749280684-dccba630e2f6'), 'alt_ar' => 'واجهة موقع حديث', 'alt_en' => 'Modern Website Interface', 'order' => 0],
                    ['path' => $this->img('1531297484001-80022131f5a1'), 'alt_ar' => 'تصميم موقع متجاوب', 'alt_en' => 'Responsive Website Design', 'order' => 1],
                    ['path' => $this->img('1555066931-4365d14bab8c'), 'alt_ar' => 'لوحة تحكم الموقع', 'alt_en' => 'Website Dashboard', 'order' => 2],
                ],
                'stats' => [
                    ['number' => '1000+', 'label_ar' => 'موقع تم تطويره', 'label_en' => 'Websites Developed', 'order' => 0],
                    ['number' => '99.9%', 'label_ar' => 'وقت تشغيل', 'label_en' => 'Uptime', 'order' => 1],
                    ['number' => '24/7', 'label_ar' => 'دعم فني', 'label_en' => 'Technical Support', 'order' => 2],
                    ['number' => '50%', 'label_ar' => 'توفير في التكلفة', 'label_en' => 'Cost Saving', 'order' => 3],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'فهد العنزي',
                        'name_en' => 'Fahad Al-Anzi',
                        'text_ar' => 'الموقع الذي طوروه لشركتنا زاد من مبيعاتنا عبر الإنترنت بنسبة 300%',
                        'text_en' => 'The website they developed for our company increased our online sales by 300%',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'أمل الحربي',
                        'name_en' => 'Amal Al-Harbi',
                        'text_ar' => 'فريق محترف يقدم حلولاً تقنية متكاملة مع متابعة ممتازة',
                        'text_en' => 'Professional team that provides integrated technical solutions with excellent follow-up',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                    [
                        'name_ar' => 'تركي المطيري',
                        'name_en' => 'Turki Al-Mutairi',
                        'text_ar' => 'سرعة التنفيذ وجودة العمل تفوق التوقعات، أنصح بالتعامل معهم',
                        'text_en' => 'The speed of execution and quality of work exceed expectations, I recommend dealing with them',
                        'rating' => 5,
                        'avatar' => $this->avatar(2),
                        'order' => 2,
                    ],
                    [
                        'name_ar' => 'لطيفة السبيعي',
                        'name_en' => 'Latifa Al-Subaie',
                        'text_ar' => 'لوحة التحكم سهلة الاستخدام حتى للمبتدئين في التعامل مع المواقع',
                        'text_en' => 'The control panel is easy to use even for beginners in dealing with websites',
                        'rating' => 5,
                        'avatar' => $this->avatar(3),
                        'order' => 3,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'ثقة عملائنا',
                    'testimonial_title_en' => 'Our Clients Trust',
                    'cta_title_ar' => 'طور موقعك الإلكتروني باحترافية',
                    'cta_title_en' => 'Develop Your Website Professionally',
                    'cta_subtitle_ar' => 'احصل على موقع إلكتروني يمثل عملك بأفضل صورة',
                    'cta_subtitle_en' => 'Get a website that represents your business in the best way',
                    'cta_button1_ar' => 'اطلب عرض سعر',
                    'cta_button1_en' => 'Request a Quote',
                    'cta_button2_ar' => 'استشارة مجانية',
                    'cta_button2_en' => 'Free Consultation',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Personal blog website with custom design',
                            'pages' => 10,
                            'features' => ['blog', 'contact', 'portfolio'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 20,
                        'metadata' => [
                            'notes' => 'E-commerce website for fashion products',
                            'products' => 150,
                            'progress' => '70%',
                            'technologies' => ['laravel', 'vuejs', 'mysql'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 60,
                        'end_days_ago' => 15,
                        'metadata' => [
                            'notes' => 'Corporate website for consulting company',
                            'traffic_increase' => '250%',
                            'conversion_rate' => '8%',
                            'maintenance' => 'monthly',
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 40,
                        'metadata' => [
                            'notes' => 'Enterprise employee portal with multiple modules',
                            'users' => 500,
                            'modules' => ['hr', 'finance', 'projects', 'reports'],
                            'budget' => 120000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Online learning platform with video courses',
                            'courses' => 100,
                            'students' => 5000,
                            'features' => ['video_streaming', 'quizzes', 'certificates'],
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 180,
                        'end_days_ago' => 45,
                        'metadata' => [
                            'notes' => 'Government services portal with high security standards',
                            'daily_visitors' => 10000,
                            'services_count' => 50,
                            'satisfaction_rate' => '95%',
                        ],
                    ],
                ],
                'contact_messages' => [],
            ],
            [
                'slug' => 'graphic-design',
                'price' => 1299.99,
                'price_before_discount' => 1999.99,
                'type' => 'one_time',
                'payment_type' => 'after_deal',
                'order' => 6,
                'category_id' => 6,
                'whatsapp_number' => '+966500000007',
                'orders_count' => 140,
                'form_name_ar' => 'نموذج طلب تصميم',
                'form_name_en' => 'Design Request Form',
                'hero' => [
                    'badge_ar' => 'التميز في التصميم البصري',
                    'badge_en' => 'Excellence in Visual Design',
                    'title_ar' => 'تصميم جرافيك',
                    'title_en' => 'Graphic Design',
                    'subtitle_ar' => 'إبداع بلا حدود',
                    'subtitle_en' => 'Unlimited Creativity',
                    'description_ar' => 'نحول أفكارك إلى تصميمات إبداعية تجذب الأنظار وتنقل رسالتك بفعالية',
                    'description_en' => 'We turn your ideas into creative designs that attract attention and convey your message effectively',
                    'watch_btn_ar' => 'شاهد أعمالنا',
                    'watch_btn_en' => 'See Our Work',
                    'explore_btn_ar' => 'خدمات التصميم',
                    'explore_btn_en' => 'Design Services',
                    'hero_image' => $this->img('1561070791-2526d30994b5'),
                    'background_image' => $this->img('1558655146-9f40138edfeb'),
                ],
                'problem' => [
                    'title_ar' => 'تحديات التصميم التقليدي',
                    'title_en' => 'Traditional Design Challenges',
                    'subtitle_ar' => 'لماذا تفشل الهويات البصرية؟',
                    'subtitle_en' => 'Why Do Visual Identities Fail?',
                    'items' => [
                        [
                            'icon' => 'FaPalette',
                            'title_ar' => 'تصميمات تقليدية',
                            'title_en' => 'Traditional Designs',
                            'description_ar' => 'تصميمات مكررة لا تعبر عن هوية فريدة',
                            'description_en' => 'Repeated designs that don\'t express a unique identity',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'FaClock',
                            'title_ar' => 'وقت طويل للتنفيذ',
                            'title_en' => 'Long Execution Time',
                            'description_ar' => 'فترات انتظار طويلة للحصول على التصميم النهائي',
                            'description_en' => 'Long waiting periods to get the final design',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'FaMoneyBillAlt',
                            'title_ar' => 'تكاليف غير متوقعة',
                            'title_en' => 'Unexpected Costs',
                            'description_ar' => 'تكاليف إضافية للتعديلات والتغييرات',
                            'description_en' => 'Additional costs for modifications and changes',
                            'order' => 2,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'حلولنا الإبداعية',
                    'title_en' => 'Our Creative Solutions',
                    'subtitle_ar' => 'تصميمات مبتكرة تناسب جميع الاحتياجات',
                    'subtitle_en' => 'Innovative Designs That Suit All Needs',
                    'cta_text_ar' => 'ابدأ مشروعك الإبداعي',
                    'cta_text_en' => 'Start Your Creative Project',
                    'features' => [
                        [
                            'feature_key' => 'logo-design',
                            'icon' => 'FaPaintBrush',
                            'color' => 'bg-purple-600',
                            'title_ar' => 'تصميم الشعارات',
                            'title_en' => 'Logo Design',
                            'description_ar' => 'شعارات فريدة تعبر عن هوية علامتك التجارية',
                            'description_en' => 'Unique logos that express your brand identity',
                            'preview_image' => $this->img('1572044162444-ad60f128bdea'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'brand-identity',
                            'icon' => 'FaBrush',
                            'color' => 'bg-blue-500',
                            'title_ar' => 'هوية العلامة التجارية',
                            'title_en' => 'Brand Identity',
                            'description_ar' => 'تصميم متكامل للهوية البصرية لعلامتك التجارية',
                            'description_en' => 'Comprehensive design of your brand\'s visual identity',
                            'preview_image' => $this->img('1626785774573-4b799315345d'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'social-media-design',
                            'icon' => 'FaHashtag',
                            'color' => 'bg-pink-500',
                            'title_ar' => 'تصميم وسائل التواصل',
                            'title_en' => 'Social Media Design',
                            'description_ar' => 'تصميم محتوى مخصص لجميع منصات التواصل الاجتماعي',
                            'description_en' => 'Custom content design for all social media platforms',
                            'preview_image' => $this->img('1543286386-713bdd548da4'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'print-design',
                            'icon' => 'FaPrint',
                            'color' => 'bg-yellow-600',
                            'title_ar' => 'تصميم المواد المطبوعة',
                            'title_en' => 'Print Design',
                            'description_ar' => 'تصميم الكتيبات والبروشورات والمواد الترويجية',
                            'description_en' => 'Design of brochures, flyers and promotional materials',
                            'preview_image' => $this->img('1558655146-9f40138edfeb'),
                            'order' => 3,
                        ],
                        [
                            'feature_key' => 'motion-graphics',
                            'icon' => 'FaVideo',
                            'color' => 'bg-green-600',
                            'title_ar' => 'الجرافيك المتحرك',
                            'title_en' => 'Motion Graphics',
                            'description_ar' => 'تصميم فيديوهات إبداعية للرسوم المتحركة',
                            'description_en' => 'Creative design of animated videos',
                            'preview_image' => $this->img('1561070791-2526d30994b5'),
                            'order' => 4,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1572044162444-ad60f128bdea'), 'alt_ar' => 'تصميم شعار احترافي', 'alt_en' => 'Professional Logo Design', 'order' => 0],
                    ['path' => $this->img('1626785774573-4b799315345d'), 'alt_ar' => 'تصميم هوية بصرية', 'alt_en' => 'Visual Identity Design', 'order' => 1],
                    ['path' => $this->img('1558655146-9f40138edfeb'), 'alt_ar' => 'تصميم وسائل التواصل', 'alt_en' => 'Social Media Design', 'order' => 2],
                ],
                'stats' => [
                    ['number' => '2000+', 'label_ar' => 'تصميم ناجح', 'label_en' => 'Successful Designs', 'order' => 0],
                    ['number' => '24 ساعة', 'label_ar' => 'تسليم سريع', 'label_en' => 'Fast Delivery', 'order' => 1],
                    ['number' => '100%', 'label_ar' => 'رضا العملاء', 'label_en' => 'Client Satisfaction', 'order' => 2],
                    ['number' => '3 مراجعات', 'label_ar' => 'مراجعات مجانية', 'label_en' => 'Free Revisions', 'order' => 3],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'ريم العلي',
                        'name_en' => 'Reem Al-Ali',
                        'text_ar' => 'الشعار الذي صمموه لشركتي كان سبباً رئيسياً في نجاح علامتنا التجارية',
                        'text_en' => 'The logo they designed for my company was a major reason for the success of our brand',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'عمر السفياني',
                        'name_en' => 'Omar Al-Sufyani',
                        'text_ar' => 'فريق إبداعي يفهم احتياجات العميل ويترجمها إلى تصميمات متميزة',
                        'text_en' => 'A creative team that understands customer needs and translates them into outstanding designs',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                    [
                        'name_ar' => 'نوف الخالد',
                        'name_en' => 'Nouf Al-Khaled',
                        'text_ar' => 'التصاميم التي قدموها لمنصات التواصل الاجتماعي زادت من تفاعل متابعينا بنسبة 500%',
                        'text_en' => 'The designs they provided for social media platforms increased our followers\' engagement by 500%',
                        'rating' => 5,
                        'avatar' => $this->avatar(2),
                        'order' => 2,
                    ],
                    [
                        'name_ar' => 'فيصل القحطاني',
                        'name_en' => 'Faisal Al-Qahtani',
                        'text_ar' => 'المهنية وسرعة الاستجابة والتعديلات المجانية جعلت التعامل معهم تجربة رائعة',
                        'text_en' => 'Professionalism, quick response and free revisions made dealing with them a great experience',
                        'rating' => 5,
                        'avatar' => $this->avatar(3),
                        'order' => 3,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'إبداعنا يتحدث',
                    'testimonial_title_en' => 'Our Creativity Speaks',
                    'cta_title_ar' => 'اجعل علامتك التجارية لا تُنسى',
                    'cta_title_en' => 'Make Your Brand Unforgettable',
                    'cta_subtitle_ar' => 'تصميمات إبداعية تحقق أهدافك التسويقية',
                    'cta_subtitle_en' => 'Creative designs that achieve your marketing goals',
                    'cta_button1_ar' => 'اطلب تصميمك الآن',
                    'cta_button1_en' => 'Order Your Design Now',
                    'cta_button2_ar' => 'استشارة مجانية',
                    'cta_button2_en' => 'Free Consultation',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Startup logo design with modern style',
                            'industry' => 'technology',
                            'color_preferences' => ['blue', 'white'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 5,
                        'metadata' => [
                            'notes' => 'Monthly social media design package for cafe',
                            'platforms' => ['instagram', 'facebook', 'twitter'],
                            'posts_per_month' => 30,
                            'progress' => '40%',
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 30,
                        'end_days_ago' => 5,
                        'metadata' => [
                            'notes' => 'Complete brand identity for fitness center',
                            'deliverables' => ['logo', 'business_cards', 'letterhead', 'social_media_kit'],
                            'revisions' => 2,
                            'satisfaction' => 'excellent',
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 20,
                        'metadata' => [
                            'notes' => 'Complete rebranding for established company',
                            'scope' => 'full_rebrand',
                            'team_size' => 3,
                            'budget' => 50000,
                            'deadline' => now()->addDays(15)->toDateString(),
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'Design for annual conference and exhibition',
                            'event_date' => now()->addMonths(2)->toDateString(),
                            'design_elements' => ['banners', 'brochures', 'badges', 'stage_backdrop'],
                            'expected_attendees' => 1000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 90,
                        'end_days_ago' => 30,
                        'metadata' => [
                            'notes' => 'Product packaging design for new food product line',
                            'products' => 5,
                            'market_response' => 'very_positive',
                            'sales_increase' => '200%',
                            'awards' => ['design_excellence_2024'],
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'cancelled',
                        'phase' => 'planning',
                        'start_days_ago' => 60,
                        'end_days_ago' => 45,
                        'metadata' => [
                            'notes' => 'Project cancelled due to budget constraints',
                            'cancellation_reason' => 'budget_issues',
                            'work_completed' => '20%',
                            'refund_percentage' => 80,
                        ],
                    ],
                ],
                'contact_messages' => [
                    ['name' => 'John Doe', 'email' => 'contact1@example.com', 'phone' => '+966500000007', 'message' => 'I am interested in this service.', 'status' => 'processing'],
                    ['name' => 'Jane Smith', 'email' => 'contact2@example.com', 'phone' => '+966500000008', 'message' => 'Please contact me for more details.', 'status' => 'pending'],
                ],
            ],
            [
                'slug' => 'video-production',
                'price' => 2999.99,
                'price_before_discount' => 3999.99,
                'type' => 'subscription',
                'payment_type' => 'direct',
                'order' => 7,
                'category_id' => 7,
                'whatsapp_number' => '+966500000008',
                'orders_count' => 70,
                'form_name_ar' => 'نموذج طلب إنتاج فيديو',
                'form_name_en' => 'Video Production Request Form',
                'hero' => [
                    'badge_ar' => 'صناعة المحتوى المرئي الاحترافي',
                    'badge_en' => 'Professional Video Content Production',
                    'title_ar' => 'إنتاج وتحرير الفيديو',
                    'title_en' => 'Video Production & Editing',
                    'subtitle_ar' => 'قصتك بجودة عالية',
                    'subtitle_en' => 'Your Story in High Quality',
                    'description_ar' => 'ننتج محتوى فيديو احترافي يحكي قصتك ويوصل رسالتك بأعلى جودة فنية وإبداعية',
                    'description_en' => 'We produce professional video content that tells your story and delivers your message with the highest technical and creative quality',
                    'watch_btn_ar' => 'معرض الأعمال',
                    'watch_btn_en' => 'Showreel',
                    'explore_btn_ar' => 'خدمات الإنتاج',
                    'explore_btn_en' => 'Production Services',
                    'hero_image' => $this->img('1492691527719-9d1e07e534b4'),
                    'background_image' => $this->img('1485846234645-a62644f84728'),
                ],
                'problem' => [
                    'title_ar' => 'تحديات صناعة الفيديو',
                    'title_en' => 'Video Production Challenges',
                    'subtitle_ar' => 'لماذا لا تنجح الكثير من مقاطع الفيديو؟',
                    'subtitle_en' => 'Why Do Many Videos Fail?',
                    'items' => [
                        [
                            'icon' => 'FaVideoSlash',
                            'title_ar' => 'جودة ضعيفة',
                            'title_en' => 'Poor Quality',
                            'description_ar' => 'مقاطع فيديو بجودة منخفضة لا تجذب المشاهدين',
                            'description_en' => 'Low quality videos that don\'t attract viewers',
                            'order' => 0,
                        ],
                        [
                            'icon' => 'FaUserClock',
                            'title_ar' => 'وقت إنتاج طويل',
                            'title_en' => 'Long Production Time',
                            'description_ar' => 'فترات انتظار طويلة للحصول على المنتج النهائي',
                            'description_en' => 'Long waiting periods to get the final product',
                            'order' => 1,
                        ],
                        [
                            'icon' => 'FaDollarSign',
                            'title_ar' => 'تكاليف باهظة',
                            'title_en' => 'High Costs',
                            'description_ar' => 'أسعار مرتفعة مقابل جودة غير مضمونة',
                            'description_en' => 'High prices for uncertain quality',
                            'order' => 2,
                        ],
                        [
                            'icon' => 'FaCreativeCommons',
                            'title_ar' => 'ضعف الإبداع',
                            'title_en' => 'Lack of Creativity',
                            'description_ar' => 'محتوى مكرر لا يحمل أي عناصر إبداعية مميزة',
                            'description_en' => 'Repetitive content with no distinctive creative elements',
                            'order' => 3,
                        ],
                    ],
                ],
                'solution' => [
                    'title_ar' => 'حلولنا الإبداعية',
                    'title_en' => 'Our Creative Solutions',
                    'subtitle_ar' => 'خدمات فيديو متكاملة تغطي جميع احتياجاتك',
                    'subtitle_en' => 'Integrated video services covering all your needs',
                    'cta_text_ar' => 'ابدأ مشروع الفيديو الخاص بك',
                    'cta_text_en' => 'Start Your Video Project',
                    'features' => [
                        [
                            'feature_key' => 'corporate-videos',
                            'icon' => 'FaBuilding',
                            'color' => 'bg-blue-600',
                            'title_ar' => 'فيديوهات مؤسسية',
                            'title_en' => 'Corporate Videos',
                            'description_ar' => 'فيديوهات تعرض شركتك وخدماتك بشكل احترافي',
                            'description_en' => 'Videos that showcase your company and services professionally',
                            'preview_image' => $this->img('1492691527719-9d1e07e534b4'),
                            'order' => 0,
                        ],
                        [
                            'feature_key' => 'social-media-videos',
                            'icon' => 'FaInstagram',
                            'color' => 'bg-pink-500',
                            'title_ar' => 'فيديوهات وسائل التواصل',
                            'title_en' => 'Social Media Videos',
                            'description_ar' => 'محتوى فيديو مخصص لمنصات التواصل الاجتماعي',
                            'description_en' => 'Custom video content for social media platforms',
                            'preview_image' => $this->img('1579965342575-16428a7c8881'),
                            'order' => 1,
                        ],
                        [
                            'feature_key' => 'motion-graphics',
                            'icon' => 'FaPlayCircle',
                            'color' => 'bg-green-500',
                            'title_ar' => 'الرسوم المتحركة',
                            'title_en' => 'Motion Graphics',
                            'description_ar' => 'رسوم متحركة إبداعية تناسب جميع أنواع المحتوى',
                            'description_en' => 'Creative motion graphics suitable for all types of content',
                            'preview_image' => $this->img('1500634245200-e5245c7574ef'),
                            'order' => 2,
                        ],
                        [
                            'feature_key' => 'video-editing',
                            'icon' => 'FaCut',
                            'color' => 'bg-purple-600',
                            'title_ar' => 'تعديل وتحرير الفيديو',
                            'title_en' => 'Video Editing',
                            'description_ar' => 'تحرير احترافي للمقاطع مع إضافة المؤثرات',
                            'description_en' => 'Professional editing of clips with added effects',
                            'preview_image' => $this->img('1485846234645-a62644f84728'),
                            'order' => 3,
                        ],
                        [
                            'feature_key' => 'drone-videography',
                            'icon' => 'FaDrone',
                            'color' => 'bg-yellow-600',
                            'title_ar' => 'التصوير الجوي بالدرون',
                            'title_en' => 'Drone Videography',
                            'description_ar' => 'لقطات جوية مذهلة تضيف بعداً جديداً لفيديوهاتك',
                            'description_en' => 'Stunning aerial shots that add a new dimension to your videos',
                            'preview_image' => $this->img('1551650975-87deedd944c3'),
                            'order' => 4,
                        ],
                        [
                            'feature_key' => 'live-streaming',
                            'icon' => 'FaBroadcastTower',
                            'color' => 'bg-red-500',
                            'title_ar' => 'البث المباشر',
                            'title_en' => 'Live Streaming',
                            'description_ar' => 'إنتاج وتنظيم فعاليات البث المباشر بجودة احترافية',
                            'description_en' => 'Production and organization of live streaming events with professional quality',
                            'preview_image' => $this->img('1543286386-713bdd548da4'),
                            'order' => 5,
                        ],
                    ],
                ],
                'gallery' => [
                    ['path' => $this->img('1492691527719-9d1e07e534b4'), 'alt_ar' => 'تصوير فيديو احترافي', 'alt_en' => 'Professional Video Shooting', 'order' => 0],
                    ['path' => $this->img('1485846234645-a62644f84728'), 'alt_ar' => 'تعديل الفيديو', 'alt_en' => 'Video Editing', 'order' => 1],
                    ['path' => $this->img('1500634245200-e5245c7574ef'), 'alt_ar' => 'التصوير الجوي', 'alt_en' => 'Aerial Shooting', 'order' => 2],
                    ['path' => $this->img('1579965342575-16428a7c8881'), 'alt_ar' => 'إنتاج فيديو متكامل', 'alt_en' => 'Complete Video Production', 'order' => 3],
                ],
                'stats' => [
                    ['number' => '1500+', 'label_ar' => 'فيديو منتج', 'label_en' => 'Videos Produced', 'order' => 0],
                    ['number' => '4K', 'label_ar' => 'جودة تصوير', 'label_en' => 'Shooting Quality', 'order' => 1],
                    ['number' => '95%', 'label_ar' => 'رضا العملاء', 'label_en' => 'Client Satisfaction', 'order' => 2],
                    ['number' => '48 ساعة', 'label_ar' => 'تسليم سريع', 'label_en' => 'Fast Delivery', 'order' => 3],
                    ['number' => '10M+', 'label_ar' => 'مشاهدات', 'label_en' => 'Views', 'order' => 4],
                ],
                'testimonials' => [
                    [
                        'name_ar' => 'سالم المري',
                        'name_en' => 'Salem Al-Mary',
                        'text_ar' => 'الفيديو الترويجي الذي أنتجوه لشركتنا حصد أكثر من مليون مشاهدة في أسبوع',
                        'text_en' => 'The promotional video they produced for our company garnered over one million views in a week',
                        'rating' => 5,
                        'avatar' => $this->avatar(0),
                        'order' => 0,
                    ],
                    [
                        'name_ar' => 'لمى السديري',
                        'name_en' => 'Lama Al-Sudairi',
                        'text_ar' => 'فريق إبداعي يتمتع بخبرة تقنية عالية وسرعة في التسليم',
                        'text_en' => 'A creative team with high technical expertise and fast delivery',
                        'rating' => 5,
                        'avatar' => $this->avatar(1),
                        'order' => 1,
                    ],
                    [
                        'name_ar' => 'نايف الحربي',
                        'name_en' => 'Naif Al-Harbi',
                        'text_ar' => 'الرسوم المتحركة التي صمموها لعلامتنا التجارية كانت مميزة جداً',
                        'text_en' => 'The motion graphics they designed for our brand were very distinctive',
                        'rating' => 5,
                        'avatar' => $this->avatar(2),
                        'order' => 2,
                    ],
                    [
                        'name_ar' => 'أريج القحطاني',
                        'name_en' => 'Areej Al-Qahtani',
                        'text_ar' => 'نظموا لنا فعالية بث مباشر ناجحة حضرها أكثر من 5000 شخص',
                        'text_en' => 'They organized a successful live streaming event attended by over 5,000 people',
                        'rating' => 5,
                        'avatar' => $this->avatar(3),
                        'order' => 3,
                    ],
                ],
                'cta' => [
                    'testimonial_title_ar' => 'قصص نجاح عملائنا',
                    'testimonial_title_en' => 'Our Clients Success Stories',
                    'cta_title_ar' => 'حول فكرتك إلى فيديو مذهل',
                    'cta_title_en' => 'Turn Your Idea into an Amazing Video',
                    'cta_subtitle_ar' => 'فريقنا المتخصص جاهز لتحقيق رؤيتك الإبداعية',
                    'cta_subtitle_en' => 'Our specialized team is ready to realize your creative vision',
                    'cta_button1_ar' => 'اطلب فيديو الآن',
                    'cta_button1_en' => 'Order Video Now',
                    'cta_button2_ar' => 'استشارة مجانية',
                    'cta_button2_en' => 'Free Consultation',
                ],
                'trackings' => [
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'YouTube channel intro video',
                            'duration' => '30 seconds',
                            'style' => 'modern_animated',
                            'platform' => 'youtube',
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'start_days_ago' => 10,
                        'metadata' => [
                            'notes' => 'Product demonstration video for new tech gadget',
                            'duration' => '3 minutes',
                            'shooting_days' => 2,
                            'progress' => '50%',
                            'locations' => ['studio', 'outdoor'],
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'start_days_ago' => 45,
                        'end_days_ago' => 10,
                        'metadata' => [
                            'notes' => 'Wedding highlights video with drone shots',
                            'duration' => '10 minutes',
                            'delivery_format' => ['4k_file', 'social_media_cuts'],
                            'satisfaction' => 'excellent',
                            'views' => 25000,
                        ],
                    ],
                    [
                        'user_type' => 'user',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'start_days_ago' => 30,
                        'metadata' => [
                            'notes' => 'Short documentary about local heritage',
                            'hold_reason' => 'awaiting_permissions',
                            'estimated_resume' => now()->addDays(15)->toDateString(),
                            'work_completed' => '25%',
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'in_progress',
                        'phase' => 'planning',
                        'start_days_ago' => 25,
                        'metadata' => [
                            'notes' => 'Series of corporate culture videos for internal training',
                            'episodes' => 10,
                            'episode_duration' => '5-7 minutes',
                            'progress' => '70%',
                            'team_size' => 5,
                            'budget' => 75000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'pending',
                        'phase' => 'planning',
                        'metadata' => [
                            'notes' => 'TV commercial for national campaign',
                            'duration' => '60 seconds',
                            'channels' => ['mbc', 'rotana', 'dmc'],
                            'celebrities_involved' => true,
                            'budget' => 200000,
                        ],
                    ],
                    [
                        'user_type' => 'organization',
                        'status' => 'completed',
                        'phase' => 'planning',
                        'start_days_ago' => 90,
                        'end_days_ago' => 20,
                        'metadata' => [
                            'notes' => 'Full coverage of annual conference with multi-camera setup',
                            'event_duration' => '3 days',
                            'cameras_used' => 6,
                            'deliverables' => ['highlight_video', 'full_sessions', 'interviews'],
                            'social_media_reach' => '2.5M',
                        ],
                    ],
                ],
                'contact_messages' => [
                    ['name' => 'John Doe', 'email' => 'contact1@example.com', 'phone' => '+966500000008', 'message' => 'I am interested in this service.', 'status' => 'processing'],
                    ['name' => 'Jane Smith', 'email' => 'contact2@example.com', 'phone' => '+966500000009', 'message' => 'Please contact me for more details.', 'status' => 'completed'],
                ],
            ],
        ];
    }
}
