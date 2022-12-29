@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
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
                                
                              
                                <form id="formteacher" action="{{ route('admin.teacher.store') }}" method="POST"
                                    role="form">
                                    @csrf
                                    <div class="example-box-wrapper">
                                       
                                      
                                         



                                          

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Name </label>
                                                            <input placeholder="Name"
                                                                class="form-control @error('name') is-invalid @enderror "
                                                                name="name" value=""
                                                                type="text">
                                                            <span class="text-danger">@error('name') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Father Name </label>
                                                            <input placeholder="Father Name"
                                                                class="form-control @error('fname') is-invalid @enderror "
                                                                name="fname"
                                                                value=""
                                                                type="text">
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
                                                            <input placeholder="username" 
                                                                class="form-control @error('username') is-invalid @enderror "
                                                                name="username" value="" type="text">
                                                            <span class="text-danger">@error('username') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Email </label>
                                                            <input placeholder="Email" value="" 
                                                                class="form-control @error('email') is-invalid @enderror "
                                                                name="email" type="text">
                                                            <span class="text-danger">@error('email') {{ $message }}
                                                                @enderror</span>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Password </label>
                                                            <input placeholder="Password"
                                                                class="form-control @error('password') is-invalid @enderror "
                                                                id="password" name="password" value="" type="text">
                                                            <span class="text-danger">@error('password') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Confirm Password </label>
                                                            <input placeholder="Confirm Password" value=""
                                                                class="form-control @error('confirmpassword') is-invalid @enderror "
                                                                name="confirmpassword" type="text">
                                                            <span class="text-danger">@error('confirmpassword')
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
                                                                <option selected="selected" value="">Select Resource
                                                                </option>
                                                                <option
                                                                   
                                                                    value="1">Marketing/Advertisement</option>
                                                                <option
                                                                   
                                                                    value="2">Reference</option>

                                                            </select>



                                                            <span class="text-danger">@error('resource') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row"
                                                    style="display:none">
                                                    <div class="col-sm-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Marketing Agencies </label>


                                                            <select
                                                                class="marketingagencies select2 @error('marketingagencies') is-invalid @enderror "
                                                                name="marketingagencies" style="width: 100%;">
                                                                <option selected="selected" value="">Select Marketing
                                                                    Agencies</option>

                                                                @foreach($Agencies as $a)
                                                                <option
                                                                    
                                                                    value="{{$a->id}}">{{$a->agencyname}}</option>
                                                                @endforeach

                                                            </select>



                                                            <span class="text-danger">@error('marketingagencies')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row"
                                                    style="display:none">
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Reference Name </label>
                                                            <input placeholder="Reference Name"
                                                                class="form-control referencename @error('referencename') is-invalid @enderror "
                                                                value=""
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
                                                                class="form-control referenceemail @error('referenceemail') is-invalid @enderror "
                                                                value=""
                                                                name="referenceemail" type="text">
                                                            <span class="text-danger">@error('referenceemail')
                                                                {{ $message }}
                                                                @enderror</span>
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
                                                                value="" name="age" type="text">
                                                            <span class="text-danger">@error('age') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Gender <span class="text-danger">@error('gender')
                                                                    {{ $message }}
                                                                    @enderror</span></label>
                                                            <div class="clearfix">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="radioPrimary1" checked value="1"
                                                                        name="gender"
                                                                        >
                                                                    <label for="radioPrimary1">
                                                                        Male
                                                                    </label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="radioPrimary2" value="2"
                                                                        
                                                                        name="gender">
                                                                    <label for="radioPrimary2">
                                                                        Female
                                                                    </label>
                                                                </div>

                                                            </div>
                                                            <span class="text-danger">@error('gender') {{ $message }}
                                                                @enderror</span>
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
                                                                    <input checked type="radio" id="radioPrimarymaritalStatus1"
                                                                        value="Single" name="maritalStatus"
                                                                       >
                                                                    <label for="radioPrimary1">
                                                                        Single
                                                                    </label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="radioPrimarymaritalStatus2"
                                                                        value="Married"
                                                                        name="maritalStatus">
                                                                    <label for="Married">
                                                                        Married
                                                                    </label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="radioPrimarymaritalStatus3"
                                                                        value="Divorce"
                                                                        name="maritalStatus">
                                                                    <label for="Divorce">
                                                                        Divorce
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

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Language (Multiple)</label>
                                                            <div class="select2-purple">
                                                                <select name="language[]" id="language" class="select2"
                                                                    multiple="multiple"
                                                                    data-placeholder="Select a language"
                                                                    data-dropdown-css-class="select2-purple"
                                                                    style="width: 100%;">
                                                                    @foreach($Language as $s)
                                                                    <option 
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
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Country </label>


                                                            <select
                                                                class=" select2 @error('country') is-invalid @enderror "
                                                                name="country" id="countryload"  style="width: 100%;">
                                                                <option selected="selected" value="">Select Country
                                                                </option>
                                                                @foreach($Country as $s)
                                                                <option
                                                                   
                                                                    value="{{$s->id}}">{{$s->CountryName}}</option>
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


                                                            <select
                                                                class=" select2 @error('city') is-invalid @enderror "
                                                                name="city" id="citydrop" style="width: 100%;">
                                                                <option selected="selected" value="">Select City
                                                                </option>
                                                              

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
                                                                class="form-control @error('contactno') is-invalid @enderror "
                                                                value="" name="contactno"
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
                                                                value=""
                                                                class="form-control @error('contactno2') is-invalid @enderror "
                                                                name="contactno2" type="text">
                                                            <span class="text-danger">@error('contactno2')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">

                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>WhatsApp No </label>
                                                            <input placeholder="WhatsApp No"
                                                                value=""
                                                                class="form-control @error('whatsappno') is-invalid @enderror "
                                                                name="whatsappno" type="text">
                                                            <span class="text-danger">@error('whatsappno')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                     <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Personal Email </label>
                                                            <input placeholder="Personal Email"
                                                                value=""
                                                                class="form-control @error('personalEmail') is-invalid @enderror "
                                                                name="personalEmail" type="text">
                                                            <span class="text-danger">@error('personalEmail')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>ID Card No </label>
                                                            <input placeholder="ID Card No"
                                                                value=""
                                                                class="form-control @error('cardno') is-invalid @enderror "
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
                                                                value=""
                                                                class="form-control @error('personalskype') is-invalid @enderror "
                                                                name="personalskype" type="text">
                                                            <span class="text-danger">@error('personalskype')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-sm-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Current Address </label>


                                                            <textarea
                                                                class="form-control @error('currentaddress') is-invalid @enderror "
                                                                name="currentaddress"></textarea>
                                                            <span class="text-danger">@error('currentaddress')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-sm-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Permanent Address </label>


                                                            <textarea
                                                                class="form-control @error('permanentaddress') is-invalid @enderror "
                                                                name="permanentaddress"></textarea>
                                                            <span class="text-danger">@error('permanentaddress')
                                                                {{ $message }}
                                                                @enderror</span>
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

                                                                    @foreach($Skill as $s)
                                                                    <option 

                                                                        value="{{$s->id}}">{{$s->skillname}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">@error('skills') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Qualification </label>
                                                            <input placeholder="Qualification"
                                                                value=""
                                                                class="form-control qualification @error('qualification') is-invalid @enderror "
                                                                name="qualification" type="text">
                                                            <span class="text-danger">@error('qualification')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Contract Duration</label>
                                                            <input placeholder="Contract Duration"
                                                                value=""
                                                                class="form-control contractduration @error('contractduration') is-invalid @enderror "
                                                                name="contractduration" type="text">
                                                            <span class="text-danger">@error('contractduration')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Experience </label>
                                                            <input placeholder="Experience"
                                                                value=""
                                                                class="form-control @error('experience') is-invalid @enderror "
                                                                name="experience" type="text">
                                                            <span class="text-danger">@error('experience')
                                                                {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-sm-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Comment </label>


                                                            <textarea
                                                                class="form-control @error('comment') is-invalid @enderror "
                                                                name="comment"></textarea>
                                                            <span class="text-danger">@error('comment') {{ $message }}
                                                                @enderror</span>
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
                                                                        value="">Select Status</option>
                                                                    <option 
                                                                        value="1">Active</option>
                                                                    <option 
                                                                        value="2">Deactive</option>


                                                                </select>
                                                            </div>
                                                            <span class="text-danger">@error('status') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                                
                                                
                                                <div class="row">
                                                    <div class="col-sm-3 pull-right">
                                                       <div class="form-group">
                                                           <button type="button" class="btn btn-primary btnadddocument pull-right">Add Documents</button>
                                                          
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                 <br/>
                                                 <div class="appendareadocument">
                                                     
                                                </div>


                                          
                                            
                                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                                      
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
    src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"> </script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
</script>


<script type="text/javascript">
$(document).ready(function() {
    $('.select2').select2();
    
     window.documentnameArr = JSON.parse("{{json_encode($document_names)}}".replace(/&quot;/g,'"'));
    
  
     $(document).on('click','.btndeletedocument',function(){
         $(this).closest('.row').remove();
     })
    $(document).on('click','.btnadddocument',function(){
        
        console.log(window.documentnameArr);
         var index = $(".documentnameclass").length + 1;
        var html =  `<div class="row">
                       <div class="col-sm-3">
                                                       <div class="form-group">
                                                            <label>Document </label>
                                                            <select name="documentname[]" id="id_ct${index}" class="form-control documentnameclass">
                                                            <option value="">select Document</option>`
                                                            
                                                            
                                                           
                                                           $.map(window.documentnameArr, function(element,index) {
                                                               html+= `<option value="${element.id}">${element.name}</option>`}
                                                               )
                                                            
                                                            
                                                            
                                                            
                                                             html+=`</select>
                                                          
                                                        </div>
                                                    </div>
                                                     <div class="col-sm-3">
                                                      <div class="form-group" style="margin-top:28px">
                                                          <input type="hidden" name="documentIsubmittext[]" class="documentIsubmittextid" id="documentIsubmittextid${index}"  value="0" />
                                                          <input type="checkbox" name="documentIsubmit[]" class="documentIsubmitid" data-changeid="documentIsubmittextid${index}" id="documentIsubmitid${index}"  value="0" />
                                                           <label for="documentIsubmitid${index}">isSubmit </label>
                                                           
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="col-sm-4">
                                                       <div class="form-group">
                                                            <label>Comments </label>
                                                            <input type="text" name="documentcomment[]" class="form-control" placeholder="comment" />
                                                           
                                                        </div>
                                                    </div>
                                                     <div class="col-sm-2">
                                                      <button class="btn btn-danger btndeletedocument">Delete</button>
                                                    </div>
                                                     </div>`;
        
        $('.appendareadocument').append(html)
        
        $('form#formteacher').validate();
    })


    $(document).on('change', '#countryload', function() {

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
    
    
     $.validator.addMethod("mytst", function (value, element) {
        var flag = true;
                
      $("[name^=documentname]").each(function (i, j) {
                        $(this).parent('.form-group').find('label.error').remove();
$(this).parent('p').find('label.error').remove();                        
                        if ($.trim($(this).val()) == '') {
                            flag = false;
                            
                            $(this).parent('.form-group').append('<label  id="id_ct'+i+'-error" class="error">This field is required.</label>');
                        }
                    });
                
                
                    return flag;


    }, "");
    
    
    $(document).on('change','.documentIsubmitid',function(){
            let textchangeid  = $(this).attr('data-changeid');
            console.log(textchangeid);
            
            if(this.checked) {
                  $(`#${textchangeid}`).val(1);
            }else{
                 $(`#${textchangeid}`).val(0);
            }
    })

    $("#formteacher").validate({
        ignore: "not:hidden",
        rules: {
            username:{
                required: true,
                remote: {
                 type: 'GET',
                 url: '{{route("checkUserName")}}',
                 data: {
                            username: function () 
                                     {
                                         return $("input[name='username']").val();
                                      }
                            },

               async:false
              
             }
            },
            email:{
                required: true,
                remote: {
                 type: 'GET',
                 url: '{{route("checkUserEmail")}}',
                 data: {
                    email: function () 
                                     {
                                         return $("input[name='email']").val();
                                      }
                            },

               async:false
              
             }
            },
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
                minlength: 5,
            },
            password: {
                required: true,
                minlength: 5
            },
            confirmpassword: {
                minlength: 5,
                equalTo: "#password"
            },
            status: {
                required: true,
            },
            'documentname[]': {
                 mytst:true
            }
            
            

        },
        messages: { //messages to appear on error
            // name: {
            //     required: "Please Enter  your name.",
            //     minlength: "C'mon full name please."
            // }

            username: {
                required: "Please Enter Username!",
                remote: "Username already in use!"
            },
            email: {
                required: "Please Enter Email!",
                remote: "Email already in use!"
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

                    console.log(data);


                    if (data.Success) {
                        swal({
                            title: "Good job!",
                            text: data.msg,
                            icon: "success",
                            button: "Close",
                        });
                        setTimeout(() => {
                            window.location = data.redirect
                        }, 300);
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
                            $(input).parents('.form-group').find('.text-danger')
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


   


});
</script>
@endpush