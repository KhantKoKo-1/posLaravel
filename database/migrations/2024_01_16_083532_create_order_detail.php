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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('original_amount')->default(0);
            $table->unsignedInteger('discount_amount')->default(0);
            $table->unsignedInteger('sub_total')->default(0);
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('item_id');
            // $table->foreign('order_id')->references('id')->on('order');
            // $table->foreign('item_id')->references('id')->on('item');
            $table->tinyInteger('status')->default(0)->comment('0 (unpaid) 1 (paid) 2 (cancel)');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->unsignedInteger('deleted_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail');
    }
};
