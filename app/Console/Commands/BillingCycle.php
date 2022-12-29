<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\InvoiceBillingCycle;
use App\models\Invoice;

class BillingCycle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:cycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $current_date = date("Y-m-d");

        $invoices = InvoiceBillingCycle::whereDate("date_paid", $current_date)->get();
        if(!empty($invoices)){
            foreach($invoices as $i){
                $lastInvoice = Invoice::where("group_id", $i->group_id)->latest()->first();
                Invoice::create([
                    "group_id" => $i->group_id,
                    "date" => $current_date,
                    "invoice_amount" => $i->amount,
                    "paid_from_user_balance" => 0,
                    "discount" => 0,
                    "paid_amount" => 0,
                    "remaing_amount" => $lastInvoice->remaing_amount,
                    "created_type" => "custom",
                    "paid_type" => "partial",
                    "status" => "unpaid",
                    "notes" => $lastInvoice->notes,
                    "paid_by" => "none",
                    "created_by" => $lastInvoice->created_by,
                ]);
            }
        }
        //
    }
}
