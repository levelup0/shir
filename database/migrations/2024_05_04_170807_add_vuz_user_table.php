<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('vuz')->nullable(); //ВУЗ
            $table->string('education_course')->nullable(); //ВУЗ
            $table->string('interes')->nullable(); //Краткое описание своих интересов
        });
    }
	
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('vuz');
            $table->dropColumn('education_course');
            $table->dropColumn('interes');
        });
    }
};
