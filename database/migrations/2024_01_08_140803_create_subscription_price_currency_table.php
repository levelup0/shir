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
        Schema::create('subscription_price_currency', function (Blueprint $table) {
            $table->id();

            $table->biginteger('subscription_id')->unsigned()->index();
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onUpdate('cascade')->onDelete('cascade');

            $table->biginteger('currency_id')->unsigned()->index()->nullable();
            $table->foreign('currency_id')->references('id')->on('currency')->onUpdate('cascade')->onDelete('cascade');

            $table->decimal('summ', 10, 2);

            $table->timestamps();
        });
        }
	
    public function down(): void
    {
        Schema::dropIfExists('subscription_price_currency');
    }
};
