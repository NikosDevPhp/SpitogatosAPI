<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // mysql ENUM type is not used for types mainly because possible values MAY change in the future
        // ENUM has also a lot of known issues
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')
                  ->unsigned();
            $table->foreign('listing_id')
                  ->references('listing_id')
                  ->on('listings')
                  ->onDelete('cascade');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
