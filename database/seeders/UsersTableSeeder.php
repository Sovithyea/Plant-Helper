<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'system';
        $user->first_name = 'Root';
        $user->last_name = 'System';
        $user->email = 'system@email.com';
        $user->password = Hash::make('system');
        $user->email_verified_at = now();
        $user->role = 'admin';
        $user->save();
        
        $user = new User();
        $user->username = 'admin';
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->email = 'admin@email.com';
        $user->password = Hash::make('superadmin');
        $user->email_verified_at = now();
        $user->role = 'admin';
        $user->save();
    }
}
