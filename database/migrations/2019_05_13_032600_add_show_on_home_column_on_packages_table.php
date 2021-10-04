<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowOnHomeColumnOnPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('is_publish');
            $table->timestamp('publish_at')->nullable();
            $table->boolean('show_on_home')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('published_by')->nullable();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('published_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('is_publish')->default(0);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['published_by']);

            $table->dropColumn('category_id', 'publish_at', 'show_on_home', 'published_by');
        });
    }
}
