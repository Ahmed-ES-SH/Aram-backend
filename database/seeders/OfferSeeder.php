<?php

namespace Database\Seeders;

use App\Modules\Promotion\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('offers')->truncate();

        $categories = DB::table('categories')->pluck('id')->toArray();
        $organizations = DB::table('organizations')->pluck('id')->toArray();

        // صور من Unsplash تناسب كل عرض (روابط حقيقية ومفعّلة)
        $offers = [
            [
                'title'            => 'خصم الصيف',
                'description'      => 'خصم 20% على جميع المنتجات خلال موسم الصيف.',
                'image'            => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 100,
                'discount_type'    => 'percentage',
                'discount_value'   => 20.00,
                'code'             => 'SUMMER20',
                'start_date'       => '2025-06-01',
                'end_date'         => '2025-08-31',
                'status'           => 'active',
            ],
            [
                'title'            => 'عرض العودة للمدارس',
                'description'      => 'خصم 50 جنيه على كل طلبية فوق 300 جنيه.',
                'image'            => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 200,
                'discount_type'    => 'fixed',
                'discount_value'   => 50.00,
                'code'             => 'SCHOOL50',
                'start_date'       => '2025-08-15',
                'end_date'         => '2025-09-15',
                'status'           => 'waiting',
            ],
            [
                'title'            => 'عرض الجمعة البيضاء',
                'description'      => 'خصومات تصل إلى 70% على فئات مختارة.',
                'image'            => 'https://images.unsplash.com/photo-1556742044-3c52d6e88c62?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 500,
                'discount_type'    => 'percentage',
                'discount_value'   => 70.00,
                'code'             => 'BLACK70',
                'start_date'       => '2025-11-25',
                'end_date'         => '2025-11-30',
                'status'           => 'active',
            ],
            [
                'title'            => 'عرض نهاية العام',
                'description'      => 'خصم 100 جنيه على جميع المنتجات.',
                'image'            => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 150,
                'discount_type'    => 'fixed',
                'discount_value'   => 100.00,
                'code'             => 'END100',
                'start_date'       => '2025-12-20',
                'end_date'         => '2025-12-31',
                'status'           => 'waiting',
            ],
            [
                'title'            => 'عرض رمضان',
                'description'      => 'خصم 25% على المأكولات والمشروبات.',
                'image'            => 'https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 300,
                'discount_type'    => 'percentage',
                'discount_value'   => 25.00,
                'code'             => 'RAMADAN25',
                'start_date'       => '2025-03-01',
                'end_date'         => '2025-04-15',
                'status'           => 'active',
            ],
            [
                'title'            => 'عرض عيد الحب',
                'description'      => 'خصم 40 جنيه على أي هدية.',
                'image'            => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 80,
                'discount_type'    => 'fixed',
                'discount_value'   => 40.00,
                'code'             => 'LOVE40',
                'start_date'       => '2025-02-10',
                'end_date'         => '2025-02-15',
                'status'           => 'expired',
            ],
            [
                'title'            => 'عرض الجمعة السعيدة',
                'description'      => 'خصم 15% على كل المنتجات يوم الجمعة.',
                'image'            => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 50,
                'discount_type'    => 'percentage',
                'discount_value'   => 15.00,
                'code'             => 'FRIDAY15',
                'start_date'       => '2025-09-01',
                'end_date'         => '2025-09-01',
                'status'           => 'active',
            ],
            [
                'title'            => 'عرض الشتاء',
                'description'      => 'خصم 30% على الملابس الشتوية.',
                'image'            => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 120,
                'discount_type'    => 'percentage',
                'discount_value'   => 30.00,
                'code'             => 'WINTER30',
                'start_date'       => '2025-12-01',
                'end_date'         => '2026-01-15',
                'status'           => 'waiting',
            ],
            [
                'title'            => 'عرض الشحن المجاني',
                'description'      => 'احصل على شحن مجاني للطلبات فوق 200 جنيه.',
                'image'            => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => 400,
                'discount_type'    => 'fixed',
                'discount_value'   => 0.00,
                'code'             => 'FREESHIP',
                'start_date'       => '2025-07-01',
                'end_date'         => '2025-07-31',
                'status'           => 'active',
            ],
            [
                'title'            => 'عرض VIP',
                'description'      => 'خصم خاص للأعضاء المميزين.',
                'image'            => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'number_of_uses'   => 0,
                'usage_limit'      => null,
                'discount_type'    => 'percentage',
                'discount_value'   => 10.00,
                'code'             => 'VIP10',
                'start_date'       => '2025-01-01',
                'end_date'         => '2025-12-31',
                'status'           => 'active',
            ],
        ];

        foreach ($offers as $offerData) {
            $offer = Offer::create([
                'title' => $offerData['title'],
                'description' => $offerData['description'],
                'number_of_uses' => $offerData['number_of_uses'],
                'usage_limit' => $offerData['usage_limit'],
                'discount_type' => $offerData['discount_type'],
                'discount_value' => $offerData['discount_value'],
                'image' => $offerData['image'],
                'code' => $offerData['code'],
                'start_date' => $offerData['start_date'],
                'end_date' => $offerData['end_date'],
                'status' => $offerData['status'],
                'category_id' => $categories[array_rand($categories)],
                'organization_id' => $organizations[array_rand($organizations)],
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
