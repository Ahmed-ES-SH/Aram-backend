<?php

namespace Database\Seeders;

use App\Modules\Keyword\Models\Keyword;
use App\Modules\Organization\Models\Organization;
use App\Modules\Organization\Models\OrganizationBenefit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('organizations')->truncate();
        DB::table('organization_benefits')->truncate();
        DB::table('organization_keywords')->truncate();
        DB::table('organization_categories')->truncate();
        DB::table('organization_sub_categories')->truncate();

        // Map categories and sub-categories by title to guarantee full coverage
        $categories = DB::table('categories')->pluck('id', 'title_en')->toArray();
        $subCategories = DB::table('sub_categories')->pluck('id', 'title_en')->toArray();

        $keywords = Keyword::all(['id', 'title'])->pluck('id', 'title')->toArray();

        // Verified working Unsplash photo IDs (HTTP 200) grouped by theme.
        $themeImages = [
            'health'     => ['photo-1516574187841-cb9cc2ca948b', 'photo-1586773860418-d37222d8fce3', 'photo-1559757148-5c350d0d3c56', 'photo-1582750433449-648ed127bb54'],
            'tech'       => ['photo-1519389950473-47ba0277781c', 'photo-1555066931-4365d14bab8c', 'photo-1461749280684-dccba630e2f6', 'photo-1531482615713-2afd69097998', 'photo-1555396273-367ea4eb4db5', 'photo-1551288049-bebda4e38f71', 'photo-1522071820081-009f0129c71c'],
            'travel'     => ['photo-1476514525535-07fb3b4ae5f1', 'photo-1469854523086-cc02fe5d8800', 'photo-1488646953014-85cb44e25828', 'photo-1503454537195-1dcabb73ffb9', 'photo-1529139574466-a303027c1d8b'],
            'food'       => ['photo-1546069901-ba9599a7e63c', 'photo-1555939594-58d7cb561ad1', 'photo-1490645935967-10de6ba17061', 'photo-1469334031218-e382a71b716b', 'photo-1515003197210-e0cd71810b5f', 'photo-1517245386807-bb43f82c33c4'],
            'sports'     => ['photo-1521575107034-e0fa0b594529', 'photo-1524594152303-9fd13543fe6e', 'photo-1571019613454-1cb2f99b2d8b', 'photo-1526628953301-3e589a6a8b74'],
            'science'    => ['photo-1503676260728-1c00da094a0b', 'photo-1535139262971-c51845709a48', 'photo-1563986768609-322da13575f3'],
            'finance'    => ['photo-1542831371-29b0f74f9713', 'photo-1460925895917-afdab827c52f', 'photo-1556745757-8d76bdb6984b'],
            'environment'=> ['photo-1504384308090-c894fdcc538d', 'photo-1551076805-e1869033e561'],
            'education'  => ['photo-1524178232363-1fb2b075b655', 'photo-1523240795612-9a054b0db644', 'photo-1522202176988-66273c2fd55f', 'photo-1503676260728-1c00da094a0b'],
            'art'        => ['photo-1542393545-10f5cde2c810', 'photo-1551632811-561732d1e306', 'photo-1531482615713-2afd69097998'],
            'business'   => ['photo-1556745757-8d76bdb6984b', 'photo-1555396273-367ea4eb4db5', 'photo-1551288049-bebda4e38f71', 'photo-1521791136064-7986c2920216'],
            'fashion'    => ['photo-1483985988355-763728e1935b', 'photo-1436262513933-a0b06755c784'],
            'media'      => ['photo-1477346611705-65d1883cee1e', 'photo-1519345182560-3f2917c472ef', 'photo-1516321497487-e288fb19713f'],
            'political'  => ['photo-1573164713988-8665fc963095', 'photo-1545324418-cc1a3fa10c00'],
            'history'    => ['photo-1464822759023-fed622ff2c3b', 'photo-1579684385127-1ef15d508118'],
            'culture'    => ['photo-1521791136064-7986c2920216', 'photo-1464822759023-fed622ff2c3b', 'photo-1494390248081-4e521a5940db'],
        ];

        // Verified working Unsplash photo IDs used for logos / avatars
        $logoImages = [
            'photo-1560472354-b33ff0c44a43',
            'photo-1565688534245-05d6b5be184a',
            'photo-1565106430482-8f6e74349ca1',
            'photo-1517248135467-4c7edcad34c4',
            'photo-1559839734-2b71ea197ec2',
            'photo-1567521464027-f127ff144326',
            'photo-1607082348824-0a96f2a4b9da',
            'photo-1542393545-10f5cde2c810',
            'photo-1551632811-561732d1e306',
            'photo-1552083375-1447ce886485',
            'photo-1521791136064-7986c2920216',
            'photo-1531482615713-2afd69097998',
            'photo-1517245386807-bb43f82c33c4',
            'photo-1555396273-367ea4eb4db5',
            'photo-1469854523086-cc02fe5d8800',
            'photo-1504674900247-0877df9cc836',
            'photo-1568901346375-23c9450c58cd',
            'photo-1573164713988-8665fc963095',
        ];

        $imageUrl = fn ($id, $w = 1200, $h = null) => 'https://images.unsplash.com/' . $id
            . '?auto=format&fit=crop&w=' . $w . ($h ? '&h=' . $h : '') . '&q=80';

        // Realistic organizations anchored in Egypt, covering every main & sub category.
        $organizations = [
            [
                'title' => 'Nile Valley Medical Center',
                'description' => 'A leading multi-specialty medical center in downtown Cairo offering outpatient clinics, diagnostics, and long-term disease management with a board of certified specialists.',
                'city' => 'Cairo', 'district' => 'Downtown', 'street' => '21 El Kasr El Aini St',
                'lat' => 30.0444, 'lng' => 31.2357,
                'categories' => ['Health'],
                'theme' => 'health',
                'keywords' => ['Medical Consultation', 'General Practitioner', 'Symptom Assessment', 'Chronic Disease Management'],
            ],
            [
                'title' => 'ModernTech Innovation Hub',
                'description' => 'A technology development center and co-working community focused on web and mobile engineering, UX design, and digital product incubation for startups and enterprises.',
                'city' => 'New Cairo', 'district' => 'Fifth Settlement', 'street' => '90th St, North Investors Building',
                'lat' => 30.0250, 'lng' => 31.4700,
                'categories' => ['Technology', 'Modern Technology'],
                'theme' => 'tech',
                'keywords' => ['Web Development', 'Mobile App Development', 'UX/UI Design', 'SEO', 'Data Analysis'],
            ],
            [
                'title' => 'Pharaonic Tours Egypt',
                'description' => 'A premium travel agency specializing in curated tours across Egypt, blending history, culture, and adventure with licensed multilingual guides and comfortable transport.',
                'city' => 'Giza', 'district' => 'Haram', 'street' => '45 Pyramids Road',
                'lat' => 29.9941, 'lng' => 31.1448,
                'categories' => ['Travel', 'History', 'Culture'],
                'theme' => 'travel',
                'keywords' => ['Translation', 'Localization', 'Data Entry'],
            ],
            [
                'title' => 'Golden Spoon Fine Dining',
                'description' => 'An award-winning fine dining restaurant in Zamalek serving contemporary Egyptian and Mediterranean cuisine, with private dining options and an in-house pastry lab.',
                'city' => 'Cairo', 'district' => 'Zamalek', 'street' => '12 Brazil St',
                'lat' => 30.0626, 'lng' => 31.2167,
                'categories' => ['Food'],
                'theme' => 'food',
                'keywords' => ['Copywriting', 'Content Marketing'],
            ],
            [
                'title' => 'El-Masry Sports Academy',
                'description' => 'A professional training academy offering football, swimming, and athletics programs for all ages, with certified coaches, modern courts, and wellness recovery facilities.',
                'city' => 'Alexandria', 'district' => 'Sidi Gaber', 'street' => '8 Emad El Din St',
                'lat' => 31.2180, 'lng' => 29.9395,
                'categories' => ['Sports'],
                'theme' => 'sports',
                'keywords' => ['Training and Development', 'Data Analysis'],
            ],
            [
                'title' => 'Arab Science Research Institute',
                'description' => 'A research institution headquartered in Upper Egypt conducting interdisciplinary studies in applied sciences, with analytical laboratories and academic partnerships.',
                'city' => 'Asyut', 'district' => 'El Walideya', 'street' => '2 University Street',
                'lat' => 27.1809, 'lng' => 31.1837,
                'categories' => ['Science'],
                'theme' => 'science',
                'keywords' => ['Data Analysis', 'Statistical Analysis', 'Machine Learning Models'],
            ],
            [
                'title' => 'Nile Bank Financial Services',
                'description' => 'A full-service financial institution offering retail and corporate banking, investment advisory, and treasury solutions with a secure digital banking platform.',
                'city' => 'Cairo', 'district' => 'Nasr City', 'street' => '34 Abbas El Akkad St',
                'lat' => 30.0638, 'lng' => 31.3234,
                'categories' => ['Finance', 'Economics'],
                'theme' => 'finance',
                'keywords' => ['Financial Analysis', 'Bookkeeping', 'Business Intelligence'],
            ],
            [
                'title' => 'Green Future Environmental Center',
                'description' => 'A sustainability center dedicated to renewable energy adoption, waste reduction, and community awareness programs across the Nile Delta, supported by certified engineers.',
                'city' => 'Tanta', 'district' => 'El Gharbia', 'street' => '15 El Geish St',
                'lat' => 30.7885, 'lng' => 31.0000,
                'categories' => ['Environment'],
                'theme' => 'environment',
                'keywords' => ['Data Visualization', 'ETL Pipelines'],
            ],
            [
                'title' => 'Delta Educational Academy',
                'description' => 'An accredited learning institute offering preparatory and secondary education with STEM track programs, language enrichment, and individualized learning plans.',
                'city' => 'Mansoura', 'district' => 'El Mowza', 'street' => '9 Gomhoreya St',
                'lat' => 31.0409, 'lng' => 31.3785,
                'categories' => ['Education'],
                'theme' => 'education',
                'keywords' => ['E-learning', 'Online Tutoring', 'Interactive Lessons', 'Curriculum Development'],
            ],
            [
                'title' => 'Cairo Art & Design Studio',
                'description' => 'A contemporary art studio and gallery in Zamalek hosting exhibitions, commissioned paintings, and private workshops for emerging and established artists.',
                'city' => 'Cairo', 'district' => 'Zamalek', 'street' => '6 El Mansour Mohamed St',
                'lat' => 30.0580, 'lng' => 31.2240,
                'categories' => ['Art'],
                'theme' => 'art',
                'keywords' => ['Illustration', 'Logo Design', 'Creative Writing'],
            ],
            [
                'title' => 'Alexandria Business Consultancy',
                'description' => 'A management and strategy consultancy supporting SMEs with market research, operational optimization, feasibility studies, and access to funding networks.',
                'city' => 'Alexandria', 'district' => 'Smouha', 'street' => '77 El Nasr St',
                'lat' => 31.2210, 'lng' => 29.9690,
                'categories' => ['Business', 'Economics'],
                'theme' => 'business',
                'keywords' => ['Business Plan', 'Feasibility Study', 'Market Analysis', 'Project Management'],
            ],
            [
                'title' => 'Fashion House of Cairo',
                'description' => 'A fashion design house crafting limited-edition ready-to-wear collections from premium ethically sourced fabrics, with personal styling and made-to-order services.',
                'city' => 'Cairo', 'district' => 'Maadi', 'street' => '26 Rd 9',
                'lat' => 29.9658, 'lng' => 31.2575,
                'categories' => ['Fashion'],
                'theme' => 'fashion',
                'keywords' => ['Logo Design', 'Product Design', 'Copywriting'],
            ],
            [
                'title' => 'MediaPro Production House',
                'description' => 'An integrated media production company offering film, video, and broadcast services with in-house studios, cinematography teams, and post-production editing.',
                'city' => 'Giza', 'district' => 'Mohandessin', 'street' => '31 Syria St',
                'lat' => 30.0550, 'lng' => 31.2070,
                'categories' => ['Media'],
                'theme' => 'media',
                'keywords' => ['Video Editing', 'Voice Over', 'Sound Mixing', 'Podcast Editing'],
            ],
            [
                'title' => 'Modern Marketing Solutions',
                'description' => 'A full-funnel digital marketing agency delivering data-driven campaigns, creative production, content marketing, and performance analytics for regional brands.',
                'city' => 'Cairo', 'district' => 'Nasr City', 'street' => '60 Abbas El Akkad St',
                'lat' => 30.0570, 'lng' => 31.3172,
                'categories' => ['Marketing'],
                'theme' => 'business',
                'keywords' => ['Digital Marketing', 'Marketing Strategy', 'Facebook Ads', 'Google Ads', 'SEO', 'Email Marketing'],
            ],
            [
                'title' => 'Political Insight Research Center',
                'description' => 'A non-partisan policy research center producing data-driven analysis, public opinion studies, and expert briefings for decision makers and the media.',
                'city' => 'Cairo', 'district' => 'Zamalek', 'street' => '18 Abu El Feda St',
                'lat' => 30.0610, 'lng' => 31.2200,
                'categories' => ['Political Analysis'],
                'theme' => 'political',
                'keywords' => ['Data Analysis', 'Statistical Analysis', 'Predictive Analytics', 'Copywriting'],
            ],
            [
                'title' => 'Advanced Technology Laboratories',
                'description' => 'An applied research and engineering lab developing IoT, embedded systems, and AI prototypes in partnership with universities on the industrial city belt.',
                'city' => '10th of Ramadan', 'district' => 'Industrial Zone B',
                'street' => '3 Factories District',
                'lat' => 30.3095, 'lng' => 31.7402,
                'categories' => ['Modern Technology', 'Technology', 'Science'],
                'theme' => 'tech',
                'keywords' => ['Machine Learning Models', 'Python Data Analysis', '3D Modeling', 'Product Design'],
            ],
            [
                'title' => 'Medical Excellence Clinic',
                'description' => 'A patient-centered outpatient clinic in Sheikh Zayed offering internal medicine, dermatology, nutrition counseling, and preventive care programs.',
                'city' => 'Giza', 'district' => 'Sheikh Zayed', 'street' => '14 El Hadaba El Wosta',
                'lat' => 30.0561, 'lng' => 30.9694,
                'categories' => ['Health'],
                'theme' => 'health',
                'keywords' => ['Medical Consultation', 'Internal Medicine', 'Dermatology Advice', 'Nutrition Advice', 'Preventive Medicine'],
            ],
            [
                'title' => 'Entrepreneurs Growth Hub',
                'description' => 'A business incubation space providing mentorship, co-working, workshops, and seed-funding connections for early-stage Egyptian startups.',
                'city' => 'New Cairo', 'district' => 'Sun City', 'street' => '48 Ring Road Extension',
                'lat' => 30.0120, 'lng' => 31.4490,
                'categories' => ['Business', 'Economics'],
                'theme' => 'business',
                'keywords' => ['Business Plan', 'Feasibility Study', 'Market Analysis'],
            ],
            [
                'title' => 'Environmental Protection Council',
                'description' => 'An NGO promoting environmental stewardship in the Suez Canal region through cleanups, green infrastructure projects, and public educational campaigns.',
                'city' => 'Ismailia', 'district' => 'El Salam', 'street' => '11 Suez Canal St',
                'lat' => 30.5965, 'lng' => 32.2715,
                'categories' => ['Environment', 'Science'],
                'theme' => 'environment',
                'keywords' => ['Data Visualization', 'ETL Pipelines'],
            ],
            [
                'title' => 'Smart Learning Center',
                'description' => 'A modern educational center combining classroom tuition with coding bootcamps, robotics clubs, and digital skills workshops for students of all ages.',
                'city' => 'Zagazig', 'district' => 'El Bostan', 'street' => '22 El Kawmeya St',
                'lat' => 30.5877, 'lng' => 31.5020,
                'categories' => ['Education', 'Technology'],
                'theme' => 'education',
                'keywords' => ['Teaching Coding', 'E-learning', 'Interactive Lessons', 'Online Tutoring'],
            ],
            [
                'title' => 'Fitness First Athletic Club',
                'description' => 'A modern fitness and wellness club offering strength training, group classes, physiotherapy guidance, and structured nutrition plans in Port Said.',
                'city' => 'Port Said', 'district' => 'El Sharq', 'street' => '5 23rd of December St',
                'lat' => 31.2653, 'lng' => 32.3019,
                'categories' => ['Sports', 'Health'],
                'theme' => 'sports',
                'keywords' => ['Training and Development', 'Nutrition Advice', 'Mental Health Support'],
            ],
            [
                'title' => 'Sphinx History Museum',
                'description' => 'A historical museum and cultural venue preserving Pharaonic artifacts, hosting expert-led tours, and running conservation education programs with universities.',
                'city' => 'Giza', 'district' => 'El Remaya', 'street' => '1 Pyramids Plateau Rd',
                'lat' => 29.9861, 'lng' => 31.1318,
                'categories' => ['History', 'Culture'],
                'theme' => 'history',
                'keywords' => ['Creative Writing', 'Copywriting'],
            ],
            [
                'title' => 'Red Sea Diving Center',
                'description' => 'A PADI-certified diving and water-sports center in Hurghada offering courses, guided reef trips, and underwater photography packages along the Red Sea coast.',
                'city' => 'Hurghada', 'district' => 'Sheraton Road', 'street' => '9 Villages Rd',
                'lat' => 27.2579, 'lng' => 33.8116,
                'categories' => ['Travel', 'Sports'],
                'theme' => 'travel',
                'keywords' => ['Video Editing', 'Photography'],
            ],
            [
                'title' => 'Nile Gourmet Catering',
                'description' => 'A corporate and events catering company delivering chef-crafted menus, full-service banquet management, and creative culinary experiences across Cairo.',
                'city' => 'Cairo', 'district' => 'Heliopolis', 'street' => '16 El Obour Buildings',
                'lat' => 30.0900, 'lng' => 31.3290,
                'categories' => ['Food', 'Business'],
                'theme' => 'food',
                'keywords' => ['Copywriting', 'Content Marketing'],
            ],
            [
                'title' => 'Modern Finance Advisory',
                'description' => 'An independent financial advisory firm delivering wealth planning, corporate restructuring, and risk management with transparent and fee-based advice.',
                'city' => 'Alexandria', 'district' => 'El Azarita', 'street' => '30 El Sultan Hussein St',
                'lat' => 31.1970, 'lng' => 29.9070,
                'categories' => ['Finance', 'Economics'],
                'theme' => 'finance',
                'keywords' => ['Financial Analysis', 'Bookkeeping', 'Business Intelligence', 'Statistical Analysis'],
            ],
            [
                'title' => 'Sustainable Fashion Atelier',
                'description' => 'An eco-conscious fashion atelier producing zero-waste garments from upcycled and organic textiles, with workshops on regenerative fashion design.',
                'city' => 'Cairo', 'district' => 'Dokki', 'street' => '44 Mosadak St',
                'lat' => 30.0375, 'lng' => 31.2090,
                'categories' => ['Fashion', 'Environment'],
                'theme' => 'fashion',
                'keywords' => ['Product Design', 'Logo Design'],
            ],
            [
                'title' => 'Digital Branding Studio',
                'description' => 'A branding and visual identity studio crafting logos, packaging, and full brand systems for startups, combining strategy with playful design execution.',
                'city' => 'Cairo', 'district' => 'Garden City', 'street' => '3 El Saray St',
                'lat' => 30.0330, 'lng' => 31.2280,
                'categories' => ['Marketing', 'Art'],
                'theme' => 'art',
                'keywords' => ['Logo Design', 'Illustration', 'Brand Building'],
            ],
            [
                'title' => 'National News & Analysis Network',
                'description' => 'A newsroom and analysis platform delivering verified reporting, live broadcast, and data-driven coverage across political and economic beats.',
                'city' => 'Cairo', 'district' => '6th of October', 'street' => '28 El Mehwar St',
                'lat' => 29.9440, 'lng' => 30.9180,
                'categories' => ['Media', 'Political Analysis'],
                'theme' => 'media',
                'keywords' => ['Copywriting', 'Video Editing', 'Voice Over'],
            ],
            [
                'title' => 'National Science Symposium Center',
                'description' => 'A conference and outreach center hosting national research symposia, student science fairs, and hands-on laboratory experimentation days for schools.',
                'city' => 'Minya', 'district' => 'El Minya University St',
                'street' => '1 Camels Market Rd',
                'lat' => 28.1099, 'lng' => 30.7503,
                'categories' => ['Science', 'Education'],
                'theme' => 'science',
                'keywords' => ['Online Tutoring', 'Curriculum Development'],
            ],
            [
                'title' => 'Arabic Culture Institute',
                'description' => 'An institute dedicated to Arabic heritage and arts, offering language classes, traditional craft workshops, theater programs, and cultural documentation.',
                'city' => 'Luxor', 'district' => 'El Karnak', 'street' => '7 Karnak Temple Rd',
                'lat' => 25.7200, 'lng' => 32.6580,
                'categories' => ['Culture', 'Education', 'Art'],
                'theme' => 'culture',
                'keywords' => ['Translation', 'Localization', 'Creative Writing'],
            ],
            [
                'title' => 'Corporate Strategy Partners',
                'description' => 'A strategy consulting firm advising enterprises on market entry, digital transformation, and organizational redesign with benchmarked research.',
                'city' => 'Cairo', 'district' => 'Sheraton', 'street' => '10 El Tayaran St',
                'lat' => 30.0730, 'lng' => 31.3400,
                'categories' => ['Business'],
                'theme' => 'business',
                'keywords' => ['Business Plan', 'Feasibility Study', 'Market Analysis', 'Project Management', 'HR Management'],
            ],
            [
                'title' => 'Future Fintech Center',
                'description' => 'A fintech innovation hub combining financial services with engineering labs, accelerating digital payments, lending, and open-banking products.',
                'city' => 'Giza', 'district' => 'Smart Village', 'street' => 'KM 28 Cairo-Alex Desert Rd',
                'lat' => 30.0650, 'lng' => 30.9520,
                'categories' => ['Modern Technology', 'Finance', 'Technology'],
                'theme' => 'tech',
                'keywords' => ['Mobile App Development', 'Data Analysis', 'Machine Learning Models', 'Web Development'],
            ],
            [
                'title' => 'Family Health & Wellness Center',
                'description' => 'An integrated wellness center offering family medicine, pediatric care, mental health counseling, and lifestyle coaching in Aswan.',
                'city' => 'Aswan', 'district' => 'El Corniche', 'street' => '23 Nile Corniche',
                'lat' => 24.0889, 'lng' => 32.8998,
                'categories' => ['Health'],
                'theme' => 'health',
                'keywords' => ['Pediatric Consultation', 'Psychological Counseling', 'Mental Health Support', 'Nutrition Advice'],
            ],
            [
                'title' => 'Culinary Arts Academy',
                'description' => 'A professional cooking school offering chef diplomas, pastry certifications, and short workshops blending international technique with Egyptian flavors.',
                'city' => 'Alexandria', 'district' => 'San Stefano', 'street' => '4 El Geish Rd',
                'lat' => 31.2400, 'lng' => 29.9520,
                'categories' => ['Food', 'Education'],
                'theme' => 'food',
                'keywords' => ['E-learning', 'Online Tutoring', 'Interactive Lessons'],
            ],
            [
                'title' => 'Legacy Travel & Landmarks',
                'description' => 'A destination management company designing luxury heritage itineraries in Luxor and Aswan, including river cruises, hot-air balloon rides, and temple tours.',
                'city' => 'Luxor', 'district' => 'El Gezira', 'street' => '15 Khalid Ibn El Walid St',
                'lat' => 25.6872, 'lng' => 32.6396,
                'categories' => ['Travel', 'History'],
                'theme' => 'travel',
                'keywords' => ['Translation', 'Localization'],
            ],
            [
                'title' => 'Data & Media Intelligence Co.',
                'description' => 'A data science and media analytics firm providing audience insights, content strategy, and visualization dashboards for broadcasters and digital platforms.',
                'city' => 'Cairo', 'district' => 'New Cairo', 'street' => '83 El Teseen St',
                'lat' => 30.0100, 'lng' => 31.4400,
                'categories' => ['Media', 'Modern Technology', 'Marketing'],
                'theme' => 'media',
                'keywords' => ['Data Analysis', 'Data Visualization', 'Predictive Analytics', 'Digital Marketing', 'Business Intelligence'],
            ],
        ];

        $benefitsByTheme = [
            'health' => [
                'Experienced board-certified medical team',
                'State-of-the-art diagnostic equipment',
                '24/7 emergency and follow-up support',
                'Transparent consultation pricing',
                'Free follow-up review after the first visit',
            ],
            'tech' => [
                'Agile delivery from idea to launch',
                'Senior engineers and designers only',
                'Ongoing maintenance and support plans',
                'Clear weekly progress reporting',
                'Flexible engagement and pricing models',
            ],
            'travel' => [
                'Expert licensed local tour guides',
                'Handpicked authentic experiences',
                'Flexible booking and free rescheduling',
                'Safe and insured transfers',
                'Multi-language customer support',
            ],
            'food' => [
                'Fresh ingredients sourced daily',
                'Chef-crafted authentic recipes',
                'Reservations with instant confirmation',
                'Private dining and event spaces',
                'Live cooking and tasting experiences',
            ],
            'sports' => [
                'Professional certified coaches',
                'Modern facilities and equipment',
                'Personalized training plans',
                'Nutrition and recovery guidance',
                'Programs for all age groups',
            ],
            'science' => [
                'Research published in peer-reviewed journals',
                'Accessible public data portal',
                'Hands-on laboratory programs',
                'Collaborations with universities',
                'Public science engagement events',
            ],
            'finance' => [
                'Independent and unbiased advisory',
                'Robust risk management frameworks',
                'Transparent fee structure',
                'Secure digital banking platforms',
                'Periodic portfolio performance reviews',
            ],
            'environment' => [
                'Certified sustainability projects',
                'Community cleanup programs',
                'Adoption of green technologies',
                'Measurable carbon reduction',
                'Public awareness campaigns',
            ],
            'education' => [
                'Accredited and modern curricula',
                'Experienced professional educators',
                'Interactive small classrooms',
                'Practical skill-building tracks',
                'Scholarships for outstanding students',
            ],
            'art' => [
                'Curated gallery exhibitions',
                'Private studio workshops',
                'Artist-in-residence programs',
                'Commissioned original artwork',
                'Art consulting for collectors',
            ],
            'business' => [
                'End-to-end business consultancy',
                'Market research and feasibility studies',
                'Operational process optimization',
                'Access to investor networks',
                'Post-launch operational support',
            ],
            'fashion' => [
                'Limited-edition original designs',
                'Premium ethically sourced fabrics',
                'Personal styling consultations',
                'Sustainable production practices',
                'Worldwide delivery and returns',
            ],
            'media' => [
                'High-end production equipment',
                'In-house content studios',
                'Multi-platform distribution',
                'Editorial integrity standards',
                'Fast-turnaround delivery',
            ],
            'political' => [
                'Non-partisan evidence-based research',
                'Verified open-data sources',
                'Expert panel discussions',
                'Briefings for decision makers',
                'Public awareness publications',
            ],
            'history' => [
                'Curated museum collections',
                'Expert-led guided tours',
                'Educational preservation programs',
                'Digitized archive access',
                'Cultural exchange initiatives',
            ],
            'culture' => [
                'Immersive cultural programs',
                'Traditional arts workshops',
                'Community art festivals',
                'Language and heritage classes',
                'Multimedia cultural archives',
            ],
        ];

        $cities = ['Cairo', 'Giza', 'Alexandria', 'Hurghada', 'Luxor', 'Mansoura', 'Tanta', 'Aswan', 'Port Said', 'Zagazig'];

        foreach ($organizations as $index => $data) {
            $theme = $data['theme'];

            $randomImage = $themeImages[$theme][array_rand($themeImages[$theme])];
            $randomLogo = $logoImages[array_rand($logoImages)];

            $title = $data['title'];
            $email = Str::slug($data['title'], '_') . '_' . uniqid() . '@' . Str::slug($data['district']) . '.com';

            $keywordIds = [];
            foreach ($data['keywords'] as $keywordTitle) {
                if (isset($keywords[$keywordTitle])) {
                    $keywordIds[] = $keywords[$keywordTitle];
                }
            }

            $organization = Organization::create([
                'title' => $title,
                'description' => $data['description'],
                'email' => $email,
                'password' => Hash::make('password'),
                'location' => [
                    'address' => $data['street'] . ', ' . $data['district'] . ', ' . $data['city'] . ', Egypt',
                    'coordinates' => [
                        'lat' => $data['lat'] + (rand(-40, 40) / 1000),
                        'lng' => $data['lng'] + (rand(-40, 40) / 1000),
                    ],
                ],
                'accaptable_message' => 'We are glad to confirm your booking request. Please arrive on time and present your booking reference.',
                'unaccaptable_message' => 'Unfortunately, we cannot accept your booking at this time. Please contact us for assistance.',
                'confirmation_price' => rand(50, 300) + rand(0, 99) / 100,
                'confirmation_status' => 1,
                'phone_number' => '+20' . rand(100, 129) . rand(1000000, 9999999),
                'open_at' => rand(7, 10) . ':00:00',
                'close_at' => rand(17, 22) . ':00:00',
                'url' => 'https://' . Str::slug($data['title']) . '.example.com',
                'image' => $imageUrl($randomImage, 1200),
                'logo' => $imageUrl($randomLogo, 400, 400),
                'verification_code' => $index % 3 === 0 ? (string) rand(100000, 999999) : null,
                'email_verified' => 1,
                'email_verification_token' => null,
                'active' => 1,
                'status' => in_array($theme, ['political', 'history']) ? 'under_review' : 'published',
                'rating' => round(3.2 + (rand(0, 17) / 10), 1),
                'order' => $index + 1,
                'number_of_reservations' => rand(10, 500),
                'is_signed' => 1,
                'booking_status' => 1,
                'account_type' => 'organization',
            ]);

            $attachedCategories = array_intersect_key($categories, array_flip($data['categories']));
            $attachedSubCategories = array_intersect_key($subCategories, array_flip($data['categories']));

            if (!empty($attachedCategories)) {
                $organization->categories()->attach(array_values($attachedCategories));
            }
            if (!empty($attachedSubCategories)) {
                $organization->subCategories()->attach(array_values($attachedSubCategories));
            }

            foreach ($benefitsByTheme[$theme] as $benefit) {
                OrganizationBenefit::create([
                    'organization_id' => $organization->id,
                    'title' => $benefit,
                ]);
            }

            if (count($keywordIds) === 0) {
                $keywordIds = collect($keywords)
                    ->shuffle()
                    ->take(rand(1, 4))
                    ->toArray();
            }

            $organization->keywords()->syncWithoutDetaching($keywordIds);
        }

        // Safety check: every main and sub category must have at least one organization
        foreach ($categories as $title => $categoryId) {
            if (!$this->categoryCovered($categoryId)) {
                $this->command->warn("Category \"{$title}\" ({$categoryId}) has no organizations.");
            }
        }
        foreach ($subCategories as $title => $subCategoryId) {
            if (!$this->subCategoryCovered($subCategoryId)) {
                $this->command->warn("Sub-category \"{$title}\" ({$subCategoryId}) has no organizations.");
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $total = Organization::count();
        $this->command->info("✅ Inserted {$total} realistic organizations with verified Unsplash images and full category coverage.");
    }

    private function categoryCovered(int $categoryId): bool
    {
        return DB::table('organization_categories')->where('category_id', $categoryId)->exists();
    }

    private function subCategoryCovered(int $subCategoryId): bool
    {
        return DB::table('organization_sub_categories')->where('subcategory_id', $subCategoryId)->exists();
    }
}