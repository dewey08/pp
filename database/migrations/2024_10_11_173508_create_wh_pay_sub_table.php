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
        if (!Schema::hasTable('wh_pay_sub'))
        {
            Schema::create('wh_pay_sub', function (Blueprint $table) {
                $table->bigIncrements('wh_pay_sub_id'); 
                $table->string('wh_stock_dep_sub_id')->nullable();  //
                // $table->string('pay_year')->nullable();  // 
                // $table->string('stock_list_id')->nullable(); //     คลังใหญ่
                // $table->string('stock_list_subid')->nullable(); //  คลังย่อย
                // $table->string('wh_pay_id')->nullable(); // 
                // $table->string('pro_id')->nullable();  //  
                // $table->string('pro_name')->nullable();  //   
                // $table->string('qty')->nullable();  //  
                // $table->string('qty')->nullable();  // 
                // $table->string('unit_id')->nullable();  //  
                // $table->string('unit_name')->nullable();  // 
                // $table->decimal('one_price',total: 12, places: 2)->nullable(); //   
                // $table->decimal('total_price',total: 12, places: 2)->nullable(); //                  
                // $table->string('user_id')->nullable(); //   
                // $table->string('lot_no')->nullable();  //    
                // $table->date('date_start')->nullable();  //  
                // $table->date('date_enddate')->nullable();  //                           
                // $table->timestamps();
                $table->string('wh_pay_id')->nullable(); // 
                $table->string('wh_stock_dep_id')->nullable(); // 
                $table->string('wh_stock_export_sub_id')->nullable(); // 
                $table->string('wh_stock_export_id')->nullable(); // 
                $table->string('wh_request_id')->nullable(); // 
                $table->string('stock_list_id')->nullable(); //  คลังหลัก
                $table->string('stock_list_subid')->nullable(); //  รับเข้าคลัง(ย่อย)
                $table->string('pay_year')->nullable();  //     
                $table->string('pro_id')->nullable();  //  
                $table->string('pro_code')->nullable();  //  
                $table->string('pro_name')->nullable();  //   
                $table->string('qty')->nullable();  //  
                $table->string('qty_stock')->nullable();  //    qty_pay
                $table->string('qty_pay_sub')->nullable();  // 
                $table->string('unit_id')->nullable();  //  
                $table->string('unit_name')->nullable();  // 
                $table->decimal('one_price',total: 12, places: 2)->nullable(); //   
                $table->decimal('total_price',total: 12, places: 2)->nullable(); //                  
                $table->string('user_id')->nullable(); //   
                $table->string('lot_no')->nullable();  //    
                $table->date('date_start')->nullable();  //  
                $table->date('date_enddate')->nullable();  //  
                $table->date('date_export')->nullable();  //      วันที่ตัดจ่าย     
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_pay_sub');
    }
};
