<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionalDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotional_designations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('stage');
            $table->integer('required_designation')->nullable();
            $table->unsignedBigInteger('required_designation_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::table('promotional_designations', function (Blueprint $table) {

            $table->foreign('required_designation_id')->references('id')->on('promotional_designations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotional_designations', function (Blueprint $table) {

            $table->dropForeign(['required_designation_id']);
        });

        Schema::dropIfExists('promotional_designations');
    }
}
