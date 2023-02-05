<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin_password = Str::random(10);
        echo "Пароль администратора: \n$admin_password\n";
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'access_level' => 1,
            'password' => Hash::make($admin_password),
        ]);
        $users = User::factory()
            ->count(20)
            ->make();
        DB::transaction (function () use ($users) {
            $users->each(function ($user) { $user->save(); });
        });
    }
}