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
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->decimal('summ', 10, 2);

            $table->biginteger('currency_id')->unsigned()->index()->nullable();
            $table->foreign('currency_id')->references('id')->on('currency')->onUpdate('cascade')->onDelete('cascade');

            $table->integer("count_operator");
        });

        
    }
	
    public function down(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropColumn('summ');
            $table->dropColumn('currency_id');
            $table->dropColumn('count_operator');
        });
    }
};
