<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $successfulEmailSQL = base_path('database/seeders/record.sql');

        if (DB::table('users')->count() === 0) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        if (File::exists($successfulEmailSQL) && DB::table('successful_emails')->count() === 0) {
            DB::unprepared(file_get_contents($successfulEmailSQL));
        }
    }
}
