<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEduTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id');
            $table->string('name');
            $table->string('email');
            $table->string('address')->nullable();
            $table->tinyInteger('email_verified')->default(1)->comment = '1=Yes, 0=No';
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->integer('varsity_id')->nullable()->comment = 'PK = edu_universities.id';
            $table->integer('created_by');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->string('status')->default('Active');
            $table->tinyInteger('valid')->comment = '1=Yes, 0=No';

        });

        DB::table('edu_teachers')->insert(
            array(
                'id'=> 1, 
                'teacher_id'=> '1001', 
                'name'=> 'Md.Teacher', 
                'email'=> 'teacher@gmail.com', 
                'address'=> 'Dhaka', 
                'email_verified'=> 1, 
                'email_verified_at'=> null, 
                'password'=> '$2y$10$QA2tpIzuEbbRf//TxfSj.OkRg4.4k/PiLI8TE2IpNBqJuC9A9nZH6', 
                'phone'=> null, 
                'image'=> null, 
                'active_status'=> 1, 
                'created_by'=> 1, 
                'remember_token'=> null, 
                'created_at'=> '2020-10-14 17:38:27', 
                'updated_at'=> '2020-10-14 17:38:27', 
                'deleted_at'=> null, 
                'status'=> 'Active', 
                'valid'=> 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edu_teachers');
    }
}
