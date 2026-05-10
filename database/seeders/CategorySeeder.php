<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'IT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer Support', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engineering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Design', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Operations', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Management', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Healthcare', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Education', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Legal', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Logistics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Retail / E-commerce', 'created_at' => now(), 'updated_at' => now()],

        ]);
    }
}