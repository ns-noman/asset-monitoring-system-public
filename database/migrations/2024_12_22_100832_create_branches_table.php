<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->string('phone')->nullable();
            $table->string('address', 50)->nullable();
            $table->tinyInteger('is_main_branch')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('created_by_id');
            $table->integer('updated_by_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
