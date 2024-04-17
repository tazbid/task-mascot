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
            $table->string('full_name');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->date('dob');
            $table->string('password');
            $table->boolean('status');
            $table->boolean('verification_status')->default(0);
            $table->integer('verification_code')->nullable();
            $table->text('avatar_path')->nullable();

            //employee fields
            // $table->string('designation')->nullable();
            // $table->string('contact_number')->nullable();
            // $table->string('employee_code')->nullable();
            // $table->string('employee_department')->nullable();
            // $table->string('desk_status')->nullable();
            // $table->string('office_status')->nullable();
            // $table->string('remarks')->nullable();


            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
