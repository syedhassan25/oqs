@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet"
    href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css" />
<style>
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
</style>
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <a href="#" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;&nbsp;Add
                More Student</a></h2>
        <p><strong><b>{{ $subTitle }}</b></strong></p>
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
                                <form id="formstudent" action="{{ route('admin.student.updatenewform') }}" method="POST"
                                    role="form">
                                    @csrf
                                    <div class="panel">
                                        <div class="panel-body">

                                            <div class="example-box-wrapper">
                                                <ul class="list-group list-group-separator row list-group-icons">
                                                    <li class="col-md-3 active">
                                                        <a href="#tab-example-1" data-toggle="tab"
                                                            class="list-group-item">
                                                            <i class="glyph-icon font-red icon-bullhorn"></i>
                                                            Personal Profile
                                                        </a>
                                                    </li>
                                                    <li class="col-md-3">
                                                        <a href="#tab-example-2" data-toggle="tab"
                                                            class="list-group-item">
                                                            <i class="glyph-icon icon-dashboard"></i>
                                                            Schdule/Assign
                                                        </a>
                                                    </li>
                                                    <li class="col-md-3">
                                                        <a href="#tab-example-3" data-toggle="tab"
                                                            class="list-group-item">
                                                            <i class="glyph-icon font-primary icon-camera"></i>
                                                            Lesson Details
                                                        </a>
                                                    </li>
                                                    <li class="col-md-3">
                                                        <a href="#tab-example-4" data-toggle="tab"
                                                            class="list-group-item">
                                                            <i class="glyph-icon font-blue-alt icon-globe"></i>
                                                            Status History
                                                        </a>
                                                    </li>


                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade active in" id="tab-example-1">
                                                    <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Group No<span
                                                                            class="m-l-5 text-danger  errorlabelmy">
                                                                            *</span></label>
                                                                    <input type="text" value="{{old('groupno',$targetStudent->group)}}" name="groupno"
                                                                        placeholder="Group No" id="groupno"
                                                                        class="form-control name @error('groupno') is-invalid  @enderror" />


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
                                                                        value="{{old('name',$targetStudent->studentname)}}"
                                                                        name="name" placeholder="Name"
                                                                        class="form-control name @error('name') is-invalid  @enderror" />

                                                                    <input type="hidden" name="id"
                                                                        value="{{$targetStudent->id}}" />

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Father Name <span
                                                                            class="m-l-5 text-danger  errorlabelmy">
                                                                            *</span></label>
                                                                    <input type="text"
                                                                        value="{{old('fathername',$targetStudent->fathername)}}"
                                                                        name="fathername" placeholder="Father Name"
                                                                        class="form-control fathername @error('fathername') is-invalid  @enderror" />

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Age <span class="text-danger">@error('age')
                                                                            {{ $message }} @enderror</span></label>
                                                                    <input type="text"
                                                                        value="{{old('age',$targetStudent->age)}}"
                                                                        name="age" placeholder="Age"
                                                                        class="form-control @error('age') is-invalid  @enderror" />

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Gender <span
                                                                            class="text-danger">@error('gender')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    <div class="clearfix">
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio" id="radioPrimary1"
                                                                                name="gender" value="1"
                                                                                {{($targetStudent->gender == '') ? 'checked' : ''}}
                                                                                {{($targetStudent->gender == 1)?  'checked' : ''}}>
                                                                            <label for="radioPrimary1">
                                                                                Male
                                                                            </label>
                                                                        </div>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio" value="2"
                                                                                {{($targetStudent->gender == 2)?  'checked' : ''}}
                                                                                id="radioPrimary2" name="gender">
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
                                                                        value="{{old('contact_no',$targetStudent->contact_no)}}">
                                                                    <span class="text-danger">@error('contact_no')
                                                                        {{ $message }}
                                                                        @enderror</span>
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
                                                                        value="{{old('email',$targetStudent->studentemail)}}">
                                                                    <span class="text-danger">@error('email')
                                                                        {{ $message }}
                                                                        @enderror</span>


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
                                                                        <option selected="selected" value="">Select
                                                                            Country
                                                                        </option>
                                                                        @foreach($Country as $s)
                                                                        <option
                                                                            {{($targetStudent->country == $s->id )? 'selected' : ''}}
                                                                            data-curr="{{$s->currency}}"
                                                                              data-zone="{{$s->zone}}"
                                                                            value="{{$s->id}}">{{$s->CountryName}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>



                                                                    <span class="text-danger">@error('country')
                                                                        {{ $message }}
                                                                        @enderror</span>
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
                                                                        @foreach($timezones as $s)
                                                                        <option
                                                                            {{($targetStudent->timezone == $s['timezone'] )? 'selected' : ''}}
                                                                           data-timezone="{{$s['timezone']}}"
                                                                           
                                                                           
                                                                           
                                                                            value="{{$s['timezone']}}" >{{$s['name']}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>

                                                                    <input id="timezoneName" readonly
                                                                        class="form-control timezoneName @error('timezoneName') is-invalid @enderror"
                                                                        name="timezoneName"
                                                                        value="{{($targetStudent->timezone)? $targetStudent->timezone : 'Asia/Tashkent'}}"
                                                                        type="hidden">

                                                                    <span class="text-danger">@error('timezone')
                                                                        {{ $message }}
                                                                        @enderror</span>
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


                                                                            <select name="academicStatus"
                                                                        class="form-control @error('academicStatus') is-invalid @enderror">
                                                                        <option
                                                                            {{($targetStudent->academicStatus == '') ? 'selected' :''}}
                                                                            value="">Class Type</option>
                                                                        <option
                                                                            {{($targetStudent->academicStatus == '1') ? 'selected' :''}}
                                                                            value="1">Active</option>
                                                                        <option
                                                                            {{($targetStudent->academicStatus == '2') ? 'selected' :''}}
                                                                            value="2">InActive</option>
                                                                            <option
                                                                            {{($targetStudent->academicStatus == '3') ? 'selected' :''}}
                                                                            value="3">Leave</option>
                                                                            <option
                                                                            {{($targetStudent->academicStatus == '4') ? 'selected' :''}}
                                                                            value="4">Close</option>
                                                                            
                                                                             <option
                                                                            {{($targetStudent->academicStatus == '5') ? 'selected' :''}}
                                                                            value="5">Rejected</option>
                                                                             <option
                                                                            {{($targetStudent->academicStatus == '6') ? 'selected' :''}}
                                                                            value="6">Pending</option>
                                                                    </select>



                                                                    <span class="text-danger">@error('academicStatus')
                                                                        {{ $message }}
                                                                        @enderror</span>
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
                                                                        value="{{$Currency}}"
                                                                        class="form-control currencysymbol @error('currencysymbol') is-invalid @enderror"
                                                                        name="currencysymbol" type="text">



                                                                    <span class="text-danger">@error('currencysymbol')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>

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
                                                                        name="city" id="citydrop" style="width: 100%;">
                                                                        <option value="">Select City
                                                                        </option>
                                                                        @foreach($City as $s)
                                                                        <option
                                                                            {{($targetStudent->city == $s->id )? 'selected' : ''}}
                                                                            value="{{$s->id}}">{{$s->CityName}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>



                                                                    <span class="text-danger">@error('country')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Language (Multiple)</label>
                            <div class="select2-purple">
                                <select name="language[]" id="language" class="select2" multiple="multiple"
                                    data-placeholder="Select a language" data-dropdown-css-class="select2-purple"
                                    style="width: 100%;">
                                    @foreach($Language as $s)
                                    <option  @foreach($StudentLanguage as $p) @if($s->id == $p->language_id) selected="selected"@endif @endforeach value="{{$s->id}}">{{$s->languagename}}</option>
                                    @endforeach

                                </select>
                                <span class="text-danger">@error('language') {{ $message }}
                                    @enderror</span>
                            </div>
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
                                                                        value="{{$targetStudent->whatsapp}}"
                                                                        class="form-control  @error('whatsapp') is-invalid @enderror "
                                                                        name="whatsApp" type="text">



                                                                    <span class="text-danger">@error('whatsapp')
                                                                        {{ $message }}
                                                                        @enderror</span>
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
                                                                        value="{{$User->email}}"
                                                                        class="form-control email @error('loginemail') is-invalid @enderror "
                                                                        name="loginemail" type="text">
                                                                    <span class="text-danger">@error('loginemail')
                                                                        {{ $message }}
                                                                        @enderror</span>
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
                                                                        name="password" type="text">


                                                                    <span class="text-danger">@error('password')
                                                                        {{ $message }}
                                                                        @enderror</span>
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
                                                                        name="confirm-password" type="text">


                                                                    <span class="text-danger">@error('confirm-password')
                                                                        {{ $message }}
                                                                        @enderror</span>
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


                                                                    <input placeholder="Skype 1 " name="skype1"
                                                                        value="{{$targetStudent->skypid_1}}"
                                                                        class="form-control  @error('skype1') is-invalid @enderror "
                                                                        type="text">


                                                                    <span class="text-danger">@error('skype1')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Skype 2 <span
                                                                            class="m-l-5 text-danger  errorlabelmy">
                                                                            *</span></label>


                                                                    <input placeholder="skype2"
                                                                        value="{{$targetStudent->skypid_2}}"
                                                                        class="form-control  @error('skype2') is-invalid @enderror "
                                                                        name="skype2" type="text">


                                                                    <span class="text-danger">@error('skype2')
                                                                        {{ $message }}
                                                                        @enderror</span>
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
                                                                            {{($targetStudent->joining_source == '') ? 'selected' : '' }}
                                                                            value="">Select
                                                                            Resource</option>
                                                                        <option
                                                                            {{($targetStudent->joining_source == '1') ? 'selected' : '' }}
                                                                            value="1">Marketing/Advertisement
                                                                        </option>
                                                                        <option
                                                                            {{($targetStudent->joining_source == '2') ? 'selected' : '' }}
                                                                            value="2">Reference</option>

                                                                    </select>



                                                                    <span class="text-danger">@error('resource')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row"
                                                            style="display:{{($targetStudent->joining_source == 1 ) ? 'block' : 'none' }}">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Marketing Agencies </label>


                                                                    <select
                                                                        class="marketingagencies select2 @error('marketingagencies') is-invalid @enderror "
                                                                        name="marketingagencies" style="width: 100%;">
                                                                        <option value="">Select
                                                                            Marketing Agencies</option>
                                                                        @foreach($Agencies as $a)
                                                                        <option
                                                                            {{($targetStudent->agency_id == $a->id) ? 'selected' : ''}}
                                                                            value="{{$a->id}}">{{$a->agencyname}}
                                                                        </option>
                                                                        @endforeach

                                                                    </select>



                                                                    <span
                                                                        class="text-danger">@error('marketingagencies')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row"
                                                            style="display:{{($targetStudent->joining_source == 2 ) ? 'block' : 'none' }}">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Reference Name </label>
                                                                    <input placeholder="Reference Name"
                                                                        value="{{$targetStudent->ref_name}}"
                                                                        class="form-control referencename @error('referencename') is-invalid @enderror "
                                                                        name="referencename" type="text">
                                                                    <span class="text-danger">@error('referencename')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Reference Email </label>
                                                                    <input placeholder="Reference Email"
                                                                        value="{{$targetStudent->ref_email}}"
                                                                        class="form-control referenceemail @error('referenceemail') is-invalid @enderror "
                                                                        name="referenceemail" type="text">
                                                                    <span class="text-danger">@error('referenceemail')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="display:none" class="row">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Joining Date </label>
                                                                    <input placeholder="Joining Date"
                                                                        data-date-format="mm/dd/yy"
                                                                        class="form-control bootstrap-datepicker joiningdate @error('joiningdate') is-invalid @enderror "
                                                                        name="joiningdate" type="text"
                                                                        value="{{$targetStudent->joining_date}}">
                                                                    <span class="text-danger">@error('joiningdate')
                                                                        {{ $message }}
                                                                        @enderror</span>
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


                                                                    <textarea name="detail"
                                                                        class="form-control @error('detail') is-invalid @enderror">{{old('detail',$targetStudent->detail)}}</textarea>



                                                                    <span class="text-danger">@error('detail')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab-example-2">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Days <span class="text-danger">@error('days')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    <div class="select2-purple">
                                                                        <select name="days[]" id="daysDrp"
                                                                            class="select2" multiple="multiple"
                                                                            data-placeholder="Select a days"
                                                                            data-dropdown-css-class="select2-purple"
                                                                            style="width: 100%;">

                                                                            <option value="1">Monday
                                                                            </option>
                                                                            <option value="2">Tuesday</option>
                                                                            <option value="3">Wednesday
                                                                            </option>
                                                                            <option value="4">Thursday</option>
                                                                            <option value="5">Friday
                                                                            </option>
                                                                            <option value="6">Saturday</option>
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
                                                                            class="text-danger">@error('studenttime')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    <div class="row seven-cols studenttimepickerdiv">


                                                                    </div>





                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="row localtimepickerdivparent" style="display:none">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Local Time <span
                                                                            class="text-danger">@error('localtime')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    <div class="row seven-cols localtimepickerdiv">


                                                                    </div>





                                                                </div>
                                                            </div>


                                                        </div>
                                                    
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Class Type <span
                                                                            class="text-danger">@error('classtype')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    <select name="classtype"
                                                                        class="form-control @error('classtype') is-invalid @enderror">
                                                                        <option {{($targetStudent->class_type == '') ? 'selected' :''}} value="">Class Type</option>
                                                                        <option {{($targetStudent->class_type == '1') ? 'selected' :''}} value="1">Trial</option>
                                                                        <option {{($targetStudent->class_type == '2') ? 'selected' :''}} value="2">Regular</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Duration <span
                                                                            class="text-danger">@error('duration')
                                                                            {{ $message }}
                                                                            @enderror</span></label>



                                                                            <select name="duration"
                                                                        class="form-control @error('duration') is-invalid @enderror">
                                                                        <option {{($targetStudent->duration == '') ? 'selected' :''}} value="">Duration</option>
                                                                        <option {{($targetStudent->duration == '10') ? 'selected' :''}} value="10">10</option>
                                                                        <option {{($targetStudent->duration == '15') ? 'selected' :''}} value="15">15</option>
                                                                        <option {{($targetStudent->duration == '20') ? 'selected' :''}} value="20">20</option>
                                                                        <option {{($targetStudent->duration == '30') ? 'selected' :''}} value="30">30</option>
                                                                        <option {{($targetStudent->duration == '45') ? 'selected' :''}} value="45">45</option>
                                                                        <option {{($targetStudent->duration == '60') ? 'selected' :''}} value="60">60</option>
                                                                    </select>


                                                                    

                                                                </div>
                                                            </div>



                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Assign <span
                                                                            class="text-danger ">@error('teacherassign')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    <select name="teacherassign"
                                                                        class="form-control teacherassign @error('teacherassign') is-invalid @enderror">
                                                                        <option
                                                                            {{( old('teacherassign',$targetStudent->teacher_assign_status) == '') ? 'selected' :''}}
                                                                            value="">Select Teacher assign</option>
                                                                        <option
                                                                            {{( old('teacherassign',$targetStudent->teacher_assign_status) == '1') ? 'selected' :''}}
                                                                            value="1">Teacher assign</option>
                                                                        <option
                                                                            {{( old('teacherassign',$targetStudent->teacher_assign_status) == '2') ? 'selected' :''}}
                                                                            value="2">Teacher assign Schdule</option>


                                                                    </select>

                                                                </div>
                                                            </div>




                                                        </div>

                                                        <div class="row" style="display:{{($targetStudent->teacher_assign_status == 2 ) ? 'block' : 'none' }}">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Schdule date <span
                                                                            class="text-danger">@error('teacherscduledate')
                                                                            {{ $message }}
                                                                            @enderror</span></label>

                                                                    <input type="text" id="teacherscduledate" name="teacherscduledate"
                                                                        class="form-control bootstrap-datepicker"
                                                                        value="" />

                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Schdule Time <span
                                                                            class="text-danger">@error('teacherscduletime')
                                                                            {{ $message }}
                                                                            @enderror</span></label>

                                                                    <input type="text" id="teacherscduletime" name="teacherscduletime"
                                                                        class="form-control"
                                                                        value="" />

                                                                </div>
                                                            </div>


                                                        </div>

                                                      <div class="row" style="display:{{($targetStudent->teacher_assign_status == 1 ) ? 'block' : 'none' }}">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Country<span
                                                                            class="text-danger">@error('selectteachercountry')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                            
                                                                    <select style="width: 100%;" id="selectteachercountry" class="form-control select2 @error('selectteachercountry') is-invalid @enderror">
                                                                       <option selected="selected" value="">Select
                                                                            Country
                                                                        </option>
                                                                        @foreach($Country as $s)
                                                                            <option value="{{$s->id}}">{{$s->CountryName}}
                                                                            </option>
                                                                        @endforeach
                                                                     
                                                                    </select>

                                                                </div>



                                                         


                                                            </div>
                                                             <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Language<span
                                                                            class="text-danger">@error('selectteacherlanguage')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                            
                                                                    <select id="selectteacherlanguage" 
                                                                    
                                                                  
                                                                            class="select2" 
                                                                            data-placeholder="Select a language"
                                                                            data-dropdown-css-class="select2-purple"
                                                                            style="width: 100%;"
                                                                    
                                                                    class="form-control @error('selectteacherlanguage') is-invalid @enderror">
                                                                      
                                                                        @foreach($Language as $s)
                                                                            <option value="{{$s->id}}">{{$s->languagename}}
                                                                            </option>
                                                                            @endforeach
                                                                     
                                                                    </select>

                                                                </div>



                                                          


                                                            </div>
                                                        </div>
                                                        <div class="row" style="display:{{($targetStudent->teacher_assign_status == 1 ) ? 'block' : 'none' }}">
                                                            <div class="col-sm-8">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher <span
                                                                            class="text-danger">@error('teacherid')
                                                                            {{ $message }}
                                                                            @enderror</span></label>

                                                                    <select name="teacherid"  id="selectnewteacher" 
                                                                        class="form-control @error('teacherid') is-invalid @enderror">
                                                                        <option value="">Select Teacher</option>
                                                                       

                                                                    </select>

                                                                </div>
                                                            </div>

                                                             <div class="col-sm-2">
                                                                
                                                                <button class="btn btn-info btn-block btnsearchteachertime">Search </button>
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


                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Requirement <span
                                                                            class="text-danger">@error('teacherrequirement')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    <textarea name="teacherrequirement"
                                                                        class="form-control @error('teacherrequirement') is-invalid @enderror">{{$targetStudent->teacher_requirement }}</textarea>

                                                                </div>
                                                            </div>




                                                        </div>


                                                    </div>
                                                    <div class="tab-pane fade" id="tab-example-3">

                                                        <div class="row">
                                                            <h3>Lesson List <button
                                                                    class="btn btn-primary pull-right addLessonbtn">Add
                                                                    Lesson</button></h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <table id="LessonDatatable"
                                                                    data-link="{{route('admin.student.lesson.lessondatatable')}}"
                                                                    class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Subject</th>
                                                                            <th>End to Start/ Start to End</th>
                                                                            <th>Average</th>
                                                                            <th>From page to page</th>
                                                                            <th>from ayah/line to line</th>
                                                                            <th>Memorization</th>
                                                                            <th>Memorization details</th>
                                                                            <th>Akscent Type</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>


                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="tab-pane fade " id="tab-example-4">
                                                    <div class="row">
                                                            <h3>Feedback</h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <table id="feedbackDatatable"
                                                                    data-link="{{route('admin.student.teacher.feedbackdatatable')}}"
                                                                    class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Teacher</th>
                                                                            <th>feedback</th>
                                                                            <th>Date</th>
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


                          

                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
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

<!-- Modal -->
<div id="LessonModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="formlessonstudent" action="{{ route('admin.student.lesson.save') }}" method="POST" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Subject <span class="text-danger">@error('subject')
                                        {{ $message }}
                                        @enderror</span></label>


                                <select name="subject" class="form-control @error('subject') is-invalid @enderror">
                                    <option value="">Select Subject</option>
                                    @foreach($Subject as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="student_id" value="{{$targetStudent->id}}" />
                                <input type="hidden" name="id" value="" />
                            </div>
                        </div>

                    </div>

                    <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <!-- text input -->
                                                                        <div class="form-group">
                                                                            <label>Chapter <span
                                                                                    class="text-danger">@error('chapter')
                                                                                    {{ $message }}
                                                                                    @enderror</span></label>

                                                                            <input placeholder="Chapter"
                                                                                class="form-control frompage @error('chapter') is-invalid @enderror "
                                                                                name="chapter" type="number">


                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>From page To page <span class="text-danger">@error('frompage')
                                        {{ $message }}
                                        @enderror</span></label>

                                <input placeholder="From page To page"
                                    class="form-control frompage @error('frompage') is-invalid @enderror "
                                    name="frompage" type="text">


                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>From Ayah/line to line<span class="text-danger">@error('fromayah')
                                        {{ $message }}
                                        @enderror</span></label>
                                <input placeholder="From Ayah/line to line"
                                    class="form-control fromayah @error('fromayah') is-invalid @enderror "
                                    name="fromayah" type="text">


                            </div>
                        </div>

                    </div>
                  
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Start Lesson <span class="text-danger">@error('startlesson')
                                        {{ $message }}
                                        @enderror</span></label>

                                <select name="startlesson"
                                    class="form-control @error('startlesson') is-invalid @enderror">
                                    <option value="">Select Start Lesson</option>
                                    <option value="1">Start TO End</option>
                                    <option value="2">End TO Start</option>

                                </select>


                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Average <span class="text-danger">@error('average')
                                        {{ $message }}
                                        @enderror</span></label>

                                <input placeholder="Average"
                                    class="form-control frompage @error('average') is-invalid @enderror " name="average"
                                    type="text">


                            </div>
                        </div>

                    </div>

                  
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">

                                <label>Memorization <span class="text-danger">@error('memorization')
                                        {{ $message }}
                                        @enderror</span></label>
                                <select name="memorization"
                                    class="form-control @error('memorization') is-invalid @enderror">
                                    <option value="">Select Memorization</option>
                                    <option value="1">yes</option>
                                    <option value="2">No</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Memorization Details <span class="text-danger">@error('memorizationdetail')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="memorizationdetail"
                                    class="form-control @error('memorizationdetail') is-invalid @enderror"></textarea>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">

                                <label>Method <span class="text-danger">@error('accent_type')
                                        {{ $message }}
                                        @enderror</span></label>
                                <select name="accent_type"
                                    class="form-control @error('accent_type') is-invalid @enderror">
                                    <option value="">Select Accent</option>
                                    <option value="1">Asian</option>
                                    <option value="2">Arabic</option>
                                </select>

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
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker-demo.js') }}"></script>

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>


<script type="text/javascript"
    src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"> </script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
</script>


<script type="text/javascript">
$(document).ready(function() {
    $('.loading-spinner').css("display", "none");
    $('.select2').select2();
    
 


window.dayTimming = {};

function setTimeStudenttime(element,index){
            var today = new Date();

                var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();



                var dateTime = date + ' ' + element;




             
//                 let studenttime = new Date(toTimeZone(dateTime, $('#timezoneName').val() ));
//                 let localtimeget =   toTimeZone(date + ' ' + studenttime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent');
//                 $('#localtime' + index).timepicker('setTime',new Date(localtimeget));

// console.log('studenttime',studenttime)
// console.log('localtimeget',localtimeget)


                // console.log($('#timezoneName').val())

                // console.log(toTimeZone(dateTime, $('#timezoneName').val()));

                $('#studenttime' + index).timepicker('setTime', new Date(toTimeZone(dateTime, $('#timezoneName')
                    .val())));
    }

    @if(count($student_days) > 0)
    let day_arrrrr = '{{$student_days->pluck("student_day_no")->implode(",")}}';
    $('#daysDrp').val(day_arrrrr.split(',')).trigger('change');

    console.log('{{$student_days}}')
    let html = "";
    let htmlstudentime = "";
    let dayinners = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
    day_arrrrr =  day_arrrrr.split(',');
    if (day_arrrrr) {
           @foreach($student_days as $index => $val)
           
               html += `<div class="col-md-1">
                     <label for="" class="col-sm-4 control-label"><select name="localtimeday[]" >`;
                     
                     
                      dayinners.forEach(function(item,i) {
                            let daynooo= i+1;
                            
                           let selValday = (daynooo == '{{$val->day_no}}') ? 'selected' : ''; 
                            
                            html += `<option ${selValday}  value="${daynooo}">${item}</option>`
                      });
                     
                     
                    
                
                html += `</select></label><div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="localtimeday[]" id="localtimeday{{$index}}"  value="{{$val->day_no}}" type="hidden">
                       <input name="localtime[]" readonly id="localtime{{$index}}"  value="{{$val->local_time_text}}" data-index="{{$index}}" class="timepicker-local localtimeclass form-control" type="text">
                      </div>
                      </div>
                      </div>
                      </div>`;



                         var obj = {
                            'studenttime' : '{{$val->student_time_text}}',
                            'localtime' : '{{$val->local_time_text}}',
                            'dataindex' :  '{{$index}}',
                            'day_no':'{{$val->day_no}}'
                        }
                      window.dayTimming[days_name(parseInt('{{$val->student_day_no}}'))] =  obj;
                     

                htmlstudentime += `<div class="col-md-1 studenttimeclassparent">
                     <label for="" class="col-sm-4 control-label">${days_name(parseInt('{{$val->student_day_no}}'))}</label>
                     <div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="studenttimeday[]" id="studenttimeday{{$index}}" value="{{$val->student_day_no}}" type="hidden">
                       <input name="studenttime[]" id="studenttime{{$index}}" value="{{$val->student_time_text}}"  data-index="{{$index}}" class="timepicker-student studenttimeclass form-control" type="text">
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
                console.log(text);
            }
        });
        $('.timepicker-student').timepicker({
            minuteStep: 5,
        });


        // $('.localtimeclass').each(function(i){
        //   let index =  $(this).attr('data-index')
        //   let element =  $(this).val();

        //     setTimeStudenttime(element,index)
        // })

        console.log(window.dayTimming)



    @endif
    
    
    
     @if(count($student_days) > 0)
    
        setTimeout(function(){ 
            
             let day_arrrrrnew = '{{$student_days->pluck("student_day_no")->implode(",")}}';
            $('#daysDrp').val(day_arrrrrnew.split(',')).trigger('change');
            
        }, 1000);
       
     @endif
    


    @if($targetStudent->joining_date != '0000-00-00' && $targetStudent->joining_date != '')
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',

    }).datepicker("update", '{{$targetStudent->joining_date}}');;
    @else

    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',

    }).datepicker("update", new Date());;
    @endif

    @if($targetStudent->teacheSchduledate != '0000-00-00' && $targetStudent->teacheSchduledate != '')
    $('#teacherscduledate').datepicker({
        format: 'yyyy-mm-dd',

    }).datepicker("update", '{{$targetStudent->teacheSchduledate}}');;
    @else

    $('#teacherscduledate').datepicker({
        format: 'yyyy-mm-dd',

    }).datepicker("update", new Date());;
    @endif

    @if($targetStudent->teacheSchduletime != '')
                var today = new Date();
                var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();
                var dateTime = date + ' ' + '{{$targetStudent->teacheSchduletime}}';
                $('#teacherscduletime').timepicker('setTime', new Date(dateTime));
    @else

   
    @endif



    
    

    $('#teacherscduletime').timepicker();

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
           
            $('#currencysymbol').val(val);
            
             var zone = $(this).find('option:selected').attr('data-zone');
           $('#timezonedrp').val(zone).trigger('change')
 console.log('ssss',val,'zone',zone)
            var val = $(this).val();
            var url = '{{ route("city.load.country", ":id") }}';
            url = url.replace(':id', val);

            $.get(url, function(res) {

                let html = "<option value=''>Select City</option>"
                $.each(res, function($i, $val) {
                    console.log($val)
                    html += `<option value="${$val['id']}">${$val['CityName']}</option>`;
                })
                $('#citydrop').html(html)

            })


    })

    $(document).on('click', '.addLessonbtn', function(e) {

        e.preventDefault();


        $(`#formlessonstudent input[name="id"]`).val('')
        $(`#formlessonstudent select[name="subject"]`).val('');
        $(`#formlessonstudent select[name="startlesson"]`).val('')
        $(`#formlessonstudent input[name="average"]`).val('')
        $(`#formlessonstudent input[name="frompage"]`).val('')
        $(`#formlessonstudent input[name="fromayah"]`).val('')
        $(`#formlessonstudent select[name="memorization"]`).val('')
        $(`#formlessonstudent textarea[name="memorizationdetail"]`).val('')
        $(`#formlessonstudent select[name="accent_type"]`).val('');

        $('#LessonModal').modal('show');


    })

    $(document).on('change', '#timezonedrp', function() {
        // attr('data-curr');


        var val = $(this).find('option:selected').attr('data-timezone');
        console.log(val)
        $('#timezoneName').val(val)


    })


    $(document).on('change', '#daysDrp', function() {
        // attr('data-curr');

        if($('#timezoneName').val() == ""){
            $('#daysDrp').val('');
            toastr.info('Please Must Select  First','Timezone');
            return;
            }

        var days = $(this).val();

        console.log(days)
        let html = "";
        let htmlstudentime = "";
let dayinners = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
        if (days) {
            $.each(days, function(index, value) {
                
                
                
                 let getlocaltime = '';
                let getstudenttime  = '';
                let day_no = '';
                if(window.dayTimming[days_name(parseInt(value))]){
                      let   valueday = window.dayTimming[days_name(parseInt(value))];
                      
                      getlocaltime = valueday.localtime;
                      getstudenttime = valueday.studenttime;
                      
                      day_no = valueday.day_no
                      
                      console.log(getlocaltime,'',getstudenttime)
                }
                
                
                 html += `<div class="col-md-1">
                     <label for="" class="col-sm-4 control-label"><select name="localtimeday[]" >`;
                     
                     
                      dayinners.forEach(function(item,i) {
                            let daynooo= i+1;
                            
                           let selValday = (daynooo == day_no) ? 'selected' : ''; 
                            
                            html += `<option ${selValday}  value="${daynooo}">${item}</option>`
                      });
                     
                     
                    
                
                html += `</select></label><div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="localtime[]" readonly id="localtime${index}" value="${getlocaltime}"  data-index="${index}" class="timepicker-local localtimeclass form-control" type="text">
                      </div>
                      </div>
                      </div>
                      </div>`;


                htmlstudentime += `<div class="col-md-1 studenttimeclassparent">
                     <label for="" class="col-sm-4 control-label">${days_name(parseInt(value))}</label>
                     <div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="studenttimeday[]" id="studenttimeday${index}" value="${value}" type="hidden">
                       <input name="studenttime[]" id="studenttime${index}" value="${getstudenttime}"  data-index="${index}" class="timepicker-student studenttimeclass form-control" type="text">
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
                console.log(text);
            }
        });
        $('.timepicker-student').timepicker({
            minuteStep: 5,
        });

        // $('.localtimeclass').each(function(i){
        //    let index =  $(this).attr('data-index')
        //    let element =  $(this).val();

        //     setTimeStudenttime(element,index)
        // })

    });



    function toTimeZone(time, zone) {
        var format = 'YYYY/MM/DD HH:mm:ss A';
        var format2 = 'YYYY/MM/DD hh:mm a';


        return moment(time, format).tz(zone).format(format2);

        // return moment.tz(time,zone).format('YYYY-MM-DD HH:mm:ss');
    }

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

    
    $(document).on("change", ".localtimeclass", function(e) {
        var element = $(this).val();

        var index = $(this).attr('data-index');

        // setTimeStudenttime(element,index)
        //    console.log('')
    });

    $(document).on("change", ".studenttimeclass", function(e) {

        e.preventDefault();
        var element = $(this).val();
        var index = $(this).attr('data-index');
        var day = `${days_name(parseInt($(`#studenttimeday${index}`).val()))}`;
     

        var today = new Date();

        var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();

         console.log('day',window.dayTimming)

         var dateTime = date + ' ' + element;



         let nows = moment.utc();
        let anothertimezone = moment.tz.zone($('#timezoneName').val()).offset(nows)
        let pak = moment.tz.zone("Asia/Tashkent").offset(nows);
        let hours  = (anothertimezone - pak)/60;
        let minutes =  anothertimezone - pak;

        console.log('timedifference hours',minutes)

        let changetimezone = toTimeZoneHouradd(dateTime, $('#timezoneName').val(),minutes );
        let studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a');
        if (minutes > 0) {

        //   studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a') ;
        
         studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('hh:mm a') ;
        
          console.log('changetimezone convert', moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
        }else{
            minutes = Math.abs(minutes)
        //   studenttime  =  moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a');
        
         studenttime  =  moment(changetimezone).subtract(minutes, 'minutes').format('hh:mm a');
        
            console.log('changetimezone convert', moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
        }
       
        // $('#localtime' + index).timepicker('setTime',new Date(studenttime));
        
        $('#localtime' + index).timepicker('setTime',studenttime);




                // Object.keys(window.dayTimming).forEach(item => {
                //       if(item == day){
                //            dateTime = date + ' ' + window.dayTimming[item].studenttime;

                //            console.log(item,'loop date dateTime',window.dayTimming[item].studenttime)
                //       }
                // });
       

        // var dateTime = date + ' ' + element;
        // console.log('oute loop date dateTime',dateTime)
        // let studenttime = new Date(toTimeZone(dateTime, $('#timezoneName').val() ));
        // let localtimeget =   toTimeZone(date + ' ' + studenttime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent');
        // $('#localtime' + index).timepicker('setTime',new Date(localtimeget));


        // console.log('studettime', studenttime)
        //  console.log('localtimeget', localtimeget)

        // $('#localtime' + index).timepicker('setTime', new Date(toTimeZone(dateTime, $('#timezoneName')
        //     .val())));
        //    console.log('')
    });




    $()

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

    let url  = '{{route("admin.teacher.search")}}';
    
    let daytime = [];
    $('.localtimeclass').each(function(){
       daytime.push($(this).val())
    })
    let day = []
    $("select[name='localtimeday[]']").each(function() {
         day.push($(this).val())
     });
    let duration =  $("select[name='duration']").val();
     let language =  $("#selectteacherlanguage").val();
      let country =  $("#selectteachercountry").val();
    
    if(day.length > 0 && daytime.length > 0 && duration != "" ){
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
           data: {day:day,daytime:daytime,duration:duration,language:language,country:country},
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
         
         console.log(data)
            if (data.error) {
                
            }

            if (data.success) {
                $('#selectnewteacher').html('')
               let res =  data.freeteacher;
                  let html = "<option value=''>Select Teachers</option>"
                    $.each(res, function($i, $val) {
                        console.log($val)
                        html += `<option value="${$val['teacher_id']}">${$val['teachername']}</option>`;
                    })
                   $('#selectnewteacher').html(html)
                
                console.log(res)
            }
        })
        .fail(function(data) {
            console.log(data);

        });
    }else{
        toastr.info('please must set student timing and duration then search')
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
                required: true,
                minlength: 2,
            },
            age: {
                required: true,

            },
            gender: {
                required: true,

            },
            contact_no: {
                required: true,

            },

            email: {
                required: true,
                minlength: 2,
            },
            country: {
                required: true,

            },
            city: {
                required: true,

            },
            timezone: {
                required: true,
                minlength: 1,
            },
            currencysymbol: {
                required: true,

            },
            resource: {
                required: true,

            },
            joiningdate: {
                required: true,

            },
            detail: {
                required: true,

            },
            classTime: {
                required: true,

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
            'days[]': {
                required: true,

            },
            'studenttime[]': {
                required: true,

            },
            'localtime[]': {
                required: true,

            },

            subject: {
                required: true
            },
            startlesson: {
                required: true
            },
            average: {
                required: true
            },
            frompage: {
                required: true
            },
            fromayah: {
                required: true
            },
            memorization: {
                required: true
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
                success: function(data) {
                    alert('Success')
                },
                error: function(data) {
                    alert('Error')
                }
            });
        }
    });
});



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
            data:{id:'{{$targetStudent->id}}'}
        },

        columns: [{
                data: 'subjectName',
                name: 'subject.subjectName'
            },
            {
                data: 'start_to_from',
                name: 'student_lesson.start_to_from',
                orderable: false,
                searchable: false
            },
            {
                data: 'average',
                name: 'student_lesson.average'
            },
            {
                data: 'page_to_from',
                name: 'student_lesson.page_to_from'
            },
            {
                data: 'ayah_line',
                name: 'student_lesson.ayah_line'
            },
            {
                data: 'memorization',
                name: 'student_lesson.memorization'
            },
            {
                data: 'memorization_detail',
                name: 'student_lesson.memorization_detail'
            },
            {
                data: 'accent',
                name: 'student_lesson.accent',
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
            data:{id:'{{$targetStudent->id}}'}
        },

        columns: [{
                data: 'employeename',
                name: 'employees.employeename'
            },
            {
                data: 'feedback',
                name: 'feedbackAboutTeacher.feedback',
            },
            
            {
                data: 'created_at',
                name: 'feedbackAboutTeacher.created_at'
            }
        ]
    });


    
});


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
            console.log(data);
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
                $('#LessonModal').modal('hide');
                $('#LessonDatatable').DataTable().draw(true);

            }
        })
        .fail(function(data) {
            console.log(data);

        });
});

$(document).on('click', '.btneditleson', function() {
    var id = $(this).attr('data-id');

    var route = '{{ route("admin.student.lesson.edit", ":id") }}';

    route = route.replace(':id', id);

    $.get(route, {}, function(res) {


        $(`#formlessonstudent input[name="id"]`).val(res.id)
        $(`#formlessonstudent select[name="subject"]`).val(res.subject_id);
        $(`#formlessonstudent select[name="startlesson"]`).val(res.start_to_end)
        $(`#formlessonstudent input[name="average"]`).val(res.average)
        $(`#formlessonstudent input[name="frompage"]`).val(res.page_to_from)
        $(`#formlessonstudent input[name="fromayah"]`).val(res.ayah_line)
        $(`#formlessonstudent select[name="memorization"]`).val(res.memorization)
        $(`#formlessonstudent textarea[name="memorizationdetail"]`).val(res.memorization_detail)
        $(`#formlessonstudent select[name="accent_type"]`).val(res.accent_type);

        $('#LessonModal').modal('show');
    })


})

$(document).on('click', '.teacherassign', function() {

var value = $(this).val();
console.log(value);
$('#formstudent input[name="teacherscduledate"]').closest('.row').hide();
$('#formstudent select[name="teacherid"]').closest('.row').hide();


if (value == 1) {
    $('#formstudent input[name="teacherscduledate"]').closest('.row').hide();
    $('#formstudent select[name="teacherid"]').closest('.row').show();
} else if(value == 2) {
    $('#formstudent input[name="teacherscduledate"]').closest('.row').show();
    $('#formstudent select[name="teacherid"]').closest('.row').hide();
}
})


setTimeout(function(){ 
    
     @if($targetStudent->country)
     $('#countrydrp').val('{{$targetStudent->country}}').trigger('change')
    @endif 
    
}, 3000);

  
</script>
@endpush