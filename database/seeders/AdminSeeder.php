<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_role = UserRole::where('name', 'superadmin')->first();

        if(is_null($user_role))
        {
            echo "The role is not found";
            return;
        }

        $superadmin = User::where([
            'user_role_id' => $user_role->id,
            'email' => 'superadmin@gmail.com'
        ])
            ->first();
            
        $password = Hash::make('superadmin');
        if ($superadmin) {
            $superadmin->password = $password;
            $superadmin->save();
        } else {
            User::create([
                'name' => 'superadmin',
                'user_role_id' => $user_role->id,
                'email' => 'superadmin@gmail.com',
                'password' => $password
            ]);
        }
    }
}