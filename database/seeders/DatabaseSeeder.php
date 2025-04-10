<?php

namespace Database\Seeders;

use App\Models\Cashier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cashier::create([
            'id' => 1,
            'name' => 'johnatan',
            'telephone' => '09284',
            'email' => 'ship@gmai.com'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
