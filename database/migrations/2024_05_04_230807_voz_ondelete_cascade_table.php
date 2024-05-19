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
        Schema::dropIfExists('voz_category_relation');

        // Schema::table('voz_category_relation', function (Blueprint $table) {

        //     $table->foreign('category_voz_id')
        // ->references('id')->on('category_voz')
        // ->onDelete('cascade')
        // ->change();

        //     // $table->dropForeign('voz_category_relation_category_voz_id_index');
        //     // $table->foreign('category_voz_id')->references('id')->on('category_voz')->onUpdate('cascade')->onDelete('cascade');

        //     // $table->biginteger('category_voz_id')->unsigned()->index();
        //     // $table->foreign('category_voz_id')->references('id')->on('category_voz')->onUpdate('cascade')->onDelete('cascade');;
        //     // $table->biginteger('voz_id')->unsigned()->index();
        //     // $table->foreign('voz_id')->references('id')->on('voz')->onUpdate('cascade')->onDelete('cascade');;
        // });
    }
	
    public function down(): void
    {
        Schema::dropIfExists('voz_category_relation');
    }
};
