<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonTranslation;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionTranslation;
use App\Models\CodeExercise;
use App\Models\Badge;
use App\Models\PaymentPlan;
use App\Models\AdSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('KodLab içerik yükleniyor...');

        $this->command->info('  Veritabanı temizleniyor...');

        $dataDir = database_path('data');
        $jsonFiles = [
            'web-fundamentals.json' => ["Web Geliştirmeye Giriş", "İnternetin temel çalışma prensipleri", 'bi-globe', '#6C5CE7', 1],
            'html.json' => ["HTML", "Web'in iskeleti - Hiper Metin İşaretleme Dili", 'bi-filetype-html', '#E44D26', 2],
            'css.json' => ["CSS", "Web'in görsel dünyası - Stil ve tasarım dili", 'bi-filetype-css', '#264DE4', 3],
            'javascript.json' => ["JavaScript", "Web'in beyni - Dinamik ve interaktif programlama", 'bi-filetype-js', '#F7DF1E', 4],
            'jquery.json' => ["jQuery", "JavaScript kütüphanesi - Daha az kod, daha çok iş", 'bi-filetype-js', '#0769AD', 5],
            'php.json' => ["PHP", "Sunucu taraflı programlama dili", 'bi-filetype-php', '#777BB3', 6],
            'mysql.json' => ["MySQL", "Veritabanı yönetim sistemi - SQL sorguları", 'bi-database', '#4479A1', 7],
        ];

        foreach ($jsonFiles as $fileName => [$catName, $catDesc, $catIcon, $catColor, $catOrder]) {
            $filePath = $dataDir . '/' . $fileName;
            if (!File::exists($filePath)) {
                $this->command->warn("Dosya bulunamadı: $fileName");
                continue;
            }

            $jsonContent = File::get($filePath);
            $lessons = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->command->error("JSON hatası ($fileName): " . json_last_error_msg());
                continue;
            }

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($catName)],
                [
                    'name' => $catName,
                    'description' => $catDesc,
                    'icon' => $catIcon,
                    'color' => $catColor,
                    'order' => $catOrder,
                    'is_active' => true,
                ]
            );

            $source = $lessons[0]['source_ref'] ?? 'Çeşitli kaynaklar';
            $courseSlug = Str::slug($catName . '-kursu');
            $course = Course::firstOrCreate(
                ['slug' => $courseSlug],
                [
                    'category_id' => $category->id,
                    'title' => $catName . ' - Sıfırdan Uzmanlığa',
                    'slug' => $courseSlug,
                    'description' => "Sıfırdan ileri seviyeye $catName eğitimi. " . count($lessons) . " ders ve yüzlerce quiz sorusu ile kendinizi geliştirin.",
                    'icon' => $catIcon,
                    'difficulty' => 'beginner',
                    'order' => $catOrder,
                    'is_published' => true,
                    'estimated_hours' => count($lessons) * 2,
                ]
            );

            $this->command->info("  Kurs oluşturuldu: {$course->title}");

            foreach ($lessons as $lessonData) {
                $lessonSlug = $lessonData['slug'] ?? Str::slug($lessonData['title']);
                $lesson = Lesson::firstOrCreate(
                    ['course_id' => $course->id, 'slug' => $lessonSlug],
                    [
                        'course_id' => $course->id,
                        'title' => $lessonData['title'],
                        'slug' => $lessonSlug,
                        'content' => $lessonData['content'] ?? '',
                        'video_url' => $lessonData['video_url'] ?? '',
                        'source_ref' => $lessonData['source_ref'] ?? $source,
                        'source_note' => 'Bu ders içeriği ' . ($lessonData['source_ref'] ?? 'çeşitli kaynaklardan') . ' derlenmiştir.',
                        'code_example' => $lessonData['code_example'] ?? '',
                        'order' => $lessonData['order'] ?? 1,
                        'is_free' => true,
                        'is_published' => true,
                        'estimated_minutes' => 15,
                    ]
                );

                LessonTranslation::create([
                    'lesson_id' => $lesson->id,
                    'locale' => 'tr',
                    'title' => $lessonData['title'],
                    'content' => $lessonData['content'] ?? '',
                ]);

                if (!empty($lessonData['quiz'])) {
                    $quiz = Quiz::create([
                        'lesson_id' => $lesson->id,
                        'title' => $lessonData['title'] . ' - Quiz',
                        'description' => 'Bu dersi ne kadar anladığınızı test edin!',
                        'type' => 'multiple_choice',
                        'passing_score' => 70,
                        'time_limit' => 10,
                        'order' => 1,
                        'is_active' => true,
                    ]);

                    foreach ($lessonData['quiz'] as $qIndex => $qData) {
                        $questionText = $qData['question_text'] ?? $qData['question'] ?? '';
                        $correctAnswer = $qData['correct_answer'] ?? $qData['correct'] ?? $qData['correctAnswer'] ?? '';
                        $explanation = $qData['explanation'] ?? '';
                        $options = $qData['options'] ?? [];

                        $question = Question::create([
                            'quiz_id' => $quiz->id,
                            'question_text' => $questionText,
                            'type' => 'multiple_choice',
                            'options' => $options,
                            'correct_answer' => $correctAnswer,
                            'explanation' => $explanation,
                            'source_ref' => $qData['source'] ?? $source,
                            'points' => 10,
                            'order' => $qIndex + 1,
                        ]);

                        QuestionTranslation::create([
                            'question_id' => $question->id,
                            'locale' => 'tr',
                            'question_text' => $questionText,
                            'options' => $options,
                            'explanation' => $explanation,
                        ]);
                    }
                }

                if (!empty($lessonData['code_example'])) {
                    CodeExercise::create([
                        'lesson_id' => $lesson->id,
                        'title' => 'Kendin Dene',
                        'description' => 'Aşağıdaki kodu inceleyip deneyebilirsiniz.',
                        'initial_code' => $lessonData['code_example'],
                        'solution_code' => $lessonData['code_example'],
                        'language' => $this->detectLanguage($course->slug),
                        'order' => 1,
                    ]);
                }
            }
        }

        $this->createBadges();
        $this->createPaymentPlans();
        $this->createAdSettings();

        $this->command->info('KodLab içerik yüklemesi tamamlandı!');
    }

    private function detectLanguage(string $slug): string
    {
        return match (true) {
            str_contains($slug, 'html') => 'html',
            str_contains($slug, 'css') => 'css',
            str_contains($slug, 'javascript'), str_contains($slug, 'jquery') => 'javascript',
            str_contains($slug, 'php') => 'php',
            str_contains($slug, 'mysql') => 'sql',
            default => 'html',
        };
    }

    private function createBadges(): void
    {
        $badges = [
            ['name' => 'HTML Ustası', 'slug' => 'html-ustasi', 'description' => 'Tüm HTML derslerini tamamla', 'icon' => 'bi-filetype-html', 'color' => '#E44D26', 'type' => 'course', 'required_value' => 30],
            ['name' => 'CSS Ninja', 'slug' => 'css-ninja', 'description' => 'Tüm CSS derslerini tamamla', 'icon' => 'bi-filetype-css', 'color' => '#264DE4', 'type' => 'course', 'required_value' => 35],
            ['name' => 'JS Developer', 'slug' => 'js-developer', 'description' => 'Tüm JavaScript derslerini tamamla', 'icon' => 'bi-filetype-js', 'color' => '#F7DF1E', 'type' => 'course', 'required_value' => 40],
            ['name' => 'PHP Master', 'slug' => 'php-master', 'description' => 'Tüm PHP derslerini tamamla', 'icon' => 'bi-filetype-php', 'color' => '#777BB3', 'type' => 'course', 'required_value' => 35],
            ['name' => 'SQL Wizard', 'slug' => 'sql-wizard', 'description' => 'Tüm MySQL derslerini tamamla', 'icon' => 'bi-database', 'color' => '#4479A1', 'type' => 'course', 'required_value' => 20],
            ['name' => 'Quiz Şampiyonu', 'slug' => 'quiz-sampiyonu', 'description' => '100 quiz sorularını doğru cevapla', 'icon' => 'bi-trophy', 'color' => '#FFD700', 'type' => 'quiz', 'required_value' => 100],
            ['name' => 'Hızlı Cevaplayıcı', 'slug' => 'hizli-cevaplayici', 'description' => '10 quizi süre dolmadan bitir', 'icon' => 'bi-lightning', 'color' => '#FF6B6B', 'type' => 'quiz', 'required_value' => 10],
            ['name' => 'Full Stack Yolcusu', 'slug' => 'fullstack-yolcusu', 'description' => 'Tüm kategorilerde en az 1 ders tamamla', 'icon' => 'bi-stack', 'color' => '#6C5CE7', 'type' => 'special', 'required_value' => 7],
            ['name' => 'Azimli Öğrenci', 'slug' => 'azimli-ogrenci', 'description' => '7 gün üst üste ders çalış', 'icon' => 'bi-fire', 'color' => '#FF6B35', 'type' => 'streak', 'required_value' => 7],
            ['name' => 'İlk Adım', 'slug' => 'ilk-adim', 'description' => 'İlk dersini tamamla', 'icon' => 'bi-star', 'color' => '#00CEC9', 'type' => 'special', 'required_value' => 1],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }

        $this->command->info('  Rozetler oluşturuldu: ' . count($badges));
    }

    private function createPaymentPlans(): void
    {
        $plans = [
            [
                'name' => 'Ücretsiz',
                'slug' => 'free',
                'description' => 'Tüm ders içeriklerine ücretsiz erişim. Reklam destekli.',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'currency' => 'TRY',
                'features' => json_encode(['Tüm ders içerikleri', 'Sınırlı quiz hakkı', 'Reklam gösterimi', 'Temel ilerleme takibi']),
                'is_popular' => false,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'KodLab Plus',
                'slug' => 'plus',
                'description' => 'Reklamsız deneyim, sınırsız quiz ve sertifika.',
                'price_monthly' => 149.00,
                'price_yearly' => 999.00,
                'currency' => 'TRY',
                'features' => json_encode(['Tüm ders içerikleri', 'Sınırsız quiz hakkı', 'Reklamsız deneyim', 'Sertifika oluşturma', 'Rozet sistemi', 'Gelişmiş ilerleme takibi', 'Kod egzersizleri']),
                'is_popular' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'KodLab Pro',
                'slug' => 'pro',
                'description' => 'Canlı mentor desteği ve proje inceleme ile profesyonel gelişim.',
                'price_monthly' => 399.00,
                'price_yearly' => 2999.00,
                'currency' => 'TRY',
                'features' => json_encode(['Tüm Plus özellikleri', 'Canlı mentor desteği', 'Proje inceleme', 'CV danışmanlığı', 'Özel içerikler', 'Öncelikli destek']),
                'is_popular' => false,
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            PaymentPlan::create($plan);
        }

        $this->command->info('  Ödeme planları oluşturuldu: ' . count($plans));
    }

    private function createAdSettings(): void
    {
        AdSetting::create([
            'adsense_publisher_id' => '',
            'ads_enabled' => false,
            'show_in_header' => false,
            'show_in_sidebar' => false,
            'show_in_lesson' => false,
            'show_in_quiz' => false,
            'hide_for_premium' => true,
        ]);
        $this->command->info('  Reklam ayarları oluşturuldu.');
    }
}
