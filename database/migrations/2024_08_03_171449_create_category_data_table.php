<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('category_data', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('category_id');
        //     $table->foreign('category_id')->references('id')->on('categories');
        //     $table->text('label');
        //     $table->string('price')->nullable();
        //     $table->string('maxQuantity')->nullable();
        //     $table->string('image_path')->nullable();
        //     $table->softDeletes();
        //     $table->timestamp('created_at')->useCurrent();
        //     $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_data');
    }
}
