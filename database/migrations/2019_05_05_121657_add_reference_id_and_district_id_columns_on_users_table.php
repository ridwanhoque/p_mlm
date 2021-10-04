<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceIdAndDistrictIdColumnsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('reference_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->dropForeign(['reference_id']);

            $table->dropColumn('district_id', 'reference_id');
        });
    }
}
