<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::updateOrCreate(
            ['name' => 'tj'],
            [
                'name' => 'tj',
                'fullname' => 'Тоҷикӣ',
            ]
        );

        Language::updateOrCreate(
            ['name' => 'ru'],
            [
                'name' => 'ru',
                'fullname' => 'Русский',
            ]
        );

        Language::updateOrCreate(
            ['name' => 'en'],
            [
                'name' => 'en',
                'fullname' => 'English',
            ]
        );

    }
}