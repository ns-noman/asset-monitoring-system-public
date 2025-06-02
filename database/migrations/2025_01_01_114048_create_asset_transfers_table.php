<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('from_branch_id');
            $table->integer('to_branch_id');
            $table->integer('asset_id');
            $table->integer('status')->default(0)->comment('0=panding,1=received/done,2=cancelled');
            $table->date('date');
            $table->integer('created_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('asset_transfers');
    }
};
