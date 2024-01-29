<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutionTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solution_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solution_id');
            $table->unsignedBigInteger('ticket_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('solution_id')->references('id')->on('solutions')
                  ->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solution_tickets');
    }
};
