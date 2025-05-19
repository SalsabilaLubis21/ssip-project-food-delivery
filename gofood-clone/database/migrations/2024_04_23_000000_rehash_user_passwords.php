<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RehashUserPasswords extends Migration
{
    public function up()
    {
        $users = DB::table('user')->get();

        foreach ($users as $user) {
            // Assuming all users have the default password '123456'
            // You can modify this according to your needs
            DB::table('user')
                ->where('user_id', $user->user_id)
                ->update([
                    'password' => Hash::make('123456')
                ]);
        }
    }

    public function down()
    {
        // Cannot revert password hashing
    }
}