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



        $this->call([
            ServicePageSeeder_1::class,
            ServicePageSeeder_2::class,
            ServicePageSeeder_3::class,
            ServicePageSeeder_4::class,
            ServicePageSeeder_5::class,
            ServicePageSeeder_6::class,
            ServicePageSeeder_7::class,
            ServicePageSeeder_8::class,
        ]);


        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
