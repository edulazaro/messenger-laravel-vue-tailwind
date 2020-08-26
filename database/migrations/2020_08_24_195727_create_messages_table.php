<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->integer('from')->unsigned()->references('id')->on('users');
            $table->integer('to')->unsigned()->references('id')->on('users');
            $table->text('subject')->default("(no subject)");
            $table->text('content');
            $table->dateTime('read_at')->nullable();
            $table->dateTime('archived_at')->nullable();
            $table->timestamps();
            $table->engine = "InnoDB";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
