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
        if(Schema::hasTable('sales')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dateTime('sold_at')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('sales')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->date('sold_at')->nullable()->change();
            });
        }
    }
};
