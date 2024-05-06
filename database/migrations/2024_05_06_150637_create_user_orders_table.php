<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->date('pickup_date')->nullable();  
            $table->date('delivery_date')->nullable();   
            $table->text('description')->nullable();  
            $table->unsignedInteger('count')->nullable();   
            $table->string('price')->nullable();  
            $table->enum('status',['New','In-Progress','Out for Delivery','Delivered'])->default('New');  
            $table->softDeletes();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_orders');
    }
}
