<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('project_id'); // Foreign key to 'projects' table
            $table->unsignedBigInteger('created_by'); // Foreign key to 'users' table
            $table->boolean('is_approved')->default(false); // Approval status
            $table->timestamps(); // 'created_at' and 'updated_at' columns
        });
        
        // Foreign key constraints
        Schema::table('solutions', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solutions');
    }
}