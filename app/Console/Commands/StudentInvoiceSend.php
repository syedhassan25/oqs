<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use App\models\FcmNotification;
use App\models\User;
use App\models\Employee;
use App\models\Student;
use App\models\Task;
use App\models\taskAssign;
use DateTime;
use Ramsey\Uuid\Uuid;

class StudentInvoiceSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Student Invoice  Send';

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
        
        \Log::info('Invoice Send');
        
         $now  = Carbon::today()->format('Y-m-d');
         $monthName = Carbon::today()->format('F');
    
         $CheckStudent  =  DB::table('student')
        ->select('student.*', 'countries.CountryName', 
         DB::raw('group_concat(studentname) as studentnameAr')
        ,DB::raw('group_concat(student.id) as studentids'), 
         DB::raw('group_concat(fee) as studentfees'))
        ->leftjoin('countries', 'student.country', '=', 'countries.id')
        ->whereDate('invoicedate', '=', "$now")
        ->where('academicStatus',1)
        ->groupBy('group')
        ->get();
        
        \Log::info($CheckStudent);
        if(count($CheckStudent) > 0){
            
           
                   
              $arrr=[];
              foreach($CheckStudent as $index => $val){
                  
                   $lastInvoiceID = DB::table('invoice_order')->orderBy('order_id', 'DESC')->pluck('order_id')->first();
                   $newInvoiceID = (($lastInvoiceID) ? $lastInvoiceID + 1  : '1').rand(1,10);
                  
                              $studentnamesArr = explode(',', $val->studentnameAr);
                              $studentidArr = explode(',', $val->studentids);
                              $studentfeesArr = explode(',', $val->studentfees);
                              
                               \Log::info($studentidArr);
                              
                              $totalFee  = array_sum($studentfeesArr);
                              
                            $dataInvoiceOrder  = array(
                                'invoiceId' => $newInvoiceID,
                                'groupno' =>  $val->group,
                                'order_date' => $now,
                                'order_receiver_name' => ($val->fathername == "None") ? $val->studentname.' Father' :  $val->fathername,
                                'order_receiver_address' => $val->CountryName,
                                'order_total_before_tax' => 0,
                                'order_total_tax' => 0,
                                'order_tax_per' => 0,
                                'order_total_after_tax' => 0,
                                'order_amount_paid' => $totalFee ,
                                'order_total_amount_due' => $totalFee,
                                'note' => 'invoice Of The '.$monthName,
                                'paidType' => 'full',
                                'url' => Uuid::uuid4(),
                                'status' => 'active',
                                'paymentStatus' => 'unpaid',
                                'transcationId' => '',
                                'captureId' =>''
                                );
                            
                        $invoiceOrderID  =DB::table('invoice_order')->insertGetId($dataInvoiceOrder);
                        
                        for($i=0;$i<count($studentnamesArr);$i++){
                            
                            $childOrder = array(
                                'order_id' => $invoiceOrderID,
                                'studentid' =>$studentidArr[$i],
                                'studentName' => $studentnamesArr[$i],
                                'order_item_price' => $studentfeesArr[$i] ,
                                'order_item_final_amount' => $studentfeesArr[$i]
                                );
                            
                            DB::table('invoice_order_item')->insert($childOrder);
                        }
                       
                                         
                        
              }
            
        }
    }
}
