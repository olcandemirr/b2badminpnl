<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('status')->default('active');
            $table->string('type');
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('product_code')->unique()->nullable();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('vat_rate', 5, 2)->nullable();
            $table->string('box_content')->nullable();
            $table->integer('order')->nullable();
            $table->decimal('desi', 10, 2)->nullable();
            $table->integer('points')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('price1', 10, 2)->nullable();
            $table->decimal('price2', 10, 2)->nullable();
            $table->decimal('price3', 10, 2)->nullable();
            $table->decimal('price4', 10, 2)->nullable();
            $table->decimal('price5', 10, 2)->nullable();
            $table->string('currency1')->default('TRY');
            $table->string('currency2')->default('TRY');
            $table->string('currency3')->default('TRY');
            $table->string('currency4')->default('TRY');
            $table->string('currency5')->default('TRY');
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->string('discounted_currency')->default('TRY');
            $table->decimal('cost', 10, 2)->nullable();
            $table->decimal('discount_rate', 5, 2)->nullable();
            $table->decimal('additional_discount', 5, 2)->nullable();
            $table->string('discount_group_code')->nullable();
            $table->integer('min_order')->nullable();
            $table->integer('increment')->nullable();
            $table->integer('max_order')->nullable();
            $table->integer('warehouse1_stock')->nullable();
            $table->integer('warehouse2_stock')->nullable();
            $table->integer('warehouse3_stock')->nullable();
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->string('search_tags')->nullable();
            $table->datetime('counter_date')->nullable();
            $table->datetime('discount_stock_date')->nullable();
            $table->boolean('is_passive')->default(false);
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_out_of_stock')->default(false);
            $table->boolean('is_showcase')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_campaign')->default(false);
            $table->boolean('has_gift')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('has_counter')->default(false);
            $table->boolean('has_discount_stock')->default(false);
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
};
