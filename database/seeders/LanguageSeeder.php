<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [[
            'language_name' => 'English', 'language_slug' => 'en', 'language_code' => 'ltr',
        ], [
            'language_name' => 'العربية', 'language_slug' => 'ar', 'language_code' => 'rtl',
        ]];
        Language::insert($languages);
    }
}
