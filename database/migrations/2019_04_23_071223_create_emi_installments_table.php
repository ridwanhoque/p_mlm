<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmiInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emi_installments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('emi_id');
            $table->float('installment', 14, 2);
            $table->float('commission');
            $table->timestamps();

            $table->foreign('emi_id')->references('id')->on('emis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emi_installments');
    }
}
