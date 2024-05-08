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
        Schema::create('subscription_month', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->integer("count_month");
            $table->timestamps();
        });
        }
	
    public function down(): void
    {
        Schema::dropIfExists('subscription_month');
    }
};
