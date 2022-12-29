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

class SuggestController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Suggestion', 'View All Suggestion');
        return view('admin.teacherpanel.suggest.index');
    }
    
     public function get_suggest_forms(Request $request)
    {
      
    //   $teacherId = Employee::where('user_id',Auth::user()->id)->first()->id;
       
        $userid =   Auth::user()->id;


        $suggestion = DB::table('suggestion')->select(['suggestion.*'])->where('sender_user_id',$userid);
        return Datatables::of($suggestion)
            
            ->addColumn('action', function ($suggestion) {

                 
                $ret =  '<a data-id="'.$suggestion->id.'" class="btn btn-primary btneditsuggestion">Edit</a>' ;
               

                return $ret;

            })
           
            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }
    
    public function store(Request $request){
        $rules = array(
            'suggestionpurpose' => "required",
            'suggestiondetail' => "required",
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
            $suggestionid =  $request->id;
            
            $suggestion =  DB::table('suggestion')->where('id',$suggestionid)->update([
                       
                        'subject' => $request->suggestionpurpose,
                        'Description' => $request->suggestiondetail,
                        'sender_user_id' => $userid
                        ]);
                        
                         
            
        }else{
             $suggestionid =  DB::table('suggestion')->insertGetId([
                         'subject' => $request->suggestionpurpose,
                        'Description' => $request->suggestiondetail,
                        'sender_user_id' => $userid
                        ]);
        }
        
        
                  
                        
                       
                        
                   DB::commit();
                        
                        
            return response()->json([
                    'Success' => 'true' , 'msg' => 'Suggestion Send Succesfully']);            
        
         
           

        } catch (\Exception $e) {
           
            return response()->json([
                'Error' => $e]);
        }
    }
    
    public function editsuggestion(Request $request){
        
        $id  = $request->id;
        $suggestion = DB::table('suggestion')->select(['suggestion.*'])->where('id',$id)->first();
        return response()->json($suggestion);
    }
}
