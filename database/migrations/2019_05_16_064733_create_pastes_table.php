<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pastes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('slug');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->longText('content')->nullable();
            $table->string('syntax');
            $table->dateTime('expire_time')->nullable();
            $table->boolean('status')->comment('1->public, 2->Unlisted,3->Private');
            $table->integer('views');
            $table->boolean('encrypt');
            $table->addColumn('tinyInteger', 'self_destroy', ['length' => 4, 'nullable' => true]);
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
        Schema::dropIfExists('pastes');
    }
}
