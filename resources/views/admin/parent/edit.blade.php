@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <a class="btn btn-primary" href="{{ route('admin.parent.index') }}">Back</a></h2>
        <p>{{ $subTitle }}</p>
     
    </div>
    
   <div class="panel">
   <div class="panel-body">
       
       
       
       <div class="example-box-wrapper">
           
            <div class="row">
                        <div class="col-12">
                            <div class="card">

                    
                                <div class="card-body">
                                     <div class="row">
                                    <div class="col-5 col-sm-3">
                                        
                                         
                                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab"
                                                    role="tablist" aria-orientation="vertical">

                                                    <a class="nav-link active" id="tab-example-1" data-toggle="pill"
                                                        href="#tab-example-1" role="tab" aria-controls="tab-example-1"
                                                        aria-selected="true">Profile</a>

                                                    <a class="nav-link" id="#tab-example-2" data-toggle="pill" href="#tab-example-2"
                                                        role="tab" aria-controls="tab-example-2"
                                                        aria-selected="true">Student</a>
                                                  




                                                </div>
                                            </div>
                                            <div class="col-7 col-sm-9">
                                                <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-example-1">
               <div class="example-box-wrapper">
                  @include('admin.partials.flash')
                  <div class="row">
                     <div class="col-12">
                        <form  id="formteacher"  action="{{ route('admin.parent.update') }}" method="POST" role="form"
                           enctype="multipart/form-data">
                           @csrf
                           <!-- general form elements disabled -->
                             <input name="id" value="{{$targetParent->id}}" type="hidden">
                                                <input name="userid" value="{{$targetParent->user_id}}" type="hidden">
                           <div class="card card-warning">
                              <!-- /.card-header -->
                              <div class="card-body">
                        <form role="form">
                             <div class="row">
                        <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                        <label>Group No </label>
                        <input placeholder="Name" value="{{$targetParent->groupno}}" class="form-control @error('groupno') is-invalid @enderror"
                           name="groupno" type="text">
                        <span class="text-danger">@error('groupno') {{ $message }}
                        @enderror</span>
                        </div>
                        </div>
                      
                        </div>
                        <div class="row">
                        <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                        <label>Name </label>
                        <input placeholder="Name" value="{{$targetParent->name}}" class="form-control @error('name') is-invalid @enderror"
                           name="name" type="text">
                        <span class="text-danger">@error('name') {{ $message }}
                        @enderror</span>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                        <label>Father Name </label>
                        <input placeholder="Father Name" class="form-control @error('fname') is-invalid @enderror " value="{{$targetParent->fathername}}"
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
                        <input placeholder="username" class="form-control @error('username') is-invalid @enderror " value="{{$User->name}}"
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
                        <input placeholder="Email" class="form-control @error('email') is-invalid @enderror " value="{{$User->email}}"
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
                        <label>Resource </label>
                        <select id="resource" class=" select2 @error('resource') is-invalid @enderror "
                           name="resource" style="width: 100%;">
                        <option selected="selected" value="">Select Resource</option>
                       <option
                                                                    {{($targetParent->resource_type == 1) ? 'selected' : '' }}
                                                                    value="1">Marketing/Advertisement</option>
                                                                <option
                                                                    {{($targetParent->resource_type == 2) ? 'selected' : '' }}
                                                                    value="2">Reference</option>
                        </select>
                        <span class="text-danger">@error('resource') {{ $message }}
                        @enderror</span>
                        </div>
                        </div>
                        </div>
                         <div class="row"
                                                    style="display:{{($targetParent->resource_type == 1) ? 'block' : 'none' }}">
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
                                                                    {{($targetParent->resource_agency_id == $a->id ) ? 'selected' : '' }}
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
                                                    style="display:{{($targetParent->resource_type == 2) ? 'block' : 'none' }}">
                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Reference Name </label>
                                                            <input placeholder="Reference Name"
                                                                class="form-control referencename @error('referencename') is-invalid @enderror "
                                                                value="{{$targetParent->resource_name}}"
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
                                                                value="{{$targetParent->resource_email}}"
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
                                                                value="{{$targetParent->age}}" name="age" type="text">
                                                            <span class="text-danger">@error('age') {{ $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Gender <span class="text-danger">@error('gender')
                                                                    {{ $message }}
                                                                    @enderror</span></label>
                                                            <div class="clearfix">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="radioPrimary1" value="1"
                                                                        name="gender"
                                                                        {{($targetParent->gender == 1) ? 'checked' : ''}}>
                                                                    <label for="radioPrimary1">
                                                                        Male
                                                                    </label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="radioPrimary2" value="2"
                                                                        {{($targetParent->gender == 2) ? 'checked' : ''}}
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
                                                                    <option @foreach($LanguageLookup as $p) @if($s->id
                                                                        ==
                                                                        $p->language_id)
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
                                                                    {{($targetParent->country_id == $s->id) ? 'selected' : '' }}
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
                                                                @foreach($City as $s)
                                                                <option
                                                                    {{($targetParent->city_id == $s->id) ? 'selected' : '' }}
                                                                    value="{{$s->id}}">{{$s->CityName}}</option>
                                                                @endforeach

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
                                                                value="{{$targetParent->contact_no}}" name="contactno"
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
                                                                value="{{$targetParent->contact_no_2}}"
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
                                                                value="{{$targetParent->whatsapp}}"
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
                                                                value="{{$targetParent->personalEmail}}"
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
                                                                value="{{$targetParent->identity_card_no}}"
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
                                                                value="{{$targetParent->personal_skype}}"
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
                                                                name="currentaddress">{{$targetParent->current_address}}</textarea>
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
                                                                name="permanentaddress">{{$targetParent->permanent_address}}</textarea>
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
                        <label>Comment </label>
                        <textarea class="form-control @error('comment') is-invalid @enderror "
                           name="comment">{{$targetParent->comment}}</textarea>
                        <span class="text-danger">@error('comment') {{ $message }}
                                                                @enderror</span>
                        </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Status </label>
                                    <div class="select2-purple">
                                        <select name="status" id="status" class="status @error('status') is-invalid @enderror  form-control" style="width: 100%;">
                                            <option {{($User->status ==  "") ? 'selected' : ''}}
                                                value="">Select Status</option>
                                            <option {{($User->status ==  1) ? 'selected' : ''}}
                                                value="1">Active</option>
                                            <option {{($User->status ==  2) ? 'selected' : ''}}
                                                value="2">Deactive</option>


                                        </select>
                                    </div>
                                    <span class="text-danger">@error('status') {{ $message }}
                                    @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Invoice Due Date</label>
                                <input type="text" class="bootstrap-datepicker form-control" value="{{ $targetParent->invoice_date }}" name="invoice_due_date" />
                            </div>
                        </div>
                        </form>
                        </div>
                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        </form>
                     </div>
                     <!-- /.col -->
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="tab-example-2">
               <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">


                              <div class="table-responsive">
                                    <table data-link="{{route('admin.parent.student.datatable')}}"
                                        id="student-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                 <th>Status</th>
                                                <th width="20%">Days</th>
                                                <th width="10%">Language</th>
                                                <th>Country</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                                 <th>Detail</th>
                                                

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
     </div>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

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
        
        
         var oTable = $('#student-datatable').DataTable({
        processing: true,
        serverSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
            data: {
                id: '{{$targetParent->id}}'
            }
        },

        columns: [

            {
                data: 'studentprofile',
                name: 'studentprofile',
                orderable: false,
                searchable: false
            },
            {
                data: 'group',
                name: 'student.group'
            },
            
           {
                data: 'class_status',
                name: 'class_status',
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
                data: 'languages',
                name: 'languages',
                orderable: false,
                searchable: false
            },

            {
                data: 'CountryName',
                name: 'countries.CountryName'
            },
            {
                data: 'duration',
                name: 'student.duration'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'detail',
                name: 'detail',
                orderable: false,
                searchable: false
            }
        ]
    });

      
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
    
    
    
      $("#formteacher").validate({
        ignore: "not:hidden",
        rules: {
            name: {
                required: true,
               
            },
            fathername: {
                required: true,
               
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
            //console.log(valuesToSubmit);
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
                        location.reload();
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
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });
    });
</script>
@endpush