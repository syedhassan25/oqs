<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;
use Carbon\Carbon;
use Datatables;
use DateTime;
use DateTimeZone;
use DB;
use Hash;
use Validator;

class ReminderController extends BaseController
{
     public function index()
    {
        $this->setPageTitle('Reminder', 'View All Reminder');
        return view('admin.teacherpanel.reminder.index');
    }
    
      public function get_reminder_forms(Request $request)
    {
      
    //   $teacherId = Employee::where('user_id',Auth::user()->id)->first()->id;
       
        $userid =   Auth::user()->id;


        $reminder = DB::table('reminder')->select(['reminder.*'])->where('user_id',$userid);
        return Datatables::of($reminder)
            
            ->addColumn('action', function ($reminder) {

                 
                $ret =  '<a data-id="'.$reminder->id.'" class="btn btn-primary btneditreminder">Edit</a>' ;
               

                return $ret;

            })
           
            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }
    
    public function store(Request $request){
        $rules = array(
            'title' => "required",
            'purpose' => "required",
            'reminderdate' => "required",
        );
       
        DB::beginTransaction();
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }
        try {

        
        
        
         $userid =   Auth::user()->id;
        
        
        
        if($request->id){
            $reminderid =  $request->id;
            
            $reminder =  DB::table('reminder')->where('id',$reminderid)->update([
                         'title' => $request->title,
                         'purpose' => $request->purpose,
                         'reminderdate' => $request->reminderdate,
                        ]);
                        
                         
            
        }else{
             $reminderid =  DB::table('reminder')->insertGetId([
                         'title' => $request->title,
                         'purpose' => $request->purpose,
                         'reminderdate' => $request->reminderdate,
                         'user_id' => $userid
                        ]);
        }
        
        
                  
                        
                       
                        
                   DB::commit();
                        
                        
            return response()->json([
                    'Success' => 'true' , 'msg' => 'reminder Send Succesfully']);            
        
         
           

        } catch (\Exception $e) {
           
            return response()->json([
                'Error' => $e]);
        }
    }
    
    public function editreminder(Request $request){
        
        $id  = $request->id;
        $reminder = DB::table('reminder')->select(['reminder.*'])->where('id',$id)->first();
        return response()->json($reminder);
    }
}
