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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //Фио
            $table->string('business_sector')->nullable(); //Сфера бизнеса
            $table->longText('action_sector')->nullable(); //Описание деятельности
            $table->string('date_birth')->nullable(); //Дата рождения
            $table->string('url_telegram')->nullable(); //Телеграм URL
        
            // $table->string('vuz')->nullable(); //ВУЗ
            // $table->string('education_course')->nullable(); //ВУЗ
            // $table->string('interes')->nullable(); //Краткое описание своих интересов
            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->biginteger('user_role_id')->unsigned()->index();
            $table->foreign('user_role_id')->references('id')->on('user_role')->onUpdate('cascade')->onDelete('cascade');
           
            $table->string('user_id_created')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
