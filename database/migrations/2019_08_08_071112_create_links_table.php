<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('web_name')->nullable();
            $table->string('link')->nullable();
            $table->string('top_domain')->nullable();
            $table->string('domain_name')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->unsignedBigInteger('view')->default(0)->nullable();
            $table->string('ip')->nullable();
            $table->tinyInteger('timeout_times')->default(0)->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('links');
    }
}
