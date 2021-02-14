<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('nameCard');
            $table->string('description');
            $table->string('collection');
            $table->timestamps();
        });
        
        Schema::table('sales',function(Blueprint $table){
            $table->foreignId('card_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales',function(Blueprint $table){
            $table->dropForeign(['card_id']);
            $table->dropColumn(['card_id']);
        });
        
        Schema::dropIfExists('cards');
    }
}
