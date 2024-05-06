<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('user_role')->nullable();
            $table->string('password');
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->text('city')->nullable();
            $table->text('pincode')->nullable();
            $table->text('state')->nullable();
            $table->text('country')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
