@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/widgets/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} </h2>
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

                                <div class="row">
                                    <div class="col-md-4">
                                        <input placeholder="Joining Date" 
                                        id="reportrangepending"
                                        data-date-format="mm/dd/yy"
                                        class="form-control  joiningDate" name="" type="text"
                                        value="">
                                    </div>
                                      <div class="col-md-4">
                                        <select class="form-control" id="employeeDrp">
                                            <option value="">Select Teacher</option>
                                            @foreach($Employee as $val)
                                                <option value="{{$val->id}}">{{$val->employeename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                            <select name="academicStatus" class="form-control academicStatus">
                                            <option value="">Select Status</option>
                                             @foreach($academicStatusArr as $s)
                                              <option value="{{$s->academic_status_val}}">{{$s->academic_status}}</option>
                                             @endforeach
                                            </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />

                                <div class="table-responsive">
                                    <table data-link="{{route('admin.student.schdule.datatable')}}"
                                        id="student-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                 <th>Student Name</th>
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                <th width="20%">days</th>
                                                <th width="10%">Language</th>
                                                <th>Country</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                                 <th>Teacher Assign Status</th>
                                                <th>Teacher</th>
                                                 <th>Teacher</th>
                                                
                                                
                                               

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


@endsection
@push('scripts')

<!-- Data tables -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>
<script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
<script src="{{ asset('assets/widgets/sweetalert/sweetalert2.min.js') }}" defer></script>

<script type="text/javascript" src="{{ asset('assets/widgets/datepicker/datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
    integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
    crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
    </script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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

    var start = moment().subtract(60, 'years');
    var end =  moment().subtract(1, 'days');
    let startdatepending;
    let enddatepending;

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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'Get All': [moment().subtract(60, 'years'), moment().subtract(1, 'days')],
                }
            }, cb);


    var oTable = $('#student-datatable').DataTable({
        processing: true,
        serverSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
            data: function(d) {
                d.startdate = startdatepending;
                d.enddate = enddatepending;
                d.academicStatus = $('.academicStatus').val();
                  d.teacherId = $("#employeeDrp").val();
            }
        },

        columns: [
            {
                data: 'studentname',
                name: 'student.studentname',
                searchable: true,
                visible: false
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
            },
            {
                data: 'class_status',
                name: 'class_status',
                orderable: false,
                searchable: false
            },
             {
                data: 'teacher_assign_status_type',
                name: 'teacher_assign_status_type',
                orderable: false,
                searchable: false
            },
             {
                data: 'empprofile',
                name: 'empprofile',
                 orderable: false,
                searchable: false
            },
            {
                data: 'employeename',
                name: 'employees.employeename',
                searchable: true,
                visible: false
            }
        ]
    });
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});

$(document).ready(function() {
    $('.select2').select2();


    $(document).on('click', '.btnstudentdetail', function() {
        let id = $(this).attr('data-id');
        var route = '{{ route("admin.student.detail", ":id") }}';
        route = route.replace(':id', id);

        $.ajax({
            url: route,
            method: "GET",
            success: function(res) {

                let studentday = res.days;
                let studentlanguage = res.languages;
                let Student = res.Student;
                console.log(studentday)
                let dayhtml =
                    "<tr><td colspan='3' class='text-center'>No Record Found</td></tr>"
                if (studentday.length > 0) {
                    dayhtml = "";
                    $.each(studentday, function(i, row) {
                        console.log(row, 'ss', i)

                        dayhtml +=
                            `<tr><td>${row.day_name}</td><td>${row.student_time_text}</td><td>${row.local_time_text}</td></tr>`
                    })
                }
                $('#StudentDays').html(dayhtml);

                let languageHtml =
                    "<tr><td colspan='2' class='text-center' >No Record Found</td></tr>"

                if (studentlanguage.length > 0) {
                    languageHtml = "";
                    $.each(studentlanguage, function(i, row) {
                        languageHtml +=
                            `<tr><td>Language ${i+1}</td><td>${row.languagename}</td></tr>`
                    })
                }
                $('#StudentLanguage').html(languageHtml);

                $('#StudentDetail').html('');




                $('#addStudentModal').modal('show');
            }
        })
    });


    $('#formstudent').on('submit', function(event) {
        event.preventDefault();



        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#save').attr('disabled', 'disabled');
            },
            success: function(data) {
                if (data.error) {


                    $(`.form-control`).removeClass('is-invalid')
                    $('.errorlabelmy').html('');
                    for (var k in data.error) {

                        let value = data.error[k];
                        k = k.replace(/\./g, "");
                        let classvak = '.' + k;

                        console.log(classvak)

                        $(`${classvak}`).addClass('is-invalid');
                        $(`${classvak}`).closest('.form-group').find('.errorlabelmy').html(
                            value)

                    }
                } else {
                    // dynamic_field(1);
                    // $('#result').html('<div class="alert alert-success">' + data.success +
                    //     '</div>');
                    $(`.form-control`).removeClass('is-invalid')
                    $('.errorlabelmy').html('');
                    $('#save').attr('disabled', false);
                    swal("Good job!", data.success, data.alert);

                    $(".country").val('').trigger('change')
                    $("#formstudent").get(0).reset();
                    $('#addStudentModal').modal('hide');
                }
                $('#save').attr('disabled', false);

            }
        })
    });




    function changeStatus(formData) {

        console.log(formData)



        $.ajax({
            url: "{{ route('admin.student.academicstatus') }}",
            method: "POST",
            data: formData,
            success: function(res) {
                swal({
                    title: 'Status!',
                    text: 'Academin Status Change Successfully',
                    type: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1800
                });
            }
        })



    }

    function confirmStatus(info, callback) {


        swal.fire({
            title: "Are you sure?",
            text: "You Want Change status",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes !",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        }).then((result) => {
            if (result.value) {

                changeStatus(info);
                callback();
            }
        })



    }


    $(document).on('click', '.btnChangeAcademiStatus', function() {
        var studentid = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var statustext = $(this).text();
        console.log('ss')
        let $this = $(this);

        var info = {
            status: status,
            studentid: studentid,
            _token: $('meta[name="csrf-token"]').attr('content')
        }

        confirmStatus(info, function() {
            // $('#student-datatable').DataTable().draw(true);
            swal("Academic  Status change Successfully");
            $this.parents('.myclassDropStatsus').find('.btnstatustext').text(statustext);
        })

        console.log(status + '--' + studentid)
    })
});
</script>
@endpush