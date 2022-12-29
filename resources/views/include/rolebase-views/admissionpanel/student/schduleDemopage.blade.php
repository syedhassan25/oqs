@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
button#addnewstudent {
    margin-left: 14px;
}
</style>
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
                                                <input placeholder="schdule Date" data-date-format="mm/dd/yy"
                                                    class="form-control bootstrap-datepicker demoscduleDate" name=""
                                                    type="text" value="">
                                            </div>
                                            <div class="col-md-4">
                                                <input value="" class="timepickerBlank demoscduletime form-control"
                                                    value="" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary btnsearchSchdule">Search</button>
                                            </div>
                                        </div>
                                        <br />

                                        <div class="table-responsive">
                                            <table data-link="{{ route('admissionpanel.student.demoScduledatatablenew') }}"
                                                id="student-demo-schdule-datatable"
                                                class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Email</th>
                                                        <th>Group</th>
                                                        <th>Contact No</th>
                                                        <th>Country</th>
                                                        <th>Schdule Student  Time</th>
                                                        <th>Schdule Local Time</th>
                                                        <th>Schdule date</th>
                                                        <th>Action</th>
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

    $('.select2').select2({
        tags: true,
        dropdownParent: $("#SchduleModal")
    });

    $('.country').select2({
        tags: true,
        dropdownParent: $("#addStudentModal")
    });


    $('.timepickerBlank').timepicker({
        defaultTime: '',
        minuteStep: 15,
        disableFocus: true,
        template: 'dropdown'
    })
    $('.timepicker').timepicker({
        defaultTime: 'current',
        minuteStep: 15,
        disableFocus: true,
        template: 'dropdown'
    });
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    })



   
    


    var DemoSchduleTable = $('#student-demo-schdule-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-demo-schdule-datatable').attr('data-link'),
            data: function(d) {
                d.date = $('.demoscduleDate').val();
                d.time = $('.demoscduletime').val();
            }

        },

        columns: [{
                data: 'studentname',
                name: 'student.studentname'
            },
            {
                data: 'studentemail',
                name: 'student.studentemail'
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
                data: 'CountryName',
                name: 'countries.CountryName'
            },
            {
                data: 'studentTimeText',
                name: 'studentdemoschdules.studentTimeText'
            },
            {
                data: 'localTimeText',
                name: 'studentdemoschdules.localTimeText'
            },

            {
                data: 'schduleDate',
                name: 'studentdemoschdules.schduleDate'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

   


    $('.dataTables_filter input').attr("placeholder", "Search...");

    

});
</script>
@endpush