<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\Parents;
use App\models\UserWallet;
use App\models\Invoice;
use App\models\InvoiceItem;
use Carbon\Carbon;
use App\models\StudentAttendance;
use App\models\InvoiceBillingCycle;

class InvoiceSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:create';

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
        $getTodayDate = date("d");
        $from = Carbon::now()->subDays('30')->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $data = Parents::whereNotNull('invoice_date')
        ->with([
            'students' => function($q){
                $q->with([
                    "RegisterPackage"
                ])
                ->where("academicStatus", "!=", 4)
                ->whereHas('RegisterPackage');
            },
            "getInvoice" => function($q){
                $q->where("date", Carbon::now()->format('Y-m-d'));
            }
        ])
        ->whereDoesntHave("getInvoice")
        ->whereHas("students")
        ->whereHas("students.RegisterPackage")
        ->whereDay('invoice_date', $getTodayDate)
        ->get();

        if(!empty($data)){
            foreach($data as $k => $d){
                $invoice_id = uniqid();
                $invoice_amount = 0;

                if(!empty($d->students)){
                    foreach($d->students as $dkey => $students){
                        $student_attendance = StudentAttendance::where("student_id", $students->id)
                        ->select('package_id', 'attendance_date_time', 'duration')
                        ->selectRaw('count(package_id) as number_of_days')
                        ->whereBetween("attendance_date_time", [$from, $to])
                        ->with([
                            "getPackage",
                        ])
                        ->groupBy('package_id')
                        ->orderBy('package_id', 'DESC')
                        ->having('package_id', '>', 0)
                        ->get();
                        
                        if(!$student_attendance->isEmpty()){
                            $d->students[$dkey]->student_attendance = $student_attendance;
                        }
                    }
                }

                if(!empty($d->students)){
                    foreach($d->students as $dkey => $students){
                        if(!empty($students->student_attendance)){
                            foreach($students->student_attendance as $student_days){
                                if($student_days->number_of_days <= $student_days->getPackage->lessons_per_month){
                                    $totalAmount = $student_days->getPackage->amount / $student_days->getPackage->lessons_per_month;
                                    $totalAmount = $totalAmount * $student_days->number_of_days;
                                }else{
                                    $totalAmount = $student_days->getPackage->amount;
                                }
                                InvoiceItem::create([
                                    "invoice_id" => $invoice_id,
                                    "student_id" => $students->id,
                                    "package_id" => $student_days->package_id,
                                    "duration" => $student_days->duration,
                                    "per_month_amount" => $student_days->getPackage->amount,
                                    "discount" => 0,
                                    "total_month" => 1, //$student_days->number_of_days,
                                    "total" => $totalAmount,
                                ]);
                                $invoice_amount+= $totalAmount;
                            }
                        }
                    }
                }

                $billingCycle = InvoiceBillingCycle::where([
                    "group_id" => $d->groupno,
                    "cycle_status" => "unpaid"
                ])->whereBetween("date_paid", [$from, $to])->sum('amount');
        
                $unpaidinvoices = Invoice::where([
                    "group_id" => $d->groupno,
                ])->latest()->first();

                if(!empty($unpaidinvoices)){
                    $unpaidinvoices = $unpaidinvoices->remaing_amount;
                }else{
                    $unpaidinvoices = 0;
                }
                
                $userWallet = new UserWallet;
                $userBalance = $userWallet->getUserBalance($d->user_id);

                $remainingAmount = $unpaidinvoices + $invoice_amount;
                $remainingAmount = $remainingAmount - $userBalance;

                $ins = [
                    "group_id" => $d->groupno,
                    "date" => Carbon::now()->format('Y-m-d'),
                    "invoice_amount" => $invoice_amount,
                    "paid_from_user_balance" => $userBalance,
                    "discount" => 0,
                    "paid_amount" => 0,
                    "remaing_amount" => abs($remainingAmount),
                    "created_type" => "custom",
                    "paid_type" => "partial",
                    "status" => "pending",
                    "notes" => "",
                    "paid_by" => "none",
                    "created_by" => 0,
                ];
                $get_new_id = Invoice::create($ins)->id;
                InvoiceItem::where("invoice_id", $invoice_id)->update([
                    "invoice_id" => $get_new_id
                ]);
            }
        }
    }
}
