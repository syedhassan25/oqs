@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('assets/fullcalender/main.css') }}" />


    <style>
        button.btn.btn-primary.btnfeedbackmodal.pull-right {
            margin-left: 15px;
        }

        l .fa {
            font-size: 16px;
        }

        .checked {
            color: orange;
        }

        .btnrating {
            padding: 5px
        }

        @media (min-width: 768px) {

            .seven-cols .col-md-1,
            .seven-cols .col-sm-1,
            .seven-cols .col-lg-1 {
                width: 100%;
                *width: 100%;
            }
        }

        @media (min-width: 992px) {

            .seven-cols .col-md-1,
            .seven-cols .col-sm-1,
            .seven-cols .col-lg-1 {
                width: 14.285714285714285714285714285714%;
                *width: 14.285714285714285714285714285714%;
            }
        }

        /**
                             *  The following is not really needed in this case
                             *  Only to demonstrate the usage of @media for large screens
                             */
        @media (min-width: 1200px) {

            .seven-cols .col-md-1,
            .seven-cols .col-sm-1,
            .seven-cols .col-lg-1 {
                width: 14.285714285714285714285714285714%;
                *width: 14.285714285714285714285714285714%;
            }
        }

        button.btn.btn-info.btn-block.btnsearchteachertime {
            margin-top: 22px;
        }

        button.btn.btn-primary.pull-right {
            margin-right: 10px !important;
        }

        .attendanceboxes {
            float: left;
            color: #fff;
            padding: 11px;
            border: 1px solid #ccc;
            margin-left: 4px;
            background: azure;
            font-size: 12px;
            margin-bottom: 6px;
            font-weight: 900;
            cursor: pointer;
        }

        .daystablerow td {
            padding: 5px;
        }

        #teacherchangeModal h1.teacherExistenceClass {
            border: 1px solid;
            font-size: larger;
            padding: 10px;
            color: red;
        }
    </style>
    <div class="container">




        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $pageTitle }} </h1>
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


        <div class="panel">
            <div class="panel-body">

                <div class="example-box-wrapper">



                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="formstudent" action="{{ route('admin.student.update') }}" method="POST"
                                        role="form">
                                        @csrf
                                        <div class="panel">
                                            <div class="panel-body">

                                                <div class="example-box-wrapper">
                                                    <div class="row">
                                                        <div class="col-5 col-sm-3">
                                                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab"
                                                                role="tablist" aria-orientation="vertical">
                                                                <a href="#tab-example-1" data-toggle="tab"
                                                                    class="nav-link active">
                                                                    <i class="glyph-icon font-red icon-bullhorn"></i>
                                                                    Personal Profile
                                                                </a>
                                                                <a href="#tab-example-2" data-toggle="tab"
                                                                    class="nav-link ">
                                                                    <i class="glyph-icon icon-dashboard"></i>
                                                                    Schdule/Assign
                                                                </a>
                                                                
                                                                <a href="#tab-example-6" data-toggle="tab"
                                                                    class="nav-link ">
                                                                    <i class="glyph-icon font-blue-alt icon-globe"></i>
                                                                    Attendance
                                                                </a>



                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-7 col-sm-9">
                                                            <div class="tab-content">
                                                                <div class="tab-pane text-left fade show active" id="tab-example-1">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Group No<span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>
                                                                                <input type="text"
                                                                                    value="{{ old('groupno', $targetStudent->group) }}"
                                                                                    name="groupno" placeholder="Group No"
                                                                                    id="groupno"
                                                                                    class="form-control name @error('groupno') is-invalid @enderror" />


                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Name<span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>
                                                                                <input type="text"
                                                                                    value="{{ old('name', $targetStudent->studentname) }}"
                                                                                    name="name" placeholder="Name"
                                                                                    class="form-control name @error('name') is-invalid @enderror" />

                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $targetStudent->id }}" />

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Guardian Name <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>
                                                                                <input type="text"
                                                                                    value="{{ old('fathername', $targetStudent->fathername) }}"
                                                                                    name="fathername"
                                                                                    placeholder="Guardian Name"
                                                                                    class="form-control fathername @error('fathername') is-invalid @enderror" />

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Joining Age <span
                                                                                        class="text-danger">
                                                                                        @error('age')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <input type="text"
                                                                                    value="{{ old('age', $targetStudent->age) }}"
                                                                                    name="age"
                                                                                    placeholder="Joining Age"
                                                                                    class="form-control @error('age') is-invalid @enderror" />

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Date Of Birth<span
                                                                                        class="text-danger">
                                                                                        @error('dob')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <input type="text"
                                                                                    value="{{ old('dob', $targetStudent->dob) }}"
                                                                                    name="dob"
                                                                                    placeholder="Date oF Birth"
                                                                                    class="form-control dateoftbirthclass @error('dob') is-invalid @enderror" />

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Calculated Age <span
                                                                                        class="text-danger"></span></label>
                                                                                <input type="text"
                                                                                    value="{{ $targetStudent->calculated_age }}"
                                                                                    placeholder="Age" readonly
                                                                                    class="form-control calculated_ageclass" />

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Gender <span class="text-danger">
                                                                                        @error('gender')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <div class="clearfix">
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="radio"
                                                                                            id="radioPrimary1"
                                                                                            name="gender" value="1"
                                                                                            {{ $targetStudent->gender == '' ? 'checked' : '' }}
                                                                                            {{ $targetStudent->gender == 1 ? 'checked' : '' }}>
                                                                                        <label for="radioPrimary1">
                                                                                            Male
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="radio"
                                                                                            value="2"
                                                                                            {{ $targetStudent->gender == 2 ? 'checked' : '' }}
                                                                                            id="radioPrimary2"
                                                                                            name="gender">
                                                                                        <label for="radioPrimary2">
                                                                                            Female
                                                                                        </label>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Contact No <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>
                                                                                <input placeholder="Contact No"
                                                                                    class="form-control contact_no @error('contact_no') is-invalid @enderror "
                                                                                    name="contact_no" type="text"
                                                                                    value="{{ old('contact_no', $targetStudent->contact_no) }}">
                                                                                <span class="text-danger">
                                                                                    @error('contact_no')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Email <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>
                                                                                <input placeholder="Email"
                                                                                    class="form-control email @error('email') is-invalid @enderror "
                                                                                    name="email" type="text"
                                                                                    value="{{ old('email', $targetStudent->studentemail) }}">
                                                                                <span class="text-danger">
                                                                                    @error('email')
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
                                                                                <label>whatsApp <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <input placeholder="whatsApp"
                                                                                    value="{{ $targetStudent->whatsapp }}"
                                                                                    class="form-control  @error('whatsapp') is-invalid @enderror "
                                                                                    name="whatsApp" type="text">



                                                                                <span class="text-danger">
                                                                                    @error('whatsapp')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Email 2 <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>
                                                                                <input placeholder="Email 2"
                                                                                    class="form-control studentemail2 @error('studentemail2') is-invalid @enderror "
                                                                                    name="studentemail2" type="text"
                                                                                    value="{{ old('email', $targetStudent->studentemail2) }}">
                                                                                <span class="text-danger">
                                                                                    @error('studentemail2')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>


                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Billing Email <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>
                                                                                <input placeholder="Billing Email"
                                                                                    class="form-control billingemail @error('billingemail') is-invalid @enderror "
                                                                                    name="billingemail" type="text"
                                                                                    value="{{ old('email', $targetStudent->billingemail) }}">
                                                                                <span class="text-danger">
                                                                                    @error('billingemail')
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
                                                                                <label>Country <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <select
                                                                                    class=" select2 country @error('country') is-invalid @enderror "
                                                                                    name="country" id="countrydrp"
                                                                                    style="width: 100%;">
                                                                                    <option selected="selected"
                                                                                        value="">
                                                                                        Select
                                                                                        Country
                                                                                    </option>
                                                                                    @foreach ($Country as $s)
                                                                                        <option
                                                                                            {{ $targetStudent->country == $s->id ? 'selected' : '' }}
                                                                                            data-curr="{{ $s->currency }}"
                                                                                            data-zone="{{ $s->zone }}"
                                                                                            value="{{ $s->id }}">
                                                                                            {{ $s->CountryName }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>



                                                                                <span class="text-danger">
                                                                                    @error('country')
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
                                                                                <label>Timezones <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <select
                                                                                    class=" select2 country @error('timezone') is-invalid @enderror "
                                                                                    name="timezone" id="timezonedrp"
                                                                                    style="width: 100%;">
                                                                                    <option value="">Select
                                                                                        Time Zone
                                                                                    </option>
                                                                                    @foreach ($timezones as $s)
                                                                                        <option
                                                                                            {{ $targetStudent->timezone == $s['timezone'] ? 'selected' : '' }}
                                                                                            data-timezone="{{ $s['timezone'] }}"
                                                                                            value="{{ $s['timezone'] }}">
                                                                                            {{ $s['name'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>

                                                                                <input id="timezoneName" readonly
                                                                                    class="form-control timezoneName @error('timezoneName') is-invalid @enderror"
                                                                                    name="timezoneName"
                                                                                    value="{{ $targetStudent->timezone ? $targetStudent->timezone : 'Asia/Tashkent' }}"
                                                                                    type="hidden">

                                                                                <span class="text-danger">
                                                                                    @error('timezone')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Academic Status <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>

                                                                                <input type="hidden"
                                                                                    name="oldacademicStatus"
                                                                                    class="oldacademicStatus"
                                                                                    value="{{ $targetStudent->academicStatus }}">
                                                                                <select id="academicStatusChange"
                                                                                    name="academicStatus"
                                                                                    class="form-control @error('academicStatus') is-invalid @enderror">
                                                                                    <option
                                                                                        {{ $targetStudent->academicStatus == '' ? 'selected' : '' }}
                                                                                        value="">Class Type</option>
                                                                                    <option
                                                                                        @foreach ($academicStatusArr as $s) <option
                                                                            {{ $targetStudent->academicStatus == $s->academic_status_val ? 'selected' : '' }}
                                                                           
                                                                            value="{{ $s->academic_status_val }}">{{ $s->academic_status }}
                                                                        </option> @endforeach
                                                                                        </select>



                                                                                        <span class="text-danger">
                                                                                            @error('academicStatus')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Currency Symbol <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <input placeholder="Currency Symbol"
                                                                                    id="currencysymbol" readonly
                                                                                    value="{{ $Currency }}"
                                                                                    class="form-control currencysymbol @error('currencysymbol') is-invalid @enderror"
                                                                                    name="currencysymbol" type="text">



                                                                                <span class="text-danger">
                                                                                    @error('currencysymbol')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <!-- academicStatusModal Start -->
                                                                        <div id="academicStatusModal" class="modal fade"
                                                                            role="dialog" data-backdrop="static"
                                                                            data-keyboard="false">
                                                                            <div class="modal-dialog">

                                                                                <!-- Modal content-->
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button"
                                                                                            class="close btncloseacademicStatus">&times;</button>
                                                                                        <h4 class="modal-title">Academic
                                                                                            Status
                                                                                            Change Reason</h4>
                                                                                    </div>

                                                                                    <div class="modal-body">

                                                                                        <div class="row">
                                                                                            <div class="col-sm-12">
                                                                                                <!-- text input -->
                                                                                                <div class="form-group">
                                                                                                    <label>Reason <span
                                                                                                            class="text-danger">
                                                                                                            @error('subject')
                                                                                                                {{ $message }}
                                                                                                            @enderror
                                                                                                        </span></label>


                                                                                                    <select name="reason"
                                                                                                        id="reasonselect"
                                                                                                        class="form-control @error('reason') is-invalid @enderror">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            Select Reason
                                                                                                        </option>
                                                                                                        @foreach ($reason as $data)
                                                                                                            <option
                                                                                                                data-status="{{ $data->statusType }}"
                                                                                                                data-type="{{ $data->type }}"
                                                                                                                value="{{ $data->id }}">
                                                                                                                {{ $data->reason }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>

                                                                                                </div>
                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div class="col-sm-12">
                                                                                                <!-- text input -->
                                                                                                <div class="form-group">
                                                                                                    <label>Details <span
                                                                                                            class="text-danger">
                                                                                                            @error('reasondetail')
                                                                                                                {{ $message }}
                                                                                                            @enderror
                                                                                                        </span></label>

                                                                                                    <blade
                                                                                                        ___html_tags_0___ />

                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div style="display:none"
                                                                                            class="row">
                                                                                            <div class="col-sm-12">
                                                                                                <label>Reactivate Date <span
                                                                                                        class="text-danger">
                                                                                                        @error('reactivatedate')
                                                                                                            {{ $message }}
                                                                                                        @enderror
                                                                                                    </span></label>
                                                                                                <!-- text input -->
                                                                                                <div class="form-group">
                                                                                                    <input
                                                                                                        id="reactivatedate"
                                                                                                        placeholder="Reactivate date"
                                                                                                        class="form-control bootstrap-today-datepicker reactivatedate @error('reactivatedate') is-invalid @enderror "
                                                                                                        name="reactivatedate"
                                                                                                        type="text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div style="display:none"
                                                                                            class="row">
                                                                                            <div class="col-sm-12">
                                                                                                <label>Student Resume Date
                                                                                                    <span
                                                                                                        class="text-danger">
                                                                                                        @error('taskresumedate')
                                                                                                            {{ $message }}
                                                                                                        @enderror
                                                                                                    </span></label>
                                                                                                <!-- text input -->
                                                                                                <div class="form-group">
                                                                                                    <input
                                                                                                        id="taskresumedate"
                                                                                                        placeholder="Student Resume Date"
                                                                                                        class="form-control bootstrap-today-datepicker taskresumedate @error('taskresumedate') is-invalid @enderror "
                                                                                                        name="taskresumedate"
                                                                                                        type="text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-danger btn-block btncloseacademicStatus">Cancel</button>
                                                                                        <button type="button"
                                                                                            id="btnsavereason"
                                                                                            class="btn btn-primary btn-block">Save</button>


                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <!-- academicStatusModal End -->

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>City <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <select
                                                                                    class=" select2 city @error('city') is-invalid @enderror "
                                                                                    name="city" id="citydrop"
                                                                                    style="width: 100%;">
                                                                                    <option value="">Select City
                                                                                    </option>
                                                                                    @foreach ($City as $s)
                                                                                        <option
                                                                                            {{ $targetStudent->city == $s->id ? 'selected' : '' }}
                                                                                            value="{{ $s->id }}">
                                                                                            {{ $s->CityName }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>



                                                                                <span class="text-danger">
                                                                                    @error('country')
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
                                                                                <label>Language (Multiple)</label>
                                                                                <div class="select2-purple">
                                                                                    <select name="language[]"
                                                                                        id="language" class="select2"
                                                                                        multiple="multiple"
                                                                                        data-placeholder="Select a language"
                                                                                        data-dropdown-css-class="select2-purple"
                                                                                        style="width: 100%;">
                                                                                        @foreach ($Language as $s)
                                                                                            <option
                                                                                                @foreach ($StudentLanguage as $p) @if ($s->id == $p->language_id)
                                                                                selected="selected" @endif @endforeach
                                                                                                value="{{ $s->id }}">
                                                                                                {{ $s->languagename }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>
                                                                                    <span class="text-danger">
                                                                                        @error('language')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>



                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Login Email <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <input placeholder="Login Email" readonly
                                                                                    value="{{ $User->email }}"
                                                                                    class="form-control email @error('loginemail') is-invalid @enderror "
                                                                                    name="loginemail" type="text">
                                                                                <span class="text-danger">
                                                                                    @error('loginemail')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Password <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <input placeholder="password"
                                                                                    class="form-control  @error('password') is-invalid @enderror "
                                                                                    id="password" name="password"
                                                                                    type="text">


                                                                                <span class="text-danger">
                                                                                    @error('password')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Confirm Password<span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <input placeholder="Confirm Password"
                                                                                    class="form-control  @error('confirm-password') is-invalid @enderror "
                                                                                    name="confirm-password"
                                                                                    type="text">


                                                                                <span class="text-danger">
                                                                                    @error('confirm-password')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Skype 1 <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <input placeholder="Skype 1 "
                                                                                    name="skype1"
                                                                                    value="{{ $targetStudent->skypid_1 }}"
                                                                                    class="form-control  @error('skype1') is-invalid @enderror "
                                                                                    type="text">


                                                                                <span class="text-danger">
                                                                                    @error('skype1')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Skype 2 <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <input placeholder="skype2"
                                                                                    value="{{ $targetStudent->skypid_2 }}"
                                                                                    class="form-control  @error('skype2') is-invalid @enderror "
                                                                                    name="skype2" type="text">


                                                                                <span class="text-danger">
                                                                                    @error('skype2')
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
                                                                                <label>Resource </label>


                                                                                <select id="resource"
                                                                                    class=" select2 @error('resource') is-invalid @enderror "
                                                                                    name="resource" style="width: 100%;">
                                                                                    <option
                                                                                        {{ $targetStudent->joining_source == '' ? 'selected' : '' }}
                                                                                        value="">Select
                                                                                        Resource</option>
                                                                                    <option
                                                                                        {{ $targetStudent->joining_source == '1' ? 'selected' : '' }}
                                                                                        value="1">
                                                                                        Marketing/Advertisement
                                                                                    </option>
                                                                                    <option
                                                                                        {{ $targetStudent->joining_source == '2' ? 'selected' : '' }}
                                                                                        value="2">Reference</option>

                                                                                </select>



                                                                                <span class="text-danger">
                                                                                    @error('resource')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row"
                                                                        style="display:{{ $targetStudent->joining_source == 1 ? 'block' : 'none' }}">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Marketing Agencies </label>


                                                                                <select
                                                                                    class="marketingagencies select2 @error('marketingagencies') is-invalid @enderror "
                                                                                    name="marketingagencies"
                                                                                    style="width: 100%;">
                                                                                    <option value="">Select
                                                                                        Marketing Agencies</option>
                                                                                    @foreach ($Agencies as $a)
                                                                                        <option
                                                                                            {{ $targetStudent->agency_id == $a->id ? 'selected' : '' }}
                                                                                            value="{{ $a->id }}">
                                                                                            {{ $a->agencyname }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>



                                                                                <span class="text-danger">
                                                                                    @error('marketingagencies')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row"
                                                                        style="display:{{ $targetStudent->joining_source == 2 ? 'block' : 'none' }}">
                                                                        <div class="col-sm-4">

                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Reference Name <span
                                                                                        style='color:{{ $referalExist == 'Added' ? 'green' : 'red' }};font-size:14px'>{{ $referalExist }}</span></label>
                                                                                <input placeholder="Reference Name"
                                                                                    value="{{ $targetStudent->ref_name }}"
                                                                                    class="form-control referencename @error('referencename') is-invalid @enderror "
                                                                                    name="referencename" type="text">
                                                                                <span class="text-danger">
                                                                                    @error('referencename')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-sm-4">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Reference Email </label>
                                                                                <input placeholder="Reference Email"
                                                                                    value="{{ $targetStudent->ref_email }}"
                                                                                    class="form-control referenceemail @error('referenceemail') is-invalid @enderror "
                                                                                    name="referenceemail" type="text">
                                                                                <span class="text-danger">
                                                                                    @error('referenceemail')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Reference Group <label
                                                                                        style="margin-left:10px"> <input
                                                                                            type="checkbox"
                                                                                            value="Need to Update Referral"
                                                                                            id="referralcreatecheckbox"
                                                                                            name="referralcreatecheckbox"><input
                                                                                            type="hidden" value="0"
                                                                                            id="referralGenerateOrNot"
                                                                                            name="referralGenerateOrNot">&nbsp;Need
                                                                                        to Update Referral</label></label>
                                                                                <input placeholder="Reference Group"
                                                                                    value="{{ $targetStudent->ref_group }}"
                                                                                    class="form-control referencegroup @error('referencegroup') is-invalid @enderror "
                                                                                    name="referencegroup" type="text">
                                                                                <span class="text-danger">
                                                                                    @error('referencegroup')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div style="display:block" class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label>Joining Date </label>
                                                                                <input disabled placeholder="Joining Date"
                                                                                    data-date-format="mm/dd/yy"
                                                                                    class="form-control bootstrap-datepicker joiningdate @error('joiningdate') is-invalid @enderror "
                                                                                    name="joiningdate" type="text"
                                                                                    value="{{ $targetStudent->joining_date }}">
                                                                                <span class="text-danger">
                                                                                    @error('joiningdate')
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
                                                                                <label>Tafseer </label>
                                                                                <div class="select2-purple">
                                                                                    <select name="isTafseer"
                                                                                        id="isTafseer"
                                                                                        class="status @error('isTafseer') is-invalid @enderror  form-control"
                                                                                        style="width: 100%;">
                                                                                        <option
                                                                                            {{ $targetStudent->isTafseer == 0 ? 'selected' : '' }}
                                                                                            value="0">No</option>
                                                                                        <option
                                                                                            {{ $targetStudent->isTafseer == 1 ? 'selected' : '' }}
                                                                                            value="1">Yes</option>


                                                                                    </select>
                                                                                </div>
                                                                                <span class="text-danger">
                                                                                    @error('status')
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
                                                                                <label>Detail <span
                                                                                        class="m-l-5 text-danger  errorlabelmy">
                                                                                        *</span></label>


                                                                                <textarea name="detail" class="form-control @error('detail') is-invalid @enderror">{{ old('detail', $targetStudent->detail) }}</textarea>



                                                                                <span class="text-danger">
                                                                                    @error('detail')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane text-left fade" id="tab-example-2">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Days <label
                                                                                        style="margin-left:10px"> <input
                                                                                            type="checkbox"
                                                                                            value="No need to create task for billing"
                                                                                            id="taskcreatecheckbox"
                                                                                            name="taskcreatecheckbox"><input
                                                                                            type="hidden" value="0"
                                                                                            id="taskGenerateOrNot"
                                                                                            name="taskGenerateOrNot">&nbsp;No
                                                                                        need
                                                                                        to create task for billing</label>
                                                                                    <span class="text-danger">
                                                                                        @error('days')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <div class="select2-purple">
                                                                                    <select name="days[]" id="daysDrp"
                                                                                        class="select2"
                                                                                        multiple="multiple"
                                                                                        data-placeholder="Select a days"
                                                                                        data-dropdown-css-class="select2-purple"
                                                                                        style="width: 100%;">

                                                                                        <option value="1">Monday
                                                                                        </option>
                                                                                        <option value="2">Tuesday
                                                                                        </option>
                                                                                        <option value="3">Wednesday
                                                                                        </option>
                                                                                        <option value="4">Thursday
                                                                                        </option>
                                                                                        <option value="5">Friday
                                                                                        </option>
                                                                                        <option value="6">Saturday
                                                                                        </option>
                                                                                        <option value="7">Sunday
                                                                                        </option>

                                                                                    </select>

                                                                                </div>





                                                                            </div>
                                                                        </div>



                                                                    </div>
                                                                    <div class="row studenttimepickerdivparent"
                                                                        style="display:none">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Student Time <span
                                                                                        class="text-danger">
                                                                                        @error('studenttime')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <div
                                                                                    class="row seven-cols studenttimepickerdiv">


                                                                                </div>





                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                    <div class="row localtimepickerdivparent"
                                                                        style="display:none">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Local Time <span
                                                                                        class="text-danger">
                                                                                        @error('localtime')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <div
                                                                                    class="row seven-cols localtimepickerdiv">


                                                                                </div>





                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Class Type <span
                                                                                        class="text-danger">
                                                                                        @error('classtype')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <select name="classtype"
                                                                                    class="form-control @error('classtype') is-invalid @enderror">
                                                                                    <option
                                                                                        {{ $targetStudent->class_type == '' ? 'selected' : '' }}
                                                                                        value="">Class Type</option>
                                                                                    <option
                                                                                        {{ $targetStudent->class_type == '1' ? 'selected' : '' }}
                                                                                        value="1">Trial</option>
                                                                                    <option
                                                                                        {{ $targetStudent->class_type == '2' ? 'selected' : '' }}
                                                                                        value="2">Regular</option>
                                                                                </select>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Duration <span class="text-danger">
                                                                                        @error('duration')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>


                                                                                <select name="duration"
                                                                                    class="form-control @error('duration') is-invalid @enderror">
                                                                                    <option
                                                                                        {{ $targetStudent->duration == '' ? 'selected' : '' }}
                                                                                        value="">Select Duration
                                                                                    </option>
                                                                                    <option
                                                                                        @foreach ($durationArr as $s) <option
                                                                            {{ $targetStudent->duration == $s->durationVal ? 'selected' : '' }}
                                                                           
                                                                            value="{{ $s->durationVal }}">{{ $s->durationVal }}
                                                                        </option> @endforeach
                                                                                        </select>








                                                                            </div>
                                                                        </div>



                                                                    </div>






                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Assigned Teacher <span
                                                                                        class="text-danger">
                                                                                        @error('teachername')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>



                                                                                <input type="hidden"
                                                                                    id="selectoldteacher"
                                                                                    name="oldteacher"
                                                                                    value="{{ $targetStudent->teacher_id }}" />
                                                                                <input type="hidden"
                                                                                    id="selectoldteachername"
                                                                                    name="oldteachername"
                                                                                    value="{{ $teachername }}" />
                                                                                <input type="hidden"
                                                                                    id="studentteacherid" name="teacherid"
                                                                                    class="form-control"
                                                                                    value="{{ $targetStudent->teacher_id }}" />

                                                                                <input type="text" id="teachername"
                                                                                    readonly name="teachername"
                                                                                    class="form-control"
                                                                                    value="{{ $teachername }}" />

                                                                            </div>






                                                                        </div>




                                                                    </div>



                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Teacher Assign/Schedule <span
                                                                                        class="text-danger ">
                                                                                        @error('teacherassign')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <select id="teacherassign"
                                                                                    name="teacherassign"
                                                                                    class="form-control teacherassign @error('teacherassign') is-invalid @enderror">

                                                                                    <option
                                                                                        {{ $targetStudent->teacher_assign_status == '1' ? 'selected' : '' }}
                                                                                        value="1">Teacher Assign
                                                                                    </option>
                                                                                    <option
                                                                                        {{ $targetStudent->teacher_assign_status == '2' ? 'selected' : '' }}
                                                                                        value="2">Teacher Assign
                                                                                        Schdule
                                                                                    </option>


                                                                                </select>

                                                                            </div>
                                                                        </div>




                                                                    </div>


                                                                    <div class="row"
                                                                        style="display:{{ $targetStudent->teacher_assign_status == 2 ? 'block' : 'none' }}">
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Teacher Schdule date <span
                                                                                        class="text-danger">
                                                                                        @error('teacherscduledate')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>

                                                                                <input type="text"
                                                                                    id="teacherscduledate"
                                                                                    name="teacherscduledate"
                                                                                    class="form-control bootstrap-datepicker"
                                                                                    value="" />

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Teacher Schdule Time <span
                                                                                        class="text-danger">
                                                                                        @error('teacherscduletime')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>

                                                                                <input type="text"
                                                                                    id="teacherscduletime"
                                                                                    name="teacherscduletime"
                                                                                    class="form-control timepicker-example"
                                                                                    value="" />

                                                                            </div>
                                                                        </div>




                                                                    </div>


                                                                    <div class="Isteacherassigned"
                                                                        style="display:{{ $targetStudent->teacher_assign_status == 1 || $targetStudent->teacher_assign_status == '' ? 'block' : 'none' }}">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">

                                                                                    <label>Teacher Assigned Type </label>

                                                                                    <select name="teacherassigntype"
                                                                                        id="teacherassigntype"
                                                                                        class="form-control @error('teacherassigntype') is-invalid @enderror">

                                                                                        <option value="1">Regular
                                                                                        </option>
                                                                                        <option value="2">Temporary
                                                                                        </option>
                                                                                    </select>

                                                                                </div>






                                                                            </div>




                                                                        </div>
                                                                        <div class="row" style="display:none">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">

                                                                                    <label>Teacher Temporary Assigned Type
                                                                                    </label>

                                                                                    <select
                                                                                        name="teachertemporaryassigntype"
                                                                                        id="teachertemporaryassigntype"
                                                                                        class="form-control @error('teachertemporaryassigntype') is-invalid @enderror">

                                                                                        <option value="1">Automatic
                                                                                        </option>
                                                                                        <option value="2">Manual
                                                                                        </option>
                                                                                    </select>

                                                                                </div>






                                                                            </div>




                                                                        </div>
                                                                        <div class="row" style="display:none">
                                                                            <div class="col-sm-6">
                                                                                <!-- text input -->
                                                                                <div class="form-group">

                                                                                    <label>Reschdule Student To Old Teacher
                                                                                        Date
                                                                                        <span class="text-danger">
                                                                                            @error('reAssignStudenToOldTeacher')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span></label>

                                                                                    <input type="text"
                                                                                        id="reAssignStudenToOldTeacher"
                                                                                        name="reAssignStudenToOldTeacher"
                                                                                        class="form-control bootstrap-datepicker"
                                                                                        value="" />

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <!-- text input -->
                                                                                <div class="form-group">

                                                                                    <label>Reschdule Student To Old Teacher
                                                                                        Time
                                                                                        <span class="text-danger">
                                                                                            @error('reAssignStudenToOldTeachertime')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span></label>

                                                                                    <input type="text"
                                                                                        id="reAssignStudenToOldTeachertime"
                                                                                        name="reAssignStudenToOldTeachertime"
                                                                                        class="form-control timepicker-assing-teacher"
                                                                                        value="" />

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <!-- text input -->
                                                                                <div class="form-group">

                                                                                    <label>Teacher Country<span
                                                                                            class="text-danger">
                                                                                            @error('selectteachercountry')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span></label>

                                                                                    <select style="width: 100%;"
                                                                                        id="selectteachercountry"
                                                                                        class="form-control select2 @error('selectteachercountry') is-invalid @enderror">
                                                                                        <option selected="selected"
                                                                                            value="">Select
                                                                                            Country
                                                                                        </option>
                                                                                        @foreach ($Country as $s)
                                                                                            <option
                                                                                                value="{{ $s->id }}">
                                                                                                {{ $s->CountryName }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>

                                                                                </div>






                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <!-- text input -->
                                                                                <div class="form-group">

                                                                                    <label>Teacher Language<span
                                                                                            class="text-danger">
                                                                                            @error('selectteacherlanguage')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span></label>

                                                                                    <select id="selectteacherlanguage"
                                                                                        class="select2"
                                                                                        data-placeholder="Select a language"
                                                                                        data-dropdown-css-class="select2-purple"
                                                                                        style="width: 100%;"
                                                                                        class="form-control @error('selectteacherlanguage') is-invalid @enderror">

                                                                                        @foreach ($Language as $s)
                                                                                            <option
                                                                                                value="{{ $s->id }}">
                                                                                                {{ $s->languagename }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>

                                                                                </div>






                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-8">
                                                                                <!-- text input -->
                                                                                <div class="form-group">

                                                                                    <label>Search New Teachers <span
                                                                                            class="text-danger">
                                                                                            @error('selectnewteacher')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span></label>

                                                                                    <select name="selectnewteacher"
                                                                                        id="selectnewteacher"
                                                                                        class="form-control @error('selectnewteacher') is-invalid @enderror">
                                                                                        <option value="">Select
                                                                                            Teacher
                                                                                        </option>

                                                                                    </select>

                                                                                </div>



                                                                                <!-- teacherchangeModal Start -->
                                                                                <div id="teacherchangeModal"
                                                                                    class="modal fade" role="dialog">
                                                                                    <div class="modal-dialog">

                                                                                        <!-- Modal content-->
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">

                                                                                                <h4 class="modal-title">
                                                                                                    Teacher
                                                                                                    Change Reason</h4>
                                                                                            </div>

                                                                                            <div class="modal-body">



                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12">
                                                                                                        <h1 style="display:none"
                                                                                                            class="teacherExistenceClass">
                                                                                                            This Teacher is
                                                                                                            Already
                                                                                                            Assigned this
                                                                                                            Student.
                                                                                                        </h1>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12">
                                                                                                        <!-- text input -->
                                                                                                        <div
                                                                                                            class="form-group">
                                                                                                            <label>Reason
                                                                                                                <span
                                                                                                                    class="text-danger">
                                                                                                                    @error('subject')
                                                                                                                        {{ $message }}
                                                                                                                    @enderror
                                                                                                                </span></label>


                                                                                                            <select
                                                                                                                name="teacherreason"
                                                                                                                id="teacherreasonselect"
                                                                                                                class="form-control @error('teacherreasonselect') is-invalid @enderror">
                                                                                                                <option
                                                                                                                    value="">
                                                                                                                    Select
                                                                                                                    Reason
                                                                                                                </option>
                                                                                                                @foreach ($reason as $data)
                                                                                                                    <option
                                                                                                                        data-status="{{ $data->statusType }}"
                                                                                                                        data-type="{{ $data->type }}"
                                                                                                                        value="{{ $data->id }}">
                                                                                                                        {{ $data->reason }}
                                                                                                                    </option>
                                                                                                                @endforeach
                                                                                                            </select>

                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>


                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12">
                                                                                                        <!-- text input -->
                                                                                                        <div
                                                                                                            class="form-group">
                                                                                                            <label>Details
                                                                                                                <span
                                                                                                                    class="text-danger">
                                                                                                                    @error('teacherreasondetail')
                                                                                                                        {{ $message }}
                                                                                                                    @enderror
                                                                                                                </span></label>

                                                                                                            <blade
                                                                                                                ___html_tags_2___ />


                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>


                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button"
                                                                                                    id="btnteachercancel"
                                                                                                    class="btn btn-danger btn-block">Cancel</button>

                                                                                                <button type="button"
                                                                                                    id="btnsaveteacherreason"
                                                                                                    class="btn btn-primary btn-block">Save</button>


                                                                                            </div>

                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <!-- teacherchangeModal End -->



                                                                            </div>

                                                                            <div class="col-sm-2">

                                                                                <button
                                                                                    class="btn btn-info btn-block btnsearchteachertime">Search
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-sm-2">

                                                                                <div class="loading-spinner">
                                                                                    <i class="bg-blue"></i>
                                                                                    <i class="bg-blue"></i>
                                                                                    <i class="bg-blue"></i>
                                                                                    <i class="bg-blue"></i>
                                                                                    <i class="bg-blue"></i>
                                                                                    <i class="bg-blue"></i>
                                                                                </div>
                                                                            </div>


                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">

                                                                                <label>Teacher Requirement <span
                                                                                        class="text-danger">
                                                                                        @error('teacherrequirement')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span></label>
                                                                                <textarea name="teacherrequirement" class="form-control @error('teacherrequirement') is-invalid @enderror">{{ $targetStudent->teacher_requirement }}</textarea>

                                                                            </div>
                                                                        </div>




                                                                    </div>



                                                                </div>

                                                                <div class="tab-pane text-left fade " id="tab-example-6">


                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            @if (count($student_days) > 0)
                                                                                <table
                                                                                    style="font-size:22px !important;text-align:center !important">
                                                                                    <tr>
                                                                                        <td
                                                                                            colspan="{{ count($student_days) }}">
                                                                                            Package :
                                                                                            {{ count($student_days) }}
                                                                                            days
                                                                                        </td>
                                                                                    </tr>

                                                                                </table>
                                                                                <table
                                                                                    style="font-size:22px !important;text-align:center !important">

                                                                                    <tr>



                                                                                        <td>

                                                                                        </td>

                                                                                        <td>
                                                                                            <table
                                                                                                class="table-bordered daystablerow">
                                                                                                <tr>
                                                                                                    <td>Days</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Time</td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>

                                                                                        @foreach ($student_days as $index => $val)
                                                                                            <td>
                                                                                                <table
                                                                                                    class="table-bordered daystablerow">
                                                                                                    <tr>
                                                                                                        <td>{{ $val->day_name }}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>{{ $val->local_time_text }}
                                                                                                        </td>
                                                                                                    </tr>

                                                                                                </table>
                                                                                            </td>
                                                                                        @endforeach

                                                                                    </tr>

                                                                                </table>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <br />
                                                                    <div id='calendar' style="height:550px;"></div>
                                                                    <br />
                                                                    <div class="row">
                                                                        <h3>Last 40 days Attendance</h3>
                                                                        <br />
                                                                        <div class="col-sm-12">
                                                                            @foreach ($last40daysstudent as $val)
                                                                                <div class="attendanceboxes"
                                                                                    style="background-color:{{ $val->color }}"
                                                                                    title="{{ $val->status_name }} - {{ \Carbon\Carbon::parse($val->created_at)->format('d-m-Y') }}">
                                                                                    {{ \Carbon\Carbon::parse($val->created_at)->format('d') }}
                                                                                </div>
                                                                            @endforeach

                                                                        </div>
                                                                    </div>
                                                                    <br />
                                                                    <br />
                                                                    <div class="row">
                                                                        <div style="display:none" class="col-md-4">
                                                                            <div id="reportrange"
                                                                                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                                                <i class="fa fa-calendar"></i>&nbsp;
                                                                                <span></span> <i
                                                                                    class="fa fa-caret-down"></i>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <select class="form-control"
                                                                                id="attendancestatusDrp">
                                                                                <option value="">Select Attendance
                                                                                    Status
                                                                                </option>
                                                                                @foreach ($allatendancestatus as $val)
                                                                                    <option value="{{ $val->status }}">
                                                                                        {{ $val->status_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                        <div class="col-md-2">
                                                                            <button type="button"
                                                                                class="btn btn-primary btnsearchForm">Search</button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <h3>Student Attendance</h3>
                                                                        <br />
                                                                        <div class="col-md-12">
                                                                            <table id="studentattendanceDatatable"
                                                                                data-link="{{ route('admin.student.bystudent.attendance.datatable', request()->route('id')) }}"
                                                                                class="table table-bordered table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Group</th>
                                                                                        <th>Student Name</th>
                                                                                        <th>Teacher Name</th>
                                                                                        <th>Attendance Status</th>
                                                                                        <th>Attendance Status</th>
                                                                                        <th>Attendance Day</th>
                                                                                        <th>Student Time</th>
                                                                                        <th>Teacher Time</th>
                                                                                        <th>Attdendance Time</th>
                                                                                        <th>Attendance date</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>


                                                                        </div>
                                                                    </div>



                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <button type="submit" id="btnformsubmitstudent"
                                            class="btn btn-primary btn-block">Save</button>
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



    <!-- taskModal -->
    <div id="taskModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="taskForm" method="post" action="{{ route('admin.task.store') }}"
                    enctype="multipart/form-data">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Create Task</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Subject<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input type="text" value="" name="subject" placeholder="Subject"
                                        class="form-control subject">

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assign TO<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select name="assignto" class="form-control dropdownGetUsers">
                                        <option value="">Select Role</option>
                                        <option value="1">Teacher</option>
                                        <option value="2">Management</option>
                                    </select>
                                </div>

                                <!-- text input -->

                            </div>

                        </div>
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Task Type<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select name="TaskType" class="form-control dropdownTaskType">
                                        <option value="">Select Task Type</option>
                                        <option value="1">Student</option>
                                        <option value="2">Teacher</option>
                                        <option value="3">Other</option>
                                    </select>
                                </div>

                                <!-- text input -->

                            </div>

                        </div>

                        <div style="display:none" class="row managementDivStudent">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Group <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <select class="select2 form-control" name="group" id="SelectGroup"
                                        style="width: 100%;">
                                        <option value="">Select Group</option>
                                        @foreach ($groupdata as $group)
                                            <option value="{{ $group }}">{{ $group }}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Students<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select class="select2 form-control groupstudent" multiple="multiple"
                                        name="groupstudent[]" style="width: 100%;">
                                        <option value="">Select Student</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style="display:none" class="row managementDivTeacher">
                            <div class="col-sm-12">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <select class="select2 form-control" name="managementteacher"
                                        id="SelectTeacherMangement" style="width: 100%;">
                                        <option value="">Select Teahcer</option>
                                        @foreach ($teacherdata as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->employeename }}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                        </div>

                        <div style="display:none" class="row teacherDiv">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <select class="select2 form-control" name="teacher" id="SelectTeacher"
                                        style="width: 100%;">
                                        <option value="">Select Teahcer</option>
                                        @foreach ($teacherdata as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Students<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select class="select2 form-control teacherstudent" name="teacherstudent"
                                        style="width: 100%;">
                                        <option value="">Select Student</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style="display:none" class="row teacherDivother">
                            <div class="col-sm-12">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <select class="select2 form-control" name="teacherother" id="SelectTeacherother"
                                        style="width: 100%;">
                                        <option value="">Select Teahcer</option>
                                        @foreach ($teacherdata as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                        </div>

                        <div style="display:none" class="row managementDiv">

                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Users<span class="m-l-5 text-danger  errorlabelmy">*</span></label>


                                    <div class="select2-purple">
                                        <select class="select2 " data-id="users" multiple="multiple" name="users[]"
                                            id="usersdrp" data-placeholder="Select a Users"
                                            data-dropdown-css-class="select2-purple" style="width: 100%;">

                                        </select>
                                    </div>


                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">

                                    <input type="checkbox" name="IsImportantchk" id="IsImportantchk">
                                    <label>&nbsp;&nbsp;Urgent <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input type="hidden" value="0" name="isImportant" class="isImportanttxt">

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Attachment<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <input type="file" name="isAttachment" class="form-control " />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Completed Date <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input type="text" value="" name="completeddate"
                                        placeholder="Completed Date" class="form-control bootstrap-datepicker">

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Completed Time<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <input name="completedtime" class="form-control timepicker-example" />
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">

                                    <!--ckeditor-->
                                    <div class="form-group">
                                        <label>Note <span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea cols="80" id="editor1" name="note" rows="10" class="form-control note " name="note"></textarea>

                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- taskModal -->







    <!-- Lesson Modal partial -->
    @include('custompartials.lessonpartial', [
        'saveWithParentForm' => false,
        'lessonstudentid' => request()->route('id'),
        'lessonid' => '',
        'lessonteacherid' => '',
        'EditRoute' => route('admin.student.lesson.edit', ':id'),
        'isFeildsDisabled' => false,
        'SaveRoute' => route('admin.student.lesson.save'),
        'lastLessonRoute' => route('admin.student.lesson.getlastlesson', ':id'),
        'isInformativeDisabled' => false,
        'lessonOtherParam' => '',
        'lessonlastAttendanceId' => '',
        'lessonattendance_id' => '',
    ])
    <!-- Lesson Modal partial -->

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="feedBackform" action="{{ route('admin.student.teacher.feedback') }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Question 1 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                    <br />
                                    <span data-attr="1" data-ques="1" id="rating-star-1-1"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="2" data-ques="1" id="rating-star-1-2"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="3" data-ques="1" id="rating-star-1-3"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="4" data-ques="1" id="rating-star-1-4"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="5" data-ques="1" id="rating-star-1-5"
                                        class="fa fa-star btnrating"></span>
                                    <input type="hidden" name="ratingquestion1" class="ratingquestionval"
                                        id="ratingquestion1" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Question 2 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                    <br />
                                    <span data-attr="1" data-ques="2" id="rating-star-2-1"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="2" data-ques="2" id="rating-star-2-2"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="3" data-ques="2" id="rating-star-2-3"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="4" data-ques="2" id="rating-star-2-4"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="5" data-ques="2" id="rating-star-2-5"
                                        class="fa fa-star btnrating"></span>
                                    <input type="hidden" name="ratingquestion2" class="ratingquestionval"
                                        id="ratingquestion2" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Question 3 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                    <br />
                                    <span data-attr="1" data-ques="3" id="rating-star-3-1"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="2" data-ques="3" id="rating-star-3-2"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="3" data-ques="3" id="rating-star-3-3"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="4" data-ques="3" id="rating-star-3-4"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="5" data-ques="3" id="rating-star-3-5"
                                        class="fa fa-star btnrating"></span>

                                    <input type="hidden" name="ratingquestion3" class="ratingquestionval"
                                        id="ratingquestion3" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Question 4 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                    <br />
                                    <span data-attr="1" data-ques="4" id="rating-star-4-1"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="2" data-ques="4" id="rating-star-4-2"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="3" data-ques="4" id="rating-star-4-3"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="4" data-ques="4" id="rating-star-4-4"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="5" data-ques="4" id="rating-star-4-5"
                                        class="fa fa-star btnrating"></span>

                                    <input type="hidden" name="ratingquestion4" class="ratingquestionval"
                                        id="ratingquestion4" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Question 5 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                    <br />
                                    <span data-attr="1" data-ques="5" id="rating-star-5-1"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="2" data-ques="5" id="rating-star-5-2"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="3" data-ques="5" id="rating-star-5-3"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="4" data-ques="5" id="rating-star-5-4"
                                        class="fa fa-star  btnrating"></span>
                                    <span data-attr="5" data-ques="5" id="rating-star-5-5"
                                        class="fa fa-star btnrating"></span>

                                    <input type="hidden" name="ratingquestion5" class="ratingquestionval"
                                        id="ratingquestion5" value="0">
                                </div>

                                @csrf()
                                <div class="form-group">
                                    <label>Feedback <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                    <textarea name="description" class="form-control  description @error('description') is-invalid @enderror"></textarea>
                                    <input type="hidden" name="studentid" class="studentid"
                                        value="{{ request()->route('id') }}">
                                    <input type="hidden" name="teacherid" class="teacherid"
                                        value="{{ $targetStudent->teacher_id }}">
                                    <span class="text-danger">
                                        @error('detail')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <div class="modal fade" id="classRecoveryModal" tabindex="-1" role="dialog"
        aria-labelledby="SchduleModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="classRecoveryeModalLongTitle">Recovery Class Schdule</h5>

                </div>
                <form id="formstudenrecoveryclass" action="{{ route('admin.student.recovery.class.schdule.save') }}"
                    method="POST" role="form">
                    <div class="modal-body">


                        @csrf

                        <div class="row">
                            <div class="col-sm-5">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Time <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input name="recoveryclasstime" id="recoveryclasstime" value=""
                                        class="timepicker  form-control recoveryclasstime" type="text">
                                    <span class="text-danger">
                                        @error('localtime')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Date<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <input placeholder="Recovery Class Date" data-date-format="mm/dd/yy"
                                        class="form-control bootstrap-datepicker recoveryclassDate  @error('recoveryclassDate') is-invalid @enderror "
                                        name="recoveryclassDate" type="text" value="">

                                    <span class="text-danger">
                                        @error('recoveryclassDate')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <br />
                                <button class="btn btn-primary btnsearchteacherrecovery">Search</button>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <select id="recoveryclassTeacher" name="recoveryclassTeacher"
                                        class="form-control recoveryclassTeacher">

                                        <option value="">Select Teacher</option>
                                        {{-- @foreach ($teacherlist as $val)
                                            <option {{ $targetStudent->teacher_id == $val->id ? 'selected' : '' }}
                                                value="{{ $val->id }}">{{ $val->employeename }}</option>
                                        @endforeach --}}

                                    </select>
                                    <input type="hidden" class="recoverystudent" name="student_id"
                                        value="{{ request()->route('id') }}" />
                                    <input type="hidden" class="attendance_id" name="attendance_id"
                                        value="" />
                                    <input type="hidden" class="currentteacherid" name="currentteacherid"
                                        value="" />
                                    <input type="hidden" class="duration" name="duration" value="" />

                                    <input type="hidden" class="isTafseer" name="isTafseer" value="" />
                                    <input type="hidden" class="duration" name="duration" value="" />



                                    <span class="text-danger">
                                        @error('recoveryclassTeacher')
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
                                    <label>Class Payment <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <select name="recoveryclasspayment" class="form-control recoveryclasspayment">
                                        <option value="">Select Class Payment</option>
                                        <option selected value="1">Paid</option>
                                        <option value="2">UnPaid</option>
                                    </select>
                                    <input type="hidden" name="id" value="" />
                                    <span class="text-danger">
                                        @error('recoveryclasspayment')
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
                                    <label>Class Issue <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <select name="recoveryclassattendIssue"
                                        class="form-control recoveryclassattendIssue">
                                        <option value="">Select Class Attend Issue</option>
                                        <option value="1">Teacher</option>
                                        <option value="2">Company</option>
                                    </select>
                                    <input type="hidden" name="id" value="" />
                                    <span class="text-danger">
                                        @error('recoveryclassattendIssue')
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
                                    <label>Comment<span class="m-l-5 text-danger  errorlabelmy recoveryclasscomment">
                                            *</span></label>
                                    <textarea name="comment" class="form-control schduleDate @error('recoveryclasscomment') is-invalid @enderror "></textarea>

                                    <span class="text-danger">
                                        @error('recoveryclasscomment')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="saverecoverybtn" class="btn btn-primary btn-block">Save
                            changes</button>
                    </div>
                </form>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
        integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
        crossorigin="anonymous"></script>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Bootstrap Timepicker -->

    <script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
    </script>


    <script type="text/javascript"
        src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
    </script>

    <script src="https://cdn.jsdelivr.net/gh/manuelmhtr/countries-and-timezones@latest/dist/index.js"
        type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/widgets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/fullcalender/main.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('.timepicker-example').timepicker();


            $('.bootstrap-today-datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            // .datepicker("setDate",'now')

            $('.timepicker-assing-teacher').timepicker({
                minuteStep: 60,
            });
            $('#recoveryclasstime').timepicker({
                minuteStep: 5,
            });


            $('.loading-spinner').css("display", "none");
            $('.select2').select2();

            var data = ct.getCountry('MX');
            //   console.log(data);

            function getAge(dateVal) {
                var
                    birthday = new Date(dateVal.value),
                    today = new Date(),
                    ageInMilliseconds = new Date(today - birthday),
                    years = ageInMilliseconds / (24 * 60 * 60 * 1000 * 365.25),
                    months = 12 * (years % 1),
                    days = Math.floor(30 * (months % 1));
                return (Math.floor(years)) ? Math.floor(years) + ' years ' : 0 + ' years ';

            }



            $('.dateoftbirthclass').datepicker({
                format: 'yyyy-mm-dd',

            }).on('change', function() {
                var age = getAge(this);
                $('.calculated_ageclass').val(age);

            });



            window.dayTimming = {};

          

            @if (count($student_days) > 0)
                let day_arrrrr = '{{ $student_days->pluck('student_day_no')->implode(',') }}';
                $('#daysDrp').val(day_arrrrr.split(',')).trigger('change');

                // console.log('{{ $student_days }}')
                let html = "";
                let htmlstudentime = "";
                day_arrrrr = day_arrrrr.split(',');
                let dayinners = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                if (day_arrrrr) {
                    @foreach ($student_days as $index => $val)

                        //   console.log('$val->student_day_no','{{ $val->student_day_no }}')

                        html += `<div class="col-md-2">
                     <label for="" class="col-sm-4 control-label"><select name="localtimeday[]" >`;


                        dayinners.forEach(function(item, i) {
                            let daynooo = i + 1;

                            let selValday = (daynooo == '{{ $val->day_no }}') ? 'selected' : '';

                            html += `<option ${selValday}  value="${daynooo}">${item}</option>`
                        });




                        html += `</select></label><div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="localtime[]" readonly id="localtime{{ $index }}"  value="{{ $val->local_time_text }}" data-index="{{ $index }}" class="timepicker-local localtimeclass form-control" type="text">
                      </div>
                      </div>
                      </div>
                      </div>`;



                        var obj = {
                            'studenttime': '{{ $val->student_time_text }}',
                            'localtime': '{{ $val->local_time_text }}',
                            'dataindex': '{{ $index }}',
                            'day_no': '{{ $val->day_no }}'
                        }
                        window.dayTimming[days_name(parseInt('{{ $val->student_day_no }}'))] = obj;


                        htmlstudentime += `<div class="col-md-2 studenttimeclassparent">
                     <label for="" class="col-sm-4 control-label">${days_name(parseInt('{{ $val->student_day_no }}'))}</label>
                     <div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="studenttimeday[]" id="studenttimeday{{ $index }}" value="{{ $val->student_day_no }}" type="hidden">
                       <input name="studenttime[]" id="studenttime{{ $index }}" value="{{ $val->student_time_text }}"  data-index="{{ $index }}" class="timepicker-student studenttimeclass form-control" type="text">
                      </div>
                      </div>
                      </div>
                      </div>`;
                    @endforeach
                    $('.localtimepickerdivparent').show();
                    $('.studenttimepickerdivparent').show();
                } else {
                    $('.localtimepickerdivparent').hide();
                    $('.studenttimepickerdivparent').hide();
                }
                $('.localtimepickerdiv').html(html);
                $('.studenttimepickerdiv').html(htmlstudentime);


                $('.timepicker-local').timepicker({
                    pickTime: false,
                    template: false,
                    showInputs: false,
                    minuteStep: 5,
                    change: function(time) {
                        // the input field
                        var element = $(this),
                            text;
                        // get access to this Timepicker instance
                        var timepicker = element.timepicker();
                        text = 'Selected time is: ' + timepicker.format(time);
                        // console.log(text);
                    }
                });
                $('.timepicker-student').timepicker({
                    minuteStep: 5,
                });


               
            @endif

            @if (count($student_days) > 0)

                setTimeout(function() {

                    let day_arrrrrnew = '{{ $student_days->pluck('student_day_no')->implode(',') }}';
                    $('#daysDrp').val(day_arrrrrnew.split(',')).trigger('change');

                }, 1000);
            @endif


            @if ($targetStudent->joining_date != '0000-00-00' && $targetStudent->joining_date != '')
                $('.bootstrap-datepicker').datepicker({
                    format: 'yyyy-mm-dd',

                }).datepicker("update", '{{ $targetStudent->joining_date }}');;
            @else

                $('.bootstrap-datepicker').datepicker({
                    format: 'yyyy-mm-dd',

                }).datepicker("update", new Date());;
            @endif

            @if ($targetStudent->teacheSchduledate != '0000-00-00' && $targetStudent->teacheSchduledate != '')
                $('#teacherscduledate').datepicker({
                    format: 'yyyy-mm-dd',

                }).datepicker("update", '{{ $targetStudent->teacheSchduledate }}');;
            @else

                $('#teacherscduledate').datepicker({
                    format: 'yyyy-mm-dd',

                }).datepicker("update", new Date());;
            @endif

            @if ($targetStudent->teacheSchduletime != '')
                var today = new Date();
                var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();
                var dateTime = date + ' ' + '{{ $targetStudent->teacheSchduletime }}';
                $('#teacherscduletime').timepicker('setTime', new Date(dateTime));
            @else
            @endif






            $('#teacherscduletime').timepicker();


            window.teacherHistoryArr = JSON.parse(JSON.stringify(JSON.parse(
                "{{ json_encode($targetStudent->TeacherChangeHistory) }}".replace(/&quot;/g, '"'))));


            $(document).on('change', '#resource', function() {

                var val = $(this).val();
                $('.referencename').closest('.row').hide();
                $('.marketingagencies').closest('.row').hide();
                if (val == 1) {
                    $('.marketingagencies').closest('.row').show();
                }
                if (val == 2) {
                    $('.referencename').closest('.row').show();
                }


            })

            $(document).on('change', '#countrydrp', function() {
                // attr('data-curr');


                var val = $(this).find('option:selected').attr('data-curr');
                var zone = $(this).find('option:selected').attr('data-zone');
                $('#timezonedrp').val(zone).trigger('change')

                // console.log(val)
                $('#currencysymbol').val(val);

                var val = $(this).val();
                var url = '{{ route('city.load.country', ':id') }}';
                url = url.replace(':id', val);

                $.get(url, function(res) {

                    let html = "<option value=''>Select City</option>"
                    $.each(res, function($i, $val) {
                        // console.log($val)
                        html +=
                            `<option value="${$val['id']}">${$val['CityName']}</option>`;
                    })
                    $('#citydrop').html(html)

                })


            })

           




            $(document).on('change', '#timezonedrp', function() {
                // attr('data-curr');


                var val = $(this).find('option:selected').attr('data-timezone');
                // console.log(val)
                $('#timezoneName').val(val);



                const timezone = ct.getCountryForTimezone(val);
                // console.log(timezone);


            })

            $(document).on('change', '#daysDrp', function() {
                // attr('data-curr');

                if ($('#timezoneName').val() == "") {
                    $('#daysDrp').val('');
                    toastr.info('Please Must Select  First', 'Timezone');
                    return;
                }

                var days = $(this).val();

                // console.log(days)
                let html = "";
                let htmlstudentime = "";
                let dayinners = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday",
                    "Sunday"
                ];

                if (days) {
                    $.each(days, function(index, value) {


                        let getlocaltime = '';
                        let getstudenttime = '';
                        let day_no = '';
                        if (window.dayTimming[days_name(parseInt(value))]) {
                            let valueday = window.dayTimming[days_name(parseInt(value))];

                            getlocaltime = valueday.localtime;
                            getstudenttime = valueday.studenttime;

                            day_no = valueday.day_no

                            //   console.log(getlocaltime,'',getstudenttime)
                        } else {
                            day_no = value
                        }


                        html += `<div class="col-md-2">
                     <label for="" class="col-sm-4 control-label"><select name="localtimeday[]" >`;


                        dayinners.forEach(function(item, i) {
                            let daynooo = i + 1;

                            let selValday = (daynooo == day_no) ? 'selected' : '';

                            html +=
                                `<option ${selValday}  value="${daynooo}">${item}</option>`
                        });




                        html += `</select></label><div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="localtime[]" readonly id="localtime${index}"   value="${getlocaltime}"  data-index="${index}" class="timepicker-local localtimeclass form-control" type="text">
                      </div>
                      </div>
                      </div>
                      </div>`;


                        htmlstudentime += `<div class="col-md-2 studenttimeclassparent">
                     <label for="" class="col-sm-12 control-label">${days_name(parseInt(value))}</label>
                     <div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="studenttimeday[]" id="studenttimeday${index}" value="${value}" type="hidden">
                       <input name="studenttime[]" id="studenttime${index}"  value="${getstudenttime}"  data-index="${index}" class="timepicker-student studenttimeclass form-control" type="text">
                      </div>
                      </div>
                      </div>
                      </div>`;
                    });
                    $('.localtimepickerdivparent').show();
                    $('.studenttimepickerdivparent').show();
                } else {
                    $('.localtimepickerdivparent').hide();
                    $('.studenttimepickerdivparent').hide();
                }
                $('.localtimepickerdiv').html(html);
                $('.studenttimepickerdiv').html(htmlstudentime);


                $('.timepicker-local').timepicker({
                    pickTime: false,
                    template: false,
                    showInputs: false,
                    minuteStep: 5,
                    change: function(time) {
                        // the input field
                        var element = $(this),
                            text;
                        // get access to this Timepicker instance
                        var timepicker = element.timepicker();
                        text = 'Selected time is: ' + timepicker.format(time);
                        // console.log(text);
                    }
                });
                $('.timepicker-student').timepicker({
                    minuteStep: 5,
                });

              

            });


            function toTimeZone(time, zone) {
                var format = 'YYYY/MM/DD HH:mm:ss A';
                var format2 = 'YYYY/MM/DD hh:mm a';


                return moment(time, format).tz(zone).format(format2);

                // return moment.tz(time,zone).format('YYYY-MM-DD HH:mm:ss');
            }




            $(document).on("change", ".localtimeclass", function(e) {
                var element = $(this).val();

                var index = $(this).attr('data-index');

          
            });

            $(document).on("change", ".studenttimeclass", function(e) {

                e.preventDefault();
                var element = $(this).val();
                var index = $(this).attr('data-index');
                var day = `${days_name(parseInt($(`#studenttimeday${index}`).val()))}`;


                var today = new Date();

                var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();

                //  console.log('day',window.dayTimming)

                var dateTime = date + ' ' + element;

                // Object.keys(window.dayTimming).forEach(item => {
                //       if(item == day){
                //            dateTime = date + ' ' + window.dayTimming[item].studenttime;

                //            console.log(item,'loop date dateTime',window.dayTimming[item].studenttime)
                //       }
                // });


                // var dateTime = date + ' ' + element;
                // console.log('oute loop date dateTime',dateTime)
                // let studenttime = new Date(toTimeZone(dateTime, $('#timezoneName').val() ));



                let nows = moment.utc();
                let anothertimezone = moment.tz.zone($('#timezoneName').val()).offset(nows)
                let pak = moment.tz.zone("Asia/Tashkent").offset(nows);
                let hours = (anothertimezone - pak) / 60;
                let minutes = anothertimezone - pak;

                // console.log('timedifference hours',minutes)

                let changetimezone = toTimeZoneHouradd(dateTime, $('#timezoneName').val(), minutes,
                    '{{ $timeChangeEuropeStatusStudenttime }}',
                    '{{ $timeChangeEuropeStatusAmerica }}', '{{ $timeChangeEuropeStatusEurope }}');
                let studenttime = moment(changetimezone).add(minutes, 'minutes').format(
                    'YYYY/MM/DD hh:mm a');
                if (minutes > 0) {

                    //   studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a') ;

                    studenttime = moment(changetimezone).add(minutes, 'minutes').format('hh:mm a');
                    //   console.log('changetimezone convert', moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
                } else {
                    minutes = Math.abs(minutes)
                    //   studenttime  =  moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a');

                    studenttime = moment(changetimezone).subtract(minutes, 'minutes').format('hh:mm a');

                    // console.log('changetimezone convert', moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
                }





                //old another time zone to pakistan
                // let localtimeget =   toTimeZone(date + ' ' + studenttime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent');



                let localtimeget = toTimeZone(date + ' ' + studenttime.toLocaleString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                }), 'Asia/Tashkent');
                // $('#localtime' + index).timepicker('setTime',new Date(studenttime));

                $('#localtime' + index).timepicker('setTime', studenttime);


                // console.log('studettime', studenttime)
                //  console.log('localtimeget', localtimeget)

                // $('#localtime' + index).timepicker('setTime', new Date(toTimeZone(dateTime, $('#timezoneName')
                //     .val())));
                //    console.log('')
            });

            function days_name(val) {
                let day = '';
                switch (val) {
                    case 1:
                        day = 'Monday';
                        break;
                    case 2:
                        day = 'Tuesday';
                        break;
                    case 3:
                        day = 'Wednesday';
                        break;
                    case 4:
                        day = 'Thursday';
                        break;
                    case 5:
                        day = 'Friday';
                        break;
                    case 6:
                        day = 'Saturday';
                        break;
                    case 7:
                        day = 'Sunday';
                        break;
                }

                return day;
            }






            $(document).on('click', '.btnsearchteachertime', function(e) {
                e.preventDefault();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let url = '{{ route('admin.teacher.search') }}';

                let daytime = [];
                $('.localtimeclass').each(function() {
                    daytime.push($(this).val())
                })
                let day = []
                $("select[name='localtimeday[]']").each(function() {
                    day.push($(this).val())
                });
                let duration = $("select[name='duration']").val();
                let language = $("#selectteacherlanguage").val();
                let country = $("#selectteachercountry").val();




                if (day.length > 0 && daytime.length > 0 && duration != "") {
                    $.ajax({
                            type: "POST",
                            url: url,
                            dataType: 'json',
                            data: {
                                day: day,
                                daytime: daytime,
                                duration: duration,
                                language: language,
                                country: country
                            },
                            beforeSend: function() {
                                // setting a timeout
                                $('.loading-spinner').css("display", "block");
                            },
                            complete: function() {
                                $('.loading-spinner').css("display", "none");
                            }
                        })
                        .done(function(data) {

                            data = JSON.parse(JSON.stringify(data));

                            //  console.log(data)
                            if (data.error) {

                            }

                            if (data.success) {
                                $('#selectnewteacher').html('')
                                let res = data.freeteacher;
                                let html = "<option value=''>Select Teachers</option>"
                                $.each(res, function($i, $val) {
                                    // console.log($val)
                                    html +=
                                        `<option value="${$val['teacher_id']}">${$val['teachername']}</option>`;
                                })
                                $('#selectnewteacher').html(html)

                                // console.log(res)
                            }
                        })
                        .fail(function(data) {
                            console.log(data);

                        });
                } else {
                    toastr.info('please must set student timing and duration then search')
                }

            });
            $(document).on('click', '.btnsearchteacherrecovery', function(e) {
                e.preventDefault();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let url = '{{ route('admin.teacher.search') }}';
                let dayinners = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday",
                    "Sunday"
                ];

                var d = new Date($('.recoveryclassDate').val());
                // var n = dayinners[(d.getDay()-1)];
                // var dayindex = dayinners.findIndex(day => day === n)

                var dayindex = (d.getDay() == 0) ? 7 : d.getDay()


                let daytime = [];
                daytime.push($('#recoveryclasstime').val());
                let day = []
                day.push(dayindex)
                let duration = $('#formstudenrecoveryclass .duration').val();
                let language = '';
                let country = '';


                if (day.length > 0 && daytime.length > 0 && duration != "") {
                    $.ajax({
                            type: "POST",
                            url: url,
                            dataType: 'json',
                            data: {
                                day: day,
                                daytime: daytime,
                                duration: duration,
                                language: language,
                                country: country
                            },
                            beforeSend: function() {
                                // setting a timeout
                                $('.loading-spinner').css("display", "block");
                            },
                            complete: function() {
                                $('.loading-spinner').css("display", "none");
                            }
                        })
                        .done(function(data) {

                            data = JSON.parse(JSON.stringify(data));

                            //  console.log(data)
                            if (data.error) {

                            }

                            if (data.success) {
                                var id = $('#recoveryclassTeacher').attr('data-id');
                                $('#recoveryclassTeacher').html('')
                                let res = data.freeteacher;
                                let html = "<option value=''>Select Teachers</option>"
                                $.each(res, function($i, $val) {
                                    // console.log($val)
                                    html +=
                                        `<option ${($val['teacher_id'] == id) ? 'selected' :'' } value="${$val['teacher_id']}">${$val['teachername']}</option>`;
                                })
                                $('#recoveryclassTeacher').html(html)

                                // console.log(res)
                            }
                        })
                        .fail(function(data) {
                            console.log(data);

                        });
                } else {
                    toastr.info('please must set student timing and duration then search')
                }

            });


            $(document).on('change', '#taskcreatecheckbox', function() {
                if ($(this).prop("checked")) {

                    $('#taskGenerateOrNot').val(1);
                } else {
                    $('#taskGenerateOrNot').val(0);
                }
            });

            $(document).on('change', '#referralcreatecheckbox', function() {
                if ($(this).prop("checked")) {

                    $('#referralGenerateOrNot').val(1);
                } else {
                    $('#referralGenerateOrNot').val(0);
                }
            });








        });
        $(document).ready(function() {
            // $('#formstudent').bootstrapValidator({
            //     framework: 'bootstrap',
            //     excluded: [':disabled', ':hidden'],
            //     icon: {
            //         valid: 'glyphicon glyphicon-ok',
            //         invalid: 'glyphicon glyphicon-remove',
            //         validating: 'glyphicon glyphicon-refresh'
            //     },
            //     fields: {
            //         memorizationdetail: {
            //             validators: {
            //                 notEmpty: {
            //                     memorizationdetail: 'This field is required'
            //                 }
            //             }
            //         }
            //     }
            // })

            // .on('success.form.bv', function(e) {
            //     e.preventDefault();
            //       var valuesToSubmit = $(this).serialize();
            //       $.ajax({
            //         url: $(this).attr('action'),
            //         data: valuesToSubmit,
            //         dataType: 'json',
            //         type: 'POST',
            //         success: function(data) {
            //            alert('Success')
            //         },
            //         error: function(data) {
            //             alert('Error')
            //         }
            //      });
            // });

            function showtab() {
                if ($(".tab-content").find('.error').text()) {
                    $.each($(".tab-content").find('.error'), function(index, value) {
                        if ($(this).text()) {
                            $(".tab-content").children('.tab-pane').removeClass('active');
                            $(".tab-content").children('.tab-pane').removeClass('in');
                            $(this).closest('.tab-pane').addClass('active');
                            $(this).closest('.tab-pane').addClass('in');
                            $(".list-group-icons").children('li').removeClass('active');
                            var id = $(this).closest('.tab-pane').attr('id');
                            // $.each($(".nav-tabs").children('li'), function(i, a) {
                            // if (('#' + id) == $(this).children('a').attr('href'))
                            // $('#' + id).closest('li').addClass('active');

                            $(`a[href='#${id}']`).closest('li').addClass('active');
                            // });
                            return false;
                        }
                    });
                }
            }

            $("#formstudent").validate({
                ignore: "not:hidden",
                invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        //resize code goes here
                        showtab();
                    }
                },

                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                    },
                    fathername: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        minlength: 2,
                    },
                    age: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }

                    },
                    gender: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    contact_no: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },

                    classtype: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },

                    email: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        minlength: 2,
                    },
                    country: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    city: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    timezone: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        minlength: 1,
                    },
                    currencysymbol: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    resource: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    joiningdate: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    detail: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    classTime: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    marketingagencies: {
                        required: function(element) {
                            if ($("#resource").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    },
                    referencename: {
                        required: function(element) {
                            if ($("#resource").val() == '2') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        minlength: 2,
                    },
                    referenceemail: {
                        required: function(element) {
                            if ($("#resource").val() == '2') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        minlength: 2,
                    },
                    teacherassigntype: {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    reAssignStudenToOldTeacher: {
                        required: function(element) {
                            if ($("#teacherassigntype").val() == '2') {
                                return true;
                            } else {
                                return false;
                            }
                        },

                    },




                    'days[]': {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    'studenttime[]': {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    'localtime[]': {
                        required: function(element) {
                            if ($("#academicStatusChange").val() == '1') {
                                return true;
                            } else {
                                return false;
                            }
                        }


                    },
                    password: {
                        minlength: 5
                    },
                    'confirm-password': {
                        minlength: 5,
                        equalTo: "#password"
                    }

                },
                messages: { //messages to appear on error
                    // name: {
                    //     required: "Please Enter  your name.",
                    //     minlength: "C'mon full name please."
                    // }

                },
                submitHandler: function(form) {

                    var valuesToSubmit = $(form).serialize();
                    $.ajax({
                        url: $(form).attr('action'),
                        data: valuesToSubmit,
                        dataType: 'json',
                        type: 'POST',
                        beforeSend: function() {
                            $("#btnformsubmitstudent").prop('disabled',
                                true); // disable button
                        },
                        success: function(data) {

                            console.log(data)

                            $("#btnformsubmitstudent").prop('disabled', false);
                            swal("Student Save Successfully");
                            location.reload();
                        },
                        error: function(data) {
                            alert('Error')
                        }
                    });
                }
            });
        });



        $(document).ready(function() {



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
                                var inputtextarea =
                                    `#formlessonstudent textarea[name="${key}"]`;
                                var inputselect = `#formlessonstudent select[name="${key}"]`;
                                var inputselectid = `#formlessonstudent select[id="${key}"]`;
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
                        }

                        if (data.success) {
                            swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                                button: "Close",
                            });
                            $('#formlessonstudent')[0].reset();
                            $('#LessonModal').modal('hide');
                            $('#LessonDatatable').DataTable().draw(true);

                        }
                    })
                    .fail(function(data) {
                        console.log(data);

                    });
            });



            $(document).on('change', '.teacherassign', function() {

                var value = $(this).val();
                console.log(value);
                $('#formstudent input[name="teacherscduledate"]').closest('.row').hide();
                $('#formstudent .Isteacherassigned').hide();


                if (value == 1) {
                    $('#formstudent input[name="teacherscduledate"]').closest('.row').hide();
                    $('#formstudent .Isteacherassigned').show();
                } else if (value == 2) {
                    $('#formstudent input[name="teacherscduledate"]').closest('.row').show();
                    $('#formstudent .Isteacherassigned').hide();
                }
            })

            $(document).on('change', '#academicStatusChange', function() {
                let academicstatus = $(this).val();
                let status = $(this).attr('data-status');
                let type = $(this).attr('data-type');
                let oldacademicStatus = $('.oldacademicStatus').val();
                if ((academicstatus != oldacademicStatus) && (academicstatus != "")) {

                    if (academicstatus == 8) {
                        $('.reactivatedate').closest('.row').show();
                    } else {
                        $('.reactivatedate').closest('.row').hide();
                    }

                    if (academicstatus == 1 || academicstatus == 6) {
                        $('.taskresumedate').closest('.row').hide();
                    } else {
                        $('.taskresumedate').closest('.row').show();
                    }


                    //  if(type == "student"){
                    if (academicstatus > 5) {
                        $("#reasonselect option[data-type='student']").hide();
                        $("#reasonselect option[data-type='teacher']").hide();
                        $("#reasonselect option[data-type='student'][data-status='0']").show();
                    } else {
                        $("#reasonselect option[data-type='student']").hide();
                        $("#reasonselect option[data-type='teacher']").hide();
                        $("#reasonselect option[data-type='student'][data-status=" + academicstatus + "]")
                            .show();
                    }

                    //  }else{
                    //      $("#reasonselect option[data-type='student']").hide();
                    //      $("#reasonselect option[data-type='teacher']").show();
                    //  }




                    $('#academicStatusModal').modal('show');
                }

            });
            $(document).on('click', '.btncloseacademicStatus', function(e) {

                let oldacademicStatus = $('.oldacademicStatus').val();
                $('#academicStatusChange').val(oldacademicStatus);
                $('#reasonselect').val('');
                $('#reasondetail').val('');
                $('#academicStatusModal').modal('hide');

            });


            $(document).on('click', '#btnaddRffffeason', function(e) {
                e.stopImmediatePropagation();
                let reasontxt = $('.reasontxt').val();
                let _token = $('meta[name="csrf-token"]').attr('content');
                console.log(reasontxt);
                $.post('{{ route('admin.reason.storeajax') }}', {
                    reasontxt: reasontxt,
                    _token: _token
                }, function(res) {
                    console.log(res);

                    $('#teacherreasonselect').html('')
                    $('#reasonselect').html('')
                    let html = '<option value="" >Select reason</option>'
                    $.each(res['reason'], function(i, val) {
                        console.log(val['id'])
                        html += `<option value="${val['id']}" >${val['reason']}</option>`
                    });
                    $('#reasonselect').html(html);
                    $('#teacherreasonselect').html(html);
                })
            })

            $(document).on('click', '#btnsavereason', function() {



                let reasonselect = $('#reasonselect').val();
                let reasondetail = $('#reasondetail').val();

                if (reasonselect != "") {
                    $('#academicStatusModal').modal('hide');
                } else {
                    toastr.error('Please Must Select Reason', 'Error!')
                }

            })

            $(document).on('click', '#btnaddteacherttttReason', function(e) {
                e.stopImmediatePropagation();
                let reasontxt = $('.teacherreasontxt').val();
                let _token = $('meta[name="csrf-token"]').attr('content');
                console.log(reasontxt);
                $.post('{{ route('admin.reason.storeajax') }}', {
                    reasontxt: reasontxt,
                    _token: _token
                }, function(res) {
                    console.log(res);

                    $('#teacherreasonselect').html('')
                    $('#reasonselect').html('')
                    let html = '<option value="" >Select reason</option>'
                    $.each(res['reason'], function(i, val) {
                        console.log(val['id'])
                        html += `<option value="${val['id']}" >${val['reason']}</option>`
                    });
                    $('#reasonselect').html(html);
                    $('#teacherreasonselect').html(html);


                })
            })

            $(document).on('change', '#selectnewteacher', function() {
                $('.teacherExistenceClass').hide();
                let selectnewteacher = $(this).val();
                let selectoldteacher = $('#selectoldteacher').val();
                if ((selectnewteacher != selectoldteacher) && (selectnewteacher != "")) {

                    $('#studentteacherid').val($(this).val());
                    $('#teachername').val($(this).find('option:selected').text());
                    $('#teacherchangeModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });


                    var teacherOlderExist = window.teacherHistoryArr.find(obj => (obj.teacher_id == $(this)
                        .val() || obj.newteacher_id == $(this).val()));
                    if (teacherOlderExist) {
                        console.log("checkteacherexist", teacherOlderExist);

                        $('.teacherExistenceClass').show();
                    }



                } else {
                    let oldteacherid = $('#selectoldteacher').val();
                    let oldteachername = $('#selectoldteachername').val();
                    $('#studentteacherid').val(oldteacherid);
                    $('#teachername').val(oldteachername);
                }

                $("#teacherreasonselect option[data-type='student']").hide();
                $("#teacherreasonselect option[data-type='teacher']").show();


            })

            $(document).on('click', '#btnteachercancel', function() {
                $('#selectnewteacher').val('')
                $('#teacherchangeModal').modal('hide');

                let oldteacherid = $('#selectoldteacher').val();
                let oldteachername = $('#selectoldteachername').val();
                $('#studentteacherid').val(oldteacherid);
                $('#teachername').val(oldteachername);
                $('#teacherreasonselect').val('');
                $('#teacherreasondetail').val('');

            })



            $(document).on('click', '#btnsaveteacherreason', function() {


                let reasonselect = $('#teacherreasonselect').val();
                let reasondetail = $('#teacherreasondetail').val();

                if (reasonselect != "") {
                    $('#teacherchangeModal').modal('hide');
                } else {
                    toastr.error('Please Must Select Reason', 'Error!')
                }


            })

            $(document).on('click', '.btnfeedbackmodal', function() {


                $('#feedBackform .description').val('')
                $('.btnrating').removeClass('checked');
                $('.ratingquestionval').val(0);
                $('#feedbackModal').modal('show');

            });

            $("#feedBackform").validate({
                rules: {
                    description: {
                        required: true,
                    }
                },
                submitHandler: function(form) {

                    var valuesToSubmit = $(form).serialize();
                    $.ajax({
                        url: $(form).attr('action'),
                        data: valuesToSubmit,
                        dataType: 'json',
                        type: 'POST',
                        success: function(data) {

                            $('#feedBackform .teacherid').val($('#selectoldteacher').val());
                            $('#feedBackform .description').val('');

                            $('#feedBackform .btnrating').removeClass('checked');
                            $('#feedBackform .ratingquestionval').val(0);
                            $('#feedbackDatatable').DataTable().draw(true);
                            $('#feedbackModal').modal('hide');
                            swal("Feedback Save Successfully");
                        },
                        error: function(data) {
                            alert('Error')
                        }
                    });
                }
            });

            $(document).on('click', ".btnrating", (function(e) {


                var selected_value = $(this).attr("data-attr");
                var question_value = $(this).attr("data-ques");

                console.log(selected_value, '---', question_value)

                var previous_value = $(`#ratingquestion${question_value}`).val();
                $(this).closest('.form-group').find('.btnrating').removeClass('checked')
                $(`#ratingquestion${question_value}`).val(selected_value);
                for (i = 1; i <= selected_value; ++i) {
                    $(`#rating-star-${question_value}-${i}`).addClass('checked');

                }

                // for (ix = 1; ix <= previous_value; ++ix) {
                //     $(`#rating-star-${question_value}-${ix}`).toggleClass('checked');

                // }

            }));


            $(document).on('change', '#teacherassigntype', function() {

                var value = $(this).val();
                console.log(value);

                $('#formstudent input[name="reAssignStudenToOldTeacher"]').closest('.row').hide();
                $('#formstudent select[name="teachertemporaryassigntype"]').closest('.row').hide();
                $('#formstudent input[name="reAssignStudenToOldTeachertime"]').closest('.row').hide();

                if (value == 2) {
                    $('#formstudent input[name="reAssignStudenToOldTeacher"]').closest('.row').show();
                    $('#formstudent select[name="teachertemporaryassigntype"]').closest('.row').show();
                    $('#formstudent input[name="reAssignStudenToOldTeachertime"]').closest('.row').show();

                }
            })



            $(document).on('click', '#btnsearchrecoveryclass', function(e) {


                e.stopImmediatePropagation();
                let reccoveryclassdate = $('#searchrecoveryclass').val();
                let _token = $('meta[name="csrf-token"]').attr('content');
                let studentid = "{{ request()->route('id') }}";
                // classrecoverytable


                $.ajax({
                    url: '{{ route('admin.teacher.student.recovery.attendance') }}',
                    data: {
                        studentid: studentid,
                        date: reccoveryclassdate,
                        _token: _token
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function(data) {
                        console.log(data)

                        if (data.classdata.length > 0) {
                            let html = `<tr>
                                    <td>${data.classdata[0].day}</td>
                                    <td>${data.classdata[0].classtime}</td>
                                    <td>${data.classdata[0].status_name}</td>
                                    <td>${data.classdata[0].date}</td>
                                    <td><button type="button"  data-classtime='${data.classdata[0].classtime}' data-date='${data.classdata[0].created_at}' data-duration='${data.classdata[0].duration}'  data-id='${data.classdata[0].id}' class="btn btn-primary btnrecoverymodal">Recovery</button></td>
                               </tr>`
                            $('#classrecoverytable tbody').html(html);
                        }
                    },
                    error: function(data) {
                        alert('Error')
                    }
                });


            })


            $(document).on('click', '.btnrecoverymodal', function() {

                let attendanceid = $(this).attr('data-id');
                let duration = $(this).attr('data-duration');
                let classtime = $(this).attr('data-classtime');
                let date = $(this).attr('data-date');
                $(`#formstudenrecoveryclass .form-control`).removeClass('is-invalid')
                $('#formstudenrecoveryclass .errorlabelmy').html('');
                $('#formstudenrecoveryclass .attendance_id').val(attendanceid);
                // $('#formstudenrecoveryclass #recoveryclassTeacher').val(
                //     "{{ $targetStudent->teacher_id }}").trigger('change');
                $('#formstudenrecoveryclass #recoveryclassTeacher').attr('data-id',
                    "{{ $targetStudent->teacher_id }}");
                $('#formstudenrecoveryclass .currentteacherid').val("{{ $targetStudent->teacher_id }}");

                $('#formstudenrecoveryclass .recoverystudent').val("{{ request()->route('id') }}")
                $('#formstudenrecoveryclass .duration').val(duration);

                $('#formstudenrecoveryclass .recoveryclasstime').val(classtime);

                $('.recoveryclassDate').datepicker({
                    format: 'yyyy-mm-dd',

                }).datepicker("setDate", new Date(date))


                $('#classRecoveryModal').modal('show');
            })


            $('#formstudenrecoveryclass').on('submit', function(event) {
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
                        $('#saverecoverybtn').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        if (data.error) {


                            $(`#formstudenrecoveryclass .form-control`).removeClass(
                                'is-invalid')
                            $('#formstudenrecoveryclass .errorlabelmy').html('');
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




                            $(`#formstudenrecoveryclass .form-control`).removeClass(
                                'is-invalid')
                            $('#formstudenrecoveryclass .errorlabelmy').html('');

                            swal("Good job!", data.success, data.alert);

                            $('#recoveryclasstime').timepicker();
                            $('.bootstrap-datepicker').datepicker({
                                format: 'yyyy-mm-dd',
                            });
                            $('#formstudenrecoveryclass #recoveryclassTeacher').val(
                                "{{ $targetStudent->teacher_id }}").trigger('change');
                            $('#formstudenrecoveryclass .recoverystudent').val(
                                "{{ request()->route('id') }}")
                            $('#formstudenrecoveryclass .currentteacherid').val(
                                "{{ $targetStudent->teacher_id }}")

                            $('#formstudenrecoveryclass .attendance_id').val('')
                            $("#formstudenrecoveryclass").get(0).reset();
                            $('#classRecoveryModal').modal('hide');
                            $('#classrecoveryhistoryDatatable').DataTable().draw(true);

                        }
                        $('#saverecoverybtn').attr('disabled', false);

                    }
                })
            });


            $(document).on('click', '#repllicaStudentbtn', function() {

                swal({
                        title: "Are you sure?",
                        text: "You wont replica this student",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            let _token = $('meta[name="csrf-token"]').attr('content');
                            let studentid = "{{ request()->route('id') }}";

                            $.post('{{ route('admin.student.relica.create') }}', {
                                studentid: studentid,
                                _token: _token
                            }, function(res) {
                                console.log(res);

                                swal("Poof! Replica Successfully Created!", {
                                    icon: "success",
                                });
                            })



                        }
                    });

            });


            function loadStudentByGroup(group, callback) {

                $.get('{{ route('admin.task.getStudentBygroup') }}', {
                    group: group,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(res) {
                    console.log(res);

                    var html = '<option value="">Select Student</option>';
                    $.each(res, function(i, e) {
                        html += `<option value="${e.id}">${e.studentname}</option>`
                    });

                    $('.groupstudent').html(html);

                    callback();

                })
            }


            $(document).on('click', '.btncreatetask', function() {

                let group = $('#groupno').val();


                $('.dropdownGetUsers').val(2).trigger("change")
                $('.dropdownTaskType').val(1).trigger("change")
                $('#SelectGroup').val(group).trigger("change")

                loadStudentByGroup(group, function() {
                    $('.groupstudent').val('{{ request()->route('id') }}').trigger("change")
                });


                $(".bootstrap-datepicker").datepicker('setDate', new Date())
                $('#taskModal').modal('show');
                CKEDITOR.instances.editor1.setData('');
            });
            $(document).on('change', '.dropdownGetUsers', function() {

                $('.dropdownTaskType').val('')

                let roleType = $(this).val();

                if (roleType == 1) {

                    $('.managementDivTeacher').hide();
                    $('.managementDivStudent').hide();
                    $('.managementDiv').hide();
                    $('.teacherDiv').hide();
                }
                if (roleType == 2) {

                    $('.managementDiv').hide();
                    $('.teacherDiv').hide();
                    $('.teacherDivother').hide();
                }

                $.post('{{ route('admin.task.getUserRolewise') }}', {
                    roleType: roleType,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(res) {
                    console.log(res);




                    if (roleType == 1) {


                        var html = '<option value="">Select Teahcer</option>';
                        $.each(res, function(i, e) {
                            html += `<option value="${e.id}">${e.employeename}</option>`
                        });

                        $('#SelectTeacher').html(html);
                        // $('.managementDiv').hide();
                        // $('.teacherDiv').show();
                    }
                    if (roleType == 2) {

                        var html = '<option value="">Select User</option>';
                        $.each(res, function(i, e) {
                            html += `<option value="${e.id}">${e.name}</option>`
                        });

                        $('#usersdrp').html(html);
                        // $('.managementDiv').show();
                        // $('.teacherDiv').hide();
                    }



                })
            });
            $(document).on('change', '.dropdownTaskType', function() {
                let taskType = $(this).val();


                let roleType = $('.dropdownGetUsers').val();

                if (roleType == 1) {


                    if (taskType == 1) {
                        $('.teacherDiv').show();
                        $('.teacherDivother').hide();
                    } else if (taskType == 3) {
                        $('.teacherDiv').hide();
                        $('.teacherDivother').show();
                    } else {
                        $('.teacherDiv').hide();
                        $('.teacherDivother').hide();
                        $('.managementDivTeacher').hide();
                        $('.managementDivStudent').hide();
                        $('.managementDiv').hide();
                    }




                } else if (roleType == 2) {

                    if (taskType == 1) {

                        $('.managementDivStudent').show();
                        $('.managementDivTeacher').hide();
                        $('.managementDiv').show();

                    } else if (taskType == 2) {
                        $('.managementDivStudent').hide();
                        $('.managementDivTeacher').show();
                        $('.managementDiv').show();
                    } else if (taskType == 3) {
                        $('.managementDivTeacher').hide();
                        $('.managementDivStudent').hide();
                        $('.managementDiv').show();
                    } else {
                        $('.teacherDiv').hide();
                        $('.teacherDivother').hide();
                        $('.managementDivTeacher').hide();
                        $('.managementDivStudent').hide();
                        $('.managementDiv').hide();
                    }



                } else {

                    alert('Please Must Select Role');

                    $('.teacherDiv').hide();
                    $('.teacherDivother').hide();
                    $('.managementDivTeacher').hide();
                    $('.managementDivStudent').hide();
                    $('.managementDiv').hide();

                }






            });
            $(document).on('change', '#SelectGroup', function() {
                let group = $(this).val();
                loadStudentByGroup(group, function() {

                });
            });
            $(document).on('change', '#SelectTeacher', function() {
                let teacherid = $(this).val();
                $.get('{{ route('admin.task.getStudentByteacher') }}', {
                    teacherid: teacherid,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(res) {
                    console.log(res);

                    var html = '<option value="">Select Student</option>';
                    $.each(res, function(i, e) {
                        html += `<option value="${e.id}">${e.studentname}</option>`
                    });

                    $('.teacherstudent').html(html);

                })
            });
            $(document).on('submit', '#taskForm', function(e) {
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
                        url: '{{ route('admin.task.store') }}',
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: new FormData($('#taskForm')[0])
                    })
                    .done(function(data) {


                        // if(data.length > 0){
                        if (data.error) {
                            $.each(data.error, function(key, value) {
                                var input = `#taskForm input[name="${key}"]`;
                                var inputtextarea = `#taskForm textarea[name="${key}"]`;
                                var inputselect = `#taskForm select[name="${key}"]`;
                                var inputselectid = `#taskForm select[id="${key}"]`

                                var inputs = `#taskForm select[data-id="${key}"]`;
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
                                $(inputs).parents('.form-group').find('.text-danger').text(
                                    value);
                                $(input).addClass('is-invalid');
                                $(inputtextarea).addClass('is-invalid');
                                $(inputselect).addClass('is-invalid');
                                $(inputselectid).addClass('is-invalid');
                            });
                        }
                        console.log(data);

                        // }


                        if (data.Success) {
                            // swal({
                            //     title: "Good job!",
                            //     text: data.msg,
                            //     icon: "success",
                            //     button: "Close",
                            // });

                            alert('Task Create Successfully');
                            $('#taskModal').modal('hide');
                            $('#taskForm')[0].reset();



                            // $("select").trigger("change");
                        }
                    })
                    .fail(function(data) {
                        console.log(data);

                    });
            });

            CKEDITOR.editorConfig = function(config) {
                config.language = 'es';
                config.uiColor = '#F7B42C';
                config.height = 300;
                config.toolbarCanCollapse = true;

            };
            CKEDITOR.replace('editor1');







        });




        // $('#calendar').fullCalendar({
        //     events: function(start, end, timezone, callback) {
        //         jQuery.ajax({
        //             url: 'schedule.php/load',
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {
        //                 start: start.format(),
        //                 end: end.format()
        //             },
        //             success: function(doc) {
        //                 var events = [];
        //                 if(!!doc.result){
        //                     $.map( doc.result, function( r ) {
        //                         events.push({
        //                             id: r.id,
        //                             title: r.title,
        //                             start: r.date_start,
        //                             end: r.date_end
        //                         });
        //                     });
        //                 }
        //                 callback(events);
        //             }
        //         });
        //     }
        // });


        // console.log(JSON.stringify(JSON.parse("{{ json_encode($Alldaysstudent) }}".replace(/&quot;/g,'"'))))



        document.addEventListener('DOMContentLoaded', function() {


            window.defaultevent = [];
            @if ($Alldaysstudent)
                // window.defaultevent =     JSON.stringify(JSON.parse("{{ json_encode($Alldaysstudent) }}".replace(/&quot;/g,'"')));


                localStorage.setItem("alldayAttendancestudent", JSON.stringify(JSON.parse(
                    "{{ json_encode($Alldaysstudent) }}".replace(/&quot;/g, '"'))));

                window.defaultevent = JSON.parse(localStorage.getItem('alldayAttendancestudent'));

                $.each(window.defaultevent, function(i, e) {
                    //   window.defaultevent[i].display = 'background';
                });

                //  window.defaultevent = JSON.parse(window.defaultevent.replace(/"(\w+)"\s*:/g, '$1:'));
                //  $.each(defaultevent,function(i, e) {
                //       defaultevent[i].display = 'background';
                //     });
            @endif

            console.log(window.defaultevent)










        });

        $(document).ready(function() {

            function LoadCalender() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    height: 500,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: ''
                    },
                    initialDate: moment().format('YYYY-MM-DD'),
                    navLinks: false, // can click day/week names to navigate views
                    businessHours: false, // display business hours
                    editable: false,
                    selectable: false,
                    events: window.defaultevent
                });

                calendar.render();

                console.log('LoadCalender');
            }

            setTimeout(function() {

                LoadCalender()


            }, 3000);



            let startdate;
            let enddate;


            // var start = moment().subtract(29, 'days');
            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                startdate = start.format('YYYY-MM-DD');
                enddate = end.format('YYYY-MM-DD');
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'Get All': [moment().subtract(60, 'years'), moment().subtract(1, 'days')]
                }
            }, cb);

            // cb(start, end);


            $(document).on('click', '.btnsearchForm', function() {

                $('#studentattendanceDatatable').DataTable().draw(true);
            })

            function studentattendanceDatatable() {
                if (!$.fn.dataTable.isDataTable('#studentattendanceDatatable')) {
                    var oTable = $('#studentattendanceDatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#studentattendanceDatatable').attr('data-link'),
                            data: function(d) {
                                d.status = $('#attendancestatusDrp').val();
                                d.teacherId = $("#employeeDrp").val();
                                d.startdate = startdate;
                                d.enddate = enddate;

                            }
                        },

                        columns: [

                            {
                                data: 'group',
                                name: 'student.group'
                            },
                            {
                                data: 'studentname',
                                name: 'student.studentname'
                            },
                            {
                                data: 'employeename',
                                name: 'employees.employeename'
                            },

                            {
                                data: 'attendancestatusColor',
                                name: 'attendancestatusColor',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'status_name',
                                name: 'attendance_status.status_name',
                                searchable: true,
                                visible: false
                            },
                            {
                                data: 'day_name',
                                name: 'studentattendance.day_name'
                            },
                            {
                                data: 'student_time_text',
                                name: 'student_days.student_time_text',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'classtime',
                                name: 'studentattendance.attdendancetime',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'attdendancetime',
                                name: 'attdendancetime',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'created_at_attendance',
                                name: 'studentattendance.created_at'
                            }
                        ],

                    });
                }
            }

            function classrecoveryhistoryDatatable() {
                if (!$.fn.dataTable.isDataTable('#classrecoveryhistoryDatatable')) {
                    $('#classrecoveryhistoryDatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#classrecoveryhistoryDatatable').attr('data-link'),
                            data: function(d) {
                                d.id = '{{ $targetStudent->id }}';
                            }
                        },

                        columns: [

                            {
                                data: 'Recoveryteacherprofile',
                                name: 'Recoveryteacherprofile',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'Currentteacherprofile',
                                name: 'Currentteacherprofile',
                                orderable: false,
                                searchable: false
                            },

                            {
                                data: 'time',
                                name: 'time',
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
                                data: 'date',
                                name: 'date',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'comment',
                                name: 'comment'
                            },

                            {
                                data: 'created_at',
                                name: 'created_at'
                            }
                        ],

                    });
                }
            }

            function LessonDatatable() {
                if (!$.fn.dataTable.isDataTable('#LessonDatatable')) {
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

                        columns: [{
                                data: 'courseName',
                                name: 'course.courseName'
                            },
                            {
                                data: 'fundamental_islam_name',
                                name: 'fundamental_islam.fundamental_islam_name'
                            },
                            {
                                data: 'memorizationname',
                                name: 'memorization.memorizationname'
                            },
                            {
                                data: 'ethicsname',
                                name: 'ethics.ethicsname'
                            },

                            {
                                data: 'accent',
                                name: 'student_lesson_new.accent',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'comments',
                                name: 'student_lesson_new.comments'
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
                }
            }



            function feedbackDatatable() {
                if (!$.fn.dataTable.isDataTable('#feedbackDatatable')) {
                    var feedbackDataTable = $('#feedbackDatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#feedbackDatatable').attr('data-link'),
                            data: {
                                id: '{{ $targetStudent->id }}'
                            }
                        },

                        columns: [{
                                data: 'employeename',
                                name: 'employees.employeename',
                                sWidth: '50%'
                            },
                            {
                                data: 'question1',
                                name: 'question1',
                            },
                            {
                                data: 'question2',
                                name: 'question2',
                            },
                            {
                                data: 'question3',
                                name: 'question3',
                            },
                            {
                                data: 'question4',
                                name: 'question4',
                            },

                            {
                                data: 'question5',
                                name: 'question5',
                            },
                            {
                                data: 'average',
                                name: 'average',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'feedback',
                                name: 'feedbackAboutTeacher.feedback'
                            },
                            {
                                data: 'created_at',
                                name: 'feedbackAboutTeacher.created_at'
                            }
                        ]
                    });
                }
            }

            function acdemichistoryDatatable() {
                if (!$.fn.dataTable.isDataTable('#acdemichistoryDatatable')) {
                    var acdemichistoryDatatable = $('#acdemichistoryDatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#acdemichistoryDatatable').attr('data-link'),
                            data: {
                                id: '{{ $targetStudent->id }}'
                            }
                        },

                        columns: [

                            {
                                data: 'employeename',
                                name: 'employees.employeename',

                            },
                            {
                                data: 'previosstatustext',
                                name: 'previosstatustext',
                            },
                            {
                                data: 'statustext',
                                name: 'statustext',
                            },
                            {
                                data: 'reason',
                                name: 'reason.reason',
                            },
                            {
                                data: 'description',
                                name: 'academicstatuschange.description',
                            },
                            {
                                data: 'created_new',
                                name: 'academicstatuschange.created_new',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'creatorname',
                                name: 'users.name',
                            },
                        ]
                    });
                }
            }

            function teacherchangehistoryDatatable() {
                if (!$.fn.dataTable.isDataTable('#teacherchangehistoryDatatable')) {
                    var teacherchangehistoryDatatable = $('#teacherchangehistoryDatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#teacherchangehistoryDatatable').attr('data-link'),
                            data: {
                                id: '{{ $targetStudent->id }}'
                            }
                        },

                        columns: [{
                                data: 'oldteachername',
                                name: 'oldteacher.oldteachername',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'newteachername',
                                name: 'newteacher.newteachername',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'reason',
                                name: 'reason.reason',
                            },
                            {
                                data: 'description',
                                name: 'teacherchange.description',
                            },
                            {
                                data: 'createt_at_new',
                                name: 'teacherchange.created_at',
                            },
                            {
                                data: 'creatorname',
                                name: 'users.name',
                            },
                        ]
                    });
                }
            }

            function studentnewCommentDatatable() {
                if (!$.fn.dataTable.isDataTable('#student-new-comment-datatable')) {

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
                            data: {
                                id: '{{ $targetStudent->id }}'
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
                }
            }

            function dayschangehistoryDatatable() {
                if (!$.fn.dataTable.isDataTable('#dayschangehistoryDatatable')) {
                    var dayschangehistoryDatatable = $('#dayschangehistoryDatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#dayschangehistoryDatatable').attr('data-link'),
                            data: {
                                id: '{{ $targetStudent->id }}'
                            }
                        },

                        columns: [{
                                data: 'teacherprofile',
                                name: 'teacherprofile',
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
                                data: 'createt_at_new',
                                name: 'studentDayshistory.created_at',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'creatorname',
                                name: 'users.name',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });
                }
            }

            function studenttaskdatatable() {
                if (!$.fn.dataTable.isDataTable('#studenttaskdatatable')) {
                    var AssingTable = $('#studenttaskdatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#studenttaskdatatable').attr('data-link'),
                            data: {
                                id: '{{ $targetStudent->id }}'
                            }
                        },

                        columns: [

                            {
                                data: 'Groupusers',
                                name: 'Groupusers',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'subjectlink',
                                name: 'subjectlink',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'taskName',
                                name: 'taskName',
                                searchable: true,
                                visible: false
                            },
                            {
                                data: 'tasktype',
                                name: 'tasktype',
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
                                data: 'group',
                                name: 'student.group',
                                searchable: true,
                                visible: false
                            },
                            {
                                data: 'employeename',
                                name: 'employees.employeename',
                                searchable: true,
                                visible: false
                            },

                            {
                                data: 'shortdescription',
                                name: 'shortdescription',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'comment',
                                name: 'comment',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'taskCompleteddate',
                                name: 'taskCompleteddate'
                            },
                            {
                                data: 'taskCompletedtime',
                                name: 'taskCompletedtime'
                            },
                            {
                                data: 'Groupusersstatus',
                                name: 'Groupusersstatus',
                                orderable: false,
                                searchable: false
                            },



                            {
                                data: 'multi_student_group',
                                name: 'task.multi_student_group',
                                searchable: true,
                                visible: false
                            },
                        ],
                        "drawCallback": function(settings) {
                            var api = this.api();
                            var recordsTotal = this.api().page.info().recordsTotal;
                            $('.assignedtasktab').html(recordsTotal)
                            // Output the data for the visible rows to the browser's console
                            // console.log( api.rows( {page:'current'} ).data().length );

                            $('[data-toggle="popover"]').popover({
                                placement: 'top',
                                trigger: 'hover',
                                content: $('.myPopoverContent').html(),
                                html: true
                            });
                        }
                    });

                }
            }


            $(document).on("click", "#vert-tabs-tab a", function(e) {
                e.preventDefault();



              if ($(this).attr('href') == "#tab-example-6") {
                    studentattendanceDatatable();
                }


                setTimeout(function() {

                    LoadCalender()


                }, 1000);


            });
        });
    </script>
@endpush
