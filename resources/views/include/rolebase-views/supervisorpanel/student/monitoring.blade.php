@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
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



                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">
                           
                            <div class="row">
                                 <div class="col-md-4">
                                        <select class="form-control" id="employeeDrp">
                                            <option value="">Select Teacher</option>
                                            @foreach($Employee as $val)
                                                <option value="{{$val->id}}">{{$val->employeename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="attendancestatusDrp">
                                            <option value="">Select Attendance Status</option>
                                            @foreach($allatendancestatus as $val)
                                                <option value="{{$val->status}}">{{$val->status_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                   
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />
                        
                        
                          <div class="table-responsive">
                                    <table data-link="{{route('supervisorpanel.student.todayclasses.datatable')}}" id="todayclasses-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                               
                                                <th>Teacher Name</th>
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                <th>Attendance Status</th>
                                                <th>Attendance Status</th>
                                                <th>attdendanceday</th>
                                                <th>Class time</th>
                                                <th>Attendance Time</th>
                                                <th>Student Name</th>
                                                <th>Action</th>
                                              
                                              
                                              
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
    
      <div id="MarkAttendanceModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Mark Attendance </h4>
                    </div>
          <div class="modal-body">
            <div class="row">
                
                  <div class="example-box-wrapper">
                                  

                                    <button data-status="1" class="btn btn-alt btn-hover btn-success btnattendancesave">
                                        <span>Online</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>
                                    <button  data-status="2" class="btn btn-alt btn-hover btn-danger btnattendancesave">
                                        <span>offline</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>
                                    <button data-status="3"  class="btn btn-alt btn-hover btn-warning btnattendancesave">
                                        <span>leave</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>
                                    <button data-status="4"  class="btn btn-alt btn-hover btn-info btnattendancesave">
                                        <span>no answer</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>
                                    <button data-status="5" class="btn btn-alt btn-hover btn-blue-alt btnattendancesave">
                                        <span>busy</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>
                                    <button data-status="6" class="btn btn-alt btn-hover btn-yellow btnattendancesave">
                                        <span>voice problem</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>
                                    <button data-status="7" class="btn btn-alt btn-hover btn-purple btnattendancesave">
                                        <span>call failed</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>
                                    <button data-status="8" class="btn btn-alt btn-hover btn-azure btnattendancesave">
                                        <span>late</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>

                                    <button data-status="9" class="btn btn-alt btn-hover btn-primary btnattendancesave">
                                        <span>none</span>
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </button>

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

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>
<script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
<script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>
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

<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {


    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    })


    $(document).on('click', '.btnsearchForm', function() {

        $('#todayclasses-datatable').DataTable().draw(true);
    })
    
    setInterval(function(){  $('#todayclasses-datatable').DataTable().draw(true); }, 30000)
    
    
     $(document).on('click', '.btnattendanceclick', function() {

        var id  = $(this).attr('data-id');
        $('#MarkAttendanceModal').modal('show');
        $('#MarkAttendanceModal').attr('data-id',id)
      });
      
      
      $(document).on('click','.btnattendancesave',function(){
        
        
         var status = $(this).attr('data-status');
         var attendanceid = $('#MarkAttendanceModal').attr('data-id');

        var route = '{{ route("supervisorpanel.student.attendance.save") }}';

        $.post(route, {status:status,attendanceID:attendanceid,_token:$('meta[name="csrf-token"]').attr('content')}, function(data) {


            swal({
                        title: "Attendance!",
                        text: data.msg,
                        icon: "success",
                        button: "Close",
                    });
                     $('#MarkAttendanceModal').modal('hide');
                     $('#todayclasses-datatable').DataTable().draw(true);
        })
        
    })
    
    

    var oTable = $('#todayclasses-datatable').DataTable({
        processing: true,
        serverSide: true,
         paging: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#todayclasses-datatable').attr('data-link'),
             data: function(d) {
                d.status = $('#attendancestatusDrp').val();
                d.teacherId = $("#employeeDrp").val();
              
            }
        },

        columns: [
            {
                data: 'employeename',
                name: 'employees.employeename'
            },
             {
                data: 'studentprofile',
                name: 'studentprofile',
                orderable: false,
                searchable: false
            },
            
            {
                data: 'group',
                name: 'student.group'
            },
            
              {
                data: 'attendancestatusColor',
                name: 'attendancestatusColor',
                orderable: false,
                searchable: false
            },
             {
                data: 'status_name',
                name: 'attendance_status.status_name',
                searchable: true, visible: false
            },
             {
                data: 'day_name',
                name: 'studentattendance.day_name'
            },
              {
                data: 'classtime',
                name: 'studentattendance.attdendancetime',
                orderable: false,
                searchable: false
            },
             {
                data: 'attdendancetime',
                name: 'attdendancetime',
                orderable: false,
                searchable: false
            },
            { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});


</script>
@endpush