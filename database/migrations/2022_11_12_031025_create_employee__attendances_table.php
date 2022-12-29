<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee__attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->time('checkin')->nullable();
            $table->time('checkout')->nullable();
            $table->date('checkindate')->nullable();
            $table->date('checkoutdate')->nullable();
            $table->float('duration', 8, 2);
            $table->enum('status', ["absent", "present"])->default("pending");
            $table->enum('dayType', ["full", "half"])->default("none");
            $table->softDeletes();
            $table->timestamps();
        });
    }
    

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee__attendances');
    }
}
