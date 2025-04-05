<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\SurveyOption;
use Illuminate\Database\Seeder;

class SurveyOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Anket başlığı ve ayarlarını ekle
        Setting::set('survey_title', 'Ürünlerimiz Hakkında Ne Düşünüyorsunuz?', 'survey', 'text', true, 'Anket başlığı');
        Setting::set('survey_title_en', 'What Do You Think About Our Products?', 'survey', 'text', true, 'Anket başlığı (İngilizce)');
        Setting::set('survey_active', true, 'survey', 'boolean', true, 'Anket aktif mi?');
        
        // Anket seçeneklerini ekle
        $options = [
            [
                'option' => 'Çok memnunum',
                'option_en' => 'Very satisfied',
                'votes' => 15,
                'order' => 1,
                'is_active' => true
            ],
            [
                'option' => 'Memnunum',
                'option_en' => 'Satisfied',
                'votes' => 25,
                'order' => 2,
                'is_active' => true
            ],
            [
                'option' => 'Kararsızım',
                'option_en' => 'Neutral',
                'votes' => 8,
                'order' => 3,
                'is_active' => true
            ],
            [
                'option' => 'Memnun değilim',
                'option_en' => 'Unsatisfied',
                'votes' => 3,
                'order' => 4,
                'is_active' => true
            ],
            [
                'option' => 'Hiç memnun değilim',
                'option_en' => 'Very unsatisfied',
                'votes' => 1,
                'order' => 5,
                'is_active' => true
            ]
        ];
        
        foreach ($options as $option) {
            SurveyOption::create($option);
        }
    }
}
