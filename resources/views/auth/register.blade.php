@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<div class="center-vertical">
    <div class="center-content row">
        @if(Session::has('errorlogin'))
        <div class="alert alert-danger">
            {{ Session::get('errorlogin') }}
        </div>
        @endif


        <form id="registerForm" method="post" action="{{ route('userregister') }}" enctype="multipart/form-data"
            class="col-md-9 col-sm-5 col-xs-11 col-lg-9 center-margin">
            @csrf
            <h3 class="text-center pad25B font-gray text-transform-upr font-size-23">SISPN REGISTRATION FORM <span
                    class="opacity-80">v1.0</span></h3>


            <div class="card-body login-card-body">



                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name </label>
                            <input placeholder="Name" class="form-control @error('name') is-invalid @enderror "
                                name="name" type="text">
                            <span class="text-danger">@error('name') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Father Name </label>
                            <input placeholder="Father Name" class="form-control @error('fname') is-invalid @enderror "
                                name="fname" type="text">
                            <span class="text-danger">@error('fname') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>User Name </label>
                            <input placeholder="username" class="form-control @error('username') is-invalid @enderror "
                                name="username" type="text">
                            <span class="text-danger">@error('username') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Email <span class="help-block"><small style="color:red">Enter Authentic Email because
                                        confirmation
                                        Email Send</small></span></label>
                            <input placeholder="Email" class="form-control @error('email') is-invalid @enderror "
                                name="email" type="text">
                            <span class="text-danger">@error('email') {{ $message }}
                                @enderror</span>


                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>User Type </label>


                            <select id="usertype" class=" select2  @error('usertype') is-invalid @enderror "
                                name="usertype" style="width: 100%;">
                                <option selected="selected" value="">Select UserType</option>

                                <option value="1">As a Parent</option>
                                <option value="2">As a Agent</option>
                            </select>



                            <span class="text-danger">@error('usertype') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Resource </label>


                            <select id="resource" class=" select2 @error('resource') is-invalid @enderror "
                                name="resource" style="width: 100%;">
                                <option selected="selected" value="">Select Resource</option>
                                <option value="1">Marketing/Advertisement</option>
                                <option value="2">Reference</option>

                            </select>



                            <span class="text-danger">@error('resource') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>
                <div class="row" style="display:none">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Marketing Agencies </label>


                            <select class="marketingagencies select2 @error('marketingagencies') is-invalid @enderror "
                                name="marketingagencies" style="width: 100%;">
                                <option selected="selected" value="">Select Marketing Agencies</option>

                                @foreach($Agencies as $a)
                                <option value="{{$a->id}}">{{$a->agencyname}}</option>
                                @endforeach

                            </select>



                            <span class="text-danger">@error('marketingagencies')
                                {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>
                <div class="row" style="display:none">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Reference Name </label>
                            <input placeholder="Reference Name"
                                class="form-control referencename @error('referencename') is-invalid @enderror "
                                name="referencename" type="text">
                            <span class="text-danger">@error('referencename') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Reference Email </label>
                            <input placeholder="Reference Email"
                                class="form-control referenceemail @error('referenceemail') is-invalid @enderror "
                                name="referenceemail" type="text">
                            <span class="text-danger">@error('referenceemail') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="display:none">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Designation </label>


                            <select class="designation select2 @error('designation') is-invalid @enderror "
                                name="designation" style="width: 100%;">
                                <option selected="selected" value="">Select Designation</option>

                                @foreach($roles as $r)
                                <option value="{{$r->name}}">{{$r->role_name}}</option>
                                @endforeach
                            </select>



                            <span class="text-danger">@error('designation') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>
                <div class="row" style="display:none">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Skills/Subject (Multiple) </label>
                            <div class="select2-purple">
                                <select name="skills[]" id="skills"
                                    class="select2 skills @error('skills') is-invalid @enderror " multiple="multiple"
                                    data-placeholder="Select a Skill" data-dropdown-css-class="select2-purple"
                                    style="width: 100%;">
                                    <option value="">Select Skill</option>

                                    @foreach($Skill as $s)
                                    <option value="{{$s->id}}">{{$s->skillname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger">@error('skills') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Age </label>
                            <input placeholder="Age" class="form-control @error('age') is-invalid @enderror " name="age"
                                type="text">
                            <span class="text-danger">@error('age') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Gender <span class="text-danger">@error('gender') {{ $message }}
                                    @enderror</span></label>
                            <div class="clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" value="1" name="gender" checked>
                                    <label for="radioPrimary1">
                                        Male
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary2" value="2" name="gender">
                                    <label for="radioPrimary2">
                                        Female
                                    </label>
                                </div>

                            </div>
                            <span class="text-danger">@error('gender') {{ $message }}
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
                                    <option value="{{$s->id}}">{{$s->languagename}}</option>
                                    @endforeach

                                </select>
                                <span class="text-danger">@error('language') {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>
                    </div>



                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Country </label>


                            <select class=" select2 @error('country') is-invalid @enderror " id="countryload" name="country"
                                style="width: 100%;">
                                <option selected="selected" value="">Select Country</option>
                                @foreach($Country as $s)
                                <option value="{{$s->id}}">{{$s->CountryName}}</option>
                                @endforeach
                            </select>



                            <span class="text-danger">@error('country') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>City </label>


                            <select class=" select2 @error('city') is-invalid @enderror " name="city"
                            id="citydrop"
                                style="width: 100%;">
                                <option selected="selected" value="">Select City</option>
                              

                            </select>



                            <span class="text-danger">@error('city') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Contact No </label>
                            <input placeholder="Contact No"
                                class="form-control @error('contactno') is-invalid @enderror " name="contactno"
                                type="text">
                            <span class="text-danger">@error('contactno') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Contact No 2 </label>
                            <input placeholder="Contact No 2"
                                class="form-control @error('contactno2') is-invalid @enderror " name="contactno2"
                                type="text">
                            <span class="text-danger">@error('contactno2') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>WhatsApp No </label>
                            <input placeholder="WhatsApp No"
                                class="form-control @error('whatsappno') is-invalid @enderror " name="whatsappno"
                                type="text">
                            <span class="text-danger">@error('whatsappno') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>ID Card No </label>
                            <input placeholder="ID Card No" class="form-control @error('cardno') is-invalid @enderror "
                                name="cardno" type="text">
                            <span class="text-danger">@error('cardno') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Personal Skype </label>
                            <input placeholder="Personal Skype"
                                class="form-control @error('personalskype') is-invalid @enderror " name="personalskype"
                                type="text">
                            <span class="text-danger">@error('personalskype') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Current Address </label>


                            <textarea class="form-control @error('currentaddress') is-invalid @enderror "
                                name="currentaddress"></textarea>
                            <span class="text-danger">@error('currentaddress') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Permanent Address </label>


                            <textarea class="form-control @error('permanentaddress') is-invalid @enderror "
                                name="permanentaddress"></textarea>
                            <span class="text-danger">@error('permanentaddress') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>

                <div class="row" style="display:none">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Qualification </label>
                            <input placeholder="Qualification"
                                class="form-control qualification @error('qualification') is-invalid @enderror "
                                name="qualification" type="text">
                            <span class="text-danger">@error('qualification') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>

                </div>

                <div class="row" style="display:none">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Contract Duration</label>
                            <input placeholder="Contract Duration"
                                class="form-control contractduration @error('contractduration') is-invalid @enderror "
                                name="contractduration" type="text">
                            <span class="text-danger">@error('contractduration') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Experience </label>
                            <input placeholder="Experience"
                                class="form-control @error('experience') is-invalid @enderror " name="experience"
                                type="text">
                            <span class="text-danger">@error('experience') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Comment </label>


                            <textarea class="form-control @error('comment') is-invalid @enderror "
                                name="comment"></textarea>
                            <span class="text-danger">@error('comment') {{ $message }}
                                @enderror</span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>

                <br />
                <br />




            </div>


        </form>

    </div>
</div>
@endsection

@push('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-core.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-widget.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-mouse.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js-core/jquery-ui-position.js') }}"></script>
<!--<script type="text/javascript" src="{{ asset('assets/js-core/transition.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('assets/js-core/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js-core/jquery-cookie.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap/js/bootstrap.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" defer></script>
<script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>
<script>
$(document).ready(function() {
    $('.select2').select2()
});
$(function() {

    //Initialize Select2 Elements


    //Initialize Select2 Elements
    // $('.select2bs4').select2({
    //   theme: 'bootstrap4'
    // })
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

    $(document).on('change', '#usertype', function() {

        var val = $(this).val();
        $('.contractduration').closest('.row').hide();
        $('.qualification').closest('.row').hide();
        $('.designation').closest('.row').hide();
        $('.skills').closest('.row').hide();
        if (val == 2) {
            $('.contractduration').closest('.row').show();
            $('.qualification').closest('.row').show();
            $('.designation').closest('.row').show();
            $('.skills').closest('.row').show();
        }
    })

})
</script>


<script>
$(function() {
    var userData = new FormData($('#registerForm')[0]);


    $(document).on('submit', '#registerForm', function(e) {
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
                url: '{{ route("userregister") }}',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#registerForm')[0])
            })
            .done(function(data) {
                console.log(data);
                $.each(data.error, function(key, value) {
                    var input = `#registerForm input[name="${key}"]`;
                    var inputtextarea = `#registerForm textarea[name="${key}"]`;
                    var inputselect = `#registerForm select[name="${key}"]`;
                    var inputselectid = `#registerForm select[id="${key}"]`;
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

                if (data.Success) {
                    swal({
                        title: "Good job!",
                        text: data.msg,
                        icon: "success",
                        button: "Close",
                    });
                    $('#registerForm')[0].reset();
                    $("select").trigger("change");
                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });

    $(document).on('change', '#countryload', function() {

        var val = $(this).val();
        var url = '{{ route("city.load.country", ":id") }}';
        url = url.replace(':id', val);

       $.get(url,function(res){
              
                let html = "<option value=''>Select City</option>"
                $.each(res,function($i,$val){
                    console.log($val)
                    html += `<option value="${$val['id']}">${$val['CityName']}</option>`;
                })
                $('#citydrop').html(html)

       })
    })

});
</script>

@endpush