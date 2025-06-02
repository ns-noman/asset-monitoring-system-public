<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();


            // CREATE TABLE asset (
            //     purchase_date DATE NOT NULL,
            //     purchase_value DECIMAL(10, 2) NOT NULL,
            //     warranty_time INT NOT NULL COMMENT 'Warranty time in months',
            //     asset_life INT NOT NULL COMMENT 'Asset life in years',
            //     depreciation_rate DECIMAL(5, 2) NOT NULL COMMENT 'Depreciation rate in percentage',
            // );


            $table->integer('category_id');
            $table->string('code')->unique();
            $table->string('title');
            $table->longText('description')->nullable();
            
            $table->date('purchase_date');
            $table->decimal('purchase_value',10,2);
            $table->integer('warranty_time');
            $table->integer('asset_life');
            $table->decimal('depreciation_rate', 10,2);


            $table->tinyInteger('is_assigned')->default(0);
            $table->tinyInteger('is_okay')->default(1);
            $table->tinyInteger('location')->default(0)->comments('0=store, 1=branch, 2=transit,3=garage');
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('created_by_id');
            $table->bigInteger('updated_by_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('assets');
    }
};
