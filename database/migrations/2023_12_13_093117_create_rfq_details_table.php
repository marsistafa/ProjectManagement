<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')->constrained('request_for_quotations')->onDelete('cascade');
            $table->unsignedInteger('item_number');
            $table->string('description');
            $table->string('unit');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price_excl_tax', 10, 2);
            $table->decimal('total_price_excl_tax', 10, 2);
            $table->text('technical_details')->nullable();
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
        Schema::dropIfExists('rfq_details');
    }
}
;
