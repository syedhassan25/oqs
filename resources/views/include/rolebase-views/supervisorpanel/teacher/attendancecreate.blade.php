@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/widgets/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} </h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>

    <div class="panel">
        <div class="panel-body">

            <div class="example-box-wrapper">


                <form id="formteacherattendance" action="{{ route('supervisorpanel.teacher.save.attendance') }}" method="POST"
                                    role="form">
                                    @csrf
                    
                    <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <input placeholder="Joining Date" data-date-format="mm/dd/yy" name="attendanceDate"
                                            class="form-control bootstrap-datepicker attendanceDate" name="" type="text"
                                            value="">
                                    </div>
                                    <div class="col-md-4">
                                            <select name="attendanceStatusall" class="form-control attendanceStatusall">
                                            <option value=""> Select Attendance Status</option>
                                                               <option value="1"> Present</option>
                                                               <option value="2"> Absent</option>
                                                               <option value="3"> Leave</option>
                                            </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btnsearchForm">Save</button>
                                    </div>
                                </div>
                                <br />

                                <div class="table-responsive">
                                    <table  class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                               <th>Teacher NAme</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>contact_no</th>
                                                <th>Attendance</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                          
                                          @foreach($Employee as $index => $val) 
                                                    <tr>
                                                        <td>{{$val->employeename}}</td>
                                                        <td>{{$val->email}}</td>
                                                        <td>{{$val->gender_type}}</td>
                                                        <td>{{$val->contact_no}}</td>
                                                        <td>
                                                    <input type="hidden" value="{{$val->id}}" name="teacher_id[]" />        
                                                    <select required class="form-control attendancedrp" name="attendanceStatus[{{$index}}]" id="attendanceStatus-{{$val->id}}">
                                                               <option value=""> Select Attendance</option>
                                                               <option value="1"> Present</option>
                                                               <option value="2"> Absent</option>
                                                               <option value="3"> Leave</option>
                                                        </select></td>
                                                    </tr>
                                          @endforeach
                                          
                                        </tbody>



                                    </table>
                                </div>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                    
                </form>

                
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
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker-demo.js') }}"></script>

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
</script>

<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {
   $('.select2').select2();

    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    }).datepicker("setDate",'now');


$(document).on('change','.attendanceStatusall',function(){
    
     let status   =  $(this).val();
     $('.attendancedrp').val(status);
     
});




$("#formteacherattendance").validate({
         ignore: [],
        rules: {
            'teacher_id[]': {
                required: true,

            },
            'attendanceStatus[]': {
                required: true,

            },
           attendanceDate: {
                required: true
            },
           

        },
        submitHandler: function(form) {

            var valuesToSubmit = $(form).serialize();
            $.ajax({
                url: $(form).attr('action'),
                data: valuesToSubmit,
                dataType: 'json',
                type: 'POST',
                beforeSend: function() { 
                  $("#formteacherattendance").prop('disabled', true); // disable button
                },
                success: function(data) {
                    $("#btnformsubmitstudent").prop('disabled', false);
                    swal(data.msg);
                    // location.reload();
                },
                error: function(data) {
                    alert('Error')
                }
            });
        }
    });



 
});

</script>
@endpush