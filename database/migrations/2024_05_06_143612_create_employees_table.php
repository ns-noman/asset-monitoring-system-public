<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
