<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('brand')->nullable();
            $table->integer('price');
            $table->text('description');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->cascadeOnDelete();
            $table->foreignId('condision_id')->constrained('condisions', 'id')->cascadeOnDelete();
            $table->foreignId('selling_user_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('buying_user_id')->nullable()->costrained('users', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('products');
    }
}
