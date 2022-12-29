@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
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
l
.fa {
    font-size: 16px;
}

.checked {
    color: orange;
}
.btnrating{
    padding:5px
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
    margin-right:10px !important; 
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
</style>
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} </h2>
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
                                <form id="formstudent" action="{{ route('qualitycontrolpanel.student.update') }}" method="POST"
                                    role="form">
                                    @csrf
                                    <div class="panel">
                                        <div class="panel-body">

                                            <div class="example-box-wrapper">
                                                <ul class="list-group list-group-separator row list-group-icons">
                                                    <li class="col-md-2 active">
                                                        <a href="#tab-example-1" data-toggle="tab"
                                                            class="list-group-item">
                                                            <i class="glyph-icon font-red icon-bullhorn"></i>
                                                            Personal Profile
                                                        </a>
                                                    </li>
                                                    <li class="col-md-2">
                                                        <a href="#tab-example-2" data-toggle="tab"
                                                            class="list-group-item">
                                                            <i class="glyph-icon icon-dashboard"></i>
                                                            Schdule/Assign
                                                        </a>
                                                    </li>
                                                    <li class="col-md-2">
                                                        <a href="#tab-example-3" data-toggle="tab"
                                                            class="list-group-item">
                                                            <i class="glyph-icon font-primary icon-camera"></i>
                                                            Lesson Details
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
                                                                    <input type="text"
                                                                        value="{{old('groupno',$targetStudent->group)}}"
                                                                        name="groupno" placeholder="Group No"
                                                                        id="groupno"
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
                                                                            value="{{$s['timezone']}}">{{$s['name']}}
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
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Academic Status <span
                                                                            class="m-l-5 text-danger  errorlabelmy">
                                                                            *</span></label>

                                                                    <input type="hidden" name="oldacademicStatus"
                                                                        class="oldacademicStatus"
                                                                        value="{{$targetStudent->academicStatus}}">
                                                                    <select id="academicStatusChange"
                                                                        name="academicStatus"
                                                                        class="form-control @error('academicStatus') is-invalid @enderror">
                                                                        <option
                                                                            {{($targetStudent->academicStatus == '') ? 'selected' :''}}
                                                                            value="">Class Type</option>
                                                                        <option
                                                                        @foreach($academicStatusArr as $s)
                                                                        <option
                                                                            {{($targetStudent->academicStatus == $s->academic_status_val )? 'selected' : ''}}
                                                                           
                                                                            value="{{$s->academic_status_val}}">{{$s->academic_status}}
                                                                        </option>
                                                                        @endforeach
                                                                        
                                                                    </select>



                                                                    <span class="text-danger">@error('academicStatus')
                                                                        {{ $message }}
                                                                        @enderror</span>
                                                                </div>
                                                            </div>
                                                          

                                                            <!-- academicStatusModal Start -->
                                                            <div id="academicStatusModal" class="modal fade" role="dialog"  data-backdrop="static" data-keyboard="false">
                                                                <div class="modal-dialog">
                                                                
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close btncloseacademicStatus" >&times;</button>
                                                                                <h4 class="modal-title">Academic Status Change Reason</h4>
                                                                            </div>

                                                                            <div class="modal-body">


                                                                              <div class="row">
                                                                                    <div class="col-sm-9">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <input placeholder="Reason"
                                                                                                class="form-control reasontxt @error('reasontxt') is-invalid @enderror " name="reasontxt"
                                                                                                type="text">


                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <!-- text input -->
                                                                                    <button type="button" id="btnaddRffffeason" class="btn btn-primary">Add Reason</button>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <label>Reason <span class="text-danger">@error('subject')
                                                                                                    {{ $message }}
                                                                                                    @enderror</span></label>


                                                                                            <select name="reason" id="reasonselect" class="form-control @error('reason') is-invalid @enderror">
                                                                                                <option value="">Select Reason</option>
                                                                                                @foreach($reason as $data)
                                                                                                <option value="{{$data->id}}">
                                                                                                    {{$data->reason}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <label>Details <span class="text-danger">@error('reasondetail')
                                                                                                    {{ $message }}
                                                                                                    @enderror</span></label>

                                                                                            <textarea id="reasondetail" name="reasondetail"
                                                                                                class="form-control @error('reasondetail') is-invalid @enderror"></textarea>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                              
                                                                            
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger btn-block btncloseacademicStatus">Cancel</button>
                                                                                <button type="button" id="btnsavereason" class="btn btn-primary btn-block">Save</button>


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
                                                                        <select name="language[]" id="language"
                                                                            class="select2" multiple="multiple"
                                                                            data-placeholder="Select a language"
                                                                            data-dropdown-css-class="select2-purple"
                                                                            style="width: 100%;">
                                                                            @foreach($Language as $s)
                                                                            <option @foreach($StudentLanguage as $p)
                                                                                @if($s->id == $p->language_id)
                                                                                selected="selected"@endif @endforeach
                                                                                value="{{$s->id}}">{{$s->languagename}}
                                                                            </option>
                                                                            @endforeach

                                                                        </select>
                                                                        <span class="text-danger">@error('language')
                                                                            {{ $message }}
                                                                            @enderror</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                      


                                                      

                                                        <div class="row">
                                                            <div class="col-sm-12">
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

                                                                    <label>Days    <span class="text-danger">@error('days')
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
                                                                        <option
                                                                            {{($targetStudent->class_type == '') ? 'selected' :''}}
                                                                            value="">Class Type</option>
                                                                        <option
                                                                            {{($targetStudent->class_type == '1') ? 'selected' :''}}
                                                                            value="1">Trial</option>
                                                                        <option
                                                                            {{($targetStudent->class_type == '2') ? 'selected' :''}}
                                                                            value="2">Regular</option>
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
                                                                       
                                                                       
                                                                       @foreach($durationArr as $s)
                                                                        <option
                                                                            {{(old('duration') == $s->durationVal )? 'selected' : ''}}
                                                                           
                                                                            value="{{$s->durationVal}}">{{$s->durationVal}}
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

                                                                    <label>Assigned Teacher <span
                                                                            class="text-danger">@error('teachername')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                           
                                                                           
                                                                    <input type="hidden" id="teacherassign"  name="teacherassign" value="1" />       
                                                                    <input type="hidden" id="selectoldteacher"  name="oldteacher" value="{{$targetStudent->teacher_id}}" />
                                                                     <input type="hidden" id="selectoldteachername"  name="oldteachername" value="{{$teachername}}" />
                                                                    <input type="hidden" id="studentteacherid"
                                                                        name="teacherid" class="form-control"
                                                                        value="{{$targetStudent->teacher_id}}" />
                                                                        
                                                                        <input type="text" id="teachername" readonly
                                                                        name="teachername" class="form-control"
                                                                        value="{{$teachername}}" />

                                                                </div>



                                                          


                                                            </div>

                                                           


                                                        </div>
                                                        
                                                         <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Assigned Type </label>
                                                                           
                                                            <select name="teacherassigntype" id="teacherassigntype"  class="form-control @error('teacherassigntype') is-invalid @enderror">
                                                                    
                                                                        <option value="1">Regular</option>
                                                                        <option value="2">Temporary</option>
                                                                    </select>
                                                                    
                                                                </div>



                                                          


                                                            </div>

                                                           


                                                        </div>
                                                        <div class="row" style="display:none">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Temporary Assigned Type </label>
                                                                           
                                                            <select name="teachertemporaryassigntype" id="teachertemporaryassigntype"  class="form-control @error('teachertemporaryassigntype') is-invalid @enderror">
                                                                    
                                                                        <option value="1">Automatic</option>
                                                                        <option value="2">Manual</option>
                                                                    </select>
                                                                    
                                                                </div>



                                                          


                                                            </div>

                                                           


                                                        </div>
                                                        
                                                         <div class="row" style="display:none">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Reschdule Student To Old Teacher Date <span
                                                                            class="text-danger">@error('reAssignStudenToOldTeacher')
                                                                            {{ $message }}
                                                                            @enderror</span></label>

                                                                    <input type="text" id="reAssignStudenToOldTeacher" name="reAssignStudenToOldTeacher"
                                                                        class="form-control bootstrap-datepicker"
                                                                        value="" />

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Reschdule Student To Old Teacher Time <span
                                                                            class="text-danger">@error('reAssignStudenToOldTeachertime')
                                                                            {{ $message }}
                                                                            @enderror</span></label>

                                                                    <input type="text" id="reAssignStudenToOldTeachertime" name="reAssignStudenToOldTeachertime"
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
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Search New Teachers <span
                                                                            class="text-danger">@error('selectnewteacher')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                            
                                                                    <select name="selectnewteacher" id="selectnewteacher" class="form-control @error('selectnewteacher') is-invalid @enderror">
                                                                        <option  value="">Select Teacher</option>
                                                                     
                                                                    </select>

                                                                </div>



                                                            <!-- teacherchangeModal Start -->
                                                            <div id="teacherchangeModal" class="modal fade" role="dialog">
                                                                <div class="modal-dialog">
                                                                
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                              
                                                                                <h4 class="modal-title">Teacher Change Reason</h4>
                                                                            </div>

                                                                            <div class="modal-body">


                                                                            <div class="row">
                                                                                    <div class="col-sm-9">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <input placeholder="Reason"
                                                                                                class="form-control teacherreasontxt @error('teacherreasontxt') is-invalid @enderror " name="teacherreasontxt"
                                                                                                type="text">


                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <!-- text input -->
                                                                                    <button type="button" id="btnaddteacherttttReason" class="btn btn-primary">Add Reason</button>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <label>Reason <span class="text-danger">@error('subject')
                                                                                                    {{ $message }}
                                                                                                    @enderror</span></label>


                                                                                            <select name="teacherreason" id="teacherreasonselect" class="form-control @error('teacherreasonselect') is-invalid @enderror">
                                                                                                <option value="">Select Reason</option>
                                                                                                @foreach($reason as $data)
                                                                                                <option value="{{$data->id}}">
                                                                                                    {{$data->reason}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <label>Details <span class="text-danger">@error('teacherreasondetail')
                                                                                                    {{ $message }}
                                                                                                    @enderror</span></label>

                                                                                            <textarea name="teacherreasondetail"
                                                                                                class="form-control @error('teacherreasondetail') is-invalid @enderror"></textarea>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                  <button type="button" id="btnteachercancel" class="btn btn-danger btn-block">Cancel</button>

                                                                                <button type="button" id="btnsaveteacherreason" class="btn btn-primary btn-block">Save</button>
                                                                               

                                                                            </div>

                                                                        </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <!-- teacherchangeModal End -->



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
                                                              
                                                                
                                                                
                                                                   <table id="LessonDatatable" data-link="{{route('qualitycontrolpanel.student.lesson.lessondatatable')}}"
                            class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Fundamental islam</th>
                                    <th>Memorization</th>
                                    <th>Ethics</th>
                                    <th>Accent Type</th>
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
                                    </div>




                                    <button type="submit" id="btnformsubmitstudent" class="btn btn-primary btn-block">Save</button>
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
                       
                        <div style="display:none"  class="row managementDivStudent">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Group <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="group" id="SelectGroup" style="width: 100%;"> 
                                            <option value="">Select Group</option>
                                            @foreach($groupdata as $group)
                                               <option value="{{$group}}">{{$group}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Students<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select class="select2 form-control groupstudent" multiple="multiple" name="groupstudent[]" style="width: 100%;"> 
                                            <option value="">Select Student</option>
                                           
                                            </select>
                                </div>
                            </div>
                        </div>
                         <div style="display:none"  class="row managementDivTeacher">
                            <div class="col-sm-12">
                                <!-- text input -->

                             <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="managementteacher" id="SelectTeacherMangement" style="width: 100%;"> 
                                            <option value="">Select Teahcer</option>
                                            @foreach($teacherdata as $teacher)
                                               <option value="{{$teacher->id}}">{{$teacher->employeename}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                          
                        </div>

                        <div  style="display:none" class="row teacherDiv">
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="teacher" id="SelectTeacher" style="width: 100%;"> 
                                            <option value="">Select Teahcer</option>
                                            @foreach($teacherdata as $teacher)
                                               <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Students<span class="m-l-5 text-danger  errorlabelmy">*</span></label>
                                    <select class="select2 form-control teacherstudent" name="teacherstudent" style="width: 100%;"> 
                                            <option value="">Select Student</option>
                                           
                                            </select>
                                </div>
                            </div>
                        </div>
                          <div  style="display:none" class="row teacherDivother">
                            <div class="col-sm-12">
                                <!-- text input -->

                                <div class="form-group">
                                    <label>Teacher <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                            <select class="select2 form-control" name="teacherother" id="SelectTeacherother" style="width: 100%;"> 
                                            <option value="">Select Teahcer</option>
                                            @foreach($teacherdata as $teacher)
                                               <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endforeach
                                            </select>

                                </div>

                            </div>
                           
                        </div>
                        
                         <div  style="display:none" class="row managementDiv">

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
                         <div class="row" >
                            <div class="col-sm-6">
                                <!-- text input -->

                                <div class="form-group">
                                    
                                       <input type="checkbox"  name="IsImportantchk" id="IsImportantchk" >
                                       <label>&nbsp;&nbsp;Urgent <span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                          <input type="hidden" value="0" name="isImportant" class="isImportanttxt" >

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
                                    <input type="text" value="" name="completeddate" placeholder="Completed Date"
                                        class="form-control bootstrap-datepicker">

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
                                        <textarea   cols="80" id="editor1" name="note" rows="10" class="form-control note " name="note"></textarea>

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



<div id="LessonModalNEw" class="modal fade" role="dialog">
    <div style="width:1250px !important" class="modal-dialog modal-lg">
        <form id="formlessonstudentnew" action="{{ route('qualitycontrolpanel.student.lesson.save') }}"  method="POST" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Lesson</h4>
                </div>

                <div class="modal-body">
                     <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Course </label>

                                <input type="hidden" name="student_id" value="{{request()->route('id')}}" />
                                <input type="hidden" name="id" value="" />
                                 <input type="hidden" name="teacher_id" value="" />
                                
                                
                                <select name="course" id="coursetype" class="form-control @error('course') is-invalid @enderror">
                                    <option value="">Select Course</option>
                                    @foreach($course as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->courseName}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('course')
                                        {{ $message }}
                                        @enderror</span>
                              
                            </div>
                        </div>
                         <div class="col-sm-6">
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
                     <div class="row courserenderDiv" style="display:none" data-coursetype="1">
                         <div class="quransection"> 
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran Subject </label>


                                <select name="quransubject" class="form-control @error('quransubject') is-invalid @enderror">
                                    <option value="">Select Quran Subject</option>
                                    @foreach($Subjectquran as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('quransubject')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>JuzNumber/chapter </label>

                                <input type="number" name="quranjuznumber"  class="form-control @error('quranjuznumber') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranjuznumber')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranstartpage"  class="form-control @error('quranstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranendpage"  class="form-control @error('quranendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranstartaya"  class="form-control @error('quranstartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranstartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranendaya"  class="form-control @error('quranendaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranendaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="qurancomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran comments </label>

                                <textarea name="qurancomments"
                                    class="form-control @error('qurancomments') is-invalid @enderror"></textarea>
<span class="text-danger">@error('qurancomments')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="2">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran Hifz Subject <span class="text-danger">@error('quranhifzsubject')
                                        {{ $message }}
                                        @enderror</span></label>


                                <select name="quranhifzsubject" class="form-control @error('quranhifzsubject') is-invalid @enderror">
                                    <option value="">Select Quran Hifz</option>
                                    @foreach($quranhifz as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Page Line <span class="text-danger">@error('quranhifzpageline')
                                        {{ $message }}
                                        @enderror</span></label>


                              <input type="text" name="quranhifzpageline"
                                    class="form-control @error('quranhifzpageline') is-invalid @enderror" />
                               
                            </div>
                        </div>
                        
                        <div class="rowsabaq">
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Sabaq </label>


                                <input type="text" readonly value="Sabaq" name="quranhifzsabaq"  class="form-control @error('quranhifzsabaq') is-invalid @enderror" />
                               <span class="text-danger">@error('quranhifzsabaq')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Juz Number </label>

                                <input type="number" name="quranhifzsabaqjuznumber"  class="form-control @error('quranhifzsabaqjuznumber') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqjuznumber')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranhifzsabaqstartpage"  class="form-control @error('quranhifzsabaqstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranhifzsabaqendpage"  class="form-control @error('quranhifzsabaqendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranhifzsabaqstartaya"  class="form-control @error('quranhifzsabaqstartaya') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqstartaya')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranhifzsabaqendaya"  class="form-control @error('quranhifzsabaqendaya') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqendaya')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                        <div class="rowsabaqi">
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Sabaqi </label>


                                <input type="text" readonly value="Sabaqi" name="quranhifzsabaqi"  class="form-control @error('quranhifzsabaqi') is-invalid @enderror" />
                               <span class="text-danger">@error('quranhifzsabaqi')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Juz Number </label>

                                <input type="number" name="quranhifzsabaqijuznumber"  class="form-control @error('quranhifzsabaqijuznumber') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqijuznumber')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranhifzsabaqistartpage"  class="form-control @error('quranhifzsabaqistartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqistartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranhifzsabaqiendpage"  class="form-control @error('quranhifzsabaqiendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqiendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranhifzsabaqistartaya"  class="form-control @error('quranhifzsabaqistartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqistartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranhifzsabaqiendaya"  class="form-control @error('quranhifzsabaqiendaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqiendaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                        <div class="rowmanzil">
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Manzil </label>


                                <input type="text" readonly value="Manzil" name="quranhifzmanzil"  class="form-control @error('quranhifzmanzil') is-invalid @enderror" />
                               <span class="text-danger">@error('quranhifzmanzil')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Juz Number </label>

                                <input type="number" name="quranhifzmanziljuznumber"  class="form-control @error('quranhifzmanziljuznumber') is-invalid @enderror" />
                                <span class="text-danger">@error('quranhifzmanziljuznumber')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranhifzmanzilstartpage"  class="form-control @error('quranhifzmanzilstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranhifzmanzilendpage"  class="form-control @error('quranhifzmanzilendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranhifzmanzilstartaya"  class="form-control @error('quranhifzmanzilstartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilstartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranhifzmanzilendaya"  class="form-control @error('quranhifzmanzilendaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilendaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="quranhifzcomm">
                            <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran Hifz comments <span class="text-danger">@error('quranhifzcomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="quranhifzcomments"
                                    class="form-control @error('quranhifzcomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="3">
                         <div class="hadeethsection"> 
                         <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Hadeeth Subject </label>


                                <select name="hadeethsubject" class="form-control @error('hadeethsubject') is-invalid @enderror">
                                    <option value="">Select Hadeeth Subject</option>
                                    @foreach($SubjectHadeeth as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('hadeethsubject')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="hadeethstartpage"  class="form-control @error('hadeethstartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('hadeethstartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="hadeethendpage"  class="form-control @error('hadeethendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('hadeethendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="hadeethstartline"  class="form-control @error('hadeethstartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('hadeethstartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="hadeethendline"  class="form-control @error('hadeethendline') is-invalid @enderror" />
                        <span class="text-danger">@error('hadeethendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="hadeethcomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Hadeeth comments <span class="text-danger">@error('hadeethcomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="hadeethcomments"
                                    class="form-control @error('hadeethcomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="4">
                         <div class="qaidasection"> 
                         <div class="col-sm-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Qaida Subject </label>


                                <select name="qaidasubject" class="form-control @error('qaidasubject') is-invalid @enderror">
                                    <option value="">Select Qaida Subject</option>
                                    @foreach($SubjectQaida as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('qaidasubject')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Chapter / Lesson </label>

                                <input type="number" name="qaidachapterlesson"  class="form-control @error('qaidachapterlesson') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidachapterlesson')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="qaidastartpage"  class="form-control @error('qaidastartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidastartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="qaidaendpage"  class="form-control @error('qaidaendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('qaidaendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="qaidastartline"  class="form-control @error('qaidastartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidastartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="qaidaendline"  class="form-control @error('qaidaendline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidaendline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                         <div class="qaidacomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Qaida comments <span class="text-danger">@error('qaidacomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="qaidacomments"
                                    class="form-control @error('qaidacomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="5">
                         <div class="languagesection"> 
                         <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Langauges Subject </label>


                                <select name="languagesubject" class="form-control @error('languagesubject') is-invalid @enderror">
                                    <option value="">Select Langauges Subject</option>
                                    @foreach($SubjectLangauges as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('languagesubject')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="languagestartpage"  class="form-control @error('languagestartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('languagestartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="languageendpage"  class="form-control @error('languageendpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('languageendpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="languagestartline"  class="form-control @error('languagestartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('languagestartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="languageendline"  class="form-control @error('languageendline') is-invalid @enderror" />
                        <span class="text-danger">@error('languageendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="qaidacomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Language comments <span class="text-danger">@error('languagecomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="languagecomments"
                                    class="form-control @error('languagecomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Memorization <span class="text-danger">@error('memorizarion')
                                        {{ $message }}
                                        @enderror</span></label>


                                <select name="memorizarion" id="memorizariontype" class="form-control @error('memorizarion') is-invalid @enderror">
                                    <option value="">Select Memorizarion</option>
                                    @foreach($Memorizationdata as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->memorizationname}}</option>
                                    @endforeach
                                </select>
                              
                            </div>
                        </div>

                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="1">
                         <div class="kalmasection"> 
                         <div class="col-sm-5">
                            <!-- text input -->
                            <div class="form-group">
                                <label>kalma </label>


                                <select name="kalma" class="form-control @error('kalma') is-invalid @enderror">
                                      <option value="">Select Kalma</option>
                                      <option value="1">Kalma 1</option>
                                      <option value="2">Kalma 2</option>
                                      <option value="3">Kalma 3</option>
                                      <option value="4">Kalma 4</option>
                                      <option value="5">Kalma 5</option>
                                      <option value="6">Kalma 6</option>
                                </select>
                               <span class="text-danger">@error('kalma')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                      
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                <input type="number" name="kalmastartmark"  class="form-control @error('kalmastartmark') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('kalmastartmark')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-3">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                 <input type="number" name="kalmaendmark"  class="form-control @error('kalmaendmark') is-invalid @enderror" />
                        <span class="text-danger">@error('kalmaendmark')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                       
                        </div>
                        
                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="2">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Page No </label>
                                        
                                <input type="number" name="masnoonduapageno" class="form-control @error('masnoonduapageno') is-invalid @enderror" /> 
                                   
                               <span class="text-danger">@error('masnoonduapageno')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Dua No </label>
                                        
                                <input type="text" name="masnoonduaduano" class="form-control @error('masnoonduaduano') is-invalid @enderror" /> 
                                   
                               <span class="text-danger">@error('masnoonduaduano')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                       
                        
                       
                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="3">
                        <div class="col-sm-5">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Surah Name </label>
                                        
                                <input type="text" name="surahname" class="form-control @error('surahname') is-invalid @enderror" /> 
                                   
                               <span class="text-danger">@error('surahname')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="surahstartaya"  class="form-control @error('surahstartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('surahstartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-3">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="surahendaya"  class="form-control @error('surahendaya') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('surahendaya')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                       
                        
                       
                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="4">
                        <div class="col-sm-5">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Dua Name </label>
                                        
                                <input type="text" name="duaname" class="form-control @error('duaname') is-invalid @enderror" /> 
                                   <span class="text-danger">@error('duaname')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                <input type="number" name="duanamestartline"  class="form-control @error('duanamestartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('duanamestartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-3">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                 <input type="number" name="duanameendline"  class="form-control @error('duanameendline') is-invalid @enderror" />
                        <span class="text-danger">@error('duanameendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                       
                        
                       
                    </div>
                     <div class="row fundamentalislamDiv">
                         <div class="languagesection"> 
                         <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Fundamental Islam </label>


                                <select name="fundamentalislam" class="form-control @error('fundamentalislam') is-invalid @enderror">
                                    <option value="">Select Fundamental Islam</option>
                                    @foreach($Fundamentalislam as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->fundamental_islam_name}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('fundamentalislam')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="fundamentalislamstartpage"  class="form-control @error('fundamentalislamstartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('fundamentalislamstartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="fundamentalislamendpage"  class="form-control @error('fundamentalislamendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('fundamentalislamendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="fundamentalislamstartline"  class="form-control @error('fundamentalislamstartline') is-invalid @enderror" />
                        <span class="text-danger">@error('fundamentalislamstartline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="fundamentalislamendline"  class="form-control @error('fundamentalislamendline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('fundamentalislamendline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                        
                    </div>
                     <div class="row ethicsDiv">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Ethics </label>


                                <select name="ethics" id="ethicstype" class="form-control @error('ethics') is-invalid @enderror">
                                    <option value="">Select Ethics</option>
                                    @foreach($Ethicsdata as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->ethicsname}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('ethics')
                                        {{ $message }}
                                        @enderror</span>
                              
                            </div>
                        </div>
                          <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="ethicsstartpage"  class="form-control @error('ethicsstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="ethicsendpage"  class="form-control @error('ethicsendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="ethicsstartline"  class="form-control @error('ethicsstartline') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsstartline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="ethicsendline"  class="form-control @error('ethicsendline') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>

                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Comments <span class="text-danger">@error('comments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="comments"
                                    class="form-control @error('comments') is-invalid @enderror"></textarea>

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
                    <button type="button" id="btnsavelessonnew" class="btn btn-primary btn-block">Save</button>


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


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>


<script type="text/javascript"
    src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"> </script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
</script>

<script src="https://cdn.jsdelivr.net/gh/manuelmhtr/countries-and-timezones@latest/dist/index.js" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/fullcalender/main.js') }}" ></script>

<script type="text/javascript">
$(document).ready(function() {
    
    $('.timepicker-example').timepicker();
    
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

    // console.log('{{$student_days}}')
    let html = "";
    let htmlstudentime = "";
    day_arrrrr =  day_arrrrr.split(',');
    let dayinners = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
    if (day_arrrrr) {
           @foreach($student_days as $index => $val)
           
        //   console.log('$val->student_day_no','{{$val->student_day_no}}')
           
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
                // console.log(text);
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

        // console.log(window.dayTimming)



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
         var zone = $(this).find('option:selected').attr('data-zone');
           $('#timezonedrp').val(zone).trigger('change')
             
            // console.log(val)
            $('#currencysymbol').val(val);

            var val = $(this).val();
            var url = '{{ route("city.load.country", ":id") }}';
            url = url.replace(':id', val);

            $.get(url, function(res) {

                let html = "<option value=''>Select City</option>"
                $.each(res, function($i, $val) {
                    // console.log($val)
                    html += `<option value="${$val['id']}">${$val['CityName']}</option>`;
                })
                $('#citydrop').html(html)

            })


    })

       $(document).on('click', '.addLessonbtn', function(e) {

        e.preventDefault();
         
         
         $(`.courserenderDiv`).hide();
         $(`.memorizationrenderDiv`).hide();

         $(`#formlessonstudentnew input[name="id"]`).val('')
         $(`#formlessonstudentnew select`).val('');
         $(`#formlessonstudentnew input`).val('')
         $(`#formlessonstudentnew textarea`).val('')
         $(`#formlessonstudentnew input[name="quranhifzsabaq"]`).val('Sabaq')
         $(`#formlessonstudentnew input[name="quranhifzsabaqi"]`).val('Sabaqi')
         $(`#formlessonstudentnew input[name="quranhifzmanzil"]`).val('Manzil')
          $(`#formlessonstudentnew input[name="student_id"]`).val('{{request()->route("id")}}')
        //  $('#LessonModalNEw').modal('show');
        
        
         var id = '{{request()->route("id")}}';

        var route = '{{ route("qualitycontrolpanel.student.lesson.getlastlesson", ":id") }}';

        route = route.replace(':id', id);

          $.get(route, {}, function(res) {


            let coursid =  res.course_id;
            let memorizationid =  res.memorization_id;
                 $(`.courserenderDiv`).hide();
                 $(`.courserenderDiv[data-coursetype="${coursid}"]`).show();
                 if(coursid == '2'){
                     $(`.memorizationrenderDiv`).hide();
                       $(`#memorizariontype`).closest('.row').hide();
                       $(`#memorizariontype`).val('');
                 }else{
                       $(`#memorizariontype`).closest('.row').show();
                       $(`#memorizariontype`).val('');
                 }
                 
                 
                  $(`.memorizationrenderDiv`).hide();
                  if(coursid !=  '2'){
                     if(memorizationid != ""){
                  
                        $(`.memorizationrenderDiv[data-memorizationtype="${memorizationid}"]`).show();
                   }
                  }else{
                       $(`#memorizariontype`).closest('.row').hide();
                       $(`#memorizariontype`).val('');
                  }
            
               $(`#formlessonstudentnew select[name="course"]`).val(res.course_id);
               $(`#formlessonstudentnew input[name="id"]`).val('');
               $(`#formlessonstudentnew select[name="accent_type"]`).val(res.accent_type);
               $(`#formlessonstudentnew textarea[name="comments"]`).val(res.comments);
             $(`#formlessonstudentnew input[name="teacher_id"]`).val(res.teacher_id);
               
               
               
               
               if(coursid == 1){
               
                
                
               $(`#formlessonstudentnew select[name="quransubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="quranjuznumber"]`).val(res.juz_number);
               $(`#formlessonstudentnew input[name="quranstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="quranendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="quranstartaya"]`).val(res.startaya_course);
               $(`#formlessonstudentnew input[name="quranendaya"]`).val(res.endaya_course);
               $(`#formlessonstudentnew textarea[name="qurancomments"]`).val(res.comments_course);
               $(`#formlessonstudentnew select[name="startlesson"]`).val(res.startlesson);
                
                
             }
            
             if(coursid == 2){
               
             
                
                
               $(`#formlessonstudentnew select[name="quranhifzsubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="quranhifzpageline"]`).val(res.quranhifzpageline);
               $(`#formlessonstudentnew input[name="quranhifzsabaqjuznumber"]`).val(res.juz_number);
               $(`#formlessonstudentnew input[name="quranhifzsabaqstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqstartaya"]`).val(res.startaya_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqendaya"]`).val(res.endaya_course);
              
                
            
                
                
               $(`#formlessonstudentnew input[name="quranhifzsabaqijuznumber"]`).val(res.sabaqi_juz_number);
               $(`#formlessonstudentnew input[name="quranhifzsabaqistartpage"]`).val(res.sabaqi_start_page);
               $(`#formlessonstudentnew input[name="quranhifzsabaqiendpage"]`).val(res.sabaqi_end_page);
               $(`#formlessonstudentnew input[name="quranhifzsabaqistartaya"]`).val(res.sabaqi_start_aya);
               $(`#formlessonstudentnew input[name="quranhifzsabaqiendaya"]`).val(res.sabaqi_end_aya);
                
                
        
                
                
               $(`#formlessonstudentnew input[name="quranhifzmanziljuznumber"]`).val(res.manzil__juz_number);
               $(`#formlessonstudentnew input[name="quranhifzmanzilstartpage"]`).val(res.manzil_start_page);
               $(`#formlessonstudentnew input[name="quranhifzmanzilendpage"]`).val(res.manzil_end_page);
               $(`#formlessonstudentnew input[name="quranhifzmanzilstartaya"]`).val(res.manzil_start_aya);
               $(`#formlessonstudentnew input[name="quranhifzmanzilendaya"]`).val(res.manzil_end_aya);
                
                
                
               $(`#formlessonstudentnew textarea[name="quranhifzcomments"]`).val(res.comments_course);
                
                
                
             }
         
             if(coursid == 3){
                  
               $(`#formlessonstudentnew select[name="hadeethsubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="hadeethstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="hadeethendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="hadeethstartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="hadeethendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="hadeethcomments"]`).val(res.comments_course);
               
             } 
            
             if(coursid == 4){
                  

                
               $(`#formlessonstudentnew select[name="qaidasubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="qaidastartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="qaidaendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="qaidastartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="qaidaendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="qaidacomments"]`).val(res.comments_course);
                
                
            }
            
             if(coursid == 5){
                 
                 
               $(`#formlessonstudentnew select[name="languagesubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="languagestartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="languageendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="languagestartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="languageendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="languagecomments"]`).val(res.comments_course);
            
            
           }
               
               
               $(`#formlessonstudentnew select[name="fundamentalislam"]`).val(res.fundamental_islam_id);
               if(res.fundamental_islam_id){
                   $(`#formlessonstudentnew input[name="fundamentalislamstartpage"]`).val(res.startpage_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamendpage"]`).val(res.endpage_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamstartline"]`).val(res.startline_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamendline"]`).val(res.endline_fundamentalislam);
               }
               $(`#formlessonstudentnew select[name="memorizarion"]`).val(memorizationid);
               if(memorizationid){
                  
                   if(memorizationid == 1){
                   
                    $(`#formlessonstudentnew select[name="kalma"]`).val(res.kalma_no);
                    $(`#formlessonstudentnew input[name="kalmastartmark"]`).val(res.startmark);
                    $(`#formlessonstudentnew input[name="kalmaendmark"]`).val(res.endmark);
                    
                   }
                 if(memorizationid == 2){
                   
               
                    
                    $(`#formlessonstudentnew input[name="masnoonduapageno"]`).val(res.pageno_masnoondua);
                    $(`#formlessonstudentnew input[name="masnoonduaduano"]`).val(res.dua_no_masnoondua);
                    
                 }
                 if(memorizationid == 3){
                    
                    $(`#formlessonstudentnew input[name="surahname"]`).val(res.surah_name_shortsurah);
                    $(`#formlessonstudentnew input[name="surahstartaya"]`).val(res.startaya_shortsurah);
                    $(`#formlessonstudentnew input[name="surahendaya"]`).val(res.endaya_shortsurah);
                    
                 }
                 if(memorizationid == 4){
                  
                    
                    $(`#formlessonstudentnew input[name="duaname"]`).val(res.dua_Name_mainduas);
                    $(`#formlessonstudentnew input[name="duanamestartline"]`).val(res.startline_mainduas);
                    $(`#formlessonstudentnew input[name="duanameendline"]`).val(res.endline_mainduas);
                 }
                   
               }
               $(`#formlessonstudentnew select[name="ethics"]`).val(res.ethics_id);
               if(res.ethics_id){
                   $(`#formlessonstudentnew input[name="ethicsstartpage"]`).val(res.startpage_ethics);
                   $(`#formlessonstudentnew input[name="ethicsendpage"]`).val(res.endpage_ethics);
                   $(`#formlessonstudentnew input[name="ethicsstartline"]`).val(res.startline_ethics);
                   $(`#formlessonstudentnew input[name="ethicsendline"]`).val(res.endline_ethics);
               }
               
               
               
            // $(`#formlessonstudent input[name="id"]`).val(res.id)
            // $(`#formlessonstudent select[name="fundamentalislam"]`).val(res.fundamental_islam_id);
            // $(`#formlessonstudent select[name="memorizationLesson"]`).val(res.ethics_id)
            // $(`#formlessonstudent select[name="ethics"]`).val(res.memorization_id);
            // $(`#formlessonstudent input[name="chapter"]`).val(res.chapter)
            // $(`#formlessonstudent select[name="subject"]`).val(res.subject_id);
            // $(`#formlessonstudent select[name="startlesson"]`).val(res.start_to_end)
            // $(`#formlessonstudent input[name="average"]`).val(res.average)
            // $(`#formlessonstudent input[name="frompage"]`).val(res.page_to_from)
            // $(`#formlessonstudent input[name="fromayah"]`).val(res.ayah_line)
            // $(`#formlessonstudent select[name="memorization"]`).val(res.memorization)
            // $(`#formlessonstudent textarea[name="memorizationdetail"]`).val(res
            //     .memorization_detail)
            // $(`#formlessonstudent select[name="accent_type"]`).val(res.accent_type);

            $('#LessonModalNEw').modal('show');
        })
        


    })
       $(document).on('click', '#btnsavelessonnew', function(e) {
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
                url: $('#formlessonstudentnew').attr('action'),
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#formlessonstudentnew')[0])
            })
            .done(function(data) {
                // console.log(data);
                if (data.error) {
                    $.each(data.error, function(key, value) {
                        var input = `#formlessonstudentnew input[name="${key}"]`;
                        var inputtextarea = `#formlessonstudentnew textarea[name="${key}"]`;
                        var inputselect = `#formlessonstudentnew select[name="${key}"]`;
                        var inputselectid = `#formlessonstudentnew select[id="${key}"]`;
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
                    $('#formlessonstudentnew')[0].reset();
                    $('#LessonModalNEw').modal('hide');
                    $('#LessonDatatable').DataTable().draw(true);

                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });
       $(document).on('click', '.btneditleson', function() {
        var id = $(this).attr('data-id');
        
        $(`.courserenderDiv`).hide();
         $(`.memorizationrenderDiv`).hide();

         $(`#formlessonstudentnew input[name="id"]`).val('')
         $(`#formlessonstudentnew select`).val('');
         $(`#formlessonstudentnew input`).val('')
         $(`#formlessonstudentnew textarea`).val('')
         $(`#formlessonstudentnew input[name="quranhifzsabaq"]`).val('Sabaq')
         $(`#formlessonstudentnew input[name="quranhifzsabaqi"]`).val('Sabaqi')
         $(`#formlessonstudentnew input[name="quranhifzmanzil"]`).val('Manzil')
          $(`#formlessonstudentnew input[name="student_id"]`).val('{{request()->route("id")}}')

        var route = '{{ route("qualitycontrolpanel.student.lesson.edit", ":id") }}';

        route = route.replace(':id', id);

        $.get(route, {}, function(res) {


            let coursid =  res.course_id;
            let memorizationid =  res.memorization_id;
                 $(`.courserenderDiv`).hide();
                 $(`.courserenderDiv[data-coursetype="${coursid}"]`).show();
                 if(coursid == '2'){
                     $(`.memorizationrenderDiv`).hide();
                       $(`#memorizariontype`).closest('.row').hide();
                       $(`#memorizariontype`).val('');
                 }else{
                       $(`#memorizariontype`).closest('.row').show();
                       $(`#memorizariontype`).val('');
                 }
                 
                 
                  $(`.memorizationrenderDiv`).hide();
                  if(coursid !=  '2'){
                     if(memorizationid != ""){
                  
                        $(`.memorizationrenderDiv[data-memorizationtype="${memorizationid}"]`).show();
                   }
                  }else{
                       $(`#memorizariontype`).closest('.row').hide();
                       $(`#memorizariontype`).val('');
                  }
            
               $(`#formlessonstudentnew select[name="course"]`).val(res.course_id);
               $(`#formlessonstudentnew input[name="id"]`).val(res.id);
               $(`#formlessonstudentnew select[name="accent_type"]`).val(res.accent_type);
               $(`#formlessonstudentnew textarea[name="comments"]`).val(res.comments);
               $(`#formlessonstudentnew input[name="teacher_id"]`).val(res.teacher_id);
               
               
               if(coursid == 1){
               
                
                
               $(`#formlessonstudentnew select[name="quransubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="quranjuznumber"]`).val(res.juz_number);
               $(`#formlessonstudentnew input[name="quranstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="quranendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="quranstartaya"]`).val(res.startaya_course);
               $(`#formlessonstudentnew input[name="quranendaya"]`).val(res.endaya_course);
               $(`#formlessonstudentnew textarea[name="qurancomments"]`).val(res.comments_course);
               $(`#formlessonstudentnew select[name="startlesson"]`).val(res.startlesson);
                
                
             }
            
             if(coursid == 2){
               
             
                
                
               $(`#formlessonstudentnew select[name="quranhifzsubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="quranhifzpageline"]`).val(res.quranhifzpageline);
               $(`#formlessonstudentnew input[name="quranhifzsabaqjuznumber"]`).val(res.juz_number);
               $(`#formlessonstudentnew input[name="quranhifzsabaqstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqstartaya"]`).val(res.startaya_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqendaya"]`).val(res.endaya_course);
              
                
            
                
                
               $(`#formlessonstudentnew input[name="quranhifzsabaqijuznumber"]`).val(res.sabaqi_juz_number);
               $(`#formlessonstudentnew input[name="quranhifzsabaqistartpage"]`).val(res.sabaqi_start_page);
               $(`#formlessonstudentnew input[name="quranhifzsabaqiendpage"]`).val(res.sabaqi_end_page);
               $(`#formlessonstudentnew input[name="quranhifzsabaqistartaya"]`).val(res.sabaqi_start_aya);
               $(`#formlessonstudentnew input[name="quranhifzsabaqiendaya"]`).val(res.sabaqi_end_aya);
                
                
        
                
                
               $(`#formlessonstudentnew input[name="quranhifzmanziljuznumber"]`).val(res.manzil__juz_number);
               $(`#formlessonstudentnew input[name="quranhifzmanzilstartpage"]`).val(res.manzil_start_page);
               $(`#formlessonstudentnew input[name="quranhifzmanzilendpage"]`).val(res.manzil_end_page);
               $(`#formlessonstudentnew input[name="quranhifzmanzilstartaya"]`).val(res.manzil_start_aya);
               $(`#formlessonstudentnew input[name="quranhifzmanzilendaya"]`).val(res.manzil_end_aya);
                
                
                
               $(`#formlessonstudentnew textarea[name="quranhifzcomments"]`).val(res.comments_course);
                
                
                
             }
         
             if(coursid == 3){
                  
               $(`#formlessonstudentnew select[name="hadeethsubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="hadeethstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="hadeethendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="hadeethstartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="hadeethendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="hadeethcomments"]`).val(res.comments_course);
               
             } 
            
             if(coursid == 4){
                  

                
               $(`#formlessonstudentnew select[name="qaidasubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="qaidastartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="qaidaendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="qaidastartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="qaidaendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="qaidacomments"]`).val(res.comments_course);
                
                
            }
            
             if(coursid == 5){
                 
                 
               $(`#formlessonstudentnew select[name="languagesubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="languagestartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="languageendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="languagestartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="languageendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="languagecomments"]`).val(res.comments_course);
            
            
           }
               
               
               $(`#formlessonstudentnew select[name="fundamentalislam"]`).val(res.fundamental_islam_id);
               if(res.fundamental_islam_id){
                   $(`#formlessonstudentnew input[name="fundamentalislamstartpage"]`).val(res.startpage_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamendpage"]`).val(res.endpage_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamstartline"]`).val(res.startline_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamendline"]`).val(res.endline_fundamentalislam);
               }
               $(`#formlessonstudentnew select[name="memorizarion"]`).val(memorizationid);
               if(memorizationid){
                  
                   if(memorizationid == 1){
                   
                    $(`#formlessonstudentnew select[name="kalma"]`).val(res.kalma_no);
                    $(`#formlessonstudentnew input[name="kalmastartmark"]`).val(res.startmark);
                    $(`#formlessonstudentnew input[name="kalmaendmark"]`).val(res.endmark);
                    
                   }
                 if(memorizationid == 2){
                   
               
                    
                    $(`#formlessonstudentnew input[name="masnoonduapageno"]`).val(res.pageno_masnoondua);
                    $(`#formlessonstudentnew input[name="masnoonduaduano"]`).val(res.dua_no_masnoondua);
                    
                 }
                 if(memorizationid == 3){
                    
                    $(`#formlessonstudentnew input[name="surahname"]`).val(res.surah_name_shortsurah);
                    $(`#formlessonstudentnew input[name="surahstartaya"]`).val(res.startaya_shortsurah);
                    $(`#formlessonstudentnew input[name="surahendaya"]`).val(res.endaya_shortsurah);
                    
                 }
                 if(memorizationid == 4){
                  
                    
                    $(`#formlessonstudentnew input[name="duaname"]`).val(res.dua_Name_mainduas);
                    $(`#formlessonstudentnew input[name="duanamestartline"]`).val(res.startline_mainduas);
                    $(`#formlessonstudentnew input[name="duanameendline"]`).val(res.endline_mainduas);
                 }
                   
               }
               $(`#formlessonstudentnew select[name="ethics"]`).val(res.ethics_id);
               if(res.ethics_id){
                   $(`#formlessonstudentnew input[name="ethicsstartpage"]`).val(res.startpage_ethics);
                   $(`#formlessonstudentnew input[name="ethicsendpage"]`).val(res.endpage_ethics);
                   $(`#formlessonstudentnew input[name="ethicsstartline"]`).val(res.startline_ethics);
                   $(`#formlessonstudentnew input[name="ethicsendline"]`).val(res.endline_ethics);
               }
               
               
               
            // $(`#formlessonstudent input[name="id"]`).val(res.id)
            // $(`#formlessonstudent select[name="fundamentalislam"]`).val(res.fundamental_islam_id);
            // $(`#formlessonstudent select[name="memorizationLesson"]`).val(res.ethics_id)
            // $(`#formlessonstudent select[name="ethics"]`).val(res.memorization_id);
            // $(`#formlessonstudent input[name="chapter"]`).val(res.chapter)
            // $(`#formlessonstudent select[name="subject"]`).val(res.subject_id);
            // $(`#formlessonstudent select[name="startlesson"]`).val(res.start_to_end)
            // $(`#formlessonstudent input[name="average"]`).val(res.average)
            // $(`#formlessonstudent input[name="frompage"]`).val(res.page_to_from)
            // $(`#formlessonstudent input[name="fromayah"]`).val(res.ayah_line)
            // $(`#formlessonstudent select[name="memorization"]`).val(res.memorization)
            // $(`#formlessonstudent textarea[name="memorizationdetail"]`).val(res
            //     .memorization_detail)
            // $(`#formlessonstudent select[name="accent_type"]`).val(res.accent_type);

            $('#LessonModalNEw').modal('show');
        })


    })
    
    $(document).on('change','#coursetype',function(){
    
    let coursid =  $(this).val();
     $(`.courserenderDiv`).hide();
    if(coursid != ""){
         $(`.courserenderDiv[data-coursetype="${coursid}"]`).show();
         
         if(coursid == '2'){
             $(`.memorizationrenderDiv`).hide();
               $(`#memorizariontype`).closest('.row').hide();
               $(`#memorizariontype`).val('');
         }else{
               $(`#memorizariontype`).closest('.row').show();
               $(`#memorizariontype`).val('');
         }
    }
   
})

    $(document).on('change','#memorizariontype',function(){
    
    let memorizationid =  $(this).val();
    
    //   console.log(memorizationid)
      $(`.memorizationrenderDiv`).hide();
      let coursid = $('#coursetype').val();
      if(coursid !=  '2'){
         if(memorizationid != ""){
      
       
            $(`.memorizationrenderDiv[data-memorizationtype="${memorizationid}"]`).show();
       }
      }else{
           $(`#memorizariontype`).closest('.row').hide();
           $(`#memorizariontype`).val('');
      }
   
})


    $("input[type='number']").attr({
       "max" : 100000,        // substitute your own
       "min" : 1          // values (or variables) here
    });
    
    
    

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

        if($('#timezoneName').val() == ""){
            $('#daysDrp').val('');
            toastr.info('Please Must Select  First','Timezone');
            return;
            }

        var days = $(this).val();

        // console.log(days)
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
                      
                    //   console.log(getlocaltime,'',getstudenttime)
                }else{
                     day_no = value
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
                       <input name="localtime[]" readonly id="localtime${index}"   value="${getlocaltime}"  data-index="${index}" class="timepicker-local localtimeclass form-control" type="text">
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
        let hours  = (anothertimezone - pak)/60;
        let minutes =  anothertimezone - pak;

        // console.log('timedifference hours',minutes)

        let changetimezone = toTimeZoneHouradd(dateTime, $('#timezoneName').val(),minutes,'{{$timeChangeEuropeStatus}}');
        let studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a');
        if (minutes > 0) {

        //   studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a') ;
        
         studenttime  =  moment(changetimezone).add(minutes, 'minutes').format('hh:mm a') ;
        //   console.log('changetimezone convert', moment(changetimezone).add(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
        }else{
            minutes = Math.abs(minutes)
        //   studenttime  =  moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a');
        
           studenttime  =  moment(changetimezone).subtract(minutes, 'minutes').format('hh:mm a');
           
            // console.log('changetimezone convert', moment(changetimezone).subtract(minutes, 'minutes').format('YYYY/MM/DD hh:mm a'))
        }


        

       
        //old another time zone to pakistan
        // let localtimeget =   toTimeZone(date + ' ' + studenttime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent');
        


        let localtimeget =   toTimeZone(date + ' ' + studenttime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent');
        // $('#localtime' + index).timepicker('setTime',new Date(studenttime));
        
        $('#localtime' + index).timepicker('setTime',studenttime);


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

    let url  = '{{route("qualitycontrolpanel.teacher.search")}}';
    
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
         
        //  console.log(data)
            if (data.error) {
                
            }

            if (data.success) {
                $('#selectnewteacher').html('')
               let res =  data.freeteacher;
                  let html = "<option value=''>Select Teachers</option>"
                    $.each(res, function($i, $val) {
                        // console.log($val)
                        html += `<option value="${$val['teacher_id']}">${$val['teachername']}</option>`;
                    })
                   $('#selectnewteacher').html(html)
                
                // console.log(res)
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
            teacherassigntype:{
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
                  $("#btnformsubmitstudent").prop('disabled', true); // disable button
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
                id: '{{request()->route("id")}}'
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

  

    $(document).on('click', '.teacherassign', function() {

var value = $(this).val();
// console.log(value);
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

    $(document).on('change','#academicStatusChange',function(){
    let academicstatus  = $(this).val();
     let oldacademicStatus =   $('.oldacademicStatus').val();
     if((academicstatus != oldacademicStatus) && (academicstatus != "")  ){
         
        
            $('#academicStatusModal').modal('show');
     }

});
    $(document).on('click','.btncloseacademicStatus',function(e){
    
        let oldacademicStatus =   $('.oldacademicStatus').val();
        $('#academicStatusChange').val(oldacademicStatus);
        $('#reasonselect').val('');
        $('#reasondetail').val('');
        $('#academicStatusModal').modal('hide');
    
    });

    $(document).on('click','#btnaddRffffeason',function(e){
          e.stopImmediatePropagation();
            let reasontxt = $('.reasontxt').val();
            let _token  = $('meta[name="csrf-token"]').attr('content');
            console.log(reasontxt);
            $.post('{{route("admin.reason.storeajax")}}',{reasontxt:reasontxt,_token:_token},function(res){
                    console.log(res);
                   
                    $('#teacherreasonselect').html('')   
                    $('#reasonselect').html('')   
                        let html = '<option value="" >Select reason</option>'
                        $.each(res['reason'],function(i,val){
                            console.log(val['id'])
                            html += `<option value="${val['id']}" >${val['reason']}</option>`
                        });
                    $('#reasonselect').html(html);
                    $('#teacherreasonselect').html(html);
            })
})

    $(document).on('click','#btnsavereason',function(){



    let reasonselect = $('#reasonselect').val();
    let reasondetail = $('#reasondetail').val();

    if(reasonselect != ""){
            $('#academicStatusModal').modal('hide');
     }else{
        toastr.error('Please Must Select Reason', 'Error!')
     }

})

    $(document).on('click','#btnaddteacherttttReason',function(e){
    e.stopImmediatePropagation();
            let reasontxt = $('.teacherreasontxt').val();
            let _token  = $('meta[name="csrf-token"]').attr('content');
            console.log(reasontxt);
            $.post('{{route("admin.reason.storeajax")}}',{reasontxt:reasontxt,_token:_token},function(res){
                    console.log(res);

                    $('#teacherreasonselect').html('')   
                    $('#reasonselect').html('')   
                        let html = '<option value="" >Select reason</option>'
                        $.each(res['reason'],function(i,val){
                            console.log(val['id'])
                            html += `<option value="${val['id']}" >${val['reason']}</option>`
                        });
                    $('#reasonselect').html(html);
                    $('#teacherreasonselect').html(html);

                    
            })
})

    $(document).on('change','#selectnewteacher',function(){
    let selectnewteacher  = $(this).val();
     let selectoldteacher =   $('#selectoldteacher').val();
     if((selectnewteacher != selectoldteacher) && (selectnewteacher != "")  ){
         
            $('#studentteacherid').val($(this).val());
            $('#teachername').val($(this).find('option:selected').text());
            $('#teacherchangeModal').modal({
    backdrop: 'static',
    keyboard: false
});


     }else{
            let oldteacherid  = $('#selectoldteacher').val();
            let oldteachername  = $('#selectoldteachername').val();
            $('#studentteacherid').val(oldteacherid);
            $('#teachername').val(oldteachername);
     }


})

    $(document).on('click','#btnteachercancel',function(){
         $('#selectnewteacher').val('')
         $('#teacherchangeModal').modal('hide');
         
            let oldteacherid  = $('#selectoldteacher').val();
            let oldteachername  = $('#selectoldteachername').val();
            $('#studentteacherid').val(oldteacherid);
            $('#teachername').val(oldteachername);
            $('#teacherreasonselect').val('');
            $('#teacherreasondetail').val('');
         
    })



    $(document).on('click','#btnsaveteacherreason',function(){
   

    let reasonselect = $('#teacherreasonselect').val();
    let reasondetail = $('#teacherreasondetail').val();

    if(reasonselect != ""){
            $('#teacherchangeModal').modal('hide');
     }else{
        toastr.error('Please Must Select Reason', 'Error!')
     }


})

   

  
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
        
        
        
       
       
        
     
        

    
});







		









</script>
@endpush