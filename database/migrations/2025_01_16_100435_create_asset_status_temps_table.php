<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_status_temps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id');
            $table->bigInteger('asset_id');
            $table->string('remarks')->nullable();
            $table->tinyInteger('is_okay')->default(1);
            $table->date('date');
            $table->bigInteger('created_by_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('asset_status_temps');
    }
};
