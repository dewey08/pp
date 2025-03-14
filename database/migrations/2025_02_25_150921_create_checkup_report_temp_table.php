<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('checkup_report_temp'))
        {
            Schema::create('checkup_report_temp', function (Blueprint $table) {
                $table->bigIncrements('checkup_report_temp_id'); 
                $table->string('vn')->nullable();// รหัส              
                $table->string('hn')->nullable();//                 
                $table->date('vstdate')->nullable();//
                $table->Time('vsttime')->nullable();//
                $table->string('department')->nullable();//
                $table->string('ptname')->nullable();//
                $table->string('cid')->nullable();//  
                $table->string('pttype')->nullable();// สิทธิ์
                $table->date('sex')->nullable();//
                $table->date('sex_code')->nullable();//
                $table->date('age_y')->nullable();// 
                $table->string('bw')->nullable();// 
                $table->date('height')->nullable();// 
                $table->string('waist')->nullable();// 
                $table->string('temperature')->nullable();// 
                $table->string('rr')->nullable();// 
                $table->string('pulse')->nullable();// 
                $table->string('bmi')->nullable();// 
                $table->string('bps')->nullable();//  
                $table->string('bpd')->nullable();//
                $table->string('hometel')->nullable();//                  

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkup_report_temp');
    }
};
