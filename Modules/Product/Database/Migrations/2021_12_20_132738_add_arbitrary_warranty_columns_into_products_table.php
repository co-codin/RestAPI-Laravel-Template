<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArbitraryWarrantyColumnsIntoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_arbitrary_warranty')->after('warranty_info')->default(false);
            $table->text('arbitrary_warranty_info')->after('is_arbitrary_warranty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_arbitrary_warranty');
            $table->dropColumn('arbitrary_warranty_info');
        });
    }
}
