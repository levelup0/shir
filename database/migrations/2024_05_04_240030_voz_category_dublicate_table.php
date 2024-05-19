<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voz_category_relation_dublicate', function (Blueprint $table) {
            $table->id();

            $table->biginteger('category_voz_id')->unsigned()->index();
            $table->foreign('category_voz_id')->references('id')->on('category_voz')->onUpdate('cascade')->onDelete('cascade');
            $table->biginteger('voz_id')->unsigned()->index();
            $table->foreign('voz_id')->references('id')->on('voz')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voz_category_relation_dublicate');
    }
};
