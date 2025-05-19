<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordHashes extends Migration
{
    public function up()
    {
        DB::table('user')->get()->each(function ($user) {
            DB::table('user')
                ->where('user_id', $user->user_id)
                ->update([
                    'password' => Hash::make($user->password)
                ]);
        });
    }

    public function down()
    {
        // Cannot revert password hashing
    }
}