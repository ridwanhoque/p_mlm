<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageDeliveryModeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_delivery_mode', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('delivery_mode_id');

            $table->primary(['package_id', 'delivery_mode_id']);

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('delivery_mode_id')->references('id')->on('delivery_modes')->onDelete('cascade');
        });

        Schema::create('package_product', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('product_id');

            $table->primary(['package_id', 'product_id']);

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('package_category', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('category_id');
            $table->integer('depth');

            $table->primary(['package_id', 'category_id']);

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_delivery_mode');

        Schema::dropIfExists('package_product');

        Schema::dropIfExists('package_category');
    }
}
