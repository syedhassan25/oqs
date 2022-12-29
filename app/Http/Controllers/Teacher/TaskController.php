<?php

namespace App\Http\Controllers\Teacher;
use App\models\Task;
use App\models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Yajra\Datatables\Datatables;
use DB;
use Carbon\Carbon;
use App\models\taskAssign;
use Validator;
class TaskController extends BaseController
{
    public function index(){
        $this->setPageTitle('Tasks', 'View All Assign Tasks');
        return view('admin.teacherpanel.task.index');
    }
    
     public function unreadCommentbyTask($taskid,$userid){
        return DB::table('taskCommentRead')->leftjoin('taskComment','taskCommentRead.commentId','=','taskComment.id')
        ->where('taskCommentRead.taskId',$taskid)->where('taskCommentRead.isRead',0)->where('taskCommentRead.user_id',$userid)->groupBy('taskCommentRead.commentId')->get()->count();
    }

    public function get_task_forms(Request $request){
        $Task = Task::select(['task.*','users.name','student.studentname','student.group'])
        ->leftjoin('users', 'task.created_by', '=', 'users.id')
         ->leftjoin('taskassign', 'task.id', '=', 'taskassign.taskId')
         ->leftjoin('users as assignuser', 'taskassign.assignTo', '=', 'assignuser.id')
         ->leftjoin('student', 'task.studentId', '=', 'student.id')
         ->where('taskassign.assignTo',auth()->user()->id)
         ->where('task.task_assign_type',1);
        // ->where('taskassign.assignTo',Employee::where('user_id',auth()->user()->id)->first()->id);
        

        return Datatables::of($Task)
           
             ->addColumn('status', function ($Task) {

                $ret = 'Pending';
                if($Task->status == 1){
                    $ret = 'Completed';
                }else if($Task->status == 2){
                    $ret = 'Cancel';
                }

                return $ret;

            })
             ->addColumn('tasktype', function ($Task) {

            $ret = '';
            if($Task->task_type == 1){
                
                
                 $ret = "<a style='color:blue;cursor:pointer' >$Task->studentname[$Task->group]</a>";
            }
            else{
                $ret = "Other";
            }
               

                return $ret;

            })
             ->addColumn('subjectlink', function ($Task) {

                   $showurl = route('teacherpanel.task.detail', $Task->id);
              
                    $ret = '';
                    $ret = '<a href="'.$showurl.'" style="color:blue;cursor:pointer" >'.$Task->taskName.'</a>';
                    return $ret;

            })
             ->addColumn('comment', function ($Task) {
$ret = '';
            
                $total =  $this->unreadCommentbyTask($Task->id,auth()->user()->id);
                    $ret .= '<button type="button" class="btn btn-primary">Unread Comments <span class="badge badge-light">'.$total.'</span>
  <span class="sr-only">unread Comments</span>
</button>';
                

                return $ret;

            })
            ->rawColumns(['status','tasktype','subjectlink','comment'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }
    
    public function detail($id){
       
       
        $this->setPageTitle('Task Detail', 'Task Detail');
        
        DB::table('taskCommentRead')->where('taskId',$id)->where('user_id',auth()->user()->id)->update(['isRead' => 1]);
        
        
        
         $Task = Task::select(['task.*','student.studentname','student.id as studentid','student.group','student.skypid_1','employees.employeename','employees.personal_skype','users.name','taskcreator.name as  taskcreatorname'])
         ->leftjoin('student', 'task.studentId', '=', 'student.id')
          ->leftjoin('employees', 'task.teacher_id', '=', 'employees.user_id')
          ->leftjoin('users', 'employees.user_id', '=', 'users.id')
          ->leftjoin('users as taskcreator', 'task.created_by', '=', 'taskcreator.id')
         ->where('task.id',$id)->first();
       
         $Taskassign =   taskAssign::select(['assignuser.name'])->leftjoin('users as assignuser', 'taskassign.assignTo', '=', 'assignuser.id')->where('taskassign.taskId',$id)->get();
         $TaskassignCompleted =   taskAssign::select(['assignuser.name'])->leftjoin('users as assignuser', 'taskassign.assignTo', '=', 'assignuser.id')->where('taskassign.taskStatus',1)->where('taskassign.taskId',$id)->get();
         $TaskassignCancel =   taskAssign::select(['assignuser.name'])->leftjoin('users as assignuser', 'taskassign.assignTo', '=', 'assignuser.id')->where('taskassign.taskStatus',2)->where('taskassign.taskId',$id)->get();
       
        return view('admin.teacherpanel.task.detail',compact('Task','Taskassign','TaskassignCompleted','TaskassignCancel'));
   }
   
    public function comment_add(Request $request){
       
        $rules = array(
            'comment' => 'required'
        );
        

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        DB::beginTransaction();

        // dd($request);

        try {
            
           


        $taskcommentID =   DB::table('taskComment')->insertGetId([
              'comment' => $request->comment,
              'userId' => auth()->user()->id,
              'taskid' => $request->taskid
              ]);


          $getassign  = taskAssign::where('taskId',$request->taskid)->get();
            $commentread = [];
            foreach($getassign as $i => $data){
                    $commentread[] = array(
                        'taskId' => $request->taskid, 
                        'commentId' =>  $taskcommentID, 
                        'user_id' => $data->assignTo
                        ); 
            }
            
             (count($commentread) > 0) ? DB::table('taskCommentRead')->insert($commentread) : '';

              DB::commit();
            
            
            return response()->json(['Success' => 'true' , 'msg' => 'Task Comment Successfully']);
  

        }catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'Error' => $e]);
        }

       
   }
   
    public function get_comment_forms(Request $request){
        $Task =  DB::table('taskComment')->select(['taskComment.*','users.name'])
        ->leftjoin('users', 'taskComment.userId', '=', 'users.id')
        ->where('taskComment.taskid',$request->taskid);
        

        return Datatables::of($Task)->make(true);
    }
    
    public function task_status_change_detail(Request $request){
        
        
        
        $rules = array(
            'taskstatus' => 'required',
            'id' => 'required',
        );
        

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        DB::beginTransaction();

        // dd($request);

        try {
            
           $retval = '';
           if($request->taskstatus == "1"){
               $retval = 1;
           }
           else if($request->taskstatus == "2"){
               $retval = 2;
           }
            else{
                $retval = 0;
            }

       
            DB::table('taskassign')->where('taskId',$request->id)->where('assignTo',auth()->user()->id)->update(['taskStatus' => $retval]);
        
            DB::commit();
            
            
            return response()->json(['Success' => 'true' , 'msg' => 'Update Status Successfully']);
  

        }catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'Error' => $e]);
        }
        
    }
}
