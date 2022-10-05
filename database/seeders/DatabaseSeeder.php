<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'name' => 'Plant Helper Password Grant Client',
            'id' => '97049084-d157-41bc-b04c-cd5b3038f425',
            'secret' => 'nwB4aPcF59ynE67mALi5Bwk36zMNoBOj8r1pvhFA',
            'provider' => 'users',
            'redirect' => env('APP_URL'),
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->call(UsersTableSeeder::class);
    }
}
