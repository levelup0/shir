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
        Schema::create('aprove', function (Blueprint $table) {
            $table->id();
            $table->biginteger('user_id')->unsigned()->index(); // Кто создал (Это поле не должно быть пустым)
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');;
            $table->biginteger('voz_id')->unsigned()->index();
            $table->foreign('voz_id')->references('id')->on('voz')->onUpdate('cascade')->onDelete('cascade');;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aprove');
    }
};
