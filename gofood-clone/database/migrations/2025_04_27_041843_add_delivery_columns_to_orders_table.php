<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'delivery_type')) {
                    $table->string('delivery_type')->nullable()->after('payment_total');
                }
                if (!Schema::hasColumn('orders', 'delivery_cost')) {
                    $table->decimal('delivery_cost', 10, 2)->nullable()->after('delivery_type');
                }
                if (!Schema::hasColumn('orders', 'delivery_address')) {
                    $table->text('delivery_address')->nullable()->after('delivery_cost');
                }
            });
        }
    }
    

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_type', 'delivery_cost', 'delivery_address']);
        });
    }
};