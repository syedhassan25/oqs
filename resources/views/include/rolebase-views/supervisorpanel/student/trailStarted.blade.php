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
                                        <input placeholder="Joining Date" data-date-format="mm/dd/yy"
                                            class="form-control bootstrap-datepicker joiningDate" name=""
                                            type="text" value="">
                                    </div>
                                   
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />
                           
                            <div class="table-responsive">
                                    <table data-link="{{route('supervisorpanel.student.trail.started.datatable')}}" id="student-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>

                                                <th>Student Name</th>
                                                <th>Student Father Name</th>
                                                <th>Group</th>
                                                <th>Contact No</th>
                                                <th>Email</th>
                                                <th>Country</th>
                                                <th>Total Attendance</th>
                                                <th>Total Days Trail Start</th>
                                                <th>Joining Date</th>
                                                
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

        $('#student-datatable').DataTable().draw(true);
    })

    var oTable = $('#student-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
            data: function(d) {
                d.date = $('.joiningDate').val();
            }
        },

        columns: [ {
                data: 'studentprofile',
                name: 'studentprofile',
                orderable: false,
                searchable: false
            },
            {
                data: 'fathername',
                name: 'student.fathername'
            },
            {
                data: 'group',
                name: 'student.group'
            },
            {
                data: 'contact_no',
                name: 'student.contact_no'
            },
            {
                data: 'studentemail',
                name: 'student.studentemail'
            },
            {
                data: 'CountryName',
                name: 'countries.CountryName'
            },
            {
                data: 'attendancecount',
                name: 'attendancecount',
                orderable: false,
                searchable: false
            },
            {
                data: 'totaldaycount',
                name: 'totaldaycount',
                orderable: false,
                searchable: false
            },
            {
                data: 'joiningdate',
                name: 'joiningdate',
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