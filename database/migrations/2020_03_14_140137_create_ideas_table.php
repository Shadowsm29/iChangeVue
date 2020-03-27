<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_number')->nullable();
            $table->string('title');
            $table->integer('initiator_id');
            $table->uuid('change_type_id');
            $table->uuid('justification_id');
            $table->uuid('super_circle_id');
            $table->uuid('circle_id');
            $table->integer('expected_benefit');
            $table->integer('sme_id');
            $table->integer('pending_at_id');
            $table->text('description');
            $table->uuid("status_id");
            $table->integer('expected_effort')->nullable();
            $table->integer('actual_effort')->nullable();
            $table->integer('actual_benefit')->nullable();
            $table->uuid('rag_status_id')->nullable();
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
        Schema::dropIfExists('ideas');
    }
}
