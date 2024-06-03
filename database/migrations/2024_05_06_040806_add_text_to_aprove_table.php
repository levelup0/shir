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
        Schema::table('aprove', function (Blueprint $table) {
            $table->longText('text')->nullable();
        });
    }
	
    public function down(): void
    {
        Schema::table('aprove', function (Blueprint $table) {
            $table->dropColumn('text');
        });
    }
};
