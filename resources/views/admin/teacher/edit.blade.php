@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <style>
        .fa {
            font-size: 16px;
        }

        .checked {
            color: orange;
        }

        .btnrating {
            padding: 5px
        }
    </style>
    <link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css" />
    <div class="container">




        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $subTitle }} </h1>
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
                                    <form id="formteacher" action="{{ route('admin.teacher.update') }}" method="POST"
                                        role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-5 col-sm-3">
                                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab"
                                                    role="tablist" aria-orientation="vertical">

                                                    <a class="nav-link active" id="Profile-tab" data-toggle="pill"
                                                        href="#Profile" role="tab" aria-controls="Profile"
                                                        aria-selected="true">Profile</a>

                                                    <a class="nav-link" id="Student-tab" data-toggle="pill" href="#Student"
                                                        role="tab" aria-controls="Student"
                                                        aria-selected="true">Student</a>
                                                    <a class="nav-link" id="Feedback-tab" data-toggle="pill"
                                                        href="#Feedback" role="tab" aria-controls="Feedback"
                                                        aria-selected="false">Feedback</a>
                                                    <a class="nav-link" id="Finance-tab" data-toggle="pill" href="#Finance"
                                                        role="tab" aria-controls="Finance"
                                                        aria-selected="false">Finance</a>
                                                    <a class="nav-link" id="Leavetab-tab" data-toggle="pill"
                                                        href="#Leavetab" role="tab" aria-controls="Leavetab"
                                                        aria-selected="false">Leavetab</a>
                                                    <a class="nav-link" id="Otherstab-tab" data-toggle="pill"
                                                        href="#Otherstab" role="tab" aria-controls="Otherstab"
                                                        aria-selected="false">Other</a>




                                                </div>
                                            </div>
                                            <div class="col-7 col-sm-9">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="Profile">



                                                        <input name="id" value="{{ $targetTeacher->id }}"
                                                            type="hidden">
                                                        <input name="employee_id" value="{{ $targetTeacher->id }}"
                                                            type="hidden">
                                                        <input name="userid" value="{{ $targetTeacher->user_id }}"
                                                            type="hidden">

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Name </label>
                                                                    <input placeholder="Name"
                                                                        class="form-control @error('name') is-invalid @enderror "
                                                                        name="name"
                                                                        value="{{ $targetTeacher->employeename }}"
                                                                        type="text">
                                                                    <span class="text-danger">
                                                                        @error('name')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Father Name </label>
                                                                    <input placeholder="Father Name"
                                                                        class="form-control @error('fname') is-invalid @enderror "
                                                                        name="fname"
                                                                        value="{{ $targetTeacher->employeefathername }}"
                                                                        type="text">
                                                                    <span class="text-danger">
                                                                        @error('fname')
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
                                                                    <label>User Name </label>
                                                                    <input placeholder="username" readonly
                                                                        class="form-control @error('username') is-invalid @enderror "
                                                                        name="username" value="{{ $User->name }}"
                                                                        type="text">
                                                                    <span class="text-danger">
                                                                        @error('username')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Email </label>
                                                                    <input placeholder="Email"
                                                                        value="{{ $User->email }}" readonly
                                                                        class="form-control @error('email') is-invalid @enderror "
                                                                        name="email" type="text">
                                                                    <span class="text-danger">
                                                                        @error('email')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Password : <span
                                                                            class="passwordgenerateclass">{{ $User->password_text }}</span>
                                                                    </label>
                                                                    <input placeholder="Password"
                                                                        class="form-control @error('password') is-invalid @enderror "
                                                                        id="password" name="password" value=""
                                                                        type="text">
                                                                    <span class="text-danger">
                                                                        @error('password')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <!-- text input -->
                                                                <button type="button" style="margin-top: 23px;"
                                                                    class="btn btn-primary btnpasswordgenerate">Generate</button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Confirm Password </label>
                                                                    <input placeholder="Confirm Password" value=""
                                                                        id="confirmpassword"
                                                                        class="form-control @error('confirmpassword') is-invalid @enderror "
                                                                        name="confirmpassword" type="text">
                                                                    <span class="text-danger">
                                                                        @error('confirmpassword')
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
                                                                        <option selected="selected" value="">Select
                                                                            Resource
                                                                        </option>
                                                                        <option
                                                                            {{ $targetTeacher->resource_type == 1 ? 'selected' : '' }}
                                                                            value="1">Marketing/Advertisement</option>
                                                                        <option
                                                                            {{ $targetTeacher->resource_type == 2 ? 'selected' : '' }}
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
                                                            style="display:{{ $targetTeacher->resource_type == 1 ? 'block' : 'none' }}">
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Marketing Agencies </label>


                                                                    <select
                                                                        class="marketingagencies select2 @error('marketingagencies') is-invalid @enderror "
                                                                        name="marketingagencies" style="width: 100%;">
                                                                        <option selected="selected" value="">Select
                                                                            Marketing
                                                                            Agencies</option>

                                                                        @foreach ($Agencies as $a)
                                                                            <option
                                                                                {{ $targetTeacher->resource_agency_id == $a->id ? 'selected' : '' }}
                                                                                value="{{ $a->id }}">
                                                                                {{ $a->agencyname }}</option>
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
                                                            style="display:{{ $targetTeacher->resource_type == 2 ? 'block' : 'none' }}">
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Reference Name </label>
                                                                    <input placeholder="Reference Name"
                                                                        class="form-control referencename @error('referencename') is-invalid @enderror "
                                                                        value="{{ $targetTeacher->resource_name }}"
                                                                        name="referencename" type="text">
                                                                    <span class="text-danger">
                                                                        @error('referencename')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Reference Email </label>
                                                                    <input placeholder="Reference Email"
                                                                        class="form-control referenceemail @error('referenceemail') is-invalid @enderror "
                                                                        value="{{ $targetTeacher->resource_email }}"
                                                                        name="referenceemail" type="text">
                                                                    <span class="text-danger">
                                                                        @error('referenceemail')
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
                                                                    <label>Age </label>
                                                                    <input placeholder="Age"
                                                                        class="form-control @error('age') is-invalid @enderror "
                                                                        value="{{ $targetTeacher->age }}" name="age"
                                                                        type="text">
                                                                    <span class="text-danger">
                                                                        @error('age')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
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
                                                                            <input type="radio" id="radioPrimary1"
                                                                                value="1" name="gender"
                                                                                {{ $targetTeacher->gender == 1 ? 'checked' : '' }}>
                                                                            <label for="radioPrimary1">
                                                                                Male
                                                                            </label>
                                                                        </div>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio" id="radioPrimary2"
                                                                                value="2"
                                                                                {{ $targetTeacher->gender == 2 ? 'checked' : '' }}
                                                                                name="gender">
                                                                            <label for="radioPrimary2">
                                                                                Female
                                                                            </label>
                                                                        </div>

                                                                    </div>
                                                                    <span class="text-danger">
                                                                        @error('gender')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Marital Status <span class="text-danger">
                                                                            @error('maritalStatus')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </span></label>
                                                                    <div class="clearfix">
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio"
                                                                                id="radioPrimarymaritalStatus1"
                                                                                value="Single" name="maritalStatus"
                                                                                {{ $targetTeacher->maritalStatus == 'Single' ? 'checked' : '' }}>
                                                                            <label for="radioPrimary1">
                                                                                Single
                                                                            </label>
                                                                        </div>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio"
                                                                                id="radioPrimarymaritalStatus2"
                                                                                value="Married"
                                                                                {{ $targetTeacher->maritalStatus == 'Married' ? 'checked' : '' }}
                                                                                name="maritalStatus">
                                                                            <label for="Married">
                                                                                Married
                                                                            </label>
                                                                        </div>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio"
                                                                                id="radioPrimarymaritalStatus3"
                                                                                value="Divorce"
                                                                                {{ $targetTeacher->maritalStatus == 'Divorce' ? 'checked' : '' }}
                                                                                name="maritalStatus">
                                                                            <label for="Divorce">
                                                                                Divorce
                                                                            </label>
                                                                        </div>

                                                                    </div>
                                                                    <span class="text-danger">
                                                                        @error('maritalStatus')
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
                                                                        <select name="language[]" id="language"
                                                                            class="select2" multiple="multiple"
                                                                            data-placeholder="Select a language"
                                                                            data-dropdown-css-class="select2-purple"
                                                                            style="width: 100%;">
                                                                            @foreach ($Language as $s)
                                                                                <option
                                                                                    @foreach ($LanguageLookup as $p) @if ($s->id == $p->language_id)
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
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Country </label>


                                                                    <select
                                                                        class=" select2 @error('country') is-invalid @enderror "
                                                                        name="country" id="countryload"
                                                                        style="width: 100%;">
                                                                        <option selected="selected" value="">Select
                                                                            Country
                                                                        </option>
                                                                        @foreach ($Country as $s)
                                                                            <option
                                                                                {{ $targetTeacher->country_id == $s->id ? 'selected' : '' }}
                                                                                value="{{ $s->id }}">
                                                                                {{ $s->CountryName }}</option>
                                                                        @endforeach
                                                                    </select>




                                                                    <span class="text-danger">
                                                                        @error('country')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>City </label>


                                                                    <select
                                                                        class=" select2 @error('city') is-invalid @enderror "
                                                                        name="city" id="citydrop"
                                                                        style="width: 100%;">
                                                                        <option selected="selected" value="">Select
                                                                            City
                                                                        </option>
                                                                        @foreach ($City as $s)
                                                                            <option
                                                                                {{ $targetTeacher->city_id == $s->id ? 'selected' : '' }}
                                                                                value="{{ $s->id }}">
                                                                                {{ $s->CityName }}</option>
                                                                        @endforeach

                                                                    </select>



                                                                    <span class="text-danger">
                                                                        @error('city')
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
                                                                    <label>Contact No </label>
                                                                    <input placeholder="Contact No"
                                                                        class="form-control @error('contactno') is-invalid @enderror "
                                                                        value="{{ $targetTeacher->contact_no }}"
                                                                        name="contactno" type="text">
                                                                    <span class="text-danger">
                                                                        @error('contactno')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Contact No 2 </label>
                                                                    <input placeholder="Contact No 2"
                                                                        value="{{ $targetTeacher->contact_no_2 }}"
                                                                        class="form-control @error('contactno2') is-invalid @enderror "
                                                                        name="contactno2" type="text">
                                                                    <span class="text-danger">
                                                                        @error('contactno2')
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
                                                                    <label>WhatsApp No </label>
                                                                    <input placeholder="WhatsApp No"
                                                                        value="{{ $targetTeacher->whatsapp }}"
                                                                        class="form-control @error('whatsappno') is-invalid @enderror "
                                                                        name="whatsappno" type="text">
                                                                    <span class="text-danger">
                                                                        @error('whatsappno')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Personal Email </label>
                                                                    <input placeholder="Personal Email"
                                                                        value="{{ $targetTeacher->personalEmail }}"
                                                                        class="form-control @error('personalEmail') is-invalid @enderror "
                                                                        name="personalEmail" type="text">
                                                                    <span class="text-danger">
                                                                        @error('personalEmail')
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
                                                                    <label>ID Card No </label>
                                                                    <input placeholder="ID Card No"
                                                                        value="{{ $targetTeacher->identity_card_no }}"
                                                                        class="form-control @error('cardno') is-invalid @enderror "
                                                                        name="cardno" type="text">
                                                                    <span class="text-danger">
                                                                        @error('cardno')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Personal Skype </label>
                                                                    <input placeholder="Personal Skype"
                                                                        value="{{ $targetTeacher->personal_skype }}"
                                                                        class="form-control @error('personalskype') is-invalid @enderror "
                                                                        name="personalskype" type="text">
                                                                    <span class="text-danger">
                                                                        @error('personalskype')
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
                                                                    <label>AnyDesk</label>


                                                                    <input placeholder="AnyDesk"
                                                                        value="{{ $targetTeacher->anyDesk }}"
                                                                        class="form-control @error('anyDesk') is-invalid @enderror "
                                                                        name="anyDesk" type="text">
                                                                    <span class="text-danger">
                                                                        @error('anyDesk')
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
                                                                    <label>Current Address </label>


                                                                    <textarea class="form-control @error('currentaddress') is-invalid @enderror " name="currentaddress">{{ $targetTeacher->current_address }}</textarea>
                                                                    <span class="text-danger">
                                                                        @error('currentaddress')
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
                                                                    <label>Permanent Address </label>


                                                                    <textarea class="form-control @error('permanentaddress') is-invalid @enderror " name="permanentaddress">{{ $targetTeacher->current_address }}</textarea>
                                                                    <span class="text-danger">
                                                                        @error('permanentaddress')
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
                                                                    <label>Skills/Subject (Multiple) </label>
                                                                    <div class="select2-purple">
                                                                        <select name="skills[]" id="skills"
                                                                            class="select2 skills @error('skills') is-invalid @enderror "
                                                                            multiple="multiple"
                                                                            data-placeholder="Select a Skill"
                                                                            data-dropdown-css-class="select2-purple"
                                                                            style="width: 100%;">
                                                                            <option value="">Select Skill</option>

                                                                            @foreach ($Skill as $s)
                                                                                <option
                                                                                    @foreach ($SkillsLookup as $p) @if ($s->id == $p->skill_id)
                                                                        selected="selected" @endif @endforeach
                                                                                    value="{{ $s->id }}">
                                                                                    {{ $s->skillname }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <span class="text-danger">
                                                                        @error('skills')
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
                                                                    <label>Qualification </label>
                                                                    <input placeholder="Qualification"
                                                                        value="{{ $targetTeacher->qualification }}"
                                                                        class="form-control qualification @error('qualification') is-invalid @enderror "
                                                                        name="qualification" type="text">
                                                                    <span class="text-danger">
                                                                        @error('qualification')
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
                                                                    <label>Contract Duration</label>
                                                                    <input placeholder="Contract Duration"
                                                                        value="{{ $targetTeacher->contract_duration }}"
                                                                        class="form-control contractduration @error('contractduration') is-invalid @enderror "
                                                                        name="contractduration" type="text">
                                                                    <span class="text-danger">
                                                                        @error('contractduration')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Experience </label>
                                                                    <input placeholder="Experience"
                                                                        value="{{ $targetTeacher->experience }}"
                                                                        class="form-control @error('experience') is-invalid @enderror "
                                                                        name="experience" type="text">
                                                                    <span class="text-danger">
                                                                        @error('experience')
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
                                                                    <label>Salary Slip Password</label>
                                                                    <input placeholder="Salary Slip Password"
                                                                        value="{{ $targetTeacher->salarypass }}"
                                                                        class="form-control salary @error('salarypass') is-invalid @enderror "
                                                                        name="salarypass" type="text">
                                                                    <span class="text-danger">
                                                                        @error('salarypass')
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
                                                                    <label>Basic Salary</label>
                                                                    <input placeholder="Basic Salary"
                                                                        value="{{ $targetTeacher->salary }}"
                                                                        class="form-control salary @error('salary') is-invalid @enderror "
                                                                        name="salary" type="text">
                                                                    <span class="text-danger">
                                                                        @error('salary')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>% Increment </label>
                                                                    <input placeholder="% Increment"
                                                                        value="{{ $targetTeacher->increment_percentage }}"
                                                                        class="form-control @error('increment_percentage') is-invalid @enderror "
                                                                        name="increment_percentage" type="number">
                                                                    <span class="text-danger">
                                                                        @error('increment_percentage')
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
                                                                    <label>Comment </label>


                                                                    <textarea class="form-control @error('comment') is-invalid @enderror " name="comment">{{ $targetTeacher->comment }}</textarea>
                                                                    <span class="text-danger">
                                                                        @error('comment')
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
                                                                    <label>ID Card No </label>
                                                                    <input placeholder="ID Card No"
                                                                        value="{{ $targetTeacher->identity_card_no }}"
                                                                        class="form-control @error('cardno') is-invalid @enderror "
                                                                        name="cardno" type="text">
                                                                    <span class="text-danger">
                                                                        @error('cardno')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>Personal Skype </label>
                                                                    <input placeholder="Personal Skype"
                                                                        value="{{ $targetTeacher->personal_skype }}"
                                                                        class="form-control @error('personalskype') is-invalid @enderror "
                                                                        name="personalskype" type="text">
                                                                    <span class="text-danger">
                                                                        @error('personalskype')
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
                                                                    <label>BeneficiaryName </label>
                                                                    <input placeholder="BeneficiaryName"
                                                                        value="{{ $targetTeacher->BeneficiaryName }}"
                                                                        class="form-control @error('BeneficiaryName') is-invalid @enderror "
                                                                        name="BeneficiaryName" type="text">
                                                                    <span class="text-danger">
                                                                        @error('BeneficiaryName')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>AccountNo </label>
                                                                    <input placeholder="AccountNo"
                                                                        value="{{ $targetTeacher->AccountNo }}"
                                                                        class="form-control @error('AccountNo') is-invalid @enderror "
                                                                        name="AccountNo" type="text">
                                                                    <span class="text-danger">
                                                                        @error('AccountNo')
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
                                                                    <label>Bankcode </label>
                                                                    <input placeholder="Bankcode"
                                                                        value="{{ $targetTeacher->Bankcode }}"
                                                                        class="form-control @error('Bankcode') is-invalid @enderror "
                                                                        name="Bankcode" type="text">
                                                                    <span class="text-danger">
                                                                        @error('Bankcode')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>BankName </label>
                                                                    <input placeholder="BankName"
                                                                        value="{{ $targetTeacher->BankName }}"
                                                                        class="form-control @error('BankName') is-invalid @enderror "
                                                                        name="BankName" type="text">
                                                                    <span class="text-danger">
                                                                        @error('BankName')
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
                                                                    <label>branchCode </label>
                                                                    <input placeholder="branchCode"
                                                                        value="{{ $targetTeacher->branchCode }}"
                                                                        class="form-control @error('branchCode') is-invalid @enderror "
                                                                        name="branchCode" type="text">
                                                                    <span class="text-danger">
                                                                        @error('branchCode')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label>branchName </label>
                                                                    <input placeholder="branchName"
                                                                        value="{{ $targetTeacher->branchName }}"
                                                                        class="form-control @error('branchName') is-invalid @enderror "
                                                                        name="branchName" type="text">
                                                                    <span class="text-danger">
                                                                        @error('branchName')
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
                                                                    <label>Status </label>
                                                                    <div class="select2-purple">
                                                                        <select name="status" id="status"
                                                                            class="status @error('status') is-invalid @enderror  form-control"
                                                                            style="width: 100%;">
                                                                            <option
                                                                                {{ $User->status == '' ? 'selected' : '' }}
                                                                                value="">Select Status</option>
                                                                            <option
                                                                                {{ $User->status == 1 ? 'selected' : '' }}
                                                                                value="1">Active</option>
                                                                            <option
                                                                                {{ $User->status == 2 ? 'selected' : '' }}
                                                                                value="2">Deactive</option>


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
                                                                    <label>Salary Generate </label>
                                                                    <div class="select2-purple">
                                                                        <select name="salaryStatus" id="salaryStatus"
                                                                            class="salaryStatus @error('salaryStatus') is-invalid @enderror  form-control"
                                                                            style="width: 100%;">
                                                                            <option
                                                                                {{ $targetTeacher->salaryStatus == 1 ? 'selected' : '' }}
                                                                                value="1">Yes</option>
                                                                            <option
                                                                                {{ $targetTeacher->salaryStatus == 2 ? 'selected' : '' }}
                                                                                value="2">NO</option>


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


                                                    </div>
                                                    <div class="tab-pane fade" id="Student">


                                                        <div class="row">
                                                            <h3>Current Active Student List </h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        data-link="{{ route('admin.teacher.students') }}"
                                                                        id="student-datatable"
                                                                        class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>

                                                                                <th>Student Name</th>
                                                                                <th>Student Father Name</th>
                                                                                <th>Status</th>
                                                                                <th>Academic Status</th>
                                                                                <th>Group</th>
                                                                                <th>Contact No</th>
                                                                                <th>Email</th>
                                                                                <th>Country</th>
                                                                                <th>First Class Date</th>
                                                                                <th>Attendance</th>
                                                                            </tr>
                                                                        </thead>



                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <br />
                                                        <div class="row">
                                                            <h3>Current Leave Student List </h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        data-link="{{ route('admin.teacher.students.leave') }}"
                                                                        id="student-leave-datatable"
                                                                        class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>

                                                                                <th>Student Name</th>
                                                                                <th>Student Father Name</th>
                                                                                <th>Status</th>
                                                                                <th>Academic Status</th>
                                                                                <th>Group</th>
                                                                                <th>Contact No</th>
                                                                                <th>Email</th>
                                                                                <th>Country</th>
                                                                                <th>First Class Date</th>
                                                                                <th>Attendance</th>
                                                                            </tr>
                                                                        </thead>



                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <br />
                                                        <div class="row">
                                                            <h3>Current Student List Except Active and Leave </h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        data-link="{{ route('admin.teacher.students.otherstatus') }}"
                                                                        id="student-otherstatus-datatable"
                                                                        class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>

                                                                                <th>Student Name</th>
                                                                                <th>Student Father Name</th>
                                                                                <th>Status</th>
                                                                                <th>Academic Status</th>
                                                                                <th>Group</th>
                                                                                <th>Reason</th>
                                                                                <th>Detail</th>
                                                                                <th>Contact No</th>
                                                                                <th>Email</th>
                                                                                <th>Country</th>
                                                                                <th>First Class Date</th>
                                                                                <th>Last Class Date</th>
                                                                                <th>Attendance</th>
                                                                            </tr>
                                                                        </thead>



                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <br />
                                                        <div class="row">
                                                            <h3>Past Student List </h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        data-link="{{ route('admin.teacher.students.past') }}"
                                                                        id="past-student-datatable"
                                                                        class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Transfer Teacher</th>
                                                                                <th>Student Name</th>
                                                                                <th>Status</th>
                                                                                <th>Academic Status</th>
                                                                                <th>Group</th>
                                                                                <th>Reason</th>
                                                                                <th>Detail</th>
                                                                                <th>First Class Date</th>
                                                                                <th>Last Class Date</th>
                                                                                <th>Attendance</th>

                                                                            </tr>
                                                                        </thead>



                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="Feedback">
                                                        <div class="row">
                                                            <h3>Feedback</h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <table id="feedbackDatatable"
                                                                    data-link="{{ route('admin.teacher.allstudents.feedback') }}"
                                                                    class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Student</th>
                                                                            <th>Question1</th>
                                                                            <th>Question2</th>
                                                                            <th>Quention3</th>
                                                                            <th>Question4</th>
                                                                            <th>Question5</th>
                                                                            <th>Total Rate</th>
                                                                            <th>feedback</th>
                                                                            <th>Date</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="Finance">
                                                        <div class="row">
                                                            <h3>Loan/Advance <button type="button"
                                                                    class="btn btn-primary btncreditpayment">Add
                                                                    Advance/Loan</button></h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        data-link="{{ route('admin.creditloan.payroll.datatable') }}"
                                                                        id="credit-loan-datatable"
                                                                        class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>

                                                                                <th>Loan Type</th>
                                                                                <th>Amount</th>
                                                                                <th>Remaining</th>
                                                                                <th>Issue Date</th>

                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <br />
                                                            <br />
                                                            <h3>Salary</h3>
                                                            <br />
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table id="payrollitemsdatatable"
                                                                        data-link="{{ route('admin.detail.payroll.employee.datatable') }}"
                                                                        style="width:100% important"
                                                                        class="table table-bordered table-hover">

                                                                        <thead>
                                                                            <tr>
                                                                                <th>Employee ID</th>
                                                                                <th>Name</th>
                                                                                <th>Total Allowance</th>
                                                                                <th>Paid Date</th>
                                                                                <th>Salary</th>

                                                                                <th>Action</th>

                                                                            </tr>
                                                                        </thead>

                                                                    </table>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="Leavetab">
                                                        <div class="row">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <table class="table table-primary table-bordered">
                                                                        <tr>

                                                                            <td>year</td>
                                                                            <td>Total leave</td>
                                                                        </tr>
                                                                        @foreach ($totalleave as $dataleave)
                                                                            <tr>
                                                                                <td>{{ $dataleave->year }}</td>
                                                                                <td>{{ $dataleave->TotalLeaveDays }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <!-- Employee Leave Modal partial -->
                                                                @include('custompartials.empleavepartial', [
                                                                    'id' => request()->route('id'),
                                                                ])
                                                                <!-- Employee Leave Modal partial -->
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane fade" id="Otherstab">
                                                        <div class="row">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table
                                                                        data-link="{{ route('admin.teacher.complain.datatable') }}"
                                                                        id="complain-datatable"
                                                                        class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Complain Purpose</th>
                                                                                <th>Complain Description</th>
                                                                                <th>Reciever</th>
                                                                                <th>Created at</th>
                                                                            </tr>
                                                                        </thead>



                                                                    </table>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                                </div>
                                            </div>
                                        </div>

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
        </section>


        <div id="creditpaymentModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <form id="formadvancecredit" action="{{ route('admin.credit.loan.add.payroll') }}" method="POST"
                    role="form">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Advance / Loan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                            <div class="row">

                                <div class="col-sm-4">
                                    <!-- text input -->
                                    {!! csrf_field() !!}

                                    <input name="employee_id" value="{{ request()->route('id') }}" type="hidden">
                                    <div class="form-group">
                                        <label>Type <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                        <select name="creditType" class="form-control creditTypeclass creditType">
                                            <option value="">Select Credit Type</option>
                                            <option value="advance">advance</option>
                                            <option value="loan">Loan</option>
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Amount <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                        <input placeholder="Amount" class="form-control Totalamountcredit Amount"
                                            name="Amount" type="number">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div style="display:none" class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Installments <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                        <input placeholder="No oF Installments" class="form-control noinstallments"
                                            name="noinstallments" type="number">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="DivContainer">

                            </div>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="saveadvancecreditNew" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="creditpartialpaymentModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <form id="formadvancecredit" action="{{ route('admin.credit.loan.add.payroll') }}" method="POST"
                    role="form">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Installments</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                            <div class="row">
                                <table id="partialPaymenttable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>

                                            <th>Installments No</th>
                                            <th>Amount</th>
                                            <th>Paid Date</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            </p>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div id="MarkAttendanceHistoryModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Mark Attendance History </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date Time</th>

                                    </tr>
                                    <tbody id="MarkAttendanceHistorbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
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

    <script type="text/javascript"
        src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();


            $(document).on('click', '.btnDeleteInstallments', function() {

                var id = $(this).attr('data-id');
                var route = '{{ route('admin.creditloan.payroll.forms.delete', ':id') }}';

                route = route.replace(':id', id);


                swal({
                        title: "Are you sure?",
                        text: "You wont Delete this Loan",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                url: route,
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    id: id,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    $('#credit-loan-datatable').DataTable().draw(true);
                                    swal("Poof! Delete Successfully Loan!", {
                                        icon: "success",
                                    });
                                },
                                error: function(response) {
                                    console.log(response);
                                }
                            });

                        }
                    });






            });

            $(document).on('click', '.btnattendancehisotoryclick', function() {

                var id = $(this).attr('data-id');
                var route = '{{ route('admin.student.except.active.AttendanceStatus.history.get') }}';

                $.get(route, {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(data) {

                    console.log(data)
                    $('#MarkAttendanceHistorbody').html('');
                    var html = "";
                    $.each(data, function(index, value) {
                        console.log(value)
                        html +=
                            `<tr><td>${index+1}</td><td><span style="padding:10px;color:white;;background-color:${value.color}">${value.status_name}</span></td><td>${value.created_at}</td></tr>`;
                    });
                    $('#MarkAttendanceHistorbody').html(html);
                    $('#MarkAttendanceHistoryModal').modal('show');

                })



            });

            $('#formadvancecredit').on('submit', function(event) {
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
                        $('#saveadvancecreditNew').attr('disabled', 'disabled');
                    },
                    success: function(data) {

                        console.log(data)

                        if (data.error) {

                            $('#saveadvancecreditNew').attr('disabled', false);
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
                            $('#saveadvancecreditNew').attr('disabled', false);
                            $('#credit-loan-datatable').DataTable().draw(true);
                            $('#creditpaymentModal').modal('hide');
                            swal("Good job!", 'success', "Loan  Save Successfully");
                        }

                        // else {
                        //   $('#student-new-comment-datatable').DataTable().draw(true);
                        //     $(`.form-control`).removeClass('is-invalid')
                        //     $('.errorlabelmy').html('');
                        //     $('#saveCommentsNew').attr('disabled', false);
                        //      swal("Good job!", data.success, data.alert);
                        //     $("#formstudentComments").get(0).reset();
                        //     // $('#CommentStudentModal').modal('hide');
                        //     $('#CommentStudentModal  input[name="id"]').val('')


                        // }


                    }
                })
            });

            $(document).on('change', '#countryload', function() {

                var val = $(this).val();
                var url = '{{ route('city.load.country', ':id') }}';
                url = url.replace(':id', val);

                $.get(url, function(res) {

                    let html = "<option value=''>Select City</option>"
                    $.each(res, function($i, $val) {
                        console.log($val)
                        html +=
                            `<option value="${$val['id']}">${$val['CityName']}</option>`;
                    })
                    $('#citydrop').html(html)

                })
            })


            $(document).on('click', '.btncreditpayment', function() {

                $('#creditpaymentModal').modal('show');
            })


            $(document).on('change', '.creditTypeclass', function() {
                var val = $(this).val();
                $('.noinstallments').closest('.col-sm-4').hide();
                if (val == "loan") {
                    $('.noinstallments').closest('.col-sm-4').show();
                }

            });


            $(document).on('keyup', '.Totalamountcredit', function() {
                var creditType = $('.creditTypeclass').val();
                if (creditType != "") {
                    if (creditType == "advance") {
                        $('.DivContainer').html("");
                        var html = loadInstallmentHtml(1, false)
                        $('.DivContainer').html(html);
                    }
                } else {
                    swal({
                        title: "Credit Type!",
                        text: "Please Must Select Credit Type",
                        icon: "error",
                        button: "Close",
                    });
                }
            });

            function loadInstallmentHtml(val, disabled = false) {
                const date = new Date();
                var currentMonth = date.getMonth();
                var totalamount = $('.Totalamountcredit').val();

                var partialamount = Math.floor(totalamount / val);

                let html = "";
                for (i = 0; i < val; ++i) {
                    var no = i + 1;
                    var daten = new Date(date.getFullYear(), currentMonth + i, 5);
                    // var paydate  = moment(daten).format('yyyy-M-D');
                    var paydate = moment(daten).format('yyyy-MM-DD');
                    console.log(paydate);

                    var isDisabled = ""
                    if (disabled == true) {
                        isDisabled = "readonly";
                    }

                    html += `<div class="row">
                                                     <div class="col-sm-4">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Installment No. ${no} </label>
                                                          
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Installment  Amount <span class="m-l-5 text-danger partialAmount${i}  errorlabelmy"></span></label>
                                                            <input readonly placeholder="Installment  Amount" class="form-control" name="partialAmount[]" value="${partialamount}" type="number">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Date <span class="m-l-5 text-danger partialDate{i}  errorlabelmy"></span></label>
                                                            <input  ${isDisabled}  placeholder="date" class="form-control" name="partialDate[]" value="${paydate}"  type="date">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                   
                                                </div>`;


                }

                return html;
            }
            $(document).on('keyup', '.noinstallments', function() {
                var val = $(this).val();
                $('.DivContainer').html("");
                if (val > 0) {


                    var html = loadInstallmentHtml(val, true)


                    $('.DivContainer').html(html);


                }
            });



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

            $("#formteacher").validate({
                ignore: "not:hidden",
                rules: {
                    name: {
                        required: true,
                        minlength: 5,
                    },
                    fathername: {
                        required: true,
                        minlength: 5,
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
                    whatsappno: {
                        required: true,

                    },
                    cardno: {
                        required: true,

                    },
                    personalskype: {
                        required: true,

                    },
                    currentaddress: {
                        required: true,

                    },
                    permanentaddress: {
                        required: true,

                    },
                    qualification: {
                        required: true,

                    },
                    contractduration: {
                        required: true,

                    },
                    Experience: {
                        required: true,

                    },
                    country: {
                        required: true,

                    },
                    city: {
                        required: true,

                    },
                    resource: {
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
                        minlength: 5,
                    },
                    referenceemail: {
                        required: function(element) {
                            if ($("#resource").val() == '2') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        minlength: 5,
                    },
                    password: {
                        minlength: 5
                    },
                    confirmpassword: {
                        minlength: 5,
                        equalTo: "#password"
                    },
                    status: {
                        required: true,
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

                            console.log(data);


                            if (data.Success) {
                                swal({
                                    title: "Good job!",
                                    text: data.msg,
                                    icon: "success",
                                    button: "Close",
                                });
                                // $('#formteacher')[0].reset();
                                // $("select").trigger("change");
                            } else {
                                $.each(data.error, function(key, value) {
                                    var input = `#formteacher input[name="${key}"]`;
                                    var inputtextarea =
                                        `#formteacher textarea[name="${key}"]`;
                                    var inputselect =
                                        `#formteacher select[name="${key}"]`;
                                    var inputselectid =
                                        `#formteacher select[id="${key}"]`;
                                    // console.log(input)
                                    $(input).parents('.form-group').find(
                                            '.text-danger')
                                        .text(value);
                                    $(inputtextarea).parents('.form-group').find(
                                        '.text-danger').text(
                                        value);
                                    $(inputselect).parents('.form-group').find(
                                        '.text-danger').text(
                                        value);
                                    $(inputselectid).parents('.form-group').find(
                                        '.text-danger').text(
                                        value);
                                    $(input).addClass('is-invalid');
                                    $(inputtextarea).addClass('is-invalid');
                                    $(inputselect).addClass('is-invalid');
                                    $(inputselectid).addClass('is-invalid');
                                });
                            }


                        },
                        error: function(data) {
                            alert('Error')
                        }
                    });
                }
            });


            function LoadStudents() {
                if (!$.fn.dataTable.isDataTable('#student-datatable')) {
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
                                d.id = '{{ request()->route('id') }}';
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
                                data: 'class_status',
                                name: 'class_status',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'academic_status',
                                name: 'academic_status',
                                orderable: false,
                                searchable: false
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
                                data: 'studentemail',
                                name: 'student.studentemail'
                            },
                            {
                                data: 'CountryName',
                                name: 'countries.CountryName'
                            },
                            {
                                data: 'first_attendance_date',
                                name: 'first_attendance_date',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'attendancehistoryclick',
                                name: 'attendancehistoryclick',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                    var oTable = $('#student-leave-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#student-leave-datatable').attr('data-link'),
                            data: function(d) {
                                d.id = '{{ request()->route('id') }}';
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
                                data: 'class_status',
                                name: 'class_status',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'academic_status',
                                name: 'academic_status',
                                orderable: false,
                                searchable: false
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
                                data: 'studentemail',
                                name: 'student.studentemail'
                            },
                            {
                                data: 'CountryName',
                                name: 'countries.CountryName'
                            },

                            {
                                data: 'first_attendance_date',
                                name: 'first_attendance_date',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'attendancehistoryclick',
                                name: 'attendancehistoryclick',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                    var oTable = $('#student-otherstatus-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#student-otherstatus-datatable').attr('data-link'),
                            data: function(d) {
                                d.id = '{{ request()->route('id') }}';
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
                                data: 'class_status',
                                name: 'class_status',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'academic_status',
                                name: 'academic_status',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'group',
                                name: 'student.group'
                            },
                            {
                                data: 'reasontype',
                                name: 'reasontype',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'reasondescription',
                                name: 'reasondescription',
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
                                data: 'first_attendance_date',
                                name: 'first_attendance_date',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'last_attendance_date',
                                name: 'last_attendance_date',
                                orderable: false,
                                searchable: false
                            },

                            {
                                data: 'attendancehistoryclick',
                                name: 'attendancehistoryclick',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });

                    var apstTable = $('#past-student-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#past-student-datatable').attr('data-link'),
                            data: function(d) {
                                d.id = '{{ request()->route('id') }}';
                            }
                        },

                        columns: [{
                                data: 'employeename',
                                name: 'employees.employeename'
                            },
                            {
                                data: 'studentprofile',
                                name: 'studentprofile',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'class_status',
                                name: 'class_status',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'academic_status',
                                name: 'academic_status',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'group',
                                name: 'student.group'
                            },
                            {
                                data: 'reason',
                                name: 'reason.reason'
                            },
                            {
                                data: 'description',
                                name: 'teacherchange.description'
                            },
                            {
                                data: 'first_attendance_date',
                                name: 'first_attendance_date',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'last_attendance_date',
                                name: 'last_attendance_date',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'attendancehistoryclick',
                                name: 'attendancehistoryclick',
                                orderable: false,
                                searchable: false
                            },

                        ]
                    });
                }
            }




            function LoadFeedback() {
                if (!$.fn.dataTable.isDataTable('#complain-datatable')) {
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
                                id: '{{ request()->route('id') }}'
                            }
                        },

                        columns: [{
                                data: 'studentname',
                                name: 'student.studentname',
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

            function password_generator(len) {
                var length = (len) ? (len) : (10);
                var string = "abcdefghijklmnopqrstuvwxyz"; //to upper 
                var numeric = '0123456789';
                var punctuation = '!@#$%^&*()_+~`|}{[]\:;?><,./-=';
            var password = "";
            var character = "";
            var crunch = true;
            while (password.length < length) {
                entity1 = Math.ceil(string.length * Math.random() * Math.random());
                entity2 = Math.ceil(numeric.length * Math.random() * Math.random());
                entity3 = Math.ceil(punctuation.length * Math.random() * Math.random());
                hold = string.charAt(entity1);
                hold = (password.length % 2 == 0) ? (hold.toUpperCase()) : (hold);
                character += hold;
                character += numeric.charAt(entity2);
                character += punctuation.charAt(entity3);
                password = character;
            }
            password = password.split('').sort(function() {
                return 0.5 - Math.random()
            }).join('');
            return password.substr(0, len);
        }

        $(document).on('click', '.btnpasswordgenerate', function() {


            let genpass = password_generator(12);
            $('.passwordgenerateclass').html(genpass);
            $('#password').val(genpass);
            $('#confirmpassword').val(genpass);



        })

        $(document).on('click', '.btnCheckInstallments', function() {

            var data = $(this).find('textarea').val();
            data = jQuery.parseJSON(data);
            $('#partialPaymenttable tbody').html('');
            var html = "";
            $.each(data, function(index, dt) {

                html +=
                    `<tr><td>${dt.no_partial}</td><td>${dt.partial_amount}</td><td>${dt.paidDate}</td><td>${dt.isPaid}</td></tr>`

                });
                $('#partialPaymenttable tbody').html(html);
                $('#creditpartialpaymentModal').modal('show');

            })




            function loadFinance() {
                if (!$.fn.dataTable.isDataTable('#credit-loan-datatable')) {
                    $('#credit-loan-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#credit-loan-datatable').attr('data-link'),
                            data: {
                                employee_id: '{{ request()->route('id') }}'
                            }
                        },

                        columns: [{
                                data: 'type',
                                name: 'type',
                                orderable: false,

                            },
                            {
                                data: 'amount',
                                name: 'amount',
                                orderable: false,
                            },
                            {
                                data: 'remainingAmount',
                                name: 'remainingAmount',
                                orderable: false,
                                searchable: false
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

                    var oTable = $('#payrollitemsdatatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#payrollitemsdatatable').attr('data-link'),
                            data: {
                                employee_id: "{{ request()->route('id') }}"
                            }
                        },

                        columns: [{
                                data: 'employee_no',
                                name: 'employees.employee_no'
                            },
                            {
                                data: 'employeename',
                                name: 'employees.employeename'
                            },
                            {
                                data: 'allowance_amount',
                                name: 'payroll_items.allowance_amount'
                            },
                            {
                                data: 'created_at_new',
                                name: 'created_at_new',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'salaryStatus',
                                name: 'salaryStatus',
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

            function complainssDataTables() {
                if (!$.fn.dataTable.isDataTable('#complain-datatable')) {

                    $('#complain-datatable').DataTable({
                        processing: true,
                        serverSide: true,

                        lengthMenu: [
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                        ],
                        ajax: {
                            url: $('#complain-datatable').attr('data-link'),
                            data: {
                                id: "{{ request()->route('id') }}"
                            }
                        },

                        columns: [


                            {
                                data: 'complain',
                                name: 'complain'
                            },

                            {
                                data: 'Description',
                                name: 'Description'
                            },

                            {
                                data: 'reciever',
                                name: 'reciever',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });



                }
            }

            $('#vert-tabs-tab a').on("click", function(e) {
                e.preventDefault();
                if ($(this).attr('href') == "#Otherstab") {
                    complainssDataTables();
                } else if ($(this).attr('href') == "#Finance") {
                    loadFinance();
                } else if ($(this).attr('href') == "#Student") {
                    LoadStudents();
                } else if ($(this).attr('href') == "#Feedback") {
                    LoadFeedback();
                }

            });



        });
    </script>
@endpush
