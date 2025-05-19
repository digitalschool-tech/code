<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('index')->default(0);
            $table->text('description')->nullable();
            $table->string('player')->nullable();
            $table->text('goal')->nullable();
            $table->string('route')->nullable();
            $table->text('blocks')->nullable();
            $table->string('video_url')->nullable();
            $table->text('required_blocks')->nullable();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('levels');
    }
}
