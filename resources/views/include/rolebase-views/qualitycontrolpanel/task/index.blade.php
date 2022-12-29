@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
      .groupstudenttable, thead, tr, td {
  border: 1px solid black;
  text-align:center;
  padding: 2px;
}
.popover{
    max-width: 100%;
}

</style>
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <button class="btn btn-primary btncreatetask"> Create Task</button></h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>
    
    <div class="panel">
          @include('admin.partials.flash')
            <div class="panel-body">
                <h3 class="title-hero">
                   Tasks
                </h3>
                
                <div class="row">
                                   <div class="col-md-1 pull-right">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                    <div class="col-md-2 pull-right">
                                       <input type="text" value="" placeholder="Group No" id="txtserachgroup" class="form-control">
                                    </div>
                                    
                                </div>
                <br/>                
                <div class="example-box-wrapper">
                    <ul class="nav-responsive nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab"><span title="Total Task" class="badge badge-dark todaytasktab"> </span> Today <span title="Unread Comments" class="badge badge-dark todayunreadtab"> </span></a></li>
                        <li><a href="#tab2" data-toggle="tab"><span title="Total Task" class="badge badge-warning pendingtasktab"></span>Past Pending  <span title="Unread Comments" class="badge badge-warning pendingunreadtab"> </span></a></li>
                         <li><a href="#tab6" data-toggle="tab"> <span title="Total Task" class="badge badge-warning futuretasktab"></span>Upcoming  <span title="Unread Comments" class="badge badge-warning futureunreadtab"> </span></a>  </a></li>
                        <li><a href="#tab3" data-toggle="tab"> Completed  <span title="Unread Comments" class="badge badge-success completedunreadtab"> </span></a></li>
                        <li><a href="#tab4" data-toggle="tab"> Assigned  <span title="Unread Comments" class="badge badge-info assignedunreadtab"> </span></a></li>
                        <li><a href="#tab5" data-toggle="tab"> Cancelled  <span title="Unread Comments" class="badge badge-danger cancelunreadtab"> </span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                             <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                 <div class="table-responsive">
      <table id="taskdatatable" data-link="{{route('qualitycontrolpanel.task.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Assigned By</th>
                                            <th>Subject</th>
                                            <th>Subject</th>
                                            <th>Task For</th>
                                            <th>Student</th>
                                            <th>Group</th>
                                            <th>Teacher</th>
                                            <th>Description</th>
                                            <th>Comment</th>
                                            <th>Completion date</th>
                                            <th>Completion Time</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                             <th>multistudent</th>
                                        </tr>
                                    </thead>

                                </table>
    
</div>
                              

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                              <div class="row">
                                  <div class="col-md-4">
                                       <div id="reportrangepending" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
                                    </div>
                                   
                                  
                                   
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btnsearchpendingForm">Search</button>
                                    </div>
                                     <div class="col-md-3">
                                       <input type="checkbox"  id="checkboxpendingunread" class="checkboxpendingunread" value="UnReadCommentTask" />
                                       <label for="checkboxpendingunread">Show UnRead Comments</label>
                                    </div>
                                </div>
                                 <br/>
                            <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                 <div class="table-responsive">
                                     <table id="pendingtaskdatatable" data-link="{{route('qualitycontrolpanel.task.pending.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Assigned By</th>
                                            <th>Subject</th>
                                            <th>Subject</th>
                                            <th>Task For</th>
                                            <th>Student</th>
                                            <th>Group</th>
                                            <th>Teacher</th>
                                            <th>Description</th>
                                            <th>Comment</th>
                                            <th>Completion date</th>
                                            <th>Completion Time</th>
                                             <th>Created at</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                             <th>multistudent</th>
                                        </tr>
                                    </thead>

                                </table>
                                </div>
                              

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <div class="row">
                                     <div class="col-md-3">
                                       <input type="checkbox" id="checkboxcompletedunread" class="checkboxcompletedunread" />
                                        <label for="checkboxcompletedunread">Show UnRead Comments</label>
                                    </div>
                                </div>
                                 <br/>
                            <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                 <div class="table-responsive">
                                     <table id="completedtaskdatatable" data-link="{{route('qualitycontrolpanel.task.completed.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Assigned By</th>
                                            <th>Subject</th>
                                            <th>Subject</th>
                                            <th>Task For</th>
                                            <th>Student</th>
                                            <th>Group</th>
                                            <th>Teacher</th>
                                            <th>Description</th>
                                            <th>Comment</th>
                                            <th>Completion date</th>
                                            <th>Completion Time</th>
                                             <th>Completed At</th>
                                               <th>Created at</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                             <th>multistudent</th>
                                        </tr>
                                    </thead>

                                </table>
                                </div>
                              

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <div class="row">
                                     <div class="col-md-3">
                                       <input type="checkbox" id="checkboxAssignedunread" class="checkboxAssignedunread" />
                                        <label for="checkboxAssignedunread">Show UnRead Comments</label>
                                    </div>
                                </div>
                            <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <table id="taskAssigneddatatable" data-link="{{route('qualitycontrolpanel.taskAssigned.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Assigned To</th>
                                            <th>Subject</th>
                                            <th>Subject</th>
                                            <th>Task For</th>
                                            <th>Student</th>
                                            <th>Group</th>
                                            <th>Teacher</th>
                                            <th>Description</th>
                                            <th>Comment</th>
                                            <th>Completion date</th>
                                            <th>Completion Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                             <th>multistudent</th>
                                        </tr>
                                    </thead>

                                </table>



                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                        </div>
                         <div class="tab-pane" id="tab5">
                               <div style="display:none" class="row">
                                     <div class="col-md-2">
                                       <input type="checkbox" class="checkboxcancelunread" />
                                         <label for="checkboxcancelunread">Show UnRead Comments</label>
                                    </div>
                                </div>
                            <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                 <div class="table-responsive">
                                     <table id="canceltaskdatatable" data-link="{{route('qualitycontrolpanel.task.cancel.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Assigned By</th>
                                            <th>Subject</th>
                                            <th>Subject</th>
                                            <th>Task For</th>
                                            <th>Student</th>
                                            <th>Group</th>
                                            <th>Teacher</th>
                                            <th>Description</th>
                                            <th>Comment</th>
                                            <th>Completion date</th>
                                            <th>Completion Time</th>
                                            <th>Cancel Time</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                             <th>multistudent</th>
                                        </tr>
                                    </thead>

                                </table>
                                </div>
                              

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                        </div>
                         <div class="tab-pane" id="tab6">
                              <div class="row">
                                  <div class="col-md-4">
                                       <div id="reportrangefuture" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
                                    </div>
                                   
                                  
                                   
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btnsearchfutureForm">Search</button>
                                    </div>
                                    
                                    <div class="col-md-2">
                                       <input type="checkbox" class="checkboxfutureunread" />
                                       <label for="checkboxfutureunread">Show UnRead Comments</label>
                                    </div>
                                </div>
                                 <br/>
                            <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                 <div class="table-responsive">
                                     <table id="futuretaskdatatable" data-link="{{route('qualitycontrolpanel.task.future.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Assigned By</th>
                                            <th>Subject</th>
                                            <th>Subject</th>
                                            <th>Task For</th>
                                            <th>Student</th>
                                            <th>Group</th>
                                            <th>Teacher</th>
                                            <th>Description</th>
                                            <th>Comment</th>
                                            <th>Completion date</th>
                                            <th>Completion Time</th>
                                             <th>Created at</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                             <th>multistudent</th>
                                        </tr>
                                    </thead>

                                </table>
                                </div>
                              

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                        </div>
                       
                    </div>
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

<!--ckeditor-->
                                    <div class="form-group">
                                        <label>Note <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea   cols="80" id="editor1" name="note" rows="10" class="form-control note " name="note"></textarea>

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
    
    <div id="taskcompletiondateModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="taskcompletiondateForm" method="post" action="{{ route('qualitycontrolpanel.task.store') }}"
                    enctype="multipart/form-data">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Task Completion Date </h4>
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
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
<!--<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker.js') }}"></script>-->
<!--<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker-demo.js') }}"></script>-->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js"></script>

<script type="text/javascript" src="{{ asset('assets/widgets/ckeditor/ckeditor.js') }}"></script>



<script>
$(document).ready(function() {
    
    CKEDITOR.editorConfig = function (config) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = 300;
    config.toolbarCanCollapse = true;

  };
CKEDITOR.replace('editor1');


    
    
    $('.select2').select2();
    $('.timepicker-example').timepicker();
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
         startDate: new Date()

    }).datepicker("update", new Date());;

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

                var html = '<option value="">Select User</option>';
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
                     console.log(data);
                  
                // }
               

                if (data.Success) {
                    // swal({
                    //     title: "Good job!",
                    //     text: data.msg,
                    //     icon: "success",
                    //     button: "Close",
                    // });
                    
                    alert('Task Create Successfully');
                    $('#taskModal').modal('hide');
                    $('#taskForm')[0].reset();
                    
                       $('#taskdatatable').DataTable().draw(true);

                    // $("select").trigger("change");
                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });


    $(document).on('click', '.btnsearchpendingForm', function() {

        $('#pendingtaskdatatable').DataTable().draw(true);
        
    })
    $(document).on('change', '.checkboxpendingunread', function() {

        $('#pendingtaskdatatable').DataTable().draw(true);
        
        
    })
    $(document).on('change', '.checkboxcompletedunread', function() {

        $('#completedtaskdatatable').DataTable().draw(true);
        
        
    })
     $(document).on('change', '.checkboxcanceldunread', function() {

        $('#canceltaskdatatable').DataTable().draw(true);
        
        
    })
     $(document).on('change', '.checkboxfutureunread', function() {

        $('#futuretaskdatatable').DataTable().draw(true);
        
        
    })
     $(document).on('change', '.checkboxAssignedunread', function() {

        $('#taskAssigneddatatable').DataTable().draw(true);
        
        
    })
    


    
    
    

    let startdatepending;
    let enddatepending;

 
    // var start = moment().subtract(29, 'days');
    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#reportrangepending span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
         startdatepending = start.format('YYYY-MM-DD');
         enddatepending = end.format('YYYY-MM-DD');
    }

    $('#reportrangepending').daterangepicker({
        maxDate: moment().subtract(1, 'days'),
        startDate: start,
        endDate: end,
        ranges: {
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Get All': [moment().subtract(60, 'years'), moment().subtract(1, 'days')]
        }
    }, cb);
    
    
     $(document).on('click', '.btnsearchfutureForm', function() {

        $('#futuretaskdatatable').DataTable().draw(true);
        
        
    })

    let startdatefuture;
    let enddatefuture;

 
    // var start = moment().subtract(29, 'days');
    var startfuture = moment();
    var endfuture = moment();

    function cbfuture(startfuture, endfuture) {
        $('#reportrangefuture span').html(startfuture.format('MMMM D, YYYY') + ' - ' + endfuture.format('MMMM D, YYYY'));
         startdatefuture = startfuture.format('YYYY-MM-DD');
         enddatefuture = endfuture.format('YYYY-MM-DD');
    }

    $('#reportrangefuture').daterangepicker({
        minDate: moment().add(1, 'days'),
        startDate: startfuture,
        endDate: enddatefuture,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cbfuture);
    

    // cb(start, end);

    var oTable = $('#taskdatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        ordering: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#taskdatatable').attr('data-link'),
            data: function(d) {
                d.groupno = $('#txtserachgroup').val();
              
            }
        },

        columns: [
            
            {
                data: 'name',
                name: 'users.name'
            },
             {
                data: 'subjectlink',
                name: 'subjectlink',
                orderable: false,
                searchable: false
            },
            {
                data: 'taskName',
                name: 'taskName', searchable: true, visible: false 
            }
            ,
            {
                data: 'tasktype',
                name: 'tasktype',
                orderable: false,
                searchable: false
            },
            
             { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
             { data: 'group', name: 'student.group', searchable: true, visible: false },
              { data: 'employeename', name: 'employees.employeename', searchable: true, visible: false },
          
            {
                 data: 'shortdescription',
                name: 'shortdescription',
                 orderable: false,
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false
            }
            ,
              {
                data: 'taskCompleteddate',
                name: 'taskCompleteddate'
            },
              {
              data: 'taskCompletedtimenew',
                name: 'task.taskCompletedtime'
            },
             {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
             { data: 'multi_student_group', name: 'task.multi_student_group', searchable: true, visible: false },
        ],
          "drawCallback": function( settings ) {
        var api = this.api();
          var recordsTotal = this.api().page.info().recordsTotal;
            $('.todaytasktab').html(recordsTotal)
              $('.todayunreadtab').html(api.ajax.json().totalunreadcomments)
            
            
        // Output the data for the visible rows to the browser's console
        console.log( api.rows( {page:'current'} ).data().length );
        
         $('[data-toggle="popover"]').popover({
             sanitize: false, placement: 'top',html: true,
              trigger: 'hover'
           });
    }
    });
    var pendingtaskdatatable = $('#pendingtaskdatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
         ordering: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#pendingtaskdatatable').attr('data-link'),
             data: function(d) {
                d.startdate = startdatepending;
                d.enddate = enddatepending;
                d.orderby = ($(".checkboxpendingunread").is(':checked') ? true : '');
                d.groupno = $('#txtserachgroup').val();
              
            }
        },

        columns: [
            
            {
                data: 'name',
                name: 'users.name'
            },
             {
                data: 'subjectlink',
                name: 'subjectlink',
                orderable: false,
                searchable: false
            },
            {
                data: 'taskName',
                name: 'taskName', searchable: true, visible: false 
            }
            ,
            {
                data: 'tasktype',
                name: 'tasktype',
                orderable: false,
                searchable: false
            },
            
             { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
             { data: 'group', name: 'student.group', searchable: true, visible: false },
              { data: 'employeename', name: 'employees.employeename', searchable: true, visible: false },
          
            {
                data: 'shortdescription',
                name: 'shortdescription',
                 orderable: false,
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false,
                 width: '20px'
            }
            ,
              {
                data: 'taskCompleteddate',
                name: 'taskCompleteddate'
            },
              {
                data: 'taskCompletedtimenew',
                name: 'task.taskCompletedtime'
            },
              {
                data: 'created_at',
                name: 'task.created_at'
            },
             {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
             { data: 'multi_student_group', name: 'task.multi_student_group', searchable: true, visible: false },
        ],
        "drawCallback": function( settings ) {
        var api = this.api();
         var info = this.api().page.info();
 
             console.log(info,'infoinfoinfoinfo',api.ajax.json().totalunreadcomments)
            $('.pendingtasktab').html(info.recordsTotal)
            $('.pendingunreadtab').html(api.ajax.json().totalunreadcomments)
            
            
             $('[data-toggle="popover"]').popover({
             sanitize: false, placement: 'top',html: true,
              trigger: 'hover'
           });
            // Output the data for the visible rows to the browser's console
            // console.log( api.rows( {page:'current'} ).data().length );
    }
    });
    var completedtaskdatatable = $('#completedtaskdatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
         ordering: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#completedtaskdatatable').attr('data-link'),
            data: function(d) {
                d.orderby = ($(".checkboxcompletedunread").is(':checked') ? true : '');
                d.groupno = $('#txtserachgroup').val();
              
            }
        },

        columns: [
            
            {
                data: 'name',
                name: 'users.name',
                 orderable: false,
                searchable: false
            },
             {
                data: 'subjectlink',
                name: 'subjectlink',
                orderable: false,
                searchable: false
            },
            {
                data: 'taskName',
                name: 'taskName', searchable: true, visible: false 
            }
            ,
            {
                data: 'tasktype',
                name: 'tasktype',
                orderable: false,
                searchable: false
            },
            
             { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
             { data: 'group', name: 'student.group', searchable: true, visible: false },
              { data: 'employeename', name: 'employees.employeename', searchable: true, visible: false },
          
            {
                data: 'shortdescription',
                name: 'shortdescription',
                 orderable: false,
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false
            }
            ,
              {
                data: 'taskCompleteddate',
                name: 'task.taskCompleteddate'
            },
              {
                data: 'taskCompletedtimenew',
                name: 'task.taskCompletedtime'
            },
             {
                data: 'completedAt',
                name: 'taskassign.taskCompleteddate'
            },
             {
                data: 'created_at',
                name: 'task.created_at'
            },
             {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
             { data: 'multi_student_group', name: 'task.multi_student_group', searchable: true, visible: false },
        ],
         "drawCallback": function( settings ) {
        var api = this.api();
        var recordsTotal = this.api().page.info().recordsTotal;
 
            $('.completedtasktab').html(recordsTotal)
            $('.completedunreadtab').html(api.ajax.json().totalunreadcomments)
        // Output the data for the visible rows to the browser's console
        console.log( api.rows( {page:'current'} ).data().length );
        
        
         $('[data-toggle="popover"]').popover({
             sanitize: false, placement: 'top',html: true,
              trigger: 'hover'
           });
    }
    });
    var canceltaskdatatable = $('#canceltaskdatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
         ordering: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#canceltaskdatatable').attr('data-link'),
            data: function(d) {
                 d.orderby = ($(".checkboxcancelunread").is(':checked') ? true : '');
                 d.groupno = $('#txtserachgroup').val();
              
            }
            
        },

        columns: [
            
            {
                data: 'name',
                name: 'users.name'
            },
             {
                data: 'subjectlink',
                name: 'subjectlink',
                orderable: false,
                searchable: false
            },
            {
                data: 'taskName',
                name: 'taskName', searchable: true, visible: false 
            }
            ,
            {
                data: 'tasktype',
                name: 'tasktype',
                orderable: false,
                searchable: false
            },
            
             { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
             { data: 'group', name: 'student.group', searchable: true, visible: false },
              { data: 'employeename', name: 'employees.employeename', searchable: true, visible: false },
          
            {
                data: 'shortdescription',
                name: 'shortdescription',
                 orderable: false,
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false
            }
            ,
              {
                data: 'taskCompleteddate',
                name: 'taskCompleteddate',
            },
              {
                 data: 'taskCompletedtimenew',
                name: 'task.taskCompletedtime'
            },
             {
                data: 'cancelAt',
                name: 'taskassign.updated_at'
            },
             {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
             { data: 'multi_student_group', name: 'task.multi_student_group', searchable: true, visible: false },
        ],
        "drawCallback": function( settings ) {
        var api = this.api();
         var recordsTotal = this.api().page.info().recordsTotal;
            $('.canceltasktab').html(recordsTotal)
             $('.cancelunreadtab').html(api.ajax.json().totalunreadcomments)
            
            
        // Output the data for the visible rows to the browser's console
        console.log( api.rows( {page:'current'} ).data().length );
        
         $('[data-toggle="popover"]').popover({
             sanitize: false, placement: 'top',html: true,
              trigger: 'hover'
           });
    }
    });
    var futuretaskdatatable = $('#futuretaskdatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        ordering: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#futuretaskdatatable').attr('data-link'),
             data: function(d) {
                d.startdate = startdatefuture;
                d.enddate = enddatefuture;
                  d.orderby = ($(".checkboxfutureunread").is(':checked') ? true : '');
                  d.groupno = $('#txtserachgroup').val();
            }
        },

        columns: [
            
            {
                data: 'name',
                name: 'users.name'
            },
             {
                data: 'subjectlink',
                name: 'subjectlink',
                orderable: false,
                searchable: false
            },
            {
                data: 'taskName',
                name: 'taskName', searchable: true, visible: false 
            }
            ,
            {
                data: 'tasktype',
                name: 'tasktype',
                orderable: false,
                searchable: false
            },
            
             { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
             { data: 'group', name: 'student.group', searchable: true, visible: false },
              { data: 'employeename', name: 'employees.employeename', searchable: true, visible: false },
          
            {
                data: 'shortdescription',
                name: 'shortdescription',
                 orderable: false,
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false,
                 width: '20px'
            }
            ,
              {
                data: 'taskCompleteddate',
                name: 'taskCompleteddate'
            },
              {
                data: 'taskCompletedtimenew',
                name: 'task.taskCompletedtime'
            },
              {
                data: 'created_at',
                name: 'task.created_at'
            },
             {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
             { data: 'multi_student_group', name: 'task.multi_student_group', searchable: true, visible: false },
        ],
        "drawCallback": function( settings ) {
        var api = this.api();
         var recordsTotal = this.api().page.info().recordsTotal;
            $('.futuretasktab').html(recordsTotal)
             $('.futureunreadtab').html(api.ajax.json().totalunreadcomments)
            
            
        // Output the data for the visible rows to the browser's console
        console.log( api.rows( {page:'current'} ).data().length );
        
         $('[data-toggle="popover"]').popover({
             sanitize: false, placement: 'top',html: true,
              trigger: 'hover'
           });
    }
    });
    var AssingTable = $('#taskAssigneddatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#taskAssigneddatatable').attr('data-link'),
            data: function(d) {
                d.startdate = '';
                d.enddate = '';
                d.orderby = ($(".checkboxAssignedunread").is(':checked') ? true : '');
                d.groupno = $('#txtserachgroup').val();
            }
        },

        columns: [
            
            {
                data: 'Groupusers',
                name: 'Groupusers',
                orderable: false,
                searchable: false
            },
             {
                data: 'subjectlink',
                name: 'subjectlink',
                orderable: false,
                searchable: false
            },
            {
                data: 'taskName',
                name: 'taskName', searchable: true, visible: false 
            }
            ,
            {
                data: 'tasktype',
                name: 'tasktype',
                orderable: false,
                searchable: false
            },
            
             { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
             { data: 'group', name: 'student.group', searchable: true, visible: false },
              { data: 'employeename', name: 'employees.employeename', searchable: true, visible: false },
          
            {
                 data: 'shortdescription',
                name: 'shortdescription',
                 orderable: false,
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false
            }
            ,
              {
                data: 'taskCompleteddate',
                name: 'taskCompleteddate'
            },
              {
                data: 'taskCompletedtimenew',
                name: 'task.taskCompletedtime'
            },
             {
                data: 'Groupusersstatus',
                name: 'Groupusersstatus',
                orderable: false,
                searchable: false
            },
            

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
             { data: 'multi_student_group', name: 'task.multi_student_group', searchable: true, visible: false },
        ],
        "drawCallback": function( settings ) {
        var api = this.api();
   var recordsTotal = this.api().page.info().recordsTotal;
            $('.assignedtasktab').html(recordsTotal)
            
              $('.assignedunreadtab').html(api.ajax.json().totalunreadcomments)
            
            
        // Output the data for the visible rows to the browser's console
        console.log( api.rows( {page:'current'} ).data().length );
        
         $('[data-toggle="popover"]').popover({
             sanitize: false, placement: 'top',html: true,
              trigger: 'hover',
              content: $('.myPopoverContent').html(),
              html: true
           });
    }
    });
    
   
    
    
    
     $(document).on('click','.btnsearchForm',function(){
    
                     $('#taskdatatable').DataTable().draw(true);
                     $('#pendingtaskdatatable').DataTable().draw(true);
                     $('#completedtaskdatatable').DataTable().draw(true);
                     $('#canceltaskdatatable').DataTable().draw(true);
                     $('#taskAssigneddatatable').DataTable().draw(true);
                     $('#futuretaskdatatable').DataTable().draw(true);
                     
                     
      
    })
    
    $(document).on('click','.btntask',function(){
        
        
        let _token = $('meta[name="csrf-token"]').attr('content');
        let taskstatus  = $(this).attr('data-status');
        let id  = $(this).attr('data-id');
        
        $.post('{{route("qualitycontrolpanel.task.status.change")}}',{_token:_token,taskstatus:taskstatus,id:id},function(res){
            alert("successfully update status");
            
               $('#taskdatatable').DataTable().draw(true);
                     $('#pendingtaskdatatable').DataTable().draw(true);
                      $('#completedtaskdatatable').DataTable().draw(true);
                       $('#canceltaskdatatable').DataTable().draw(true);
        })
        
        
        
    })
    
    
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
                    
                    alert(data.msg);
                    $('#taskExtenddateModal').modal('hide');
                    $('#taskReAssignForm')[0].reset();
                    
                    $('#taskdatatable').DataTable().draw(true);
                     $('#pendingtaskdatatable').DataTable().draw(true);
                      $('#completedtaskdatatable').DataTable().draw(true);
                       $('#canceltaskdatatable').DataTable().draw(true);

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
    
    
  
     
 $(document).on('change','#IsImportantchk',function(){       
    if(this.checked) {
        $('.isImportanttxt').val(1);
    }else{
         $('.isImportanttxt').val(0);
    }
  })
   
    
    
    
    
    
    setTimeout(function(){ 
        
          $('[data-toggle="popover"]').popover({
     sanitize: false, placement: 'top',html: true,
      trigger: 'hover'
   });
        
    }, 3000);
   
    
    
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});
</script>
@endpush