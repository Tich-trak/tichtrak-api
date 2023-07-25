<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('users')->delete();

        $superAdmin = new User();
        $superAdmin->name = 'TichTrak';
        $superAdmin->email = 'tichtrak@mailinator.com';
        $superAdmin->password = 'Password123';
        $superAdmin->role = RoleEnum::SuperAdmin;
        $superAdmin->is_active = true;
        $superAdmin->verified_at = now();
        $superAdmin->verification_token_generated_at = now();
        $superAdmin->remember_token = Str::random(10);
        $superAdmin->save();

        $superAdmin = new User();
        $superAdmin->name = 'Adebiyi Blessing';
        $superAdmin->email = 'yoyoplenty@gmail.com';
        $superAdmin->password = 'Pearl4700';
        $superAdmin->role = RoleEnum::SuperAdmin;
        $superAdmin->is_active = true;
        $superAdmin->verified_at = now();
        $superAdmin->verification_token_generated_at = now();
        $superAdmin->remember_token = Str::random(10);
        $superAdmin->save();
    }
}
