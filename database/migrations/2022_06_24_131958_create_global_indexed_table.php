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
        Schema::table('product_variations', function (Blueprint $table) {
            $table->index('is_enabled');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('is_in_home');
            $table->index('status');
            $table->index('group_id');
            $table->index(['is_in_home', 'status', 'group_id']);
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->index('status');
            $table->index('is_in_home');
            $table->index(['status', 'is_in_home']);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->index('is_enabled');
            $table->index('page');
            $table->index(['is_enabled', 'page']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->index(['is_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropIndex(['is_enabled']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_in_home']);
            $table->dropIndex(['status']);
            $table->dropIndex(['group_id']);
            $table->dropIndex(['is_in_home', 'status', 'group_id']);
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropIndex('status');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['is_in_home']);
            $table->dropIndex(['status', 'is_in_home']);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->index(['is_enabled']);
            $table->index(['page']);
            $table->index(['is_enabled', 'page']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropIndex(['is_enabled']);
        });
    }
};
