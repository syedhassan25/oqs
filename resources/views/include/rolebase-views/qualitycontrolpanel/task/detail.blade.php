@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/widgets/pretty-photo/prettyphoto.css') }}">
<style>
    .row.divassignusers {
    margin-left: 10px;
    margin-bottom: 12px;
}

.row.divassignusers a.badge.badge-info {
    margin: 5px;
    padding: 6px;
    font-size: small;
    font-weight: bold;
}
.row.divassignusers a.badge.badge-primary {
    margin: 5px;
    padding: 6px;
    font-size: small;
    font-weight: bold;
}
.row.divassignusers a.badge.badge-danger,a.badge.badge-success {
    margin: 5px;
    padding: 6px;
    font-size: small;
    font-weight: bold;
}
button.btn-block.btnchangeStatus {
    font-size: 12px;
}

</style>
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} &nbsp;&nbsp; <a class="btn btn-primary " href="{{route('qualitycontrolpanel.task.index')}}">Back</a> <button class="btn btn-primary pull-right btncreatetask"> Create Task</button>
        
        

        
        </h2>
        <p>{{ $subTitle }}  </p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>

    <div class="panel">
        <div class="panel-body">
            @if($Task->isImportant == 1)
              <div class="ribbon">
                    <div class="bg-danger">Urgent</div>
                </div>
             @endif    
            <div class="example-box-wrapper">
                @include('admin.partials.flash')
              @if($Task->isAttachment)
                <div class="row">
                   <div class="post-image  col-md-12">
                       
                    
                       <?php 
                       
                          $val = $Task->isAttachment;
                       
                          $imageurl  = url('storage/'.$val);
                         
                         ?>
                        <a href="{{$imageurl}}" class="prettyphoto" rel="prettyPhoto[pp_gal]" title="Blog post title">
                            <img style="width:100%;height:150px" class="img-responsive lazy img-rounded" src="{{$imageurl}}" data-original="{{$imageurl}}" alt="" style="display: block;">
                        </a>
                    </div>
                </div>
              @endif  
                <div class="row" style="display:{{($Task->task_type == 1) ? 'block' : 'none'}}">
                     @if($Task->task_assign_type == 1)
                     <div class="col-12" >
                        
                             <table 
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>

                                            <th>Students</th>
                                            <th>Group</th>
                                            <th>Skype</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$Task->studentname}}</td>
                                            <td>{{$Task->group}}</td>
                                            <td>{{$Task->skypid_1}}</td>
                                        </tr>
                                    </tbody>

                                </table>

                        
                    </div>
                     @endif
                     <br/>
                      @if($Task->task_assign_type == 2)
                     <div class="col-12" >
                        
                             <table 
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Teachers</th>
                                            <th>Students</th>
                                            <th>Group</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($TaskMultistudent) > 0)
                                            @foreach($TaskMultistudent as $multi_std_data)
                                            <tr>
                                                    <td><a href=""> {{($multi_std_data->employeename) ?  $multi_std_data->employeename   : 'no Teacher Found'}} </a></td>
                                                    <td><a href="{{route('qualitycontrolpanel.student.editnewform',$multi_std_data->id)}}" >{{$multi_std_data->studentname}}</a></td>
                                                    <td>{{$multi_std_data->group}}</td>
                                                    <td>{{$multi_std_data->CountryName}}</td>
                                                   
                                                     <td>
                                                     {{$multi_std_data->academic_statusname}}
                                                     <?php 
                                                     
                                                     
                                                        // $status = '';
                                                        // switch ($multi_std_data->academicStatus) {
                                                        //     case 1:
                                                        //         $status = 'Active';
                                                        //         break;
                                                        //     case 2:
                                                        //         $status = 'Inactive';
                                                        //         break;
                                                        //     case 3:
                                                        //         $status = 'Leave';
                                                        //         break;
                                                        //     case 4:
                                                        //         $status = 'Close';
                                                        //         break;
                                                        //          case 5:
                                                        //         $status = 'Rejected';
                                                        //         break;
                                                        //     case 6:
                                                        //         $status = 'Pending';
                                                        //         break;
                                                        // }
                                                
                                                        // echo $status;
                                                     
                                                     ?></td>
                                                     <td><button class="btn btn-primary btnstudentdetail" data-id="{{$multi_std_data->id}}" >View Detail</button></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>

                        
                    </div>
                     @endif
                        
                </div>
                 <div class="row" style="display:{{($Task->task_type == 2) ? 'block' : 'none'}}">
                    <div class="col-12" >
                        
                             <table 
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>

                                            <th>Username</th>
                                            <th>Teacher Name</th>
                                            <th>Skype</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$Task->name}}</td>
                                            <td>{{$Task->employeename}}</td>
                                            <td>{{$Task->personal_skype}}</td>
                                        </tr>
                                    </tbody>

                                </table>

                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                       
                       
                         <div class="content-box" style=" padding: 12px;">
        <div class="mail-header clearfix row">
            <div class="col-md-6 pad0A">
                <label>Task :</label> <strong>{{$Task->taskName}}</strong>
            </div>
            <div class="float-right col-md-6 pad0A">
                    <div class="row">
                        
                        @if(count($checktaskstatus) > 0)
                        
                        
                        <?php  $taskStatus  =  $checktaskstatus[0]->taskStatus; ?>
                           
                        <div class="col-md-3"><button class="btn btn-primary btn-block btnchangeStatus" {{ ($taskStatus == 1) ? 'disabled' : ''}} data-status="1"> Mark As Complete</button></div>
                        
                        <div class="col-md-3"><button class="btn btn-danger  btn-block btnchangeStatus" {{ ($taskStatus == 2) ? 'disabled' : ''}} data-status="2"> Mark As Cancel</button></div>
                        
                        <div class="col-md-3"><button class="btn btn-info  btn-block btnchangeStatus" {{ ($taskStatus == 0) ? 'disabled' : ''}} data-status="0"> Mark As Pending</button></div>
                        
                        @endif
                        
                          <div class="col-md-3 pull-right">       
                          <div class="input-group  mrg15B">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions <span class="caret"></span></button>
                                        <ul class="dropdown-menu pull-right">
                                           
                                            <li class="ms-hover"><a href="#" class="btnAssignTo" data-id="{{request()->route('id')}}" >Assign To</a></li>
                                             <li class="divider"></li>
                                            <li class="ms-hover"><a href="#" class="btnExtendDate" data-id="{{request()->route('id')}}" >Extend Date</a></li>
                                        </ul>
                                    </div>
                                </div>
                          </div>
                    </div>
            </div>
        </div>
    </div>
                         <div class="content-box bg-white post-box">
      <label>Description :</label>
      
      <div class="row">
           <div style="padding-left: 22px;padding-right: 22px;padding-bottom: 22px;" class="col-lg-12">
          {!! $Task->taskDescription !!}
           </div>
      </div>
     
       
    </div>
    
                         
      <div class="row divassignusers">
         <h4>Task Created By</h4>
                    <div class="col-md-12" >
                        
                       
                         <a href="#" class="badge badge-success">{{$Task->taskcreatorname}}&nbsp;|&nbsp;Created Date : {{$Task->created_at_add}}&nbsp;|&nbsp; Completed Date : {{$Task->firsttaskCompleteddate_new}}</a>
                      


                        
                    </div>
                </div>
    
                         <div class="row divassignusers">
         <h4>Task Assign Users</h4>
                    <div class="col-md-12" >
                        
                        @foreach($Taskassign as $val)
                         <a href="#" class="badge badge-info">{{$val->name}}</a>
                        @endforeach
                            


                        
                    </div>
                </div>
                
                         <div style="display:{{(count($TaskassignCompleted) > 0) ? 'block' : 'none' }}" class="row divassignusers">
         <h4>Task Completed by</h4>
                    <div class="col-md-12" >
                        
                        @foreach($TaskassignCompleted as $val)
                         <a href="#" class="badge badge-primary">{{$val->name}}&nbsp;|&nbsp;{{$val->taskCompleteddate}}</a>
                        @endforeach
                            


                        
                    </div>
                </div>
                
                          <div style="display:{{(count($TaskassignCancel) > 0) ? 'block' : 'none' }}" class="row divassignusers">
         <h4>Task Cancel by</h4>
                    <div class="col-md-12" >
                        
                        @foreach($TaskassignCancel as $val)
                         <a href="#" class="badge badge-danger">{{$val->name}}&nbsp;|&nbsp;{{$val->taskCompleteddate}}</a>
                        @endforeach
                            


                        
                    </div>
                </div>
                
                
                      <div  class="row ">
                          
                               <div style="display:{{(count($TaskReAssignhistory) > 0) ? 'block' : 'none' }}" >
                               
                            
                              <div class="col-md-6" >
                         <h4>Reassign User</h4>
                         <br/>
                             <table  style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>

                                            <th>Assign From</th>
                                            <th>Assign To</th>
                                            <th>Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach($TaskReAssignhistory as $userdata)
                                            <tr>
                                                    <td>{{$userdata->userfromname}}</td>
                                                    <td>{{$userdata->name}}</td>
                                                    <td>{{$userdata->taskReassingdate}}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>

                                </table>

                        
                    </div>
                </div>
                
                          <div style="display:{{(count($taskExtendDatehistory) > 0) ? 'block' : 'none' }}">
                               
                            
                    <div class="col-md-6" >
                         <h4>Task Extend Completion Date</h4>
                         <br/>
                             <table  style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>

                                          
                                            <th>Extend Task user</th>
                                            <th>Extend Date</th>
                                            <th>Created Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach($taskExtendDatehistory as $userdata)
                                            <tr>
                                                   
                                                    <td>{{$userdata->name}}</td>
                                                    <td>{{$userdata->taskextenddatedate}}</td>
                                                    <td>{{$userdata->taskExtenddate}}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>

                                </table>

                        
                    </div>
                </div>
                          
                      </div>
                
    
                         <div class="content-box bg-white post-box">
       <form id="commentForm"  enctype="multipart/form-data">
        <textarea name="comment" id="editor2" class="textarea-autosize commenttxtarea" placeholder="Write Your Comment"></textarea>
        <input type="hidden" value="{{ request()->route('id') }}" name="taskid" />
        <div class="button-pane">
          
            <button type="submit" class="btn btn-md btn-post float-right btn-success btncomment" title="">
               Comment
            </button>

        </div>
        </form>
    </div>

   

                    </div>
                    <!-- /.col -->
                </div>
                  
                <div class="row">
                    <div class="col-12" >
                        
                             <table id="commentdatatable" data-link="{{route('qualitycontrolpanel.task.comment.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>

                                            <th>Commment</th>
                                            <th>Created By</th>
                                            <th>Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>

                                </table>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="taskAssignModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="taskReAssignForm" method="post" action="{{ route('qualitycontrolpanel.task.ReAssignuser.store') }}"
                    enctype="multipart/form-data">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Task Assign </h4>
                    </div>
                    <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-12 retriveAssignerCl">
                               
                            </div>
                            <input type="hidden" id="taskreassignID"  name="id" value="" />
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Users<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                     <select class="select2 " data-id="Assignusers" multiple="multiple" name="Assignusers[]"
                                            id="Assignusersdrp" data-placeholder="Select a Users"
                                            data-dropdown-css-class="select2-purple" style="width: 100%;">

                                    </select>

                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                   <button type="submit" class="btn btn-primary btn-block">Assign</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="taskExtenddateModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="taskExtenddateForm" method="post" action="{{ route('qualitycontrolpanel.task.extendDate.store') }}"
                    enctype="multipart/form-data">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Task Extend date </h4>
                    </div>
                    <div class="modal-body">
                      
                        <br/>
                            <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
 <input type="hidden" id="taskextenddateID"  name="id" value="" />
                                <div class="form-group">
                                    <label>Completed Date <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input type="text" value="" name="taskextenddatedate" placeholder="Completed Date"
                                        class="form-control bootstrap-datepicker">

                                </div>
                            
                            </div>
                          
                        </div>
                          <div class="row">
                       
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Completed Time<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <input name="taskextendtime" class="form-control timepicker-example" />
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                   <button type="submit" class="btn btn-primary btn-block">Extended Date</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="taskModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="taskForm" method="post" action="{{ route('qualitycontrolpanel.task.store') }}"
                    enctype="multipart/form-data">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Create Task</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Subject<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input type="text" value="" name="subject" placeholder="Subject"
                                        class="form-control subject">

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assign TO<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select name="assignto" class="form-control dropdownGetUsers">
                                        <option value="">Select Role</option>
                                        <option value="1">Teacher</option>
                                        <option value="2">Management</option>
                                    </select>
                                </div>

                                <!-- text input -->

                            </div>

                        </div>
                          <div class="row">
                           
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Task Type<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select name="TaskType" class="form-control dropdownTaskType">
                                        <option value="">Select Task Type</option>
                                        <option value="1">Student</option>
                                        <option value="2">Teacher</option>
                                        <option value="3">Other</option>
                                    </select>
                                </div>

                                <!-- text input -->

                            </div>

                        </div>
                       
                        <div style="display:none"  class="row managementDivStudent">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Group <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="group" id="SelectGroup" style="width: 100%;"> 
                                            <option value="">Select Group</option>
                                            @foreach($groupdata as $group)
                                               <option value="{{$group}}">{{$group}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Students<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select class="select2 form-control groupstudent" multiple="multiple" name="groupstudent[]" style="width: 100%;"> 
                                            <option value="">Select Student</option>
                                           
                                            </select>
                                </div>
                            </div>
                        </div>
                         <div style="display:none"  class="row managementDivTeacher">
                            <div class="col-sm-12">
                                <!-- text input -->

                             <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="managementteacher" id="SelectTeacherMangement" style="width: 100%;"> 
                                            <option value="">Select Teahcer</option>
                                            @foreach($teacherdata as $teacher)
                                               <option value="{{$teacher->id}}">{{$teacher->employeename}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                          
                        </div>

                        <div  style="display:none" class="row teacherDiv">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="teacher" id="SelectTeacher" style="width: 100%;"> 
                                            <option value="">Select Teahcer</option>
                                            @foreach($teacherdata as $teacher)
                                               <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Students<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select class="select2 form-control teacherstudent" name="teacherstudent" style="width: 100%;"> 
                                            <option value="">Select Student</option>
                                           
                                            </select>
                                </div>
                            </div>
                        </div>
                          <div  style="display:none" class="row teacherDivother">
                            <div class="col-sm-12">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="teacherother" id="SelectTeacherother" style="width: 100%;"> 
                                            <option value="">Select Teahcer</option>
                                            @foreach($teacherdata as $teacher)
                                               <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                           
                        </div>
                        
                         <div  style="display:none" class="row managementDiv">

                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Users<span class="m-l-5 text-danger  errorlabelmy">*</span></label>


                                    <div class="select2-purple">
                                        <select class="select2 " data-id="users" multiple="multiple" name="users[]"
                                            id="usersdrp" data-placeholder="Select a Users"
                                            data-dropdown-css-class="select2-purple" style="width: 100%;">

                                        </select>
                                    </div>


                                </div>
                            </div>

                        </div>
                          <div class="row" >
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    
                                       <input type="checkbox"  name="IsImportantchk" id="IsImportantchk" >
                                       <label>&nbsp;&nbsp;Urgent <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                          <input type="hidden" value="0" name="isImportant" class="isImportanttxt" >

                                </div>
                            
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Attachment<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <input type="file" name="isAttachment" class="form-control " />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Completed Date <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input type="text" value="" name="completeddate" placeholder="Completed Date"
                                        class="form-control bootstrap-datepicker">

                                </div>
                            
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Completed Time<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <input name="completedtime" class="form-control timepicker-example" />
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">


                                    <div class="form-group">
                                        <label>Note <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea id="editor1" rows="10" class="form-control note " name="note"></textarea>

                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
  
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="addStudentModalLongTitle">Student Detail</h5>

            </div>

            <div class="modal-body">
            <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped table-responsive-md btn-table">

                            <thead>
                                <tr>
                                    <th>label</th>
                                    <th>Value</th>
                                 
                                </tr>
                            </thead>

                            <tbody id="StudentDetail">
                              
                            </tbody>

                        </table>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped table-responsive-md btn-table">

                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Student Time</th>
                                    <th>Local Time</th>
                                </tr>
                            </thead>

                            <tbody id="StudentDays">
                              
                            </tbody>

                        </table>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped table-responsive-md btn-table">

                            <thead>
                                <tr>
                                    <th>Language</th>
                                    <th>Name</th>
                                </tr>
                            </thead>

                            <tbody id="StudentLanguage">
                              
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

</div>

@endsection
@push('scripts')
<!-- Data tables -->
<script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>


<script type="text/javascript" src="{{ asset('assets/widgets/datepicker/datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
    integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
    crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker-demo.js') }}"></script>
<script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>
<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/pretty-photo/prettyphoto.js') }}"></script>


<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>

<script type="text/javascript" src="{{ asset('assets/widgets/ckeditor/ckeditor.js') }}"></script>

<script>

  $(document).ready(function(){
    $("a[rel^='prettyPhoto[pp_gal]']").prettyPhoto();
    
    CKEDITOR.editorConfig = function (config) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = 300;
    config.toolbarCanCollapse = true;
    config.scayt_autoStartup = true;
    config.extraPlugins = 'emoji,autolink';
   

    };
   
   CKEDITOR.replace('editor1');
   CKEDITOR.replace('editor2');
    
    
  });

$(document).ready(function() {
   
    $('.select2').select2();
    $('.timepicker-example').timepicker();
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date()

    }).datepicker("update", new Date());; 
 
 
$(document).on('click', '.btnstudentdetail', function() {
        let id = $(this).attr('data-id');
        var route = '{{ route("qualitycontrolpanel.student.detail", ":id") }}';
        route = route.replace(':id', id);

        $.ajax({
            url: route,
            method: "GET",
            success: function(res) {
                
                let studentday = res.days;
                let studentlanguage =  res.languages;
                let Student =  res.Student;
                console.log(studentday)
                let dayhtml = "<tr><td colspan='3' class='text-center'>No Record Found</td></tr>"
                    if(studentday.length > 0){
                        dayhtml = "";
                        $.each(studentday,function(i,row){
                                console.log(row,'ss',i)

                                dayhtml += `<tr><td>${row.day_name}</td><td>${row.student_time_text}</td><td>${row.local_time_text}</td></tr>`
                        })
                    }
                    $('#StudentDays').html(dayhtml);

                let languageHtml = "<tr><td colspan='2' class='text-center' >No Record Found</td></tr>"

                  if(studentlanguage.length > 0){
                         languageHtml = "";
                        $.each(studentlanguage,function(i,row){
                            languageHtml += `<tr><td>Language ${i+1}</td><td>${row.languagename}</td></tr>`
                        })
                    }
                    $('#StudentLanguage').html(languageHtml);

                    $('#StudentDetail').html('');
                    let detailHtml =    `<tr><td>Skype 1</td><td>${Student.skypid_1}</td></tr>
                                         <tr><td>Skype 2</td><td>${Student.skypid_2}</td></tr>
                                         <tr><td>WhatsApp</td><td>${Student.whatsapp}</td></tr>
                                         <tr><td>Contact</td><td>${Student.contact_no}</td></tr>
                                         <tr><td>Email 1</td><td>${Student.studentemail}</td></tr>
                                         <tr><td>Email 2</td><td>${Student.studentemail2}</td></tr>
                                         <tr><td>Billing Email</td><td>${Student.billingemail}</td></tr>
                                         <tr><td>Gender</td><td>${(Student.gender == 1) ?  "male" : "Female" }</td></tr>
                                         <tr><td>Age</td><td>${Student.age}</td></tr>
                                         <tr><td>city</td><td>${Student.CityName}</td></tr>
                                         `;
                        if(Student.joining_source == 1){
                            detailHtml += `<tr><td>Agency</td><td>${Student.agencyname}</td></tr>` 
                        }else{
                            detailHtml += `<tr><td>Reference Name</td><td>${Student.ref_name}</td></tr><tr><td>Reference Email</td><td>${Student.ref_email}</td></tr>` 
                        }
                        detailHtml += `<tr><td>Duration</td><td>${Student.duration}</td></tr>` 
                        detailHtml += `<tr><td>Detail</td><td>${Student.detail}</td></tr>`                 
                       

                    $('#StudentDetail').html(detailHtml);

                    
                    

                $('#addStudentModal').modal('show');
            }
        })
    });   
   
$(document).on('click','.btnchangeStatus',function(){
    
    var status  = $(this).attr('data-status');
    var taskId  =  "{{ request()->route('id') }}";
    let token =  $('meta[name="csrf-token"]').attr('content');
    
    swal({
      title: "Are you sure?",
      text: "You Want Change Task Status!",
      icon: "warning",
      buttons: [
        'No!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        // swal({
        //   title: 'Task!',
        //   text: 'Successfully Update Status',
        //   icon: 'success'
        // }).then(function() {
            
           
        // });
        
         toastr.success('successfully update status')
        
        $.post('{{route("qualitycontrolpanel.task.status.detail.change")}}',{_token:token,taskstatus:status,id:taskId},function(res){
            // alert("successfully update status");
            // window.location.reload();
            
             window.location =  "{{route('qualitycontrolpanel.task.index')}}";
            
           })
        
      } else {
        swal("Your Task Status not Changed", "", "error");
      }
    })
    
    
    
 
    
})

   
// $(document).on('click','.btncomment',function(){

 $(document).on('submit', '#commentForm', function(e) {
        e.preventDefault();
    
        // let comment = $('.commenttxtarea').val();
        
        var comment = CKEDITOR.instances['editor2'].getData().replace(/<[^>]*>/gi, '').length
        
        let token =  $('meta[name="csrf-token"]').attr('content');
        
        // if(comment != 0){
        //     $.post('{{route("qualitycontrolpanel.task.comment")}}',{_token:token,comment:comment,taskid:"{{ request()->route('id') }}"},function(){
            
            
        //     $('.commenttxtarea').val('');
           
        //      CKEDITOR.instances.editor2.setData('');
             
             
        //      toastr.success('comment add successfully')
            
        //     //  window.location =  "{{route('qualitycontrolpanel.task.index')}}";
            
        //      $('#commentdatatable').DataTable().draw(true);
            
        // })
        // }else{
        //     toastr.info('Please Write Comment')
        // }
        
        
        if(comment != 0){
        
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                type: "POST",
                url: '{{route("qualitycontrolpanel.task.comment")}}',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#commentForm')[0])
            })
            .done(function(data) {
               
                      CKEDITOR.instances.editor2.setData('');
                         
                         
                         toastr.success('comment add successfully')
                        
                        //  window.location =  "{{route('qualitycontrolpanel.task.index')}}";
                        
                         $('#commentdatatable').DataTable().draw(true);
                
            })
            .fail(function(data) {
                console.log(data);

            });
        
        }else{
            toastr.info('Please Write Comment')
        }
        
        
        
    
})

 var oTable = $('#commentdatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#commentdatatable').attr('data-link'),
            data:{taskid:'{{ request()->route('id') }}'}
        },

        columns: [{
                data: 'commenttext',
                name: 'commenttext',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'users.name'
            },
            {
                data: 'created_at_new',
                name: 'created_at_new',
                orderable: false,
                searchable: false
            },
            
           
        ]
    });
    
    
    $(document).on('click','.btnAssignTo',function(){
        
        let id  = $(this).attr('data-id');
        $.get('{{route("qualitycontrolpanel.task.AssignUsers")}}',{id:id},function(res){
             console.log(res);
             
             
             
             
             $('#taskreassignID').val(id);
              var html = '';
            $.each(res.taskAssign, function(i, e) {
                html += `<a href="#" class="badge badge-info">${e.name}</a>&nbsp;`
            });

            $('.retriveAssignerCl').html(html);
             
             var html = '';
            $.each(res.users, function(i, e) {
                html += `<option value="${e.id}">${e.name}</option>`
            });

            $('#Assignusersdrp').html(html);
             
            $('#taskAssignModal').modal('show');
             
        })
        
      
    });
    
    
    $(document).on('submit', '#taskReAssignForm', function(e) {
        e.preventDefault();

        $('.text-danger').text('');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
        $('textarea').removeClass('is-invalid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                type: "POST",
                url: '{{ route("qualitycontrolpanel.task.ReAssignuser.store") }}',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#taskReAssignForm')[0])
            })
            .done(function(data) {
                console.log(data);

                if(data.length > 0){
                    if(data.error){
                        $.each(data.error, function(key, value) {
                    var input = `#taskReAssignForm input[name="${key}"]`;
                    var inputtextarea = `#taskReAssignForm textarea[name="${key}"]`;
                    var inputselect = `#taskReAssignForm select[name="${key}"]`;
                    var inputselectid = `#taskReAssignForm select[id="${key}"]`

                    var inputs = `#taskReAssignForm select[data-id="${key}"]`;
                    // console.log(input)
                    $(input).parents('.form-group').find('.text-danger').text(value);
                    $(inputtextarea).parents('.form-group').find('.text-danger').text(
                        value);
                    $(inputselect).parents('.form-group').find('.text-danger').text(
                        value);
                    $(inputselectid).parents('.form-group').find('.text-danger').text(
                        value);
                    $(inputs).parents('.form-group').find('.text-danger').text(
                        value);
                    $(input).addClass('is-invalid');
                    $(inputtextarea).addClass('is-invalid');
                    $(inputselect).addClass('is-invalid');
                    $(inputselectid).addClass('is-invalid');
                });
                    }
                    
                }
               

                if (data.Success) {
                    // swal({
                    //     title: "Good job!",
                    //     text: data.msg,
                    //     icon: "success",
                    //     button: "Close",
                    // });
                    
                    alert('Task ReAssign Successfully');
                    $('#taskAssignModal').modal('hide');
                    $('#taskReAssignForm')[0].reset();
                     window.location.reload();

                    // $("select").trigger("change");
                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });
    
      $(document).on('submit', '#taskExtenddateForm', function(e) {
        e.preventDefault();

        $('.text-danger').text('');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
        $('textarea').removeClass('is-invalid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                type: "POST",
                url: $('#taskExtenddateForm').attr('action'),
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#taskExtenddateForm')[0])
            })
            .done(function(data) {
                console.log(data);

                if(data.length > 0){
                    if(data.error){
                        $.each(data.error, function(key, value) {
                    var input = `#taskExtenddateForm input[name="${key}"]`;
        
                    // console.log(input)
                    $(input).parents('.form-group').find('.text-danger').text(value);
                    $(input).addClass('is-invalid');
                   
                });
                    }
                    
                }
               

                if (data.Success) {
                    // swal({
                    //     title: "Good job!",
                    //     text: data.msg,
                    //     icon: "success",
                    //     button: "Close",
                    // });
                    
                  
                    
                    toastr.success(data.msg)
                    $('#taskExtenddateModal').modal('hide');
                    $('#taskReAssignForm')[0].reset();
                    
                    
                    window.location =  "{{route('qualitycontrolpanel.task.index')}}";
                    

                    // $("select").trigger("change");
                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });
    
    
    
    
    
    $(document).on('click','.btnExtendDate',function(){
        
        let id  = $(this).attr('data-id');
        
         $('#taskextenddateID').val(id);
         
          $('#taskExtenddateModal').modal('show');
        
      
    });
    
    
    
     $(document).on('click', '.btncreatetask', function() {
         $(".bootstrap-datepicker").datepicker('setDate', new Date())
          $('#taskModal').modal('show');
         CKEDITOR.instances.editor1.setData('');
    });
    
     $(document).on('change', '.dropdownGetUsers', function() {
        
           $('.dropdownTaskType').val('')
        
        let roleType = $(this).val();

             if(roleType == 1){
              
                        $('.managementDivTeacher').hide();
                         $('.managementDivStudent').hide();
                         $('.managementDiv').hide();
                         $('.teacherDiv').hide();
            }
            if(roleType == 2){
               
                 $('.managementDiv').hide();
                 $('.teacherDiv').hide();
                 $('.teacherDivother').hide();
            }

        $.post('{{route("qualitycontrolpanel.task.getUserRolewise")}}', {
            roleType: roleType,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(res) {
            console.log(res);

            
          

            if(roleType == 1){


                var html = '<option value="">Select Teahcer</option>';
            $.each(res, function(i, e) {
                html += `<option value="${e.id}">${e.employeename}</option>`
            });

                $('#SelectTeacher').html(html);
                // $('.managementDiv').hide();
                // $('.teacherDiv').show();
            }
            if(roleType == 2){


                var html = '';
            $.each(res, function(i, e) {
                html += `<option value="${e.id}">${e.name}</option>`
            });

                $('#usersdrp').html(html);
                // $('.managementDiv').show();
                // $('.teacherDiv').hide();
            }
            


        })
    });
    
     $(document).on('change', '.dropdownTaskType', function() {
        let taskType = $(this).val();
        
        
         let roleType = $('.dropdownGetUsers').val();

             if(roleType == 1){
                 
                 
                 if(taskType == 1){
                        $('.teacherDiv').show();
                        $('.teacherDivother').hide();
                    }
                    else if(taskType == 3){
                        $('.teacherDiv').hide();
                         $('.teacherDivother').show();
                    }else{
                         $('.teacherDiv').hide();
                         $('.teacherDivother').hide();
                         $('.managementDivTeacher').hide();
                         $('.managementDivStudent').hide();
                         $('.managementDiv').hide();
                    }
                 
                   
              
              
            }
            else if(roleType == 2){
                
                if(taskType == 1){
                    
                    $('.managementDivStudent').show();
                    $('.managementDivTeacher').hide();
                     $('.managementDiv').show();
                      
                    }
                    else if(taskType == 2){
                          $('.managementDivStudent').hide();
                          $('.managementDivTeacher').show();
                          $('.managementDiv').show();
                    }
                     else if(taskType == 3){
                        $('.managementDivTeacher').hide();
                        $('.managementDivStudent').hide();
                        $('.managementDiv').show();
                    }else{
                         $('.teacherDiv').hide();
                         $('.teacherDivother').hide();
                         $('.managementDivTeacher').hide();
                         $('.managementDivStudent').hide();
                         $('.managementDiv').hide();
                    }
                    
               
              
            }else{
                
                alert('Please Must Select Role');
                
                $('.teacherDiv').hide();
                         $('.teacherDivother').hide();
                         $('.managementDivTeacher').hide();
                         $('.managementDivStudent').hide();
                         $('.managementDiv').hide();
                
            }
        
        


             

    });
    
    
     $(document).on('change', '#SelectGroup', function() {
        let group = $(this).val();
        $.get('{{route("qualitycontrolpanel.task.getStudentBygroup")}}', {
            group: group,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(res) {
            console.log(res);

            var html = '<option value="">Select Student</option>';
            $.each(res, function(i, e) {
                html += `<option value="${e.id}">${e.studentname}</option>`
            });

            $('.groupstudent').html(html);

        })
    });


     $(document).on('change', '#SelectTeacher', function() {
        let teacherid = $(this).val();
        $.get('{{route("qualitycontrolpanel.task.getStudentByteacher")}}', {
            teacherid: teacherid,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(res) {
            console.log(res);

            var html = '<option value="">Select Student</option>';
            $.each(res, function(i, e) {
                html += `<option value="${e.id}">${e.studentname}</option>`
            });

            $('.teacherstudent').html(html);

        })
    });
    
    
     $(document).on('submit', '#taskForm', function(e) {
        e.preventDefault();

        $('.text-danger').text('');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
        $('textarea').removeClass('is-invalid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                type: "POST",
                url: '{{ route("qualitycontrolpanel.task.store") }}',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#taskForm')[0])
            })
            .done(function(data) {
               

                // if(data.length > 0){
                   
                    if(data.error){
                        console.log('inin')
                        
                          $.each(data.error, function(key, value) {
                    var input = `#taskForm input[name="${key}"]`;
                    var inputtextarea = `#taskForm textarea[name="${key}"]`;
                    var inputselect = `#taskForm select[name="${key}"]`;
                    var inputselectid = `#taskForm select[id="${key}"]`

                    var inputs = `#taskForm select[data-id="${key}"]`;
                    // console.log(input)
                    $(input).parents('.form-group').find('.text-danger').text(value);
                    $(inputtextarea).parents('.form-group').find('.text-danger').text(
                        value);
                    $(inputselect).parents('.form-group').find('.text-danger').text(
                        value);
                    $(inputselectid).parents('.form-group').find('.text-danger').text(
                        value);
                    $(inputs).parents('.form-group').find('.text-danger').text(
                        value);
                    $(input).addClass('is-invalid');
                    $(inputtextarea).addClass('is-invalid');
                    $(inputselect).addClass('is-invalid');
                    $(inputselectid).addClass('is-invalid');
                });
                    }
                     
                  
                // }
               

                if (data.Success) {
                    // swal({
                    //     title: "Good job!",
                    //     text: data.msg,
                    //     icon: "success",
                    //     button: "Close",
                    // });
                    
                    alert('Task Create Successfully');
                      window.location =  "{{route('qualitycontrolpanel.task.index')}}";
                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });
    
    
    $(document).on('change','#IsImportantchk',function(){       
    if(this.checked) {
        $('.isImportanttxt').val(1);
    }else{
         $('.isImportanttxt').val(0);
    }
  })
   
});
</script>
@endpush