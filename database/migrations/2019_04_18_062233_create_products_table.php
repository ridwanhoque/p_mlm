<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('slug')->unique()->index();

            $table->unsignedBigInteger('brand_id')->index();
            $table->text('description');
            $table->string('origin')->nullable();
            $table->string('source')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->float('purchase_price');
            $table->float('sale_price');
            $table->float('discount_percentage')->default(0);
            $table->float('discount_amount')->default(0);
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            $table->boolean('emi_available')->default(0);
            $table->float('commission')->default(0);

            $table->float('a_delivery_charge_dhaka')->default(0);
            $table->float('a_delivery_charge_out_of_dhaka')->default(0);
            $table->string('delivery_time_dhaka')->nullable();
            $table->string('delivery_time_out_of_dhaka')->nullable();
            $table->string('return_time')->nullable();
            $table->integer('priority')->default(1);

            $table->text('comments')->nullable();
            $table->text('cash_back')->nullable();
            $table->text('nb')->nullable();
            $table->enum('position', [1, 2, 3])->comment('Front = 1, Back = 2, Both = 3');

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
