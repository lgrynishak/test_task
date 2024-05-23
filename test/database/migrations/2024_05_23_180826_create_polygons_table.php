<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('polygons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->geometry('polygon');
            $table->timestamps();
        });

        Schema::table('polygons', function (Blueprint $table) {
            $table->spatialIndex('polygon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('polygons', function (Blueprint $table) {
            $table->dropSpatialIndex(['polygon']);
        });

        Schema::dropIfExists('polygons');
    }
};
