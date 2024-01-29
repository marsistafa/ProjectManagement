<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutioncommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutioncomments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('solution_id');
            $table->text('content');
            $table->softDeletes(); // For the deleted_at column
            $table->timestamps();

            // Foreign key constraints (Optional, but recommended)
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('solution_id')->references('id')->on('solutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solutioncomments');
    }
}
