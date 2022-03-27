<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('tag')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('retweets')->default(0);
            $table->string('img')->nullable();
            $table->boolean('Is_bookmarked')->default(false);
            $table->boolean('Is_liked')->default(false);
            $table->boolean('Is_retweeted')->default(false);
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tweets');
    }
}
