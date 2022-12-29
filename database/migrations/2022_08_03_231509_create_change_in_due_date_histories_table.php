<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeInDueDateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_in_due_date_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_no');
            $table->date("previous_date");
            $table->date("new_date");
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
        Schema::dropIfExists('change_in_due_date_histories');
    }
}
