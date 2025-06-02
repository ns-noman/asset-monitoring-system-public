<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assign_assets', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('asset_id');
            $table->integer('created_by_id');
            $table->integer('updated_by_id');
            $table->date('date');
            $table->tinyInteger('in_branch')->default(1);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('assign_assets');
    }
};
