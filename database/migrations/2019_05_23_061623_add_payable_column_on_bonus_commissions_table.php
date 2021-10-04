<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayableColumnOnBonusCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bonus_commissions', function (Blueprint $table) {
            $table->string('payable')->nullable()->default('Update Me');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bonus_commissions', function (Blueprint $table) {
            $table->dropColumn('payable');
        });
    }
}
