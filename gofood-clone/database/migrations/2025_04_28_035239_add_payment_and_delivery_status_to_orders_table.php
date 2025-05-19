<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentAndDeliveryStatusToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    if (Schema::hasTable('orders')) {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->notNull();
            }
            if (!Schema::hasColumn('orders', 'delivery_status')) {
                $table->string('delivery_status')->default('pending');
            }
        });
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'delivery_status']);
        });
    }
}