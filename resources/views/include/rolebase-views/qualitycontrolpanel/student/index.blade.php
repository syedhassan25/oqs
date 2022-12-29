@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/widgets/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
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
                                            class="form-control bootstrap-datepicker joiningDate" name="" type="text"
                                            value="">
                                    </div>
                                      <div class="col-md-3">
                                        <select class="form-control" id="employeeDrp">
                                            <option value="">Select Teacher</option>
                                            @foreach($Employee as $val)
                                                <option value="{{$val->id}}">{{$val->employeename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                            <select name="academicStatus" class="form-control academicStatus select2"
                                            
                                           multiple="multiple" data-placeholder="Select a Status" data-dropdown-css-class="select2-purple"
                                            
                                            >
                                            <option value="">Select Status</option>
                                            <option {{ ($status == 1 ) ? 'selected' : '' }} value="1">Active</option>
                                            <option {{ ($status == 2 ) ? 'selected' : '' }} value="2">Inactive</option>
                                            <option {{ ($status == 3 ) ? 'selected' : '' }} value="3">Leave</option>
                                            <option {{ ($status == 4 ) ? 'selected' : '' }} value="4">Close</option>
                                            <option {{ ($status == 5 ) ? 'selected' : '' }} value="5">Rejected</option>
                                            <option {{ ($status == 6 ) ? 'selected' : '' }} value="6">Pending</option>
                                            </select>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" value="" placeholder="Group No" id="txtserachgroup" class="form-control"  />
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />


                            <div class="table-responsive">
                                    <table data-link="{{route('admin.student.datatable')}}" id="student-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                 <th>Group</th>
                                                
                                                 <th>Student Name</th>
                                                <th>Student Name</th>
                                               <th>Status</th>
                                                <th>Contact No</th>
                                                <th>Email</th>
                                                <th>Country</th>
                                                <th>Skype id 1</th>
                                                <th>Skype id 2</th>
                                               <th>joining Date</th>
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
      
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
            data: function(d) {
                d.date = $('.joiningDate').val();
                d.academicStatus = $('.academicStatus').val();
                d.teacherId = $("#employeeDrp").val();
                d.groupno = $("#txtserachgroup").val();
            }
        },

        columns: [
            
             {
                data: 'group',
                name: 'student.group'
            },
           
             {
                data: 'studentprofile',
                name: 'studentprofile',
                orderable: false,
                searchable: false
            },
            {
                data: 'studentname',
                name: 'student.studentname',
                searchable: true,
                visible: false
            },
           
             {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                data: 'skypid_1',
                name: 'student.skypid_1'
            },
             {
                data: 'skypid_2',
                name: 'student.skypid_2',
                 searchable: true,
                visible: false
            },
             {
                data: 'joining_date',
                name: 'student.joining_date'
            },
             {
                data: 'detail',
                name: 'detail',
                orderable: false,
                searchable: false
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
                                         <tr><td>Gender</td><td>${(Student.gender == 1) ?  "male" : "Female" }</td></tr>
                                         <tr><td>Age</td><td>${Student.age}</td></tr>
                                         <tr><td>city</td><td>${Student.CityName}</td></tr>
                                         <tr><td>joining_source</td><td>${Student.joining_source}</td></tr>
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
});
</script>
@endpush