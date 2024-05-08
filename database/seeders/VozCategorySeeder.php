<?php

namespace Database\Seeders;

use App\Models\CategoryVoz;
use Illuminate\Database\Seeder;

class VozCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        CategoryVoz::updateOrCreate(
            ['name' => 'Производство'],
            [
                'name' => 'Производство',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'ИТ'],
            [
                'name' => 'ИТ',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'Строительство'],
            [
                'name' => 'Строительство',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'Инжиниринг'],
            [
                'name' => 'Инжиниринг',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'Недвижимость'],
            [
                'name' => 'Недвижимость',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'Финансы'],
            [
                'name' => 'Финансы',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'Консалтинг'],
            [
                'name' => 'Консалтинг',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'Ритейл'],
            [
                'name' => 'Ритейл',
            ]
        );
        CategoryVoz::updateOrCreate(
            ['name' => 'Инвестиции'],
            [
                'name' => 'Инвестиции',
            ]
        );
    }
}