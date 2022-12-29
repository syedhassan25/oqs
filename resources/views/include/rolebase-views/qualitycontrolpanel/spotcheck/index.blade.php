@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="container">




        <div id="page-title">
            <h2>{{ $pageTitle }} <button class="btn btn-primary btnspotcheckadd"> Create Spotcheck</button></h2>
            <p>{{ $subTitle }}</p>
            <!-- styles -->
            @include('admin.partials.themeswitcher')
            <!-- /.styles -->
        </div>

        <div class="panel">
            <div class="panel-body">

                <div class="example-box-wrapper">
                    @include('admin.partials.flash')
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="spotcheckdatatable"
                                            data-link="{{ route('qualitycontrolpanel.spotcheck.get_spotcheck_forms') }}"
                                            style="width:100% important" class="table table-bordered table-hover">

                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Teacher</th>

                                                    <th>Student</th>
                                                    <th>Group</th>
                                                    <th>Class Start on Time</th>
                                                    <th>Introduction</th>
                                                    <th>Revision of Previous Class</th>
                                                    <th>New Lesson</th>
                                                    <th>Ethics</th>
                                                    <th>Memorization</th>
                                                    <th>Tajweed</th>
                                                    <th>Islamic Fundamental</th>
                                                    <th>English Fluency</th>
                                                    <th>Appreciation to Student</th>
                                                    <th>Identify the Mistakes</th>
                                                    <th>Tone</th>
                                                    <th>Teacher Responsive to Student</th>
                                                    <th>Form Rating</th>
                                                    <th>Edit</th>

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


        <div class="modal fade" id="SpotcheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="addStudentModalLongTitle">Add Spot Check</h5>

                    </div>
                    <form id="formspotcheck" action="{{ route('qualitycontrolpanel.spotcheck.store') }}" method="POST"
                        role="form">
                        <div class="modal-body">
                            @csrf

                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="hidden" name="spotid" value="" />
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>

                                        <select name="teacher" id="SelectTeacher" class="form-control teacher is-invalid">
                                            <option value="">Select Teacher</option>
                                            @foreach ($Employee as $val)
                                                <option value="{{ $val->id }}">{{ $val->employeename }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Student <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="student" id="teacherstudent" class="form-control student is-invalid">
                                            <option value="">Select Student</option>

                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Group <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <input type="text" class="form-control studentgroup" name="groupsss" disabled />
                                        <input type="hidden" class="form-control studentgroup" name="group" />

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Class Start on Time <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>

                                        <select name="classStartOnTime" class="form-control classStartOnTime is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Introduction <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="introduction" class="form-control introduction is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Revision of Previous Class <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="RevisionOfPreviousClass"
                                            class="form-control RevisionOfPreviousClass is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>New Lesson <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="newLesson" class="form-control newLesson is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Class Start on Time Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control classStartOnTimeText" name="classStartOnTimeText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Introduction Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control introductionText" name="introductionText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Revision of Previous Class Comments <span
                                                class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control RevisionOfPreviousClassText" name="RevisionOfPreviousClassText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>New Leson Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control newLesonText" name="newLesonText"></textarea>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Ethics <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="ethics" class="form-control ethics is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Memorization <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="memorization" class="form-control memorization is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Tajweed <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="tajweed" class="form-control tajweed is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Islamic Fundamental <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="islamicFundamental"
                                            class="form-control islamicFundamental is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Ethics Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control ethicsText" name="ethicsText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Memorization Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control memorizationText" name="memorizationText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Tajweed Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control tajweedText" name="tajweedText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Islamic Fundamental Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control islamicFundamentalText" name="islamicFundamentalText"></textarea>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>English Fluency <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="englishFluency" class="form-control englishFluency is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Appreciation to Student <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="appreciationStudent"
                                            class="form-control appreciationStudent is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Identify Mistakes <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="identifyMistakes" class="form-control identifyMistakes is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Tone <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="tone" class="form-control tone is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>English Fluency Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control englishFluencyText" name="englishFluencyText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Appreciation to Student Comments <span
                                                class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control appreciationStudentText" name="appreciationStudentText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Identify Mistakes Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control identifyMistakesText" name="identifyMistakesText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Tone Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control toneText" name="toneText"></textarea>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Teacher Responsive to Student <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="teacherResponsiveStudent"
                                            class="form-control teacherResponsiveStudent is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Closing Class <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="closingClass" class="form-control closingClass is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Form Rating <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <select name="performance_level" class="form-control performance_level is-invalid">
                                            <option value="">Select Value</option>
                                            <option value="1">Excellent</option>
                                            <option value="2">Good</option>
                                            <option value="3">Fair</option>
                                            <option value="4">Poor</option>
                                            <option value="5">N/A</option>
                                        </select>

                                    </div>
                                </div>


                            </div>
                            <div class="row">

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Teacher Responsive to Student Comments <span
                                                class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control teacherResponsiveStudentText" name="teacherResponsiveStudentText"></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Closing Class Comments <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea class="form-control closingClassText" name="closingClassText"></textarea>

                                    </div>
                                </div>

                            </div>







                        </div>
                        <div class="modal-footer">

                            <button type="button" id="saveSpotcheck" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <!-- Data tables -->
    <script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>
    <!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
    <script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>
    <script>
        $(document).ready(function() {
            var oTable = $('#spotcheckdatatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                ],
                ajax: {
                    url: $('#spotcheckdatatable').attr('data-link')
                },

                columns: [{
                        data: 'created_at',
                        name: 'spotcheck.created_at',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employeename',
                        name: 'employees.employeename',
                        searchable: true
                    },

                    {
                        data: 'studentname',
                        name: 'student.studentname',
                        searchable: true
                    },

                    {
                        data: 'groupno',
                        name: 'spotcheck.groupno',
                        searchable: true
                    },
                    {
                        data: 'classStartOnTimecol',
                        name: 'classStartOnTimecol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'introductioncol',
                        name: 'introductioncol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'RevisionOfPreviousClasscol',
                        name: 'RevisionOfPreviousClasscol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'newLessoncol',
                        name: 'newLessoncol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ethicscol',
                        name: 'ethicscol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'memorizationcol',
                        name: 'memorizationcol',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'tajweedcol',
                        name: 'tajweedcol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'islamicFundamentalcol',
                        name: 'islamicFundamentalcol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'englishFluencycol',
                        name: 'englishFluencycol',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'appreciationStudentcol',
                        name: 'appreciationStudentcol',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'identifyMistakescol',
                        name: 'identifyMistakescol',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'tonecol',
                        name: 'tonecol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'teacherResponsiveStudentcol',
                        name: 'teacherResponsiveStudentcol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'formRatingcol',
                        name: 'formRatingcol',
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


            $(document).on('click', '.btnspotcheckadd', function() {
                $(` #formspotcheck input`).val("");
                $(` #formspotcheck select`).val("");
                $(` #formspotcheck textarea`).val("");
                $(` #formspotcheck hidden`).val("");
                $('#SpotcheckModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

            })
            $(document).on('click', '.btnspotcheckedit', function() {
                var spotid = $(this).attr('data-id');
                var url = '{{ route("qualitycontrolpanel.spotcheck.detail", ":id") }}';
                url = url.replace(':id', spotid);
                $.get(url, {
                    id: spotid,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(res) {
                    console.log(res);
                    var teacherid = res.teacher_id;
                    $(` #formspotcheck [name="spotid"]`).val(res.id);
                    $(` #formspotcheck [id="SelectTeacher"]`).val(res.teacher_id);
                    
                    $(` #formspotcheck [name="group"]`).val(res.groupno);
                    $(` #formspotcheck [name="groupsss"]`).val(res.groupno);
                    
                    
                    $.each( res, function( key, value ) {
                         $(` #formspotcheck [name="${key}"]`).val(value);
                        });


                        LoadTeacher(teacherid,function(){
                            $(` #formspotcheck [id="teacherstudent"]`).val(res.student_id);
                            $('#SpotcheckModal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        });    

                    

                })


               

            })
            
            $(document).on('click', '#saveSpotcheck', function(e) {
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
                        url: $('#formspotcheck').attr('action'),
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: new FormData($('#formspotcheck')[0])
                    })
                    .done(function(data) {
                        // console.log(data);
                        if (data.error) {
                            $.each(data.error, function(key, value) {
                                var input = `#formspotcheck input[name="${key}"]`;
                                var inputtextarea = `#formspotcheck textarea[name="${key}"]`;
                                var inputselect = `#formspotcheck select[name="${key}"]`;
                                var inputselectid = `#formspotcheck select[id="${key}"]`;
                                // console.log(input)
                                $(input).parents('.form-group').find('.text-danger').text(
                                value);
                                $(inputtextarea).parents('.form-group').find('.text-danger')
                                    .text(
                                        value);
                                $(inputselect).parents('.form-group').find('.text-danger').text(
                                    value);
                                $(inputselectid).parents('.form-group').find('.text-danger')
                                    .text(
                                        value);
                                $(input).addClass('is-invalid');
                                $(inputtextarea).addClass('is-invalid');
                                $(inputselect).addClass('is-invalid');
                                $(inputselectid).addClass('is-invalid');
                            });
                        } else {
                            swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                                button: "Close",
                            });
                            $('#formspotcheck')[0].reset();
                            $('#SpotcheckModal').modal('hide');
                            $('#spotcheckdatatable').DataTable().draw(true);
                        }

                        // if (data.success) {


                        // }
                    })
                    .fail(function(data) {
                        console.log(data);

                    });
            });


            function LoadTeacher(teacherid,callback){
                $.get('{{ route('qualitycontrolpanel.spotcheck.getStudentByteacher') }}', {
                    id: teacherid,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(res) {
                    console.log(res);
                    $('#teacherstudent').html('');
                    var html = '<option value="">Select Student</option>';
                    $.each(res, function(i, e) {
                        html +=
                            `<option data-group="${e.group}" value="${e.id}">${e.studentname}</option>`
                    });

                    $('#teacherstudent').html(html);
                    callback();

                })
            }
            $(document).on('change', '#SelectTeacher', function() {
                let teacherid = $(this).val();
                LoadTeacher(teacherid,function(){

                });
            });

            $(document).on('change', '#teacherstudent', function() {
                let group = $(this).find('option:selected').attr('data-group');
                $('.studentgroup').val(group);
            });





        });

        $(document).ready(function() {
            $('.dataTables_filter input').attr("placeholder", "Search...");
        });
    </script>
@endpush
