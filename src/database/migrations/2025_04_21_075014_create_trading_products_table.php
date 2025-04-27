<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trading_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchased_product_id')->constrained('purchased_products', 'id')->cascadeOnDelete();
            $table->foreignId('selling_user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('buying_user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->datetime('selling_user_seeTime');
            $table->datetime('buying_user_seeTime');
            $table->integer('selling_user_rate')->nullable();
            $table->integer('buying_user_rate')->nullable();
            $table->boolean('completion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trading_products');
    }
}
