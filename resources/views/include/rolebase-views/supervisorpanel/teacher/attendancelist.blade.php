@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                                       <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
                                    </div>
                                 <div class="col-md-3">
                                        <select class="form-control js-example-basic-single" id="employeeDrp">
                                            <option value="">Select Teacher</option>
                                            @foreach($Employee as $val)
                                                <option value="{{$val->id}}">{{$val->employeename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" id="attendancestatusDrp">
                                            <option value="">Select Attendance Status</option>
                                   
                                                               <option value="1"> Present</option>
                                                               <option value="2"> Absent</option>
                                                               <option value="3"> Leave</option>
                                        </select>
                                    </div>
                                    
                                   
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />
                        
                      
                        
                          <div class="table-responsive">
                                    <table data-link="{{route('supervisorpanel.teacher.attendance.datatable')}}" id="todayclasses-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Teacher NAme</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>contact_no</th>
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
<!--<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker.js') }}"></script>-->
<!--<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker-demo.js') }}"></script>-->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>


<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-fixedcolumns.js') }}"></script>



<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {
    $('.js-example-basic-single').select2();

 "use strict";
 
 
 
    let startdate;
    let enddate;

 
    // var start = moment().subtract(29, 'days');
    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
         startdate = start.format('DD-MM-YYYY');
         enddate = end.format('DD-MM-YYYY');
    }

    $('#reportrange').daterangepicker({
        locale: {
        format: 'DD/MMM/YYYY'
        },
        startDate: moment().startOf('day'),
        endDate: moment().endOf('day'),
        ranges: {
           'Today': [moment().startOf('day'), moment().endOf('day')],
           'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
           'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
           'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
 


    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    })


var _token = '{{ csrf_token() }}'
$(document).on('change','.attendancedrp',function(){
      var id =  $(this).find('option:selected').attr('data-id');
       var status  = $(this).val();
       swal({
      title: "Are you sure?",
      text: "Do You Want Change Attendance Status",
      icon: "warning",
      buttons: true,
      dangerMode: false,
       buttons: ["Cancel", "Yes"],
    })
.then((willDelete) => {
  if (willDelete) {
        $.post('{{route("supervisorpanel.teacher.update.status.attendance")}}',{status:status,id:id,_token:_token},function(res){
            if(res.success){
                swal("Poof! Change Status Successfully", {
                  icon: "success",
                });
            }else{
                swal("Cancelled", "Something Went Wrong", "error");
            }
             
        })
  }
});
       
    
})
    
    
    
    
       $(document).on('click', '.btnsearchForm', function() {

        $('#todayclasses-datatable').DataTable().draw(true);
    })
    
    // setInterval(function(){  $('#todayclasses-datatable').DataTable().draw(true); }, 10000)

    var oTable = $('#todayclasses-datatable').DataTable({
         processing: true,
         serverSide: true,
         paging: false,
         scrollY:        "600px",
         scrollX:        true,
         scrollCollapse: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#todayclasses-datatable').attr('data-link'),
             data: function(d) {
                d.status = $('#attendancestatusDrp').val();
                d.teacherId = $("#employeeDrp").val();
                d.startdate = startdate;
                d.enddate = enddate;
              
            }
        },

        columns: [
            {
                data: 'employeename',
                name: 'employees.employeename'
            },
            {
                data: 'email',
                name: 'users.email'
            },
            {
                data: 'gender_type',
                name: 'gender_type',
                orderable: false,
                searchable: false
            },
             {
                data: 'contact_no',
                name: 'employees.contact_no'
            },
            {
                 data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    
    
    
   

    
    
     
    
    
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});


</script>
@endpush