<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\Invoice;
use Carbon\Carbon;

class DueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Due:Invoices';

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
        //
        $invoices = Invoice::where("status", "pending")
        ->whereDate("date", "<", date("Y-m-d"))->get();
        $getTodayDate = date("d");
        if(!empty($invoices)){
            foreach($invoices as $i){
                $add3Day = Carbon::createFromFormat('Y-m-d', $i->date)->addDays('3')->format('Y-m-d');
                if(strtotime($add3Day) < strtotime(date("Y-m-d"))){
                    Invoice::where("id", $i->id)->update([
                        "status" => "unpaid"
                    ]);
                }
            }
        }
    }
}
