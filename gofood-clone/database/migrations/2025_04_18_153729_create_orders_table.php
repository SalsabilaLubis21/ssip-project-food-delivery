<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    if (Schema::hasTable('orders')) {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('Pending');
            }
            if (!Schema::hasColumn('orders', 'delivery_driver_id')) {
                $table->unsignedBigInteger('delivery_driver_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'delivery_time')) {
                $table->timestamp('delivery_time')->nullable();
            }
            if (!Schema::hasColumn('orders', 'delivery_status')) {
                $table->string('delivery_status')->default('Pending');
            }
            if (!Schema::hasColumn('orders', 'delivery_type')) {
                $table->string('delivery_type')->default('Standard');
            }
            if (!Schema::hasColumn('orders', 'delivery_cost')) {
                $table->decimal('delivery_cost', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'delivery_address')) {
                $table->text('delivery_address');
            }
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};