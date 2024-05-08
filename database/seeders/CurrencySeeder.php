<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Currency::updateOrCreate(
            ['title' => 'U.S. Dollar'],
            [
                'title' => 'U.S. Dollar',
                'symbol_left' => '$',
				'symbol_right' => '',
				'code' => 'USD',
				'class'=>'fa-usd',
				'decimal_place' => 2,
				'decimal_point' => '.',
				'thousand_point' => ',',
				'status' => 1,
            ]
        );

        Currency::updateOrCreate(
            ['title' => 'Euro'],
            [
                'title' => 'Euro',
				'symbol_left' => '€',
				'symbol_right' => '',
				'code' => 'EUR',
				'class'=>'fa-eur',
				'decimal_place' => 2,
				'decimal_point' => '.',
				'thousand_point' => ',',
				'status' => 1,
            ]
        );

        Currency::updateOrCreate(
            ['title' => 'Russian ruble'],
            [
                'title' => 'Russian ruble',
				'symbol_left' => '₽',
				'symbol_right' => '',
				'code' => 'RUB',
				'class'=>'fa-rub',
				'decimal_place' => 2,
				'decimal_point' => '.',
				'thousand_point' => ',',
				'status' => 1,
            ]
        );

        Currency::updateOrCreate(
            ['title' => 'TJS Somoni'],
            [
                'title' => 'TJS Somoni',
				'symbol_left' => 'сом',
				'symbol_right' => '',
				'code' => 'TJS',
				'class'=>'fa-tsj',
				'decimal_place' => 2,
				'decimal_point' => '.',
				'thousand_point' => ',',
				'status' => 1,
            ]
        );

    }
}
