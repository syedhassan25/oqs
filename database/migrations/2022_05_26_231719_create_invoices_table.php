<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id');
            $table->date('date'); //invoice date
            $table->float('invoice_amount', 11, 2);
            $table->float('paid_from_user_balance', 11, 2);
            $table->integer('discount')->default(0);
            $table->float('paid_amount', 11, 2);
            $table->float('remaing_amount', 11, 2);
            $table->text('reference_id')->nullable();
            $table->enum('created_type', ['system', 'custom']);
            $table->enum('paid_type', ['partial', 'full']);
            $table->enum('status', ['paid', 'unpaid', 'cancelled', 'draft']);
            $table->text('notes')->nullable();
            $table->text('transaction_id')->nullable();
            $table->enum('paid_by', ['paypal', 'visa', 'master', 'american_express', 'none']);
            $table->float('remaining_amount', 11, 2);
            $table->text('capture_id')->nullable();
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('invoices');
    }
}
