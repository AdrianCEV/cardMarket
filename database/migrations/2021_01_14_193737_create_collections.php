<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('nameCollection');
            $table->string('symbol');
            $table->date('dateEdition');
            $table->timestamps();
        });
        
        Schema::table('cards',function(Blueprint $table){
            $table->foreignId('collection_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards',function(Blueprint $table){
            $table->dropForeign(['collection_id']);
            $table->dropColumn(['collection_id']);
        });
        
        Schema::dropIfExists('collections');
    }
}
