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
        Schema::create('voz', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500); 
            $table->string('sector', 500); 
            $table->longText('description')->nullable(); //Описание деятельности
            $table->timestamp('publish_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_date')->default(DB::raw('CURRENT_TIMESTAMP'));
             
            $table->biginteger('user_id')->unsigned()->index(); // Кто создал (Это поле не должно быть пустым)
            $table->foreign('user_id')->references('id')->on('users');
          
            $table->string('status')->nullable();

            $table->biginteger('category_voz_id')->unsigned()->index();
            $table->foreign('category_voz_id')->references('id')->on('category_voz');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voz');
    }
};
