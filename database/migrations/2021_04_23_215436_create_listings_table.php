<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('city')->nullable();
            $table->longText('location')->nullable();
            $table->string('type')->nullable();
            $table->decimal('price', 20, 2)->nullable();
            $table->integer('area')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('attach_bathrooms')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->string('purpose')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
