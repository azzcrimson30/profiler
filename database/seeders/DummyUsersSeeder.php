<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 users user_1 ... user_10
        for ($i = 1; $i <= 10; $i++) {
            $username = 'user_' . $i;
            $user = User::updateOrCreate(
                ['username' => $username],
                [
                    'name' => 'User ' . $i,
                    'email' => $username . '@example.com',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            // create or update a simple profile for the user
            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => 'User',
                    'last_name' => (string)$i,
                    'email' => $user->email,
                    'phone' => '555-010' . str_pad((string)$i, 2, '0', STR_PAD_LEFT),
                    'city' => 'City ' . $i,
                    'country' => 'Country',
                    'title' => 'Software Engineer',
                    'summary' => 'Experienced developer working on sample projects.',
                    'skills' => ['PHP', 'Laravel', 'MySQL'],
                    'work_experiences' => [
                        ['company' => 'Acme Corp', 'position' => 'Engineer', 'start_date' => '2020', 'end_date' => '2023', 'description' => 'Worked on web apps.']
                    ],
                    'educations' => [
                        ['school' => 'University', 'degree' => 'BSc Computer Science', 'start_date' => '2015', 'end_date' => '2019']
                    ],
                ]
            );
        }

        // Ensure admin also has a profile
        $admin = User::where('username', 'admin')->first();
        if ($admin) {
            Profile::updateOrCreate(
                ['user_id' => $admin->id],
                [
                    'first_name' => 'Admin',
                    'last_name' => 'User',
                    'email' => $admin->email,
                    'title' => 'Administrator',
                    'summary' => 'Site administrator account.',
                    'skills' => ['Management','Laravel'],
                ]
            );
        }
    }
}
