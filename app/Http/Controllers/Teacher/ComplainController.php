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

class ComplainController extends BaseController
{
     public function index()
    {
        $this->setPageTitle('Complain', 'View All Complain');
        return view('admin.teacherpanel.complain.index');
    }
    
     public function get_complain_forms(Request $request)
    {
      
    //   $teacherId = Employee::where('user_id',Auth::user()->id)->first()->id;
       
        $userid =   Auth::user()->id;


        $complain = DB::table('complain')->select(['complain.*'])->where('sender_user_id',$userid);
        return Datatables::of($complain)
            
            ->addColumn('action', function ($complain) {

                 
                $ret =  '<a data-id="'.$complain->id.'" class="btn btn-primary btneditcomplain">Edit</a>' ;
               

                return $ret;

            })
              ->addColumn('reciever', function ($complain) {

                 
                $ret =  ($complain->reciver_type == 1) ? "Section Incharge" : 'Team' ;
               

                return $ret;

            })
           
            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }
    
    public function store(Request $request){
        $rules = array(
            'complainreciever' => "required|numeric|min:1|max:2",
            'complainpurpose' => "required",
            'complaindetail' => "required",
        );
       
        DB::beginTransaction();
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }
        try {

         if($request->complainreciever == 1 || $request->complainreciever == 2){
        
        
         $userid =   Auth::user()->id;
        
        
        
        if($request->id){
            $complainid =  $request->id;
            
            $complainid =  DB::table('complain')->where('id',$complainid)->update([
                        'reciver_type' => $request->complainreciever,
                        'complain' => $request->complainpurpose,
                        'Description' => $request->complaindetail,
                        'sender_user_id' => $userid
                        ]);
                        
                         DB::table('complain_assign')->where('complain_id',$complainid)->delete();
            
        }else{
             $complainid =  DB::table('complain')->insertGetId([
                        'reciver_type' => $request->complainreciever,
                        'complain' => $request->complainpurpose,
                        'Description' => $request->complaindetail,
                        'sender_user_id' => $userid
                        ]);
        }
        
        
                  
                        
                       $recieverdata = []; 
                        if($request->complainreciever == 1){
                            
                         $recieverdata =    DB::table('users')->where('role','incharge')->get();
                        }else{
                          $recieverdata =   DB::table('users')->whereIn('role', array('admin', 'general-manager', 'supervisor','qcd-manager'))->get();
                        }
                        // DB::table('complain_assign')->insert()
                        
                        
                        foreach($recieverdata as $val){
                            DB::table('complain_assign')->insert([
                                'user_id'=> $val->id,
                                'complain_id' => $complainid
                                ]);
                        }
                        
                   DB::commit();
                        
                        
            return response()->json([
                    'Success' => 'true' , 'msg' => 'Complain Send Succesfully']);            
         }else{
              return response()->json([
                    'Success' => 'false' , 'msg' => 'Something Went Wrong']);
         }
         
           

        } catch (\Exception $e) {
           
            return response()->json([
                'Error' => $e]);
        }
    }
    
    public function editcomplain(Request $request){
        
        $id  = $request->id;
        $complain = DB::table('complain')->select(['complain.*'])->where('id',$id)->first();
        return response()->json($complain);
    }
}
