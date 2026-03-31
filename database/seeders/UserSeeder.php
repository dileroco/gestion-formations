<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@formations.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'language' => 'fr',
                'is_active' => true,
                'phone' => '0600000000',
            ]
        );

        if (method_exists($superAdmin, 'assignRole')) {
            $superAdmin->assignRole('Super Admin');
        }

        User::factory(8)->create()->each(function (User $user) {
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('Participant');
            }
        });

        User::factory(3)->create()->each(function (User $user) {
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('Formateur');
            }
        });
    }
}
