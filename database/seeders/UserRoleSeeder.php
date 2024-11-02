<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'student'],
            ['role_name' => 'advisor'],
            ['role_name' => 'supervisor'],
            ['role_name' => 'jury'],
            ['role_name' => 'admin'],
        ];

        // Insert roles into the user_roles table
        DB::table('user_roles')->insert($roles);
    }
}
