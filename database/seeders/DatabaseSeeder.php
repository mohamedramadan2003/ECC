<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([

                'name' => 'محمد السيد',
                'username' => 'admin2003',
                'password' => bcrypt('admin@1'),
                'remember_token' => Str::random(10),
                'usertype' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        Location::factory()->create([
                'committee_number' => 1,
                'place_name' => 'مدرج 1',
                'committee_code' => 'B',
            ]);
            Location::factory()->create([
                'committee_number' => 2,
                'place_name' => 'مدرج 2',
                'committee_code' => 'B',
            ]);
            Location::factory()->create([
                'committee_number' => 3,
                'place_name' => 'مدرج 3',
                'committee_code' => 'B',
            ]);

    }
}
