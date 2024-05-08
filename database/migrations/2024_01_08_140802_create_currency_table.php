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
        Schema::create('currency', function (Blueprint $table) {
					$table->id();
					$table->string('title', 255);
					$table->string('symbol_left', 12);
					$table->string('symbol_right', 12);
					$table->string('code', 3);
					$table->string('class', 255);
					$table->integer('decimal_place');
					$table->string('decimal_point', 3);
					$table->string('thousand_point', 3);
					$table->integer('status');

					$table->timestamps();
				});
			}
	
    public function down(): void
    {
        Schema::dropIfExists('currency');
    }
};
