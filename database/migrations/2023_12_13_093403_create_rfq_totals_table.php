<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')->constrained('request_for_quotations')->onDelete('cascade');
            $table->decimal('transport_cost', 15, 2)->default(0);
            $table->decimal('other_cost', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_excl_tax', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('total_incl_tax', 15, 2);
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
        Schema::dropIfExists('rfq_totals');
    }
};