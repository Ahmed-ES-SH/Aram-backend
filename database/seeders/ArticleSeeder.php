<?php

namespace Database\Seeders;

use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Article::truncate();
        ArticleTag::truncate();

        $articles = [
            [
                'category' => 'Technology',
                'title_en' => 'The Rise of Edge Computing: Why Your Data Needs to Move Closer',
                'title_ar' => 'صعود الحوسبة الطرفية: لماذا تحتاج بياناتك إلى الانتقال إلى الأقرب',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1000&q=80',
                'views' => 18420,
                'status' => 'published',
                'content_en' => "Edge computing is reshaping the way modern applications process data. Instead of sending every byte to a distant cloud data center, organizations are now shifting computation toward the source of the data itself.\n\nFor years, cloud computing centralized storage and processing in massive data centers. While this approach offered scalability and convenience, it also introduced latency that is unacceptable for real-time systems such as autonomous vehicles, industrial sensors, and telehealth services.\n\nToday, edge nodes sitting at the network boundary handle thousands of requests per second, filtering raw telemetry and acting instantly. The result is lower bandwidth costs, improved privacy, and faster decision-making.\n\nSecurity deserves special attention. Moving computation closer to devices reduces the window in which sensitive information travels across public networks. Teams must still encrypt data in transit and at rest, but the attack surface becomes dramatically smaller.\n\nThe shift to edge computing is not about replacing the cloud. It is about creating a continuum where data flows intelligently between devices, edge gateways, and central infrastructure based on what each workload actually requires.",
                'content_ar' => "تغيّر الحوسبة الطرفية الطريقة التي تعالج بها التطبيقات الحديثة البيانات. فبدلاً من إرسال كل بايت إلى مركز بيانات بعيد في السحابة، بدأت المؤسسات في نقل المعالجة نحو مصدر البيانات نفسه.\n\nلسنوات طويلة، اعتمدت الحوسبة السحابية على تخزين البيانات ومعالجتها في مراكز بيانات ضخمة. ورغم أن هذا النهج وفّر قابلية التوسع والراحة، فإنه أدخل تأخيراً زمنياً لا يتحمله النظامية الحساسة مثل المركبات ذاتية القيادة وأجهزة الاستشعار الصناعية وخدمات الرعاية الصحية عن بُعد.\n\nاليوم تتعامل العقد الطرفية الواقعة على حافة الشبكة مع آلاف الطلبات في الثانية، وتقوم بتصفية البيانات الخام والاستجابة الفورية. والنتيجة هي انخفاض تكاليف النطاق الترددي وتحسين الخصوصية واتخاذ قرارات أسرع.\n\nالأمن يستحق اهتماماً خاصاً. فتحريك المعالجة إلى الأقرب من الأجهزة يقلل من الوقت الذي تنتقل فيه المعلومات الحساسة عبر الشبكات العامة. لا يزال يتعين على الفرق تشفير البيانات أثناء النقل وفي التخزين، لكن سطح الهجوم يصبح أصغر بشكل كبير.\n\nالانتقال إلى الحوسبة الطرفية لا يعني الاستغناء عن السحابة. بل يعني إنشاء سلسلة متصلة تتدفق فيها البيانات بذكاء بين الأجهزة والبوابات الطرفية والبنية المركزية بناءً على ما تتطلبه كل مهمة فعلياً.",
            ],
            [
                'category' => 'Health',
                'title_en' => '10 Daily Habits for a Healthier Heart',
                'title_ar' => '10 عادات يومية لقلب أكثر صحة',
                'image' => 'https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?auto=format&fit=crop&w=1000&q=80',
                'views' => 24310,
                'status' => 'published',
                'content_en' => "Cardiovascular disease remains one of the leading causes of death worldwide, yet most of its risk factors can be managed through daily routine. Small, consistent habits outperform dramatic but short-lived changes.\n\nStart your morning with movement. A brisk twenty-minute walk before breakfast improves circulation and helps regulate blood pressure. Activity accumulated throughout the day protects the heart even when it never involves formal exercise.\n\nNutrition plays an equally important role. Replacing refined carbohydrates with whole grains, increasing fiber, and limiting sodium can shift your cardiovascular risk profile within weeks. Vegetables, legumes, and fatty fish should anchor most meals.\n\nSleep is underestimated. Sleeping fewer than six hours a night is associated with a marked increase in hypertension and arrhythmia. Aim for a consistent schedule, a dark room, and no screens shortly before bed.\n\nFinally, manage stress deliberately. Chronic stress raises cortisol and inflammation, both of which damage arterial walls. Mindfulness, breathing exercises, and genuine social connection are not luxuries: they are cardioprotective medicine.",
                'content_ar' => "لا تزال أمراض القلب والأوعية الدموية أحد الأسباب الرئيسية للوفاة في العالم، ومعظم عوامل خطرها يمكن التحكم فيها عبر الروتين اليومي. فالعادات الصغيرة والمستمرة تتفوق على التغييرات الدراماتيكية قصيرة الأمد.\n\nابدأ صباحك بالحركة. فمشي عشرين دقيقة بخطى سريعة قبل الفطور يحسّن الدورة الدموية ويساعد في تنظيم ضغط الدم. والنشاط الموزّع على مدار اليوم يحمي القلب حتى لو لم يتضمن تمريناً رسمياً.\n\nيلعب الغذاء دوراً مهماً بنفس القدر. فاستبدال الكربوهيدرات المكررة بالحبوب الكاملة وزيادة الألياف والحد من الصوديوم يمكن أن يغيّر ملف المخاطر القلبية خلال أسابيع. يجب أن تكون الخضراوات والبقوليات والأسماك الدهنية أساس أغلب الوجبات.\n\nالنوم يُستهان به دوماً. فالنوم أقل من ست ساعات ليلاً يرتبط بزيادة ملحوظة في ارتفاع ضغط الدم واضطراب نظم القلب. استهدف مواعيد منتظمة وغرفة مظلمة والابتعاد عن الشاشات قبل النوم مباشرة.\n\nأخيراً، تعامل مع التوتر بوعي. فالتوتر المزمن يرفع الكورتيزول والالتهابات، وكلاهما يضر بجدران الشرايين. التأمل وتمارين التنفس والتواصل الاجتماعي الحقيقي ليست رفاهية، بل دواء واقٍ للقلب.",
            ],
            [
                'category' => 'Science',
                'title_en' => 'How CRISPR Is Rewriting the Future of Genetic Medicine',
                'title_ar' => 'كيف يعيد كريسبر كتابة مستقبل الطب الجيني',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=1000&q=80',
                'views' => 15680,
                'status' => 'published',
                'content_en' => "Gene editing has moved from science fiction to clinical reality faster than almost any technology in modern medicine. At the center of this transformation is CRISPR, a molecular scissors capable of targeting and modifying DNA with unprecedented precision.\n\nThe system originated in bacteria, where it acts as an immune defense against viruses. Researchers adapted this natural mechanism into a toolkit that can disable a faulty gene, insert a corrective sequence, or regulate gene expression on demand.\n\nInherited conditions such as sickle cell disease and beta-thalassemia have already been treated in experimental trials by editing stem cells outside the body. Early results show durable correction of symptoms, raising hope for thousands of patients worldwide.\n\nEthical questions follow scientific progress closely. Editing embryos, altering traits unrelated to disease, and the long-term consequences of permanent genetic change demand careful governance. Regulatory bodies are building frameworks that balance innovation with safety.\n\nThe promise is enormous, but so is the responsibility. Scientists, clinicians, and policymakers must move forward together, ensuring that a tool capable of rewriting life is used to heal rather than to gamble.",
                'content_ar' => "انتقل التحرير الجيني من الخيال العلمي إلى الواقع السريري أسرع من أي تقنية حديثة في الطب المعاصر. في قلب هذا التحول يقف كريسبر، وهو مقص جزيئي قادر على استهداف وتعديل الحمض النووي بدقة غير مسبوقة.\n\nنشأ النظام في البكتيريا حيث يعمل كدفاع مناعي ضد الفيروسات. ثم حوّل الباحثون هذه الآلية الطبيعية إلى مجموعة أدوات قادرة على تعطيل جين معيب، أو إدراج تسلسل تصحيحي، أو تنظيم التعبير الجيني عند الحاجة.\n\nتم بالفعل علاج أمراض وراثية مثل مرض الخلايا المنجلية والثلاسيميا في تجارب إكلينيكية عبر تعديل الخلايا الجذعية خارج الجسم. وأظهرت النتائج المبكرة تصحيحاً دائماً للأعراض، مما يبعث الأمل في آلاف المرضى حول العالم.\n\nالأسئلة الأخلاقية تتبع التقدم العلمي عن كثب. تعديل الأجنة، وتغيير السمات غير المرتبطة بالمرض، والعواقب طويلة الأمد للتغيير الوراثي الدائم، كلها تتطلب حوكمة دقيقة. وتعمل الهيئات التنظيمية على بناء أطر توازن بين الابتكار والسلامة.\n\nالوعد هائل، لكن المسؤولية أيضاً كذلك. على العلماء والأطباء وواضعي السياسات التقدم معاً، لضمان أن تُستخدم أداة قادرة على إعادة كتابة الحياة للشفاء لا للمقامرة.",
            ],
            [
                'category' => 'Economics',
                'title_en' => 'Inflation After the Storm: What the Numbers Really Tell Us',
                'title_ar' => 'التضخم بعد العاصفة: ماذا تخبرنا الأرقام حقاً',
                'image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1000&q=80',
                'views' => 20970,
                'status' => 'published',
                'content_en' => "Inflation dominated headlines for years, and while headline rates have cooled, the story behind the data is more complex than a single percentage point suggests.\n\nSupply chains that shattered during the pandemic have largely recovered, yet structural pressures remain. Energy transitions, geopolitical tensions, and labor shortages continue to push costs upward in specific sectors even as broad indices ease.\n\nWages now play a different role. As workers recovered bargaining power, nominal pay rises began filtering into service prices. Central banks watch this carefully, because the persistence of price increases often depends on how quickly expectations adjust.\n\nFor households, the experience of inflation lags the statistics. Housing and food weigh more heavily on real budgets than the average basket implies, which is why many families still feel squeezed despite a lower official rate.\n\nLooking ahead, the balance hinges on policy discipline. If inflation expectations remain anchored and productivity growth returns, economies can emerge with low unemployment and stable prices. If not, the next shock could arrive sooner than markets expect.",
                'content_ar' => "هيمن التضخم على العناوين الرئيسية لسنوات، وعلى الرغم من تراجع المعدلات العامة، فإن القصة الكامنة خلف الأرقام أكثر تعقيداً من مجرد نسبة مئوية واحدة.\n\nسلاسل الإمداد التي تحطمت أثناء الجائحة تعافت إلى حد كبير، لكن الضغوط البنيوية ما زالت قائمة. إذ يستمر تحول الطاقة والتوترات الجيوسياسية ونقص العمالة في دفع التكاليف إلى الأعلى في قطاعات محددة حتى مع هدوء المؤشرات الواسعة.\n\nتلعب الأجور الآن دوراً مختلفاً. فمع استعادة العمال قدرة تفاوضية، بدأت الزيادات الاسمية في الأجور تتسرب إلى أسعار الخدمات. تراقب البنوك المركزية ذلك بعناية، لأنَ استمرار ارتفاع الأسعار يعتمد كثيراً على سرعة تكيف التوقعات.\n\nبالنسبة للأسر، فإن تجربة التضخم تتأخر عن الإحصاءات. فالإنفاق على السكن والغذاء يثقل على الميزانيات الحقيقية أكثر من المتوسط الذي تشير إليه السلة القياسية، لذا ما زالت كثير من العائلات تشعر بضغط رغم انخفاض المعدل الرسمي.\n\nعلى المدى المقبل، يتوقف التوازن على الانضباط في السياسات. إذا بقيت توقعات التضخم مثبتة وعاد نمو الإنتاجية، يمكن أن تخرج الاقتصادات بتوظيف منخفض وأسعار مستقرة. وإذا لم يحدث ذلك، فقد يأتي الصدمة التالية أقرب مما تتوقع الأسواق.",
            ],
            [
                'category' => 'Environment',
                'title_en' => 'Reforestation That Actually Works: Lessons from Three Continents',
                'title_ar' => 'إعادة التشجير الناجحة فعلاً: دروس من ثلاث قارات',
                'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1000&q=80',
                'views' => 17850,
                'status' => 'published',
                'content_en' => "Planting trees has become a symbol of climate action, but the gap between a photo-worthy campaign and a restored ecosystem is wide. The most successful reforestation efforts treat trees as instruments of a larger ecological process.\n\nChoosing the right species is decisive. Native trees that evolved with local soils, pollinators, and rainfall patterns survive longer and support more biodiversity than fast-growing exotics. Monoculture plantations capture carbon, but they rarely restore life.\n\nCommunity ownership determines longevity. Projects in Kenya and Nepal demonstrate that when villages receive legal rights over planted forests, survival rates double within a decade. Enforcement, grazing control, and fire management are as important as planting.\n\nLandscape planning matters too. Restoring corridors between surviving patches of forest allows wildlife to move and seeds to travel. Small, scattered plantings without ecological connection often fade quietly.\n\nReal reforestation is slow, local, and long-term. The most inspiring examples on every continent share one trait: they were designed around people and ecosystems, not headlines.",
                'content_ar' => "أصبحت زراعة الأشجار رمزاً للعمل المناخي، لكن الفجوة بين حملة صالحة للتصوير ونظام بيئي مُعاد تأهيله واسعة. أنجح جهود إعادة التشجير تتعامل مع الأشجار كأدوات ضمن عملية إيكولوجية أكبر.\n\nاختيار الأنواع الصحيحة هو العامل الحاسم. فالأشجار المحلية التي نشأت مع تربة المنطقة ومجتمعات الملقحات وأنماط الأمطار تعيش أطول وتدعم تنوعاً حيوياً أكبر من الأنواع الغريبة سريعة النمو. مزارع الأحادية تلتقط الكربون لكنها نادراً ما تستعيد الحياة.\n\nالملكية المجتمعية تحدد طول العمر. تُظهر مشاريع في كينيا ونيبال أنه عندما تحصل القرى على حقوق قانونية على الغابات المزروعة، تتضاعف معدلات البقاء خلال عقد واحد. إن فرض القوانين وضبط الرعي وإدارة الحرائق لا تقل أهمية عن الزراعة نفسها.\n\nالتخطيط على مستوى المشهد الطبيعي مهم أيضاً. استعادة الممرات بين بقع الغابات المتبقية يتيح للحيوانات البرية التنقل وللبذور الانتشار. الزراعات الصغيرة المتفرقة دون اتصال إيكولوجي غالباً ما تتلاشى بهدوء.\n\nإعادة التشجير الحقيقية بطيئة ومحلية وطويلة الأمد. تشترك أكثر الأمثلة إلهاماً في كل قارة بسمة واحدة: لقد صُممت حول الناس والنظم البيئية، لا حول العناوين.",
            ],
            [
                'category' => 'Education',
                'title_en' => 'Why Project-Based Learning Outperforms Memorization',
                'title_ar' => 'لماذا يتفوق التعلم القائم على المشاريع على الحفظ',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1000&q=80',
                'views' => 12340,
                'status' => 'published',
                'content_en' => "For more than a century, classrooms have relied on lectures, notes, and standardized tests. Yet a growing body of research suggests that students retain knowledge far longer when they build something real around it.\n\nProject-based learning asks a simple question instead of giving an answer. Students investigate a problem, design a solution, test it, and present the result. Along the way they encounter friction, make mistakes, and learn from both.\n\nThis approach develops more than content knowledge. It trains collaboration, time management, and resilience, skills that machines cannot automate and that employers consistently rank first in hiring surveys.\n\nCritics argue that projects take time away from curriculum coverage. In practice, well-designed projects integrate subjects rather than replace them, and mastery of a concept demonstrated through application is more durable than recognition in a multiple-choice test.\n\nSchools that have embraced the model, from Finland to Singapore, report higher engagement and lower dropout rates. The evidence is clear: education designed around doing prepares students not just to answer questions, but to ask the right ones.",
                'content_ar' => "لأكثر من قرن، اعتمدت الفصول الدراسية على المحاضرات والملاحظات والاختبارات الموحدة. ومع ذلك تشير مجموعة متزايدة من الأبحاث إلى أن المتعلمين يحتفظون بالمعرفة لفترة أطول بكثير عندما يبنون شيئاً حقيقياً حولها.\n\nالتعلم القائم على المشاريع يطرح سؤالاً بسيطاً بدلاً من إعطاء إجابة جاهزة. يستقصي الطلاب مشكلة، ويصممون حلاً، ويختبرونه، ثم يعرضون النتيجة. في الطريق يواجهون الاحتكاك ويرتكبون الأخطاء ويتعلمون من الاثنين معاً.\n\nهذا النهج يطوّر أكثر من مجرد معرفة المحتوى. إنه يدرب التعاون وإدارة الوقت والمرونة، وهي مهارات لا يمكن للآلات أتمتتها ويضعها أصحاب العمل دائماً في صدارة استطلاعات التوظيف.\n\nيرى النقاد أن المشاريع تبتلع وقتاً كان يمكن تخصيصه لتغطية المنهج. لكن في الممارسة، المشاريع المصممة جيداً تدمج المواد بدلاً من استبدالها، وإتقان مفهوم ما من خلال التطبيق أكثر ديمومة من التعرف عليه في اختبار اختياري.\n\nالمدارس التي تبنت هذا النموذج، من فنلندا إلى سنغافورة، تبلغ عن مشاركة أعلى ومعدلات تسرب أقل. الأدلة واضحة: التعليم المصمم حول الفعل يهيئ الطلاب ليس فقط للإجابة عن الأسئلة، بل لطرح الأسئلة الصحيحة.",
            ],
            [
                'category' => 'Sports',
                'title_en' => 'The Science Behind the Runner\'s High',
                'title_ar' => 'العلم وراء نشوة العدّاء',
                'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1000&q=80',
                'views' => 8690,
                'status' => 'published',
                'content_en' => "Almost every long-distance runner has felt it: a wave of lightness, focus, and euphoria that arrives in the middle of a hard effort. Known as the runner's high, this state has fascinated both athletes and neuroscientists for decades.\n\nFor years the euphoria was attributed to endorphins, the body's natural painkillers. Recent studies painted a richer picture: endocannabinoids, signaling molecules produced by the brain, bind to the same receptors as cannabis and appear responsible for the tranquility that follows sustained exercise.\n\nThe effect is not limited to elite athletes. Moderate jogging performed regularly alters brain chemistry over time, improving mood regulation and reducing symptoms of mild anxiety and depression in randomized trials.\n\nGenetics influence who feels it most. Individuals with certain variants of the endocannabinoid receptor report stronger responses to exercise, which helps explain why some people become lifelong runners while others struggle to start.\n\nThe runner's high is a reminder that movement is medicine for the mind. Consistency matters more than intensity: the brains that benefit most are the ones that show up, week after week.",
                'content_ar' => "تقريباً كل عدّاء مسافات طويلة شعر بها: موجة من الخفة والتركيز والنشوة تصل في منتصف جهد شاق. تُعرف بنشوة العدّاء، وكانت هذه الحالة مصدر سحر للرياضيين وعلماء الأعصاب على مدى عقود.\n\nلسنوات نُسبت طلب النشوة إلى الإندورفين، مسَكّنات الألم الطبيعية في الجسم. الدراسات الحديثة رسمت صورة أغنى: الإندوكانابينويدات، وهي جزيئات إشارات ينتجها الدماغ، ترتبط بنفس المستقبلات التي يرتبط بها القنب وتُعتبر مسؤولة عن الهدوء الذي يتبع التمرين المستمر.\n\nلا يقتصر التأثير على الرياضيين النخبة. فالهرولة المعتدلة المنتظمة تغيّر كيمياء الدماغ بمرور الوقت، وتحسّن تنظيم المزاج وتقلل أعراض القلق الخفيف والاكتئاب في التجارب العشوائية.\n\nيؤثر الجينوم فيمن يشعر بها أكثر. فالأفراد الذين يحملون بعض المتغيرات في مستقبلات الإندوكانابينويد يبلّغون عن استجابات أقوى للتمرين، ما يساعد في تفسير لماذا يصبح بعض الناس عدّائين مدى الحياة بينما يعاني آخرون من البدء.\n\nنشوة العدّاء تذكير بأن الحركة دواء للعقل. الاتساق أهم من الشدة: فالدماغ الذي يستفيد أكثر هو الذي يلتزم بالحضور، أسبوعاً بعد أسبوع.",
            ],
            [
                'category' => 'Culture',
                'title_en' => 'Museums Are Reinventing Themselves for a Digital Generation',
                'title_ar' => 'المتاحف تعيد ابتكار نفسها لجيل رقمي',
                'image' => 'https://images.unsplash.com/photo-1523995462485-3d171b5c8fa9?auto=format&fit=crop&w=1000&q=80',
                'views' => 6540,
                'status' => 'published',
                'content_en' => "The museum, long seen as a quiet temple of the past, is undergoing its most dramatic transformation in a century. Audience expectations have shifted, and institutions are responding with creativity rather than resistance.\n\nDigital experiences are no longer optional extras. Augmented reality overlays bring fragments of statues to life, and immersive installations let visitors walk through reconstructed ancient streets. These tools do not replace artifacts; they deepen the story around them.\n\nAccessibility is at the heart of the change. Virtual tours, audio guides in dozens of languages, and free digital collections have opened floors that were once reserved for ticketed crowds. Museums now reach millions who may never visit the building.\n\nThey are also becoming spaces for contemporary voices. Instead of displaying a fixed narrative, curators increasingly commission artists and communities to challenge, reinterpret, and expand the collection's meaning.\n\nThe most successful transformations share one philosophy: a museum is not a warehouse of objects but a workshop of questions. Those institutions are thriving because they invite visitors to belong to the story, not just observe it.",
                'content_ar' => "المتحف، الذي ظل يُنظر إليه لفترة طويلة كمعبد هادئ للماضي، يخوض أدراماتيكية تحول منذ قرن. تحولت توقعات الجمهور، وتستجيب المؤسسات بإبداع بدلاً من المقاومة.\n\nالتجارب الرقمية لم تعد رفاهية إضافية. فطبقات الواقع المعزز تعيد الحياة إلى شظايا التماثيل، والتركيبات الغامرة تسمح للزوار بالسير في شوارع قديمة معاد بناؤها. هذه الأدوات لا تحل محل القطع الأثرية؛ إنها تعمق القصة المحيطة بها.\n\nإمكانية الوصول في قلب هذا التغيير. الجولات الافتراضية، والأدلة الصوتية بعشرات اللغات، والمجموعات الرقمية المجانية فتحت قاعات كانت محجوزة ذات يوم للجماهير المتذاكرة. المتاحف اليوم تصل إلى ملايين لا يزورون المبنى أبداً.\n\nكما أنها تتحول إلى فضاءات للأصوات المعاصرة. بدلاً من عرض سردية ثابتة، يقوم القيمون بشكل متزايد بتكليف فنانين ومجتمعات لتحدي المعنى وتفسيره وتوسيعه.\n\nأنجح التحولات تشترك في فلسفة واحدة: المتحف ليس مستودعاً للأشياء بل ورشة أسئلة. هذه المؤسسات تزدهر لأنها تدعو الزوار إلى الانتماء إلى القصة، لا مجرد مشاهدتها.",
            ],
            [
                'category' => 'Travel',
                'title_en' => 'Slow Travel: The Art of Seeing Fewer Places More Deeply',
                'title_ar' => 'السفر البطيء: فن رؤية أماكن أقل بعمق أكبر',
                'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1000&q=80',
                'views' => 14120,
                'status' => 'published',
                'content_en' => "A decade ago, the ideal trip meant cramming four cities into seven days. Today a quiet counter-movement is reshaping travel culture: staying longer, going slower, and letting a place reveal itself on its own schedule.\n\nSlow travel roots you in daily life. Morning markets, neighborhood cafés, and routines locals actually follow replace the checklist of famous landmarks. These experiences cost less, produce fewer emissions, and create memories that survive the return home.\n\nThe economic case is compelling. Travelers who stay three weeks in one region spend more per capita in local businesses than those who hop between capitals, spreading income to small shops, farms, and guides rather than international chains.\n\nIt also reduces the environmental toll of tourism. Fewer flights and shorter transfers cut carbon footprints dramatically, while dispersed visitor pressure protects fragile heritage sites from overtourism.\n\nSlow travel asks for patience, and patience rewards with depth. The traveler who returns to the same village every winter leaves not with photographs but with relationships, recipes, and a piece of belonging.",
                'content_ar' => "قبل عقد من الزمن، كانت الرحلة المثالية تعني حشر أربع مدن في سبعة أيام. اليوم يعيد تيار هادئ تشكيل ثقافة السفر: البقاء أطول، والذهاب ببطء، والسماح للمكان بأن يكشف عن نفسه وفق جدوله الخاص.\n\nالسفر البطيء يرسخك في الحياة اليومية. أسواق الصباح، ومقاهي الأحياء، والروتين الذي يمارسه السكان فعلاً تحل محل قائمة المعالم الشهيرة. هذه التجارب تكلف أقل، وتنتج انبعاثات أقل، وتخلق ذكريات تدوم بعد العودة.\n\nالحالة الاقتصادية مقنعة. فالمسافر الذي يمكث ثلاثة أسابيع في منطقة واحدة ينفق نصيباً أكبر للفرد في الأعمال المحلية ممن يتنقل بين العواصم، موزعاً الدخل على المحلات الصغيرة والمزارع والمرشدين بدلاً من السلاسل الدولية.\n\nكما يقلل من الأثر البيئي للسياحة. فعدد أقل من الرحلات الجوية والتنقلات الأقصر يخفضان البصمة الكربونية بشكل كبير، بينما يخفف توزيع الضغط على المواقع التراثية الهشة من وطأة السياحة المفرطة.\n\nالسفر البطيء يطلب صبراً، والصبر يكافئ بالعمق. المسافر الذي يعود إلى القرية نفسها كل شتاء لا يعود بصور بل بعلاقات ووصفات وقسط من الانتماء.",
            ],
            [
                'category' => 'Food',
                'title_en' => 'Fermentation: The Ancient Technique Making a Modern Comeback',
                'title_ar' => 'التخمير: التقنية القديمة تعود بقوة في العصر الحديث',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=1000&q=80',
                'views' => 9980,
                'status' => 'published',
                'content_en' => "Fermentation is one of humanity's oldest food technologies, and after decades in the shadow of industrial processing, it is returning to kitchens, restaurants, and laboratories with fresh energy.\n\nThe process is elegantly simple: microorganisms convert sugars into acids, gases, or alcohol, transforming flavor and preserving food. Yogurt, sourdough bread, kimchi, sauerkraut, and kombucha all owe their character to these living cultures.\n\nInterest has grown beyond taste. Fermented foods introduce beneficial bacteria to the gut, and research links a healthy microbiome to improved digestion, stronger immunity, and even mood regulation. Consumers increasingly treat the fridge as a source of probiotics rather than mere storage.\n\nHome fermentation democratizes food science. Anyone can transform humble vegetables into complex, shelf-stable ingredients with salt, water, and time. The craft teaches patience and observation, qualities that industrial convenience rarely encourages.\n\nChefs have embraced the technique in reverse, using controlled fermentation to invent flavors no fresh ingredient possesses. Whether in a family kitchen or a Michelin-starred dining room, fermentation reminds us that some of the best food science is very, very old.",
                'content_ar' => "التخمير واحد من أقدم تقنيات الغذاء عند البشرية، وبعد عقود في ظل المعالجة الصناعية، ها هو يعود إلى المطابخ والمطاعم والمختبرات بطاقة جديدة.\n\nالعملية بسيطة بأناقة: الكائنات الحية الدقيقة تحول السكريات إلى أحماض أو غازات أو كحول، مما يغير النكهة ويحفظ الغذاء. الزبادي، والخبز بالمقبلات، والكيمتشي، والمخلل الألماني، والكمبوتشا، كلها تدين بشخصيتها لهذه الثقافات الحية.\n\nالاهتمام تجاوز المذاق. الأطعمة المخمرة تدخل بكتيريا مفيدة للأمعاء، والأبحاث تربط البكتيريا الدقيقة الصحية بتحسين الهضم وتقوية المناعة وحتى تنظيم المزاج. المستهلكون يتعاملون مع الثلاجة اليوم كمصدر للبروبيوتيك لا مجرد مخزن.\n\nالتخمير المنزلي يضفي الصفة الديمقراطية على علم الغذاء. أي شخص يستطيع تحويل خضروات متواضعة إلى مكونات معقدة تدوم طويلاً بالملح والماء والوقت. هذه الحرفة تعلّم الصبر والملاحظة، وهما صفتان نادراً ما تشجع عليهما الراحة الصناعية.\n\nاحتضن الطهاة التقنية بالعكس، مستخدمين التخمير المتحكم فيه لابتكار نكهات لا يمتلكها أي مكون طازج. سواء في مطبخ عائلي أو قاعة طعام حائزة على نجوم ميشلان، يذكرنا التخمير بأن بعضاً من أفضل علوم الطعام قديم جداً.",
            ],
            [
                'category' => 'Business',
                'title_en' => 'How Small Businesses Win in a Digital-First Marketplace',
                'title_ar' => 'كيف تنتصر الشركات الصغيرة في سوق رقمي أولاً',
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1000&q=80',
                'views' => 11250,
                'status' => 'published',
                'content_en' => "Large e-commerce platforms command enormous budgets, yet small businesses continue to capture surprising market share. Their advantage is not scale but agility, identity, and the quality of a relationship.\n\nSpecialization beats generalization. A boutique that understands one niche deeply can outperform a department store channel by offering curated expertise, fit advice, and after-sale care that algorithms cannot replicate.\n\nDigital tools have leveled the playing field. Cloud stores, payment links, and social selling remove most of the infrastructure cost that once guarded retail. A single skilled founder can now reach customers across borders with a phone.\n\nCommunity is the small business moat. Businesses that speak their customers' language, respond to comments, and build trust through transparency convert followers into lifelong advocates far more effectively than branded ad campaigns.\n\nData still matters, but the small business version is simpler: listen, adapt, repeat. The winners in the digital-first economy are not the loudest brands; they are the ones customers feel known by.",
                'content_ar' => "تتولى منصات التجارة الإلكترونية الكبيرة ميزانيات ضخمة، ومع ذلك تواصل الشركات الصغيرة اقتناص حصة سوقية مفاجئة. ميزتها ليست الحجم بل المرونة والهوية وجودة العلاقة.\n\nالتخصص يتفوق على العمومية. متجر بوتيك يفهم تخصصاً واحداً بعمق يمكنه التفوق على قناة متجر شامل عبر تقديم خبرة منسقة ونصائح مقاس ورعاية بعد البيع لا تستطيع الخوارزميات محاكاتها.\n\nالأدوات الرقمية ساوت ميدان اللعب. المتاجر السحابية وروابط الدفع والبيع الاجتماعي أزالت معظم تكلفة البنية التحتية التي كانت تحرس تجارة التجزئة. مؤسس واحد ماهر يستطيع اليوم الوصول إلى عملاء عبر الحدود بهاتف واحد.\n\nالمجتمع هو خندق الشركات الصغيرة. الشركات التي تتحدث لغة عملائها وترد على التعليقات وتبني الثقة عبر الشفافية تحول المتابعين إلى مناصرين مدى الحياة بفعالية أكبر بكثير من حملات العلامات التجارية المعلنة.\n\nالبيانات ما زالت مهمة، لكن نسخة الشركات الصغيرة أبسط: استمع، تكيّف، كرر. الفائزون في الاقتصاد الرقمي الأول ليسوا العلامات الأعلى صوتاً؛ بل الذين يشعر العملاء أنهم معروفون لديهم.",
            ],
            [
                'category' => 'Art',
                'title_en' => 'Contemporary Art and the Meaning of Authenticity',
                'title_ar' => 'الفن المعاصر ومعنى الأصالة',
                'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?auto=format&fit=crop&w=1000&q=80',
                'views' => 5470,
                'status' => 'published',
                'content_en' => "Contemporary art has long provoked a familiar question from museum visitors: is this really art? The question itself, however, reveals an older assumption that authenticity equals skill in imitation.\n\nModern and contemporary movements deliberately dismantled that assumption. Cubism fractured perspective, abstract expressionism dissolved the object, and conceptual art removed the physical work almost entirely, leaving the idea as the artwork.\n\nThis evolution forced a redefinition of the artist's role. Today's creators are often curators of meaning: they select, frame, and present material that asks audiences to participate in the act of interpretation rather than passively receive a finished image.\n\nTechnology now challenges authenticity again. Digital exhibitions, generative tools, and artificial intelligence raise questions about authorship that museum boards and legal systems are only beginning to answer.\n\nWhat remains constant is the encounter. A powerful work, made by hand or generated by code, still holds a mirror to its moment. When it does, the visitor's question is no longer is this art, but what is this asking me to see.",
                'content_ar' => "أثار الفن المعاصر منذ زمن طويل سؤالاً مألوفاً لدى زوار المتاحف: هل هذا فن حقاً؟ لكن السؤال نفسه يكشف افتراضاً قديماً أن الأصالة تعني المهارة في المحاكاة.\n\nتعمد التيارات الحداثية والمعاصرة تفكيك هذا الافتراض. كسّر التكعيبية المنظور، وحلّت التعبيرية التجريدية موضوع العمل، وأزالت الفن المفاهيمي العمل المادي بالكامل تقريباً تاركة الفكرة كالعمل الفني.\n\nهذا التطور فرض إعادة تعريف دور الفنان. صنّاع اليوم غالباً ما يكونون منسقين للمعنى: يختارون ويؤطرون ويقدمون مادة تدعو الجمهور للمشاركة في فعل التفسير بدلاً من تلقّي صورة مكتملة بسلبية.\n\nتتحدى التكنولوجيا الأصالة الآن من جديد. المعارض الرقمية والأدوات التوليدية والذكاء الاصطناعي تثير أسئلة حول التأليف بدأت مجالس المتاحف والأنظمة القانونية للتو في الإجابة عنها.\n\nما يبقى ثابتاً هو المواجهة. فالعمل القوي، المصنوع يدوياً أو المولّد بشفرة، يظل يحمل مرآة للحظة زمنه. وعندما يفعل ذلك، لم يعد سؤال الزائر هو: هل هذا فن؟ بل: ماذا يطلب مني هذا أن أرى؟",
            ],
            [
                'category' => 'History',
                'title_en' => 'Trade Routes Before Globalization: How Silk Linked Empires',
                'title_ar' => 'طرق التجارة قبل العولمة: كيف ربط الحرير الإمبراطوريات',
                'image' => 'https://images.unsplash.com/photo-1558642084-fd07fae5282e?auto=format&fit=crop&w=1000&q=80',
                'views' => 16330,
                'status' => 'published',
                'content_en' => "Long before container ships and instant messaging, an intricate network of roads, sea lanes, and caravanserais carried goods, ideas, and faiths across Asia. Historians now view this system as the first true globalization.\n\nThe Silk Road was not a single road but a web of routes stretching from Chinese capitals to the Mediterranean. Silk traveled west, while glass, horses, and gold traveled east, yet the most consequential cargo was information.\n\nReligions spread along these corridors, from Buddhism reaching China through Central Asia to innovations such as papermaking, printing, and the compass migrating westward centuries before European exploration accelerated.\n\nCities like Samarkand, Palmyra, and Baghdad flourished as points where merchants, diplomats, and scholars exchanged not only goods but manuscripts and measuring instruments.\n\nWhat the network teaches us is that connection has always reshaped civilization. The willingness to trade across cultures did not merely enrich empires; it created the intellectual foundations on which the modern world was eventually built.",
                'content_ar' => "قبل سفن الحاويات والمراسلة الفورية بوقت طويل، حملت شبكة معقدة من الطرق والمعابر البحرية وخانات القوافل البضائع والأفكار والأديان عبر آسيا. يعتبرها المؤرخون اليوم أول عولمة حقيقية.\n\nلم يكن طريق الحرير طريقاً واحداً بل شبكة طرق تمتد من العواصم الصينية إلى البحر المتوسط. انتقل الحرير غرباً، بينما انتقلت الزجاج والخيول والذهب شرقاً، لكن الشحنة الأكثر تأثيراً كانت المعلومات.\n\nانتشرت الأديان على هذه الممرات، من وصول البوذية إلى الصين عبر آسيا الوسطى، إلى ابتكارات مثل صناعة الورق والطباعة والبوصلة التي هاجرت غرباً قبل قرون من تسارع الاستكشاف الأوروبي.\n\nازدهرت مدن مثل سمرقند وتدمر وبغداد كنقاط تبادل فيها التجار والدبلوماسيون والعلماء البضائع والمخطوطات وأدوات القياس على حد سواء.\n\nما تعلمنا إياه هذه الشبكة هو أن التواصل أعاد تشكيل الحضارة دائماً. فالتجارة عبر الثقافات لم تُغنِ الإمبراطوريات فحسب؛ بل خلقت الأسس الفكرية التي بُنيت عليها لاحقاً العالم الحديث.",
            ],
            [
                'category' => 'Finance',
                'title_en' => 'The Hidden Costs of Consumer Credit and How to Avoid Them',
                'title_ar' => 'التكاليف الخفية للائتمان الاستهلاكي وكيفية تجنبها',
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1000&q=80',
                'views' => 18900,
                'status' => 'published',
                'content_en' => "Credit cards, installment plans, and buy-now-pay-later schemes have made purchasing effortless, but the convenience conceals a structure designed to make the long-term cost far exceed the sticker price.\n\nThe most dangerous element is compound interest. A modest balance carried month to month grows quickly because interest is charged on unpaid interest. At common annual rates, a balance can double in fewer than five years without a single new purchase.\n\nLate fees and penalties compound the problem. One missed payment can raise the interest rate on an entire account, retroactively. Consumers who think a single slip is harmless often discover the true cost months later.\n\nBehavioral traps matter as much as mathematics. Payment plans lengthen if minimum payments are chosen, and psychological studies show that splitting a purchase into small installments makes people spend more overall.\n\nThe protection is discipline: pay balances in full, treat credit as a tool rather than income, and build an emergency fund that removes the need to borrow for surprises. Understanding the cost structure is the first step to refusing it.",
                'content_ar' => "جعلت البطاقات الائتمانية وخطط التقسيط وأنظمة اشترِ الآن وادفع لاحقاً عملية الشراء بلا جهد، لكن الراحة تخفي بنية مصممة ليجعل التكلفة طويلة الأمد تتجاوز بكثير السعر المعلن.\n\nالعنصر الأكثر خطورة هو الفائدة المركبة. فالرصيد المتواضع المتنقل من شهر لآخر ينمو بسرعة لأن الفائدة تُحتسب على فوائد غير مسددة. وبمعدلات سنوية شائعة، يمكن أن يتضاعف الرصيد في أقل من خمس سنوات دون عملية شراء واحدة جديدة.\n\nالرسوم المتأخرة والغرامات تضاعف المشكلة. دفعة واحدة مفقودة يمكن أن ترفع سعر الفائدة على الحساب بالكامل وبأثر رجعي. المستهلكون الذين يعتقدون أن زلة واحدة غير ضارة يكتشفون غالباً التكلفة الحقيقية بعد أشهر.\n\nالمكائد السلوكية لا تقل أهمية عن الرياضيات. خطط السداد تطول إذا اختيرت الدفعات الدنيا، وتظهر الدراسات النفسية أن تقسيم الشراء إلى أقساط صغيرة يجعل الناس ينفقون أكثر إجمالاً.\n\nالحماية هي الانضباط: سدد الأرصدة بالكامل، وعامل الائتمان كأداة لا كدخل، وابنِ صندوقاً للطوارئ يلغي الحاجة إلى الاقتراض للصدمات. فهم هيكل التكلفة هو الخطوة الأولى لرفضها.",
            ],
            [
                'category' => 'Fashion',
                'title_en' => 'The Environmental Cost of Fast Fashion and the Rise of Circularity',
                'title_ar' => 'الكلفة البيئية للأزياء السريعة وصعود الاقتصاد الدائري',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1000&q=80',
                'views' => 10760,
                'status' => 'published',
                'content_en' => "Fast fashion transformed the industry with low prices and rapid trend turnover, but the true invoice arrives as water pollution, textile waste, and an environmental footprint that rivals aviation.\n\nThe numbers are startling. The sector consumes billions of cubic meters of water annually, while synthetic fibers shed microplastics into oceans with every wash. A single t-shirt can carry a carbon footprint comparable to driving tens of kilometers.\n\nConsumer behavior is shifting in response. Resale platforms have grown into multi-billion-dollar markets, and repair culture is being rediscovered. Buying secondhand, renting, and mending extend garment life and reduce demand for virgin production.\n\nBrands are answering with circularity. Recycled fibers, take-back programs, and garment-to-garment recycling plants signal an industry attempting to close the loop, though critics point out that true circularity remains rare.\n\nChange ultimately depends on the shopper. Clothing kept in use twice as long halves its environmental impact. Durability, versatility, and care, rather than quantity, are the new luxury.",
                'content_ar' => "غيّرت الأزياء السريعة الصناعة بأسعار منخفضة وسرعة في تناوب الصيحات، لكن الفاتورة الحقيقية تصل على شكل تلوث الماء وهدر المنسوجات وبصمة بيئية تنافس الطيران.\n\nالأرقام مذهلة. يستهلك القطاع مليارات الأمتار المكعبة من المياه سنوياً، بينما تُطلق الألياف الصناعية جزيئات بلاستيكية دقيقة إلى المحيطات مع كل غسلة. قميص واحد يمكن أن يحمل بصمة كربونية تعادل القيادة لعشرات الكيلومترات.\n\nيتحول سلوك المستهلك استجابة لذلك. نمت منصات إعادة البيع إلى أسواق بمليارات الدولارات، وأعيد اكتشاف ثقافة الإصلاح. شراء المستعمل والاستئجار والترقيع يطيل عمر الملابس ويقلل الطلب على الإنتاج الجديد.\n\nتستجيب العلامات بالاقتصاد الدائري. الألياف المعاد تدويرها وبرامج الاسترجاع ومصانع إعادة تدوير الملابس تحويلاً إلى ملابس تشير إلى صناعة تحاول إغلاق الحلقة، رغم أن النقاد يشيرون إلى أن الدائرية الحقيقية ما تزال نادرة.\n\nالتغيير يعتمد في النهاية على المتسوق. فالملابس التي تبقى قيد الاستخدام ضعف المدة تخفض أثرها البيئي إلى النصف. المتانة والتنوع والعناية، لا الكمية، هي الرفاهية الجديدة.",
            ],
            [
                'category' => 'Marketing',
                'title_en' => 'Content Is Not the King Anymore: Distribution Takes the Throne',
                'title_ar' => 'المحتوى لم يعد ملكاً بعد الآن: التوزيع يتولى العرش',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1000&q=80',
                'views' => 13240,
                'status' => 'published',
                'content_en' => "Marketers built the last decade around a beloved slogan: content is king. Yet teams are learning that brilliant content with weak distribution is a masterpiece hidden in an empty room.\n\nAttribution data now shows that on most platforms, organic reach has collapsed as algorithms prioritize paid placements and engaged networks. Creating and hoping no longer works.\n\nDistribution has become a discipline of its own. Successful teams map each asset to a channel, repurpose one idea across text, video, and audio, and schedule it when audiences are actually active. Consistency of distribution beats occasional bursts of genius.\n\nRelationships outperform broadcasts. Influencers, niche communities, and email lists grant access that feeds cannot. A small audience reached repeatedly and personally converts far better than a vast one reached once.\n\nPaid reach is not a failure of creativity but an amplifier of it. The modern marketer's question is no longer what to create, but where, when, and to whom this creation will travel.",
                'content_ar' => "بنى المسوقون العقد الماضي حول شعار محبوب: المحتوى هو الملك. لكن الفرق تتعلم الآن أن المحتوى الرائع مع توزيع ضعيف تحفة فنية في غرفة فارغة.\n\nتُظهر بيانات الإسناد الآن أن الوصول العضوي على معظم المنصات انهار بينما تمنح الخوارزميات الأولوية للإعلانات المدفوعة والشبكات التفاعلية. الإبداع ثم الأمل لم يعد يحقق النتائج.\n\nأصبح التوزيع تخصصاً قائماً بذاته. الفرق الناجحة تحدد لكل أصل قناته، وتعيد توظيف الفكرة الواحدة بين النص والفيديو والصوت، وتجدولها عندما يكون الجمهور نشطاً فعلاً. اتساق التوزيع يتفوق على الاندفاعات النادرة من العبقرية.\n\nالعلاقات تتفوق على البث. المؤثرون والمجتمعات المتخصصة وقوائم البريد تخول وصولاً لا تستطيع ملفات التغذية منحه. الجمهور الصغير الذي يُخاطب مراراً وبشكل شخصي يحوّل أفضل بكثير من الجمهور الواسع الذي يُخاطب مرة واحدة.\n\nالوصول المدفوع ليس فشل إبداع بل مكبر له. سؤال المسوق الحديث لم يعد ماذا نصنع، بل إلى أين ومتى ولمن سيسافر هذا الإبداع.",
            ],
            [
                'category' => 'Modern Technology',
                'title_en' => 'Generative AI in the Workplace: A Practical Guide for Teams',
                'title_ar' => 'الذكاء الاصطناعي التوليدي في مكان العمل: دليل عملي للفرق',
                'image' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=1000&q=80',
                'views' => 22680,
                'status' => 'published',
                'content_en' => "Generative artificial intelligence has moved from research papers to desktop icons at astonishing speed. Teams are adopting language models for drafting, coding, analysis, and design, but success depends on how the tool is governed, not just how it is used.\n\nStart with the right framing. A language model is not an oracle or an employee; it is an amplifier of human direction. The quality of its output tracks the quality of the prompt, of the source data, and of the human review behind it.\n\nExperimentation should be structured. Leading organizations run small pilot teams, track measurable outcomes, and publish internal guidelines that clarify what is allowed with customer data versus internal documents.\n\nValidation is non-negotiable. Generated code must be reviewed, statistics must be checked against sources, and any text representing the company should pass through a human editor. The model proposes; people dispose.\n\nThe strategic advantage belongs to organizations that treat AI as institutional muscle memory, capturing effective prompts and workflows so that knowledge compounds across the team rather than living in individual tabs.",
                'content_ar' => "انتقل الذكاء الاصطناعي التوليدي من الأوراق البحثية إلى أيقونات سطح المكتب بسرعة مذهلة. تتبنى الفرق النماذج اللغوية للصياغة والبرمجة والتحليل والتصميم، لكن النجاح يعتمد على كيفية إدارة الأداة، لا مجرد طريقة استخدامها.\n\nابدأ بالتأطير الصحيح. النموذج اللغوي ليس عرّافة ولا موظفاً؛ إنه مكبر للتوجيه البشري. جودة مخرجاته تتبع جودة الطلب وجودة البيانات المصدرية وجودة المراجعة البشرية خلفه.\n\nينبغي أن تكون التجربة منظمة. تدير المنظمات الرائدة فرقاً تجريبية صغيرة، وتتبع نتائج قابلة للقياس، وتنشر إرشادات داخلية توضح ما هو مسموح مع بيانات العملاء مقابل المستندات الداخلية.\n\nالتحقق ليس قابلاً للتفاوض. يجب مراجعة الكود المولّد، والتحقق من الإحصائيات مقابل المصادر، وينبغي أن يمر أي نص يمثل الشركة عبر محرر بشري. النموذج يقترح؛ والناس يقررون.\n\nالميزة الاستراتيجية تعود للمنظمات التي تعامل الذكاء الاصطناعي كذاكرة عضلية مؤسسية، تلتقط الطلبات وأساليب العمل الفعالة بحيث تتراكم المعرفة عبر الفريق بدلاً من أن تعيش في تبويبات منفردة.",
            ],
            [
                'category' => 'Media',
                'title_en' => 'Newsroom Economics: Quality Journalism in an Attention Economy',
                'title_ar' => 'اقتصاديات غرفة الأخبار: الصحافة الجيدة في اقتصاد الانتباه',
                'image' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1000&q=80',
                'views' => 7810,
                'status' => 'published',
                'content_en' => "News organizations face a paradox: audiences consume more information than ever, yet the revenue that sustains original reporting has dried to a trickle of advertising and subscriptions.\n\nThe distribution revolution broke the old model. Classifieds moved online, digital platforms captured the majority of ad spend, and readers accustomed to free content resisted paywalls for years.\n\nSubscriptions have stabilized some outlets by rewarding trust and depth. Publishers who cultivate explanatory journalism, verification, and distinctive voices convert readers into paying members more reliably than those chasing viral velocity.\n\nThe difficulty is that quality costs. Investigating corruption, covering wars, and documenting local communities require time, safety systems, and specialized staff that content churn does not generate.\n\nEmerging models offer cautious hope: reader-funded co-ops, philanthropy-supported desks, and bundling journalism into broader digital products. The common thread is that society still depends on someone checking the facts, and that payment for that service remains the question journalism must answer.",
                'content_ar' => "تواجه المؤسسات الإخبارية مفارقة: الجمهور يستهلك معلومات أكثر من أي وقت مضى، لكن الإيرادات التي تدعم التغطية الأصلية تقلصت إلى تيار ضيق من الإعلانات والاشتراكات.\n\nثورة التوزيع كسرت النموذج القديم. انتقلت الإعلانات المبوبة أون لاين، واستولت المنصات الرقمية على معظم الإنفاق الإعلاني، وقاوم القراء المعتادون على المحتوى المجاني الجدران المدفوعة لسنوات.\n\nلقد استقرت الاشتراكات من بعض المنافذ عبر مكافأة الثقة والعمق. الناشرون الذين يزرعون صحافة تفسيرية وتحقيقاً ومراجعة وأصواتاً مميزة يحولون القراء إلى أعضاء يدفعون بشكل أكثر موثوقية من أولئك الذين يطاردون السرعة الفيروسية.\n\nالمشكلة أن الجودة تكلف. فالتحقيق في الفساد وتغطية الحروب وتوثيق المجتمعات المحلية تتطلب وقتاً وأنظمة أمان وطاقماً متخصصاً لا يولده تداول المحتوى السريع.\n\nالنماذج الناشئة تقدم أملاً حذراً: تعاونيات ممولة من القراء، ومكاتب مدعومة بالعمل الخيري، وتجميع الصحافة في منتجات رقمية أوسع. الخيط المشترك هو أن المجتمع ما زال يعتمد على من يتحقق من الحقائق، وأن الدفع مقابل هذه الخدمة يبقى السؤال الذي يجب أن تجيبه الصحافة.",
            ],
            [
                'category' => 'Political Analysis',
                'title_en' => 'The Realignment of Voters: When Traditional Alliances Crack',
                'title_ar' => 'إعادة تموضع الناخبين: حين تنكسر التحالفات التقليدية',
                'image' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?auto=format&fit=crop&w=1000&q=80',
                'views' => 15460,
                'status' => 'draft',
                'content_en' => "Political scientists have long relied on stable coalitions to predict elections: patterns of class, geography, and identity that held for generations. Those equations are now misfiring across democracies.\n\nEducation has replaced much of the class signal. Higher-educated urban voters moved toward cosmopolitan platforms, while working-class regions increasingly support protectionist and nationalist voices who promise to undo globalization's costs.\n\nThe divide is less about left versus right than center versus anti-establishment. Long-running government institutions face distrust on all sides, and challengers campaign against the system itself rather than its policies.\n\nDigital media magnify the shift. Algorithmic timelines reward intensity and grievance, fragmenting the shared public conversation on which coalition building once depended.\n\nThese fractures are reshaping platforms, primaries, and parliaments. Whoever learns to reassemble credible coalitions inside this volatility, not against it, will define the politics of the next decade.",
                'content_ar' => "اعتمد علماء السياسة لفترة طويلة على ائتلافات مستقرة للتنبؤ بالانتخابات: أنماط من الطبقة والجغرافيا والهوية صمدت لأجيال. هذه المعادلات تخطئ الآن الهدف في دول ديمقراطية عديدة.\n\nحلّ التعليم محل معظم إشارات الطبقة. تحركت الناخبون الحضريون الأعلى تعليماً نحو منصات عالمية، بينما تدعم المناطق العاملة بشكل متزايد أصواتاً حمائية وقومية تتعهد بإلغاء تكاليف العولمة.\n\nالانقسام أقل حول اليسار واليمين وأكثر حول المركز مقابل المناهضين للمؤسسة. تواجه المؤسسات الحكومية طويلة الأمد انعدام ثقة من جميع الجوانب، ويقود المنافسون حملات ضد النظام نفسه لا ضد سياساته.\n\nتضخم الإعلام الرقمي هذا التحول. تكافئ الجداول الزمنية الخوارزمية الشدة والاستياء، مجزأة المحادثة العامة المشتركة التي اعتمد عليها بناء الائتلافات.\n\nتعيد هذه الصدوع تشكيل المنصات والانتخابات التمهيدية والبرلمانات. ومن يتعلم إعادة تجميع ائتلافات موثوقة داخل هذا التقلب، لا ضده، سيحدد سياسات العقد المقبل.",
            ],
            [
                'category' => 'Technology',
                'title_en' => 'The Danger of Digital Blind Spots: Why Companies Forget to Audit Their Infrastructure',
                'title_ar' => 'خطر النقاط العمياء الرقمية: لماذا تنسى الشركات مراجعة بنيتها التحتية',
                'image' => 'https://images.unsplash.com/photo-1517180102446-f3ece451e9d8?auto=format&fit=crop&w=1000&q=80',
                'views' => 4320,
                'status' => 'archived',
                'content_en' => "Every organization maintains a mental map of its systems, yet audits consistently reveal gaps: forgotten servers, unpatched services, and deprecated accounts that no one remembers creating.\n\nShadow IT is the usual source. Teams spin up cloud instances and collaboration tools to solve immediate problems, and those assets quietly outlive their purpose. When staff leave, credentials often remain valid.\n\nInventory drift compounds the danger. Configuration changes accumulate faster than documentation can follow, so the documented network and the actual network diverge, and security teams defend the wrong picture.\n\nThe consequences surface at the worst moments. Breaches routinely begin in components the organization believed no longer existed, turning a small misremembering into a headline incident.\n\nContinuous discovery is the antidote. Automated scanning, lifecycle policies for cloud resources, and regular access reviews transform infrastructure management from a yearly exercise into a constantly breathing discipline.",
                'content_ar' => "تحتفظ كل منظمة بخريطة ذهنية لأنظمتها، ومع ذلك تكشف المراجعات باستمرار فجوات: خوادم منسية، وخدمات غير مصححة، وحسابات متقادمة لا يتذكر أحد إنشاءها.\n\nتكنولوجيا المعلومات الظلية هي المصدر المعتاد. تطلق الفرق مثيلات سحابية وأدوات تعاون لحل مشكلات فورية، ثم تعيش تلك الأصول بهدوء بعد انتهاء غايتها. وعندما يغادر الموظفون، تبقى بيانات الدخول صالحة غالباً.\n\nانحراف الجرد يفاقم الخطر. تتجمع تغييرات الإعداد أسرع مما تستطيع التوثيق مواكبتها، لذلك تتباعد الشبكة الموثقة عن الشبكة الفعلية، وتدافع فرق الأمن عن صورة خاطئة.\n\nتظهر العواقب في أسوأ اللحظات. وغالباً ما تبدأ الاختراقات في مكونات اعتقدت المنظمة أنها لم تعد موجودة، محولةً خطأ تذكر صغيراً إلى حادثة في العناوين.\n\nالاكتشاف المستمر هو الترياق. المسح الآلي وسياسات دورة الحياة للموارد السحابية والمراجعات الدورية للوصول تحول إدارة البنية التحتية من تمرين سنوي إلى تخصص يتنفس باستمرار.",
            ],
        ];

        $categories = DB::table('article_categories')->pluck('id', 'title_en')->toArray();
        $usersidsarray = DB::table('users')->pluck('id')->toArray();
        $tags = DB::table('tags')->pluck('id')->toArray();

        $insertedArticles = [];

        foreach ($articles as $index => $article) {
            $categoryId = $categories[$article['category']] ?? null;

            if ($categoryId === null) {
                continue;
            }

            $insertedArticles[] = Article::create([
                'title_en' => $article['title_en'],
                'title_ar' => $article['title_ar'],
                'content_en' => $article['content_en'],
                'content_ar' => $article['content_ar'],
                'image' => $article['image'],
                'status' => $article['status'],
                'views' => $article['views'],
                'category_id' => $categoryId,
                'author_id' => $usersidsarray[array_rand($usersidsarray)],
                'created_at' => now()->subMonths(count($articles) - $index)->addDays(rand(1, 28)),
                'updated_at' => now()->subMonths(count($articles) - $index)->addDays(rand(1, 28)),
            ]);
        }

        $articleTags = [];

        foreach ($insertedArticles as $article) {
            $numberOfTags = rand(2, 4);
            $selectedTags = array_rand($tags, $numberOfTags);

            if (!is_array($selectedTags)) {
                $selectedTags = [$selectedTags];
            }

            foreach ($selectedTags as $tagIndex) {
                $articleTags[] = [
                    'tag_id' => $tags[$tagIndex],
                    'article_id' => $article->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        ArticleTag::insert($articleTags);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}