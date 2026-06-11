<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Role Seeder
 *
 * Creates the default roles and assigns administrator role to the admin user.
 */
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $administrator = Role::updateOrCreate(
            ['slug' => 'administrator'],
            ['name' => 'Administrator']
        );

        $commoner = Role::updateOrCreate(
            ['slug' => 'commoner'],
            ['name' => 'Commoner']
        );

        // Assign administrator role to the admin user
        $admin = User::where('username', 'admin')->first();
        if ($admin) {
            $admin->update(['role_id' => $administrator->id]);
        }

        // Assign commoner role to any users without a role
        User::whereNull('role_id')->update(['role_id' => $commoner->id]);
    }
}