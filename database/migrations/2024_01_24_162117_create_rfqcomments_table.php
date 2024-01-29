<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rfqcomments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('request_for_quotation_id');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_for_quotation_id')->references('id')->on('request_for_quotations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rfqcomments');
    }
};
