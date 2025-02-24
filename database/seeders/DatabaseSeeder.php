<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            videoSeeder::class,
            ServiceCategorySeeder::class,
            ServicesSeeder::class,
            CardTypeCategorySeeder::class,
            OrganizationsTableSeeder::class,
            ArticalCategoriesSeeder::class,
            ArticalsSeeder::class,
            ArticleReactionsCount::class,
            OrganizationsTableSeeder::class,
            SliderSeeder::class,
            BookingListSeeder::class,
            CardSeeder::class,
            CommentsSeeder::class,
            contactMessagesSeeder::class,
            AffilliateServicesSeeder::class,
            OffersSeeder::class,
            CouponeSeeder::class,
            FinancialTransactionsSeeder::class,
            #AffiliateCardTypeSeeder::class,
            PurchaseSeeder::class,
            OrganizationReviewSeeder::class,
            CardVisitSeeder::class,
            VisitsSeeder::class,
        ]);
    }
}
