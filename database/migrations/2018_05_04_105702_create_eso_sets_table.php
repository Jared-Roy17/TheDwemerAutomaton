<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsoSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eso_sets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('location');
            $table->string('type');
            $table->string('slug');
            $table->string('bonus_item_1')->nullable();
            $table->string('bonus_item_2')->nullable();
            $table->string('bonus_item_3')->nullable();
            $table->string('bonus_item_4')->nullable();
            $table->string('bonus_item_5')->nullable();
            $table->integer('has_jewels')->default(0);
            $table->integer('has_weapons')->default(0);
            $table->integer('has_light_armor')->default(0);
            $table->integer('has_medium_armor')->default(0);
            $table->integer('has_heavy_armor')->default(0);
            $table->integer('traits_needed')->nullable();
            $table->integer('order');
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
        Schema::dropIfExists('eso_sets');
    }
}
