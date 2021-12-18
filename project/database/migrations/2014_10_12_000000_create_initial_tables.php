<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 1024);
            $table->longText('description');
            $table->longText('contacts');
            $table->unsignedInteger('category_id');

            $table->index(['category_id'], 'catalog');
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
        Schema::dropIfExists('categories');

    }
}
