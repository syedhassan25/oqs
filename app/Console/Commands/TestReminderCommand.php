<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestReminder;
// use App\Mail;

class TestReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminderEmail:testReminder';

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
    //     $limit = Carbon::now()->addDay(7)->format('Y-m-d');
    //     $monthName = Carbon::now()->addDay(7)->format('F');
    // //  dd($limit);
    //      $CheckStudent  =  DB::table('student')
    //     ->select('student.*', 'countries.CountryName', 
    //      DB::raw('group_concat(studentname) as studentnameAr')
    //     ,DB::raw('group_concat(student.id) as studentids'), 
    //      DB::raw('group_concat(fee) as studentfees'))
    //     ->leftjoin('countries', 'student.country', '=', 'countries.id')
    //     ->whereDate('invoicedate', '=', "$limit")
    //     ->where('academicStatus',1)
    //     ->groupBy('group')
    //     ->get();
        
    //     \Log::info($CheckStudent);
    //     $arrr=[];
    //     if(count($CheckStudent) > 0){
            
              
    //           foreach($CheckStudent as $index => $val){
                  
    //               $lastInvoiceID = DB::table('invoice_order')->orderBy('order_id', 'DESC')->pluck('order_id')->first();
    //               $newInvoiceID = (($lastInvoiceID) ? $lastInvoiceID + 1  : '1').rand(1,10);
                  
    //                           $studentnamesArr = explode(',', $val->studentnameAr);
    //                           $studentidArr = explode(',', $val->studentids);
    //                           $studentfeesArr = explode(',', $val->studentfees);
                              
    //                           \Log::info($studentidArr);
                              
    //                           $totalFee  = array_sum($studentfeesArr);
                              
    //                         $dataInvoiceOrder  = array(
    //                             'invoiceId' => $newInvoiceID,
    //                             'groupno' =>  $val->group,
    //                             'order_date' => $val->invoicedate,
    //                             'order_receiver_name' => ($val->fathername == "None") ? $val->studentname.' Father' :  $val->fathername,
    //                             'order_receiver_address' => $val->CountryName,
    //                             'order_total_before_tax' => 0,
    //                             'order_total_tax' => 0,
    //                             'order_tax_per' => 0,
    //                             'order_total_after_tax' => 0,
    //                             'order_amount_paid' => $totalFee ,
    //                             'order_total_amount_due' => $totalFee,
    //                             'note' => 'invoice Of The '.$monthName,
    //                             'paidType' => 'full',
    //                             'status' => 'active',
    //                             'paymentStatus' => 'unpaid',
    //                             'transcationId' => '',
    //                             'captureId' =>''
    //                             );
                                
    //                             $arrr[] = $dataInvoiceOrder;
                                
    //                           $details = [
    //                             'title' => 'Mail from sispm.com',
    //                             'body' => 'This is for testing email using smtp'
    //                         ];
                           
    //                           $Reaaar  = Mail::to('syedhassan25@hotmail.com')->send(new TestReminder($details));
    //                           dd("ddddd--".$Reaaar.'--test email');
                            
    //                     //      $data = [
    //                     //       'subject' => 'Seven Days Reminder',
    //                     //       'email' => 'syedhassan25@hotmail.com',
    //                     //       'content' => 'This is for testing email using smtp'
    //                     //     ];
                    
    //                     //   $Reaaar = Mail::send('emails.test', $data, function($message) use ($data) {
    //                     //       $message->to($data['email'])
    //                     //       ->subject($data['subject']);
    //                     //     });
                                
                                
    //                     //         dd("ddddd--".$Reaaar.'--test email');
                            
                     
                        
    //                     // for($i=0;$i<count($studentnamesArr);$i++){
                            
    //                     //     $childOrder = array(
    //                     //         'order_id' => $invoiceOrderID,
    //                     //         'studentid' =>$studentidArr[$i],
    //                     //         'studentName' => $studentnamesArr[$i],
    //                     //         'order_item_price' => $studentfeesArr[$i] ,
    //                     //         'order_item_final_amount' => $studentfeesArr[$i]
    //                     //         );
                            
                           
    //                     // }
                       
                                         
                        
    //           }
             
            
    //     }
        //  dd($arrr);
        
           Mail::raw("This is automatically generated Hourly Update", function($message)
           {
               $message->from('testing@sispn.net');
       $message->to('syedhassan25@hotmail.com')->subject('Hourly Update');
               
                 $this->info('Hourly Update has been send successfully');
           });
        
      
    }
}
