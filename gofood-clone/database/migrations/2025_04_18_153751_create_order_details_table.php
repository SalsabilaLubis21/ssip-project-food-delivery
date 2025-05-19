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
    if (Schema::hasTable('orderdetail')) {
        Schema::table('orderdetail', function (Blueprint $table) {
            if (!Schema::hasColumn('orderdetail', 'quantity')) {
                $table->integer('quantity')->default(1);
            }
            if (!Schema::hasColumn('orderdetail', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('orderdetail', 'order_id')) {
                $table->unsignedBigInteger('order_id');
                $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            }
            if (!Schema::hasColumn('orderdetail', 'menu_id')) {
                $table->unsignedBigInteger('menu_id');
                $table->foreign('menu_id')->references('menu_id')->on('menu')->onDelete('cascade');
            }
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};