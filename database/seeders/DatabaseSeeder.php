<?php

namespace Database\Seeders;

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
                'email' => 'admin1@gmail.com',
                'email_verified_at' => now(),  // تأكد من إضافة القيمة الصحيحة هنا
                'password' => bcrypt('admin@1'),
                'remember_token' => Str::random(10),
                'usertype' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            
            
        ]);
    }
}
