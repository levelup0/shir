<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::updateOrCreate([
          'name' => 'superadmin',
        ]);

        UserRole::updateOrCreate([
          'name' => 'caller', // Вызоводатель
        ]);

        UserRole::updateOrCreate([
          'name' => 'recipient', // Вызовополучатель
        ]);
    }
}