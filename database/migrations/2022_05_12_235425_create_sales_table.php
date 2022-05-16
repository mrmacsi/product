<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('quantity');
            $table->decimal('profit',10,2)->nullable();
            $table->decimal('unit_cost',10,2);
            $table->decimal('shipping_cost',10,2)->nullable();
            $table->decimal('cost',10,2)->nullable();
            $table->decimal('selling_price',10,2)->nullable();
            $table->string('name')->nullable();
            $table->date('sold_at')->nullable();
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
        Schema::dropIfExists('sales');
    }
};
