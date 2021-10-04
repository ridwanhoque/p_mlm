<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('slug')->unique()->index();
            $table->float('sale_price', 14, 2);
            $table->float('discount_percentage')->default(0);
            $table->float('discount_amount')->default(0);
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            $table->float('commission')->default(0);

            $table->float('a_delivery_charge_dhaka')->default(0);
            $table->float('a_delivery_charge_out_of_dhaka')->default(0);
            $table->string('delivery_time_dhaka')->nullable();
            $table->string('delivery_time_out_of_dhaka')->nullable();

            $table->integer('priority')->default(1);

            $table->text('comments')->nullable();
            $table->text('cash_back')->nullable();
            $table->text('nb')->nullable();
            $table->enum('position', [1, 2, 3])->comment('Front = 1, Back = 2, Both = 3');

            $table->boolean('is_publish')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();


            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
