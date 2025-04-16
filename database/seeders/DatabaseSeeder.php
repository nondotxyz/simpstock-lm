<?php

namespace Database\Seeders;

use App\Models\Cashier;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $cashierRole = Role::create([
            'name' => 'cashier',
            'guard_name' => 'cashier',
        ]);

        $cashier = Cashier::create([
            'id' => 1,
            'name' => 'johnatan',
            'telephone' => '09284',
            'password' => 'heresjohnny',
        ]);

        $cashier->assignRole($cashierRole);

        $user = User::create([
            'name' => env("ADMIN_USERNAME"),
            'password' => env("ADMIN_PASSWORD"),
        ]);

        $user->assignRole($adminRole);
    }

}
