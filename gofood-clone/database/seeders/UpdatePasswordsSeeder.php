<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordsSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'password' => Hash::make($user->password)
                ]);
        }
    }
}