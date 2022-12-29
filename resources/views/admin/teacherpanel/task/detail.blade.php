@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
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


</style>
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }}</h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>

    <div class="panel">
        <div class="panel-body">

            <div class="example-box-wrapper">
                @include('admin.partials.flash')
                <div class="row">
                    <div class="col-12">
                       
                       
                         <div class="content-box" style=" padding: 12px;">
        <div class="mail-header clearfix row">
            <div class="col-md-6 pad0A">
                <label>Task :</label> <strong>{{$Task->taskName}}</strong>
            </div>
            <div class="float-right col-md-6 pad0A">
                    <div class="row">
                        <div class="col-md-5"><button class="btn btn-primary btn-block btnchangeStatus" data-status="1"> Mark As Complete</button></div>
                        
                        <div class="col-md-5"><button class="btn btn-danger  btn-block btnchangeStatus" data-status="2"> Mark As Cancel</button></div>
                    </div>
            </div>
        </div>
    </div>
                         <div class="content-box bg-white post-box">
      <label>Note :</label>
        <textarea name="" readonly class="textarea-autosize">{{$Task->taskDescription}}</textarea>
       
    </div>
    
                         
      <div class="row divassignusers">
         <h4>Task Created By</h4>
                    <div class="col-md-12" >
                        
                       
                         <a href="#" class="badge badge-success">{{$Task->taskcreatorname}}</a>
                      


                        
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
                         <a href="#" class="badge badge-primary">{{$val->name}}</a>
                        @endforeach
                            


                        
                    </div>
                </div>
                
                          <div style="display:{{(count($TaskassignCancel) > 0) ? 'block' : 'none' }}" class="row divassignusers">
         <h4>Task Cancel by</h4>
                    <div class="col-md-12" >
                        
                        @foreach($TaskassignCancel as $val)
                         <a href="#" class="badge badge-danger">{{$val->name}}</a>
                        @endforeach
                            


                        
                    </div>
                </div>
    
                         <div class="content-box bg-white post-box">
       
        <textarea name="" class="textarea-autosize commenttxtarea" placeholder="Write Your Comment"></textarea>
        <div class="button-pane">
          
            <button class="btn btn-md btn-post float-right btn-success btncomment" title="">
               Comment
            </button>

        </div>
    </div>

   

                    </div>
                    <!-- /.col -->
                </div>
                 <div class="row" style="display:{{($Task->task_type == 1) ? 'block' : 'none'}}">
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
                    <div class="col-12" >
                        
                             <table id="commentdatatable" data-link="{{route('teacherpanel.task.comment.datatable')}}"
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

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>

<script>
$(document).ready(function() {
   
   
$(document).on('click','.btnchangeStatus',function(){
    
    var status  = $(this).attr('data-status');
    var taskId  =  "{{ request()->route('id') }}";
    let token =  $('meta[name="csrf-token"]').attr('content');
    
   $.post('{{route("teacherpanel.task.status.detail.change")}}',{_token:token,taskstatus:status,id:taskId},function(res){
            alert("successfully update status");
            window.location.reload();
    })
    
})

   
$(document).on('click','.btncomment',function(){
    
        let comment = $('.commenttxtarea').val();
        let token =  $('meta[name="csrf-token"]').attr('content');
        
        if(comment != ""){
            $.post('{{route("teacherpanel.task.comment")}}',{_token:token,comment:comment,taskid:"{{ request()->route('id') }}"},function(){
            
            
            alert('comment add successfully');
            
             $('#commentdatatable').DataTable().draw(true);
            
        })
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
                data: 'comment',
                name: 'comment'
            },
            {
                data: 'name',
                name: 'users.name'
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
            
           
        ]
    });
   
});
</script>
@endpush