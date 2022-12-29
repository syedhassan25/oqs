@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
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

                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Age</th>
                                        <th>Student Group</th>
                                        <th>Duration</th>
                                        <th>Student Days</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($Student as $val)
                                        <tr>
                                            <td>{{ $val->studentname }}</td>
                                            <td>{{ $val->age }}</td>
                                            <td>{{ $val->group }}</td>
                                            <td>{{ $val->duration }}</td>

                                            <td><?php
                                            
                                            $days = explode(',', $val->days);
                                            $studentdays = explode(',', $val->studentdays_name);
                                            $local_time_text = explode(',', $val->local_time_text);
                                            
                                            $ret = '<table style="font-size:10px !important;text-align:center !important">';
                                            
                                            foreach ($days as $index => $val) {
                                                $studentdaysss = isset($studentdays[$index]) ? ($studentdays[$index] != '' ? substr($studentdays[$index], 0, 3) : 'no') : 'no';
                                                $ret .= '<td>';
                                                $ret .= '<table class="table-bordered">';
                                                $ret .= '<tr><td>' . substr($days[$index], 0, 3) . '</td></tr>';
                                                $ret .= '<tr><td>' . $local_time_text[$index] . '</td></tr>';
                                                $ret .= '</table>';
                                                $ret .= '</td>';
                                            }
                                            $ret .= '</tr>';
                                            $ret .= '</table>';
                                            
                                            echo $ret;
                                            ?>
                                            
                                            <input type="hidden" id="lastattendanceid" value="{{ $lastAttendanceId }}" />
                                        </td>




                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>

                    <div class="row">
                        <div style="display:none" id="attendancePopAlert" class="col-md-12">

                            <div class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero">
                                        Attendance Status <span class="pull-right">Current : <strong
                                                class="attendance_status_name">{{ $status_name }}</strong></span>
                                    </h3>
                                    <div class="example-box-wrapper">


                                        <button data-status="1" class="btn btn-alt btn-hover btn-success btnattendancesave">
                                            <span>Online</span>
                                            <i class="glyph-icon icon-arrow-right"></i>
                                        </button>
                                        <button data-status="2" class="btn btn-alt btn-hover btn-danger btnattendancesave">
                                            <span>offline</span>
                                            <i class="glyph-icon icon-arrow-right"></i>
                                        </button>
                                        <button data-status="3" class="btn btn-alt btn-hover btn-warning btnattendancesave">
                                            <span>leave</span>
                                            <i class="glyph-icon icon-arrow-right"></i>
                                        </button>
                                        <button data-status="4" class="btn btn-alt btn-hover btn-info btnattendancesave">
                                            <span>no answer</span>
                                            <i class="glyph-icon icon-arrow-right"></i>
                                        </button>
                                        <button data-status="5"
                                            class="btn btn-alt btn-hover btn-blue-alt btnattendancesave">
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

                                        <!--<button data-status="9" class="btn btn-alt btn-hover btn-primary btnattendancesave">-->
                                        <!--    <span>none</span>-->
                                        <!--    <i class="glyph-icon icon-arrow-right"></i>-->
                                        <!--</button>-->

                                    </div>
                                </div>
                            </div>
                            <div style="display:none" class="panel commentform">

                            </div>

                        </div>
                        <div style="display:block" id="noClassTime" class="col-md-12">

                            <div class="panel">
                                <div class="panel-body">
                                    <h3 style="text-align:center;color:red;font-size:20px !important;font-weight:bold"
                                        class="title-hero">
                                        <strong>This is Not Class Time</strong>
                                    </h3>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <h3>Lesson List <button
                                style="display:{{ $status_name == 'leave' || $status_name == 'offline' ? 'none' : 'block' }}"
                                class="btn btn-primary pull-right addLessonbtn">Add
                                Lesson</button></h3>
                        <br />
                        <div class="col-sm-12">
                            <table id="LessonDatatable"
                                data-link="{{ route('teacherpanel.student.lesson.lessondatatable') }}"
                                class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        
                                        <th>Comment</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="LessonModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="formlessonstudent" action="{{ route('teacherpanel.student.lesson.save') }}" method="POST"
                role="form">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Lesson</h4>
                    </div>

                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                     <input type="hidden" name="student_id" value="{{request()->route('id')}}" />
                                <input type="hidden" name="id" value="" />
                                <input type="hidden" name="lastattendance_id" value="{{$lastAttendanceId}}" />
                                 <input type="hidden" name="teacher_id" value="" />
                                    <label>Lesson Details <span class="text-danger">
                                            @error('memorizationdetail')
                                                {{ $message }}
                                            @enderror
                                        </span></label>

                                    <textarea name="Lesson" class="form-control @error('Lesson') is-invalid @enderror"></textarea>

                                </div>
                            </div>

                        </div>

                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnsavelesson" class="btn btn-primary btn-block">Save</button>


                    </div>

                </div>
            </form>
        </div>
    </div>



  

   



@endsection
@push('scripts')
    <!-- Data tables -->

    <!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
    <script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>
    <script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
        integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
    </script>

    <script type="text/javascript">
        localStorage.setItem("teacherclasses", JSON.stringify(JSON.parse("{{ json_encode($teacherStudentclasses) }}"
            .replace(/&quot;/g, '"'))));

        let classessarray = JSON.parse(localStorage.getItem('teacherclasses'));
        let duration = "{{ $Student ? $Student[0]->duration : 0 }}"
        let studentid = parseInt("{{ request()->route('id') }}");


        const isTimeBetween = function(startTime, endTime, serverTime) {
            let start = moment(startTime, "H:mm")
            let end = moment(endTime, "H:mm")
            let server = moment(serverTime, "H:mm")
            if (end < start) {
                return server >= start && server <= moment('23:59:59', "h:mm:ss") || server >= moment('0:00:00',
                    "h:mm:ss") && server < end;
            }
            return server >= start && server < end
        }

        console.log(classessarray, '--', duration, '---', studentid);

        setInterval(function() {
            checkattendance();
        }, 1000);
        var x = document.getElementById("myAudio");

        function playAudio() {
            x.play();
        }

        function pauseAudio() {
            x.pause();
        }

        function checkattendance() {

            for (var key in classessarray) {

                let student_day = classessarray[key].student_day;
                let teacherday = classessarray[key].day;
                if (studentid == parseInt(classessarray[key].student_id)) {
                    let attdendance_time = classessarray[key].attdendance_time;
                    let attdendance_id = classessarray[key].id;
                    let attendance_status = classessarray[key].attendance_status;

                    //  let currenttime  =  moment().format('hh:mm');

                    let currenttime = moment();
                    let starttime = moment(moment(attdendance_time, 'HH:mm:ss').format('HH:mm'), "hh:mm")
                    let endtime = moment(moment(attdendance_time, 'HH:mm:ss').add(duration, 'minutes').format('HH:mm'),
                        "hh:mm")


                    console.log(moment(attdendance_time, 'HH:mm:ss').format('hh:mm'), 'match', moment(attdendance_time,
                        'HH:mm:ss').add(20, 'minutes').format('hh:mm'), 'currenttime', moment().format('hh:mm'));





                    // if (currenttime.isBetween(starttime, endtime)) {
                    if (isTimeBetween(moment(attdendance_time, 'HH:mm:ss').format('hh:mm'), moment(attdendance_time,
                            'HH:mm:ss').add(duration, 'minutes').format('hh:mm'), moment().format('hh:mm'))) {
                        console.log('is between class panel')

                        $('#attendancePopAlert').show();
                        $('#noClassTime').hide();



                        $('.btnattendancesave').attr('data-attendanceid', attdendance_id);
                        $('#formlessonstudent input[name="attendance_id"]').val(attdendance_id);

                        // var eventTime= endtime; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
                        // var currentTime = currenttime; // Timestamp - Sun, 21 Apr 2013 12:30:00 GMT
                        // var diffTime = eventTime - currentTime;
                        // var newduration = moment.duration(diffTime*1000, 'milliseconds');
                        // newduration = moment.duration(newduration - 1000, 'milliseconds');
                        // $('.countdown').text(newduration.hours() + ":" + newduration.minutes() + ":" + newduration.seconds())

                        // console.log(currenttime)

                        // playAudio();
                        console.log('playAudio();', attendance_status)

                        if (attendance_status == 9) {

                            playAudio();

                        } else {
                            pauseAudio();
                        }

                    } else {

                        pauseAudio();

                        console.log('pauseAudio();')

                        $('.btnattendancesave').attr('data-attendanceid', '');
                        $('#formlessonstudent input[name="attendance_id"]').val('');

                        $('#attendancePopAlert').hide();
                        $('#noClassTime').show();
                        console.log('is not between')
                    }
                }


            }
        }


        var d = new Date();





        console.log(moment("{{ $currenttime }}", 'YYYY-MM-DDTHH:mm:ss').format());
        console.log(moment().tz("Asia/Karachi").format());

        /* Datatables responsive */

        $(document).ready(function() {
            var oTable = $('#LessonDatatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                ],
                ajax: {
                    url: $('#LessonDatatable').attr('data-link'),
                    data: {
                        id: '{{ request()->route('id') }}'
                    }
                },

                columns: [
                    {
                        data: 'comments',
                        name: 'student_lesson.comments'
                    },
                    {
                        data: 'created_at_new',
                        name: 'created_at_new',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            



            $(document).on('click', '.btnattendancesave', function() {

                $('.btnattendancesave').removeClass('active');
                $(this).addClass('active');


                var status = $(this).attr('data-status');
                var attendanceid = $(this).attr('data-attendanceid');

                if (status != 3) {
                    var route = '{{ route('teacherpanel.student.attendancesave') }}';

                    $.post(route, {
                        attendanceid: attendanceid,
                        status: status,
                        studentid: '{{ request()->route('id') }}',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function(data) {


                        (data.Success) ? $('.attendance_status_name').html(data.status_name): '';
                        if (status == 2 || status == 3) {
                            $('.addLessonbtn').hide();
                           
                        } else {
                            $('.addLessonbtn').show();
                        }

                        changeAttendanceStatus('{{ request()->route('id') }}', status)

                        swal({
                            title: "Attendance!",
                            text: data.msg,
                            icon: "success",
                            button: "Close",
                        });
                    })
                } else {

                    if (status == 3) {
                        $('.addLessonbtn').hide();
                       
                    }

                  
                }

            })


            function changeAttendanceStatus(student_id, attendance_status) {

                let projects = JSON.parse(localStorage.getItem('teacherStudentclassesPanel'))
                for (var i in projects) {
                    if (projects[i].student_id == student_id) {
                        projects[i].attendance_status = attendance_status;
                        break; //Stop this loop, we found it!
                    }
                };

                localStorage.removeItem("teacherStudentclassesPanel")
                console.log(projects)

                localStorage.setItem("teacherStudentclassesPanel", JSON.stringify(projects));

                location.reload();




            }




       $(document).on('click', '.addLessonbtn', function(e) {

        e.preventDefault();
         
         $('#LessonModal').modal('show');
        

    })
       $(document).on('click', '#btnsavelesson', function(e) {
        e.preventDefault();

        $('.text-danger').text('');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
        $('textarea').removeClass('is-invalid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
                type: "POST",
                url: $('#formlessonstudent').attr('action'),
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#formlessonstudent')[0])
            })
            .done(function(data) {
                // console.log(data);
                if (data.error) {
                    $.each(data.error, function(key, value) {
                        var input = `#formlessonstudent input[name="${key}"]`;
                        var inputtextarea = `#formlessonstudent textarea[name="${key}"]`;
                        var inputselect = `#formlessonstudent select[name="${key}"]`;
                        var inputselectid = `#formlessonstudent select[id="${key}"]`;
                        // console.log(input)
                        $(input).parents('.form-group').find('.text-danger').text(value);
                        $(inputtextarea).parents('.form-group').find('.text-danger').text(
                            value);
                        $(inputselect).parents('.form-group').find('.text-danger').text(
                            value);
                        $(inputselectid).parents('.form-group').find('.text-danger').text(
                            value);
                        $(input).addClass('is-invalid');
                        $(inputtextarea).addClass('is-invalid');
                        $(inputselect).addClass('is-invalid');
                        $(inputselectid).addClass('is-invalid');
                    });
                }

                if (data.Success) {
                    
                    
                   
                    swal({
                        title: "Good job!",
                        text: data.msg,
                        icon: "success",
                        button: "Close",
                    });
                    $('#formlessonstudent')[0].reset();
                    $('#LessonModalNEw').modal('hide');
                    $('#LessonDatatable').DataTable().draw(true);

                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });





        });

        $(document).ready(function() {
            $('.dataTables_filter input').attr("placeholder", "Search...");
        });
    </script>
@endpush
