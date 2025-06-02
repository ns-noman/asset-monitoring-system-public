<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transfer_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('tr_no', 50)->unique();
            $table->integer('by_branch_id');
            $table->integer('from_branch_id');
            $table->integer('to_branch_id');
            $table->date('date');
            $table->string('creator_branch_remarks')->nullable();
            $table->string('receiver_branch_remarks')->nullable();
            $table->integer('created_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
            $table->integer('from_branch_created_by_id')->nullable();
            $table->integer('from_branch_updated_by_id')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=Approved, 2=cancel, 3=Back To Corrections.');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('transfer_requisitions');
    }
};
