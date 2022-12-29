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
                                                <input placeholder="Date" data-date-format="mm/dd/yy"
                                                    class="form-control bootstrap-datepicker newformDate" name=""
                                                    type="text" value="">
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary btnsearchNewForm">Search</button>
                                            </div>
                                        </div>
                                        <br />

                                        <div class="table-responsive">
                                            <table data-link="{{ route('demonstrationpanel.student.newFormdatatable') }}"
                                                id="student-datatable" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>

                                                        <th>Student Name</th>
                                                        <th>Student Father Name</th>
                                                       
                                                        <th>Group</th>
                                                      
                                                        <th>Country</th>
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
            <form id="formstudentSchdule" action="{{ route('demonstrationpanel.student.demo.schdule.save') }}" method="POST"
                role="form">
                <div class="modal-body">


                    @csrf

                    <div class="row">


                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Timezones <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>


                                <select class=" select2 timezone @error('timezone') is-invalid @enderror "
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

                                <span class="text-danger">@error('timezone')
                                    {{ $message }}
                                    @enderror</span>
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
                                <label>Local Time <span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input name="studentlocaltime" id="studentlocaltime" value=""
                                    class="timepicker studentlocaltimeclass form-control" type="text">

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
                                <label>Schdule Date<span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <input placeholder="schdule Date" data-date-format="mm/dd/yy"
                                    class="form-control bootstrap-datepicker schduleDate @error('schdule Date') is-invalid @enderror "
                                    name="schduleDate" type="text" value="">

                                <span class="text-danger">@error('schdule Date')
                                    {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" id="saveDemoScdulebtn" class="btn btn-primary btn-block">Save changes</button>
                </div>
            </form>
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
                d.date = $('.newformDate').val();
            }
        },

        columns: [{
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
                data: 'CountryName',
                name: 'countries.CountryName'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    


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

    var MeetingSchduleTable = $('#student-meeting-schdule-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-meeting-schdule-datatable').attr('data-link'),
            data: function(d) {
                d.date = $('.meetingscduleDate').val();
                d.time = $('.meetingscduletime').val();
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
                data: 'contact_no',
                name: 'student.contact_no'
            },

            {
                data: 'CountryName',
                name: 'countries.CountryName'
            },
            {
                data: 'localTimeText',
                name: 'schdule_meeting_contact_form.localTimeText'
            },

            {
                data: 'schduleDate',
                name: 'schdule_meeting_contact_form.schduleDate'
            },
            {
                data: 'comment',
                name: 'schdule_meeting_contact_form.comment'
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

    


$(document).on('click', '.btnsearchNewForm', function() {

$('#student-datatable').DataTable().draw(true);
})

    $(document).on('click', '.btnsearchMeeting', function() {

        $('#student-meeting-schdule-datatable').DataTable().draw(true);
    })

    $(document).on('click', '.btnsearchSchdule', function() {

        $('#student-demo-schdule-datatable').DataTable().draw(true);
    })



    
    


    function toTimeZoneHouradd(time, zone,minutes) {
        var format = 'YYYY/MM/DD HH:mm:ss A';
        var format2 = 'YYYY/MM/DD hh:mm a';

            console.log('timetimetimetime',)

            if (minutes > 0) {
                return moment(time, format).tz(zone).add(minutes, 'minutes').format(format2);
            }else{
            

                minutes = Math.abs(minutes)
                return moment(time, format).tz(zone).subtract(minutes, 'minutes').format(format2);
            }
      

        // return moment.tz(time,zone).format('YYYY-MM-DD HH:mm:ss');
    }

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
        let hours  = (anothertimezone - pak)/60;
        let minutes =  anothertimezone - pak;

        console.log('timedifference hours',minutes)

        let changetimezone = toTimeZoneHouradd(dateTime, $('#timezoneName').val(),minutes );
        let studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a');
        if (minutes > 0) {

           studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a') ;
          console.log('changetimezone convert', moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
        }else{
            minutes = Math.abs(minutes)
           studenttime  =  moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a');
            console.log('changetimezone convert', moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
        }

        let localtimeget =   toTimeZone(date + ' ' + studenttime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent');
        $('.studentlocaltimeclass').timepicker('setTime',new Date(studenttime));




        //    console.log('')
    });

    $(document).on('change', '#timezonedrp', function() {
        // attr('data-curr');


        var val = $(this).find('option:selected').attr('data-timezone');
        console.log(val)
        $('#timezoneName').val(val)


    });


    $(document).on('click', '#addnewstudent', function() {
        
        $('#addStudentModal').modal('show');
    });

    $(document).on('click', '.btnscduleDemo', function() {

        var studentid = $(this).attr('data-id');
         var zone = $(this).attr('data-zone');
        $('.timepicker').timepicker();
        $('.bootstrap-datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
        $('#timezonedrp').val('').trigger('change');
        $('#SchduleModal  input[name="id"]').val(studentid)
        $('#SchduleModal').modal('show');

     console.log('zonezone',zone)
      $('#timezonedrp').val(zone).trigger('change');
      $(".studenttimeclass").trigger("change");
        window.selectSchduleStudent = $(this);

    });

    $(document).on('click', '.btnscduleMeeting', function() {

        var studentid = $(this).attr('data-id');
        $('.timepicker').timepicker();
        $('.bootstrap-datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

        $('#MeetingSchduleModal  input[name="id"]').val(studentid)
        $('#MeetingSchduleModal').modal('show');

    });
    $('#formstudentMeetingSchdule').on('submit', function(event) {
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
                            .html(
                                value)

                    }
                } else {

                    $(`.form-control`).removeClass('is-invalid')
                    $('.errorlabelmy').html('');
                    $('#saveDemoScdulebtn').attr('disabled', false);
                    swal("Good job!", data.success, data.alert);

                    $('.timepicker').timepicker();
                    $('.bootstrap-datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                    });
                    $('#timezonedrp').val('').trigger('change');
                    $('#MeetingSchduleModal  input[name="id"]').val('')
                    $("#formstudentSchdule").get(0).reset();
                    $('#MeetingSchduleModal').modal('hide');

                    $('#student-meeting-schdule-datatable').DataTable().draw(true);
                }
                $('#save').attr('disabled', false);

            }
        })
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
    
    
    
     var count = 1;

    dynamic_field(count);

    function dynamic_field(number) {
        var i = number - 1
        console.log(i, 'sssssss');
        html = '<div class="parentName">';
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
                            .html(value)

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

                    $('#student-datatable').DataTable().draw(true);
                     $('.studentappendable').html('');
                }
                $('#save').attr('disabled', false);

            }
        })
    });
});
</script>
@endpush