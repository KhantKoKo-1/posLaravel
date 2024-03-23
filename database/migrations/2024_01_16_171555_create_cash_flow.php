<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flow', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('shift_id');
            $table->unsignedInteger('50')->nullable();
            $table->unsignedInteger('100')->nullable();
            $table->unsignedInteger('200')->nullable();
            $table->unsignedInteger('500')->nullable();
            $table->unsignedInteger('1000')->nullable();
            $table->unsignedInteger('5000')->nullable();
            $table->unsignedInteger('10000')->nullable();
            $table->unsignedInteger('20000')->nullable();
            $table->unsignedInteger('total_quantity')->nullable();
            $table->dateTime('updated_at');
            $table->tinyInteger('updated_by');
            $table->dateTime('deleted_at')->nullable();
            $table->tinyInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_flow');
    }
};

