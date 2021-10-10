<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Export\Enum\ExportFrequency;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('type');
            $table->string('filename');
            $table->unsignedTinyInteger('frequency')->default(ExportFrequency::EVERY_30_MINUTES);
            $table->json('parameters');
            $table->unsignedBigInteger('assigned_by_id')->nullable();
            $table->timestamp('exported_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exports');
    }
}
