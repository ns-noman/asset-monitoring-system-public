<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requisition_details', function (Blueprint $table) {
            $table->id();
            $table->integer('requisition_id');
            $table->integer('category_id');
            $table->integer('quantity');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('requisition_details');
    }
};
