@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div class="container">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $subTitle }} <button id="addnewstudent" class="btn btn-primary pull-right px-2">Add Short
                Student</button></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ $pageTitle }}</a></li>
                            <li class="breadcrumb-item active">{{ $subTitle }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>




        <section class="content">
            <div class="container-fluid">

                <div class="example-box-wrapper">



                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">


                                    <div class="row">
                                        <div class="col-md-2">
                                            <input placeholder="Joining Date" id="reportrangepending"
                                                data-date-format="mm/dd/yy" class="form-control  joiningDate" name=""
                                                type="text" value="">
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" id="employeeDrp">
                                                <option value="">Select Teacher</option>
                                                @foreach ($Employee as $val)
                                                    <option value="{{ $val->id }}">{{ $val->employeename }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="academicStatus" class="form-control academicStatus select2"
                                                multiple="multiple" data-placeholder="Select a Status"
                                                data-dropdown-css-class="select2-purple">
                                                <option value="">Select Status</option>
                                                @foreach ($academicStatusArr as $s)
                                                    <?php
                                                    $sel = '';
                                                    if ($s->academic_status_val == $status) {
                                                        $sel = 'selected';
                                                    }
                                                    
                                                    ?>
                                                    <option {{ $sel }} value="{{ $s->academic_status_val }}">
                                                        {{ $s->academic_status }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" value="{{ $groupno }}" placeholder="Group No"
                                                id="txtserachgroup" class="form-control" />
                                        </div>
                                        <div class="col-md-2">
                                            <select class="isTafseerselect select2  " name="isTafseerselect"
                                                style="width: 100%;">
                                                <option value="">isTafseer</option>
                                                <option value="2">No</option>
                                                <option value="1">Yes</option>


                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="marketingagencies select2  " name="marketingagencies"
                                                style="width: 100%;">
                                                <option value="">Select
                                                    Marketing Agencies</option>
                                                @foreach ($Agencies as $a)
                                                    <option value="{{ $a->id }}">{{ $a->agencyname }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-primary btnsearchForm">Search</button>
                                        </div>
                                    </div>
                                    <br />


                                    <div class="table-responsive">
                                        <table data-link="{{ route('admin.student.datatable') }}" id="student-datatable"
                                            class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Group</th>

                                                    <th>Student Name</th>
                                                    <th>Student Name</th>
                                                    <th>Teahcer</th>
                                                    <th>Teahcer</th>
                                                    <th>Demo By</th>
                                                    <th>Status</th>
                                                    <th>Contact No</th>
                                                    <th>Email</th>
                                                    <th>Country</th>
                                                    <th>Skype id 1</th>
                                                    <th>Skype id 2</th>
                                                    <th>Marketing</th>
                                                    <th>joining Date</th>
                                                    <th style="width:100%">Action</th>
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
        </section>

    </div>


<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="addStudentModalLongTitle">Add Student</h5>

            </div>
            <form id="formstudent" action="{{ route('admin.student.store') }}" method="POST" role="form">
                <div class="modal-body">


                    @csrf

                   
                   
                   <input type="hidden" value="" name="newstudentid" />
                   
                   <div class="row">
                   
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Group No <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input type="text" value="{{ old('groupno') }}" name="groupno"
                                    placeholder="Group No"
                                    class="form-control groupno @error('groupno') is-invalid  @enderror" />

                            </div>
                        </div>

                    </div>
                   
                       <div class="row studentappendable" >
                       

                    </div>
                      <div class="row">
                   
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Guardian Name <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input type="text" value="{{ old('fathername') }}" name="fathername"
                                    placeholder="Father Name"
                                    class="form-control fathername @error('fathername') is-invalid  @enderror" />

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Contact No <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input placeholder="Contact No"
                                    class="form-control contact_no @error('contact_no') is-invalid @enderror "
                                    name="contact_no" type="text">
                                <span class="text-danger">@error('contact_no') {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Email <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input placeholder="Email"
                                    class="form-control email @error('email') is-invalid @enderror " name="email"
                                    type="text">
                                <span class="text-danger">@error('email') {{ $message }}
                                    @enderror</span>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>WhatsApp  <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input placeholder="WhatsApp No"
                                    class="form-control whatsApp @error('whatsApp') is-invalid @enderror "
                                    name="whatsApp" type="text">
                                <span class="text-danger">@error('whatsApp') {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>
                       
                    </div>
                    
                    
           
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Skype <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input placeholder="Skype 1"
                                    class="form-control skype1 @error('skype1') is-invalid @enderror "
                                    name="skype1" type="text">
                                <span class="text-danger">@error('skype1') {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>
                      
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Country <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>


                                <select class="country @error('country') is-invalid @enderror " name="country"
                                    style="width: 100%;">
                                    <option selected="selected" value="">Select Country</option>
                                    @foreach ($Country as $s)
                                    <option value="{{ $s->id }}">{{ $s->CountryName }}</option>
                                    @endforeach
                                </select>



                                <span class="text-danger">@error('country') {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Timezones <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>


                                <select class=" select2 timezone @error('timezone') is-invalid @enderror "
                                    name="timezone" id="timezonedrpform" style="width: 100%;">
                                    <option value="">Select
                                        Time Zone
                                    </option>
                                    @foreach ($timezones as $s)
                                    <option data-timezone="{{ $s['timezone'] }}" value="{{ $s['timezone'] }}">
                                        {{ $s['name'] }}
                                    </option>
                                    @endforeach
                                </select>

                                <input id="timezoneNameshort" readonly
                                    class="form-control timezoneNameshort @error('timezoneNameshort') is-invalid @enderror"
                                    name="timezoneNameshort" value="" type="hidden">

                                <span class="text-danger">@error('timezone')
                                    {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>
                    </div>
                    
             

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Detail <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>


                                <textarea name="detail" class="form-control @error('detail') is-invalid @enderror"></textarea>



                                <span class="text-danger">@error('detail') {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Comments <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>


                                <textarea name="comment" class="form-control @error('comment') is-invalid @enderror"></textarea>



                                <span class="text-danger">@error('comment') {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">

                    <button type="submit" id="save" class="btn btn-primary btn-block">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="modal fade" id="viewStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="viewStudentModalLongTitle">Student Detail</h5>

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

    <div class="modal fade" id="CommentStudentModal" tabindex="-1" role="dialog" aria-labelledby="SchduleModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addMeetingSchduleModalLongTitle">Comments</h5>

                </div>
                <form id="formstudentComments" action="{{ route('admin.student.new.comment.save') }}" method="POST"
                    role="form">
                    <div class="modal-body">


                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="table-responsive">
                                    <table data-link="{{ route('admin.student.new.comment.datatable') }}"
                                        id="student-new-comment-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>

                                                <th>Comment</th>
                                                <th>Created By</th>
                                                <th>Created At</th>

                                            </tr>
                                        </thead>



                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Comment<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <textarea name="comment" class="form-control comment @error('comment') is-invalid @enderror "></textarea>

                                    <input type="hidden" name="id" value="" />

                                    <span class="text-danger">
                                        @error('comment')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="saveCommentsNew" class="btn btn-primary btn-block">Save
                            Comments</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FollowUpCommentStudentModal" tabindex="-1" role="dialog"
        aria-labelledby="SchduleModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addMeetingSchduleModalLongTitle">FollowUp Comments</h5>

                </div>
                <form id="formstudentFollowUpComments"
                    action="{{ route('admin.student.new.comment.followupattendance.save') }}" method="POST"
                    role="form">
                    <div class="modal-body">


                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="table-responsive">
                                    <table
                                        data-link="{{ route('admin.student.new.comment.followupattendance.datatable') }}"
                                        id="student-new-followupattendance-comment-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>

                                                <th>Comment</th>
                                                <th>Created By</th>
                                                <th>Created At</th>

                                            </tr>
                                        </thead>



                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Comment<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <textarea name="comment" class="form-control comment @error('comment') is-invalid @enderror "></textarea>

                                    <input type="hidden" name="id" value="" />

                                    <span class="text-danger">
                                        @error('comment')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="saveFollowUpCommentsNew" class="btn btn-primary btn-block">Save
                            Comments</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="SchduleModal" tabindex="-1" role="dialog" aria-labelledby="SchduleModalTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addSSchduleModalLongTitle">Demo Schdule</h5>

                </div>
                <form id="formstudentSchdule" action="{{ route('admin.student.demo.schdule.save') }}" method="POST"
                    role="form">
                    <div class="modal-body">


                        @csrf

                        <div class="row">


                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Timezones <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>


                                    <select class=" select2Timezone timezone @error('timezone') is-invalid @enderror "
                                        name="timezone" id="timezonedrp" style="width: 100%;">
                                        <option value="">Select
                                            Time Zone
                                        </option>
                                        @foreach ($timezones as $s)
                                            <option data-timezone="{{ $s['timezone'] }}" value="{{ $s['timezone'] }}">
                                                {{ $s['name'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input id="timezoneName" readonly
                                        class="form-control timezoneName @error('timezoneName') is-invalid @enderror"
                                        name="timezoneName" value="Asia/Tashkent" type="hidden">

                                    <span class="text-danger">
                                        @error('timezone')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>



                        </div>



                        <div class="row">


                            <div class="col-sm-12">
                                <input type="hidden" name="id" value="" />
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Student Time <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>




                                    <input name="studenttime" id="studenttime" value=""
                                        class="timepicker studenttimeclass form-control" type="text">

                                    <span class="text-danger">
                                        @error('timezone')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>



                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Local Time <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input name="studentlocaltime" id="studentlocaltime" value=""
                                        class="timepicker studentlocaltimeclass form-control" type="text">

                                    <span class="text-danger">
                                        @error('timezone')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Schdule Date<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input placeholder="schdule Date" data-date-format="mm/dd/yy"
                                        class="form-control bootstrap-datepicker schduleDate @error('schdule Date') is-invalid @enderror "
                                        name="schduleDate" type="text" value="">

                                    <span class="text-danger">
                                        @error('schdule Date')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="saveDemoScdulebtn" class="btn btn-primary btn-block">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    
    
@endsection
@push('scripts')
    <!-- Data tables -->

    <!--<link rel="stylesheet" type="text/css" href="../../assets/plugins/datatable/datatable.css">-->
    <script type="text/javascript" src="{{ asset('assets/plugins/datatable/datatable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/datatable/datatable-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/datatable/datatable-responsive.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}" defer></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}" defer></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/datepicker/datepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
        integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Bootstrap Timepicker -->

    <script type="text/javascript" src="{{ asset('assets/plugins/timepicker/timepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
    </script>

    <script type="text/javascript" src="{{ asset('assets/plugins/timepicker/timepicker.js') }}"></script>


    <script type="text/javascript">
        /* Datatables responsive */

        $(document).ready(function() {

            $('.select2').select2();


            $('.select2Timezone').select2({
                tags: true,
                dropdownParent: $("#SchduleModal")
            });

            $('.bootstrap-datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
            $('.timepicker').timepicker({
                defaultTime: 'current',
                minuteStep: 15,
                disableFocus: true,
                template: 'dropdown'
            });


            var start = moment().subtract(60, 'years');
            var end = moment().subtract(1, 'days');
            let startdatepending;
            let enddatepending;

            function cb(start, end) {
                $('#reportrangepending span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
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
                    'Get All': [moment().subtract(60, 'years'), moment().subtract(1, 'days')]
                }
            }, cb);


            function toTimeZone(time, zone) {
                var format = 'YYYY/MM/DD HH:mm:ss A';
                var format2 = 'YYYY/MM/DD hh:mm a';


                return moment(time, format).tz(zone).format(format2);

                // return moment.tz(time,zone).format('YYYY-MM-DD HH:mm:ss');
            }

            $(document).on("change", ".studenttimeclass", function(e) {

                e.preventDefault();
                var element = $(this).val();

                var index = $(this).attr('data-index');

                var today = new Date();

                var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();



                var dateTime = date + ' ' + element;

                // console.log('studettime', dateTime, 'teime zone', $('#timezoneName').val())
                // console.log('convertime', new Date(toTimeZone(dateTime,
                //     $('#timezoneName').val())))

                // $('.studentlocaltimeclass').timepicker('setTime', new Date(toTimeZone(dateTime,
                //     $('#timezoneName').val())));



                let nows = moment.utc();
                let anothertimezone = moment.tz.zone($('#timezoneName').val()).offset(nows)
                let pak = moment.tz.zone("Asia/Tashkent").offset(nows);
                let hours = (anothertimezone - pak) / 60;
                let minutes = anothertimezone - pak;

                console.log('timedifference hours', minutes)

                // let changetimezone = toTimeZoneHouradd(dateTime, $('#timezoneName').val(),minutes,'{{ $timeChangeEuropeStatus }}');

                let changetimezone = toTimeZoneHouradd(dateTime, $('#timezoneName').val(), minutes,
                    '{{ $timeChangeEuropeStatusStudenttime }}',
                    '{{ $timeChangeEuropeStatusAmerica }}', '{{ $timeChangeEuropeStatusEurope }}');

                let studenttime = moment(changetimezone).add(minutes, 'minutes').format(
                    'YYYY/MM/DD hh:mm a');
                if (minutes > 0) {

                    studenttime = moment(changetimezone).add(minutes, 'minutes').format(
                        'YYYY/MM/DD hh:mm a');
                    console.log('changetimezone convert', moment(changetimezone).add(minutes, 'minutes')
                        .format('YYYY/MM/DD hh:mm a'))
                } else {
                    minutes = Math.abs(minutes)
                    studenttime = moment(changetimezone).subtract(minutes, 'minutes').format(
                        'YYYY/MM/DD hh:mm a');
                    console.log('changetimezone convert', moment(changetimezone).subtract(minutes,
                        'minutes').format('YYYY/MM/DD hh:mm a'))
                }

                let localtimeget = toTimeZone(date + ' ' + studenttime.toLocaleString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                }), 'Asia/Tashkent');
                $('.studentlocaltimeclass').timepicker('setTime', new Date(studenttime));




                //    console.log('')
            });

            $(document).on('change', '#timezonedrp', function() {
                // attr('data-curr');


                var val = $(this).find('option:selected').attr('data-timezone');
                console.log(val)
                $('#timezoneName').val(val)


            });


            $(document).on('click', '.btnsearchForm', function() {

                $('#student-datatable').DataTable().draw(true);
            })

            $(document).on('click', '.btnscduleDemo', function() {

                var studentid = $(this).attr('data-id');
                var zone = $(this).attr('data-zone');
                $('.timepicker').timepicker();
                $('.bootstrap-datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                });
                $('#timezonedrp').val('').trigger('change');
                $('#SchduleModal  input[name="id"]').val(studentid)

                let studentname = $(this).parents('tr').find('td:eq(1)').text();
                let group = $(this).parents('tr').find('td:eq(0)').text();
                studentname = `${studentname}(${group}) Comments`;
                $('#SchduleModal .modal-title').html(studentname);
                $('#SchduleModal').modal('show');

                console.log('zonezone', zone)
                $('#timezonedrp').val(zone).trigger('change');
                $(".studenttimeclass").trigger("change");
                window.selectSchduleStudent = $(this);

            });

            $('#formstudentSchdule').on('submit', function(event) {
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
                        // $('#saveDemoScdulebtn').attr('disabled', 'disabled');
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
                                $(`${classvak}`).closest('.form-group').find('.errorlabelmy')
                                    .html(value)

                            }
                        } else {
                            // dynamic_field(1);
                            // $('#result').html('<div class="alert alert-success">' + data.success +
                            //     '</div>');
                            $(`.form-control`).removeClass('is-invalid')
                            $('.errorlabelmy').html('');
                            $('#saveDemoScdulebtn').attr('disabled', false);
                            swal("Good job!", data.success, data.alert);

                            $('.timepicker').timepicker();
                            $('.bootstrap-datepicker').datepicker({
                                format: 'yyyy-mm-dd',
                            });
                            $('#timezonedrp').val('').trigger('change');
                            $('#SchduleModal  input[name="id"]').val('')
                            $("#formstudentSchdule").get(0).reset();
                            $('#SchduleModal').modal('hide');
                            // $(window.selectSchduleStudent).parents('tr').remove();
                            // window.selectSchduleStudent = '';

                            $('#student-datatable').DataTable().draw(true);
                            $('#student-demo-schdule-datatable').DataTable().draw(true);
                        }
                        $('#save').attr('disabled', false);

                    }
                })
            });

            $('#formstudentComments').on('submit', function(event) {
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
                        $('#saveCommentsNew').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        if (data.error) {

                            $('#saveCommentsNew').attr('disabled', false);
                            $(`.form-control`).removeClass('is-invalid')
                            $('.errorlabelmy').html('');
                            for (var k in data.error) {

                                let value = data.error[k];
                                k = k.replace(/\./g, "");
                                let classvak = '.' + k;

                                console.log(classvak)

                                $(`${classvak}`).addClass('is-invalid');
                                $(`${classvak}`).closest('.form-group').find('.errorlabelmy')
                                    .html(value)

                            }
                        } else {

                            $('#student-new-comment-datatable').DataTable().draw(true);
                            $(`.form-control`).removeClass('is-invalid')
                            $('.errorlabelmy').html('');
                            $('#saveCommentsNew').attr('disabled', false);
                            swal("Good job!", data.success, data.alert);
                            $("#formstudentComments").get(0).reset();
                            // $('#CommentStudentModal').modal('hide');
                            $('#CommentStudentModal  input[name="id"]').val('')


                        }
                        $('#save').attr('disabled', false);

                    }
                })
            });


            $(document).on('click', '.btnstudentcommentmodal', function() {

                let studentid = $(this).attr('data-id');
                $('#CommentStudentModal  input[name="id"]').val(studentid);
                $('#student-new-comment-datatable').DataTable().draw(true);


                let studentname = $(this).parents('tr').find('td:eq(1)').text();
                let group = $(this).parents('tr').find('td:eq(0)').text();
                studentname = `${studentname}(${group}) Comments`;
                $('#CommentStudentModal .modal-title').html(studentname);


                $('#CommentStudentModal').modal('show');

            });


            var oTable = $('#student-datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
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
                        d.groupno = $("#txtserachgroup").val();
                        d.agency = $(".marketingagencies").val();
                        d.isTafseer = $(".isTafseerselect").val();
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
                    },
                    {
                        data: 'demoprofile',
                        name: 'demoprofile',
                        orderable: false,
                        searchable: false
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
                        data: 'reference',
                        name: 'reference',
                        searchable: false,
                        visible: true
                    },
                    {
                        data: 'joining_date',
                        name: 'student.joining_date'
                    },
                    {
                        data: 'detail',
                        name: 'detail',
                        orderable: false,
                        searchable: false,
                        width: "100%"
                    }
                ],


            });

            var oTable = $('#student-new-comment-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                ],
                ajax: {
                    url: $('#student-new-comment-datatable').attr('data-link'),
                    data: function(d) {
                        d.id = $('#CommentStudentModal  input[name="id"]').val();
                    }
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
                        name: 'created_at'
                    }
                ]
            });



            $(document).on('click', '.btnstudenFollowUptcommentmodal', function() {
                $('#FollowUpCommentStudentModal  input[name="id"]').val('');
                let studentid = $(this).attr('data-id');
                $('#FollowUpCommentStudentModal  input[name="id"]').val(studentid);
                $('#student-new-followupattendance-comment-datatable').DataTable().draw(true);
                $('#FollowUpCommentStudentModal').modal('show');

            });

            var oTable = $('#student-new-followupattendance-comment-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                ],
                ajax: {
                    url: $('#student-new-followupattendance-comment-datatable').attr('data-link'),
                    data: function(d) {
                        d.id = $('#FollowUpCommentStudentModal  input[name="id"]').val();
                    }
                },

                columns: [{
                        data: 'comments',
                        name: 'comments'
                    },
                    {
                        data: 'name',
                        name: 'users.name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ]
            });
            $('#formstudentFollowUpComments').on('submit', function(event) {
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
                        $('#saveFollowUpCommentsNew').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        if (data.error) {

                            $('#saveFollowUpCommentsNew').attr('disabled', false);
                            $(`.form-control`).removeClass('is-invalid')
                            $('.errorlabelmy').html('');
                            for (var k in data.error) {

                                let value = data.error[k];
                                k = k.replace(/\./g, "");
                                let classvak = '.' + k;

                                console.log(classvak)

                                $(`${classvak}`).addClass('is-invalid');
                                $(`${classvak}`).closest('.form-group').find('.errorlabelmy')
                                    .html(value)

                            }
                        } else {

                            $('#student-new-followupattendance-comment-datatable').DataTable()
                                .draw(true);
                            $(`.form-control`).removeClass('is-invalid')
                            $('.errorlabelmy').html('');
                            $('#saveFollowUpCommentsNew').attr('disabled', false);
                            swal("Good job!", data.success, data.alert);
                            $("#formstudentFollowUpComments").get(0).reset();
                            // $('#CommentStudentModal').modal('hide');

                            $('#FollowUpCommentStudentModal  textarea[name="comment"]').val('');


                        }
                        $('#save').attr('disabled', false);

                    }
                })
            });


        });

        $(document).ready(function() {
            $('.dataTables_filter input').attr("placeholder", "Search...");
        });

        $(document).ready(function() {





            $(document).on('click', '.btnstudentdetail', function() {
                let id = $(this).attr('data-id');
                let studentname = $(this).parents('tr').find('td:eq(1)').text();
                let group = $(this).parents('tr').find('td:eq(0)').text();
                studentname = `${studentname}(${group}) Student Detail`;
                $('#viewStudentModal .modal-title').html(studentname);
                var route = '{{ route('admin.student.detail', ':id') }}';
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
                        let detailHtml = `<tr><td>Skype 1</td><td>${Student.skypid_1}</td></tr>
                                         <tr><td>Skype 2</td><td>${Student.skypid_2}</td></tr>
                                         <tr><td>WhatsApp</td><td>${Student.whatsapp}</td></tr>
                                         <tr><td>Contact</td><td>${Student.contact_no}</td></tr>
                                         <tr><td>Email 1</td><td>${Student.studentemail}</td></tr>
                                         <tr><td>Email 2</td><td>${Student.studentemail2}</td></tr>
                                         <tr><td>Billing Email</td><td>${Student.billingemail}</td></tr>
                                         <tr><td>Gender</td><td>${(Student.gender == 1) ?  "male" : "Female" }</td></tr>
                                         <tr><td>Age</td><td>${Student.age}</td></tr>
                                         <tr><td>city</td><td>${Student.CityName}</td></tr>
                                         <tr><td>joining_source</td><td>${Student.joining_source}</td></tr>
                                         `;
                        if (Student.joining_source == 1) {
                            detailHtml +=
                                `<tr><td>Agency</td><td>${Student.agencyname}</td></tr>`
                        } else {
                            detailHtml +=
                                `<tr><td>Reference Name</td><td>${Student.ref_name}</td></tr><tr><td>Reference Email</td><td>${Student.ref_email}</td></tr>`
                        }
                        detailHtml += `<tr><td>Duration</td><td>${Student.duration}</td></tr>`
                        detailHtml += `<tr><td>Detail</td><td>${Student.detail}</td></tr>`


                        $('#StudentDetail').html(detailHtml);



                        $('#viewStudentModal').modal('show');
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
                                $(`${classvak}`).closest('.form-group').find('.errorlabelmy')
                                    .html(
                                        value)

                            }
                        } else {
                            // dynamic_field(1);
                            // $('#result').html('<div class="alert alert-success">' + data.success +
                            //     '</div>');
                            $(`.form-control`).removeClass('is-invalid')
                            $('.errorlabelmy').html('');
                            $('#save').attr('disabled', false);
                            // swal("Good job!", data.success, data.alert);
 alert('save successfully')
                            $(".country").val('').trigger('change')
                            $("#formstudent").get(0).reset();
                            $('#viewStudentModal').modal('hide');
                        }
                        $('#save').attr('disabled', false);

                    }
                })
            });
            
            
              
     var count = 1;

    dynamic_field(count);

    function dynamic_field(number) {
        var i = number - 1
        console.log(i, 'sssssss');
        html = '<div class="parentName row">';
        html +=
            '<div class="col-md-10"><div class="form-group"><label>Name <span class="m-l-5 text-danger  errorlabelmy">*</span></label><input type="text"  name="name[]" class="form-control name' +
            i +
            '" /></div></div>';
       
        if (number > 1) {
            html +=
                '<div class="col-md-2"><button type="button" name="remove" id=""  style="margin-top:22px" class="btn btn-danger remove">Remove</button></div></div>';
            $('.studentappendable').append(html);
        } else {
            html +=
                '<div class="col-md-2"><button type="button" style="margin-top:22px" name="add" id="add" class="btn btn-success">Add</button></div></div>';
            $('.studentappendable').html(html);
        }
    }

    $(document).on('click', '#add', function() {
        count++;
        dynamic_field(count);
    });

    $(document).on('click', '.remove', function() {
        count--;
        $(this).closest(".parentName").remove();
    });
    
    $(document).on('click', '#addnewstudent', function() {
        
         dynamic_field(1);
         $('#add').show();
        $('#addStudentModal').attr('data-id','');
        $('#addStudentModal  input[name="newstudentid"]').val('');
        $('#addStudentModal .modal-title').html("Add Student");
        $("#formstudent").get(0).reset();
        $('#addStudentModal  select[name="country"]').val('').trigger('change');
        $(`#addStudentModal .form-control`).removeClass('is-invalid')
        $('#addStudentModal .errorlabelmy').html('');
        $('#addStudentModal  input[name="groupno"]').attr('disabled',false);
         $('#save').attr('disabled', false);
        $('#addStudentModal').modal({backdrop:'static', keyboard:false});
        
        
    });
    
        });
    </script>
@endpush
