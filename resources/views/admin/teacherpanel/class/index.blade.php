@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">


    <div id="page-title">
        <h2>{{ $pageTitle }}</h2>
        <p>{{ $subTitle }}</p>
        
    </div>
 <div class="panel">
        <div class="panel-body">

            <div class="example-box-wrapper">



                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">
                                <form 
                                    role="form">
                                    @csrf
                                    <div class="example-box-wrapper">
                                        <div class="row">
                                            <div class="col-5 col-sm-3">
                                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                                <a  class="nav-link active" href="#CurrentClassess" data-toggle="tab" >
                                                    <i class="glyph-icon icon-dashboard"></i>
                                                    Current Classes
                                                </a>
                                                 <a style="display:none" class="nav-link active" href="#TodayClassess" data-toggle="tab" >
                                                    <i class="glyph-icon icon-dashboard"></i>
                                                    Total Classes
                                                </a>
                                                 <a class="nav-link" href="#allstudents" data-toggle="tab">
                                                    <i class="glyph-icon font-primary icon-camera"></i>
                                                    Total Students
                                                </a>
                                                </div>
                                            </div>
                                            <div class="col-7 col-sm-9">
                                                <div class="tab-content">
                                           
                                           
                                            <div style="display:none" class="tab-pane fade " id="CurrentClassess">

                                                 <div class="table-responsive">
                                    <table data-link="{{route('teacherpanel.student.currentclasses.datatable')}}" id="currentclasses-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                               
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                <th>Attdendance Day</th>
                                                <th>Attdendance Time</th>
                                             
                                              
                                              
                                            </tr>
                                        </thead>



                                    </table>
                                </div>


                            </div>
                            
                                            <div class="tab-pane fade show active" id="TodayClassess">

                                                 <div class="table-responsive">
                                    <table data-link="{{route('teacherpanel.student.todayclasses.datatable')}}" id="todayclasses-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                               
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                <th>Attdendance Day</th>
                                                <th>Attdendance Time</th>
                                             
                                              
                                              
                                            </tr>
                                        </thead>



                                    </table>
                                </div>


                            </div>
                                      
                                         
                                            
                                            <div class="tab-pane fade" id="allstudents">
                                               
                                                <div class="table-responsive">
                                                     <table data-link="{{route('teacherpanel.schdulestudent.datatable')}}"
                                        id="student-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                 <th>Status</th>
                                                <th width="20%">days</th>
                                                <th width="10%">Language</th>
                                                <th>Country</th>
                                                <th>Duration</th>
                                                

                                            </tr>
                                        </thead>



                                    </table>
                                                </div>
                                               
                                            </div>
                                           
                                        </div>
                                            </div>
                                        </div>
                                     
                                        
                                    </div>

                                </form>
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
<script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
<script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>

<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/widgets/datepicker/datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('.select2').select2();

    setInterval(function(){  $('#currentclasses-datatable').DataTable().draw(true); }, 30000)
    
    
    window.setInterval(function(){ // Set interval for checking
    var date = new Date(); // Create a Date object to find out what time it is
    if(date.getHours() === 0 && date.getMinutes() === 0){ // Check the time
         $('#todayclasses-datatable').DataTable().draw(true);
         console.log('checktime')
    }
}, 60000)
    


    var oTable = $('#currentclasses-datatable').DataTable({
        processing: true,
        serverSide: true,
       paging: false,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#currentclasses-datatable').attr('data-link'),
        },

        columns: [
            
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
                data: 'day_name',
                name: 'studentattendance.day_name'
            },
             {
                data: 'attdendancetime',
                name: 'studentattendance.attdendancetime',
                orderable: false,
                searchable: false
            }
        ]
    });
    
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
        },

        columns: [
            
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
                data: 'day_name',
                name: 'studentattendance.day_name'
            },
             {
                data: 'attdendancetime',
                name: 'studentattendance.attdendancetime',
                orderable: false,
                searchable: false
            }
        ]
    });
    
    var oTable = $('#recovery-class-datatable').DataTable({
        processing: true,
        serverSide: true,
      
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#recovery-class-datatable').attr('data-link'),
        },

        columns: [
            
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
                data: 'currentteachername',
                name: 'currentteachername',
                 orderable: false,
                searchable: false
            },
            {
                data: 'recoveryteachername',
                name: 'recoveryteachername',
                 orderable: false,
                searchable: false
            },
            {
                data: 'day',
                name: 'recovery_class.day'
            },
            {
                data: 'classtime',
                name: 'classtime',
                 orderable: false,
                searchable: false
            },
            {
                data: 'date',
                name: 'recovery_class.date'
            }
        ]
    });
    
    var oTable = $('#student-datatable').DataTable({
        processing: true,
        serverSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
        },

        columns: [

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
                data: 'class_status',
                name: 'class_status',
                orderable: false,
                searchable: false
            },
            
            {
                data: 'day',
                name: 'day',
                orderable: false,
                searchable: false
            },
            {
                data: 'languages',
                name: 'languages',
                orderable: false,
                searchable: false
            },

            {
                data: 'CountryName',
                name: 'countries.CountryName'
            },
            {
                data: 'duration',
                name: 'student.duration'
            }
        ]
    });


});
</script>

@endpush