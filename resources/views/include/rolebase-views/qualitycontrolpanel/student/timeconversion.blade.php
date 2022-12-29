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

button.btn.btn-primary.mt-5 {
    margin-top: 22px;
}
button.btn.btn-info.btn-block.btnsearchteachertime {
    margin-top: 22px;
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
                           
                                    <div class="panel">
                                        <div class="panel-body">

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
                                                                            {{( old("timezone") == $s['timezone'] )? 'selected' : ''}}
                                                                            data-timezone="{{$s['timezone']}}"
                                                                            value="{{$s['timezone']}}">{{$s['name']}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>

                                                                    <input id="timezoneName" readonly
                                                                        class="form-control timezoneName @error('timezoneName') is-invalid @enderror"
                                                                        name="timezoneName" value="{{old('timezone')}}"
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
                                                           
                                                            <div class="col-sm-12">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Duration <span
                                                                            class="text-danger">@error('duration')
                                                                            {{ $message }}
                                                                            @enderror</span></label>
                                                                    
                                                                        <select name="duration"
                                                                        class="form-control @error('duration') is-invalid @enderror">
                                                                        <option  {{( old('duration') == '') ? 'selected' :''}} value="">Duration</option>
                                                                        <option  {{( old('duration') == '2') ? 'selected' :''}} value="10">10</option>
                                                                        <option  {{( old('duration') == '2') ? 'selected' :''}} value="15">15</option>
                                                                        <option  {{( old('duration') == '2') ? 'selected' :''}} value="20">20</option>
                                                                        <option  {{( old('duration') == '2') ? 'selected' :''}} value="30">30</option>
                                                                        <option  {{( old('duration') == '2') ? 'selected' :''}} value="45">45</option>
                                                                        <option  {{( old('duration') == '2') ? 'selected' :''}} value="60">60</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        

                                                    
                                                        
                                                        
                                                        <div class="row"  >
                                                            <div class="col-sm-6">
                                                                <!-- text input -->
                                                                <div class="form-group">

                                                                    <label>Teacher Country<span
                                                                            class="text-danger">@error('selectnewteacher')
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
                                                                            class="text-danger">@error('selectnewteacher')
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

                                                        <div class="row" >
                                                           

                                                             <div class="col-sm-4">
                                                                
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
                                                        <br/>
                                                         <div class="row" >
                                                            <div class="col-sm-12">
                                                                <table class="table table-bordered">
                                                                   <thead>
                                                                        <tr>
                                                                    
                                                                        <td>Teacher Email</td>
                                                                        <td>Teacher Name</td>
                                                                    </tr>
                                                                   </thead>
                                                                    <tbody id="selectnewteacher">
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                           


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

    function setTimeStudenttime(element, index) {
        var today = new Date();

        var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();



        var dateTime = date + ' ' + element;

        console.log($('#timezoneName').val())

        console.log(toTimeZone(dateTime, $('#timezoneName').val()));

        $('#studenttime' + index).timepicker('setTime', new Date(toTimeZone(dateTime, $('#timezoneName')
            .val())));
    }






    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',

    }).datepicker("update", new Date());;



    $('.timepicker-example').timepicker();

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
             
              $('#formstudent select[name="timezone"]').val(zone).trigger('change')
             
            console.log(val)
            $('#currencysymbol').val(val);

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
                
               let cityid =   $('#formstudent select[name="city"]').attr('data-id');
               if(cityid){
                   $('#formstudent select[name="city"]').val(cityid).trigger('change')
               }
                
                
                

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
                
                
                
                
               html += `<div class="col-md-1">
                     <label for="" class="col-sm-4 control-label"><select name="localtimeday[]" >`;
                     
                     
                      dayinners.forEach(function(item,i) {
                            let daynooo= i+1;
                            
                           let selValday = (daynooo == value) ? 'selected' : ''; 
                            
                            html += `<option ${selValday}  value="${daynooo}">${item}</option>`
                      });
                     
                     
                    
                
                html += `</select></label><div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="localtime[]" readonly id="localtime${index}"  data-index="${index}" class="timepicker-local localtimeclass form-control" type="text">
                      </div>
                      </div>
                      </div>
                      </div>`;


                htmlstudentime += `<div class="col-md-1">
                     <label for="" class="col-sm-4 control-label">${days_name(parseInt(value))}</label>
                     <div class="form-group">
                      <div class="col-sm-12">
                      <div  class="bootstrap-timepicker dropdown">
                       <input name="studenttimeday[]" value="${value}" type="hidden">
                       <input name="studenttime[]" id="studenttime${index}"  data-index="${index}" class="timepicker-student studenttimeclass form-control" type="text">
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

        // setTimeStudenttime(element, index)
        //    console.log('')
    });

    $(document).on("change", ".studenttimeclass", function(e) {

        e.preventDefault();
        var element = $(this).val();

        var index = $(this).attr('data-index');

        var today = new Date();

        var date = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();



        var dateTime = date + ' ' + element;

        console.log('studettime', dateTime)

          


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
        
        console.log(studenttime);
         $('#localtime' + index).timepicker('setTime',studenttime);

       

        // let studenttime = new Date(toTimeZone(dateTime, $('#timezoneName').val() ));

        // console.log('qatartime',qatartime,'---',toTimeZone(dateTime, $('#timezoneName').val()));

        // console.log(qatartime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }))
         
        // console.log('pakistan time',toTimeZone(date + ' ' + qatartime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent'))

        // console.log('pakistantime', new Date(toTimeZone(date + ' ' + qatartime.toLocaleString([], { hour: '2-digit', minute: '2-digit' })), 'Asia/Tashkent'),'----',toTimeZone(qatartime, 'Asia/Tashkent'));
       
       
    //    let localtimeget =   toTimeZone(date + ' ' + studenttime.toLocaleString([], { hour: '2-digit', minute: '2-digit' }),'Asia/Tashkent');
    //     $('#localtime' + index).timepicker('setTime',new Date(localtimeget));
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
         
         console.log(data)
            if (data.error) {
                
            }

            if (data.success) {
                $('#selectnewteacher').html('')
               let res =  data.freeteacher;
                  let html = ""
                    $.each(res, function($i, $val) {
                        console.log($val)
                        html += `<tr><td>${$i+1}</td><td>${$val['teachername']}</td></tr>`;
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
                minlength: 5,
            },
            country: {
                required: true,

            },
            city: {
                required: true,

            },
            timezone: {
                required: true,
               
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
            'language[]': {
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
            ,teacherassign: {
                required: true
            }
            ,
             teacherid: {
                required: function(element) {
                    if ($("#teacherassign").val() == '1') {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
             teacherscduledate: {
                required: function(element) {
                    if ($("#teacherassign").val() == '2') {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
             teacherscduletime: {
                required: function(element) {
                    if ($("#teacherassign").val() == '2') {
                        return true;
                    } else {
                        return false;
                    }
                },
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
                   $('#btnSubmit').attr("disabled", true);
                },
                success: function(data) {
                    
                     swal({
                    title: "Good job!",
                    text: "Student Create Successfully",
                    icon: "success",
                    button: "Close",
                });
                
                
                setTimeout(function(){ 
                    
                     if ($("#teacherassign").val() == '2') {
                       window.location.href = '{{route("admin.student.teacher.schdule")}}';
                 }else{
                      window.location.href = '{{route("admin.student.index")}}';
                 }
                    
                }, 500);
                
                
                    
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
            url: $('#LessonDatatable').attr('data-link')
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
});





$(document).on('click', '.btnsearchgroup', function(e) {
    e.preventDefault();
    console.log('ddd')
    let groupno = $('#groupno').val();
    let _token = $('meta[name="csrf-token"]').attr('content')
    if (groupno != "" && Number.isInteger(parseInt(groupno))) {
        $.post('{{route("student.group.search")}}', {
            groupno: groupno,
            _token: _token
        }, function(res) {
            if (res.success == 2) {

                toastr.info('Group', res.alet)
                
                
                $('#formstudent input[name="fathername"]').val('');
               
                $('#formstudent input[name="contact_no"]').val('');
                $('#formstudent input[name="email"]').val('');
                $('#formstudent select[name="country"]').val('').trigger('change');
                // $('#formstudent select[name="city"]').val(res.data.city).trigger('change');
                
                 $('#formstudent select[name="city"]').attr('data-id','');
                 
                $('#formstudent select[name="timezone"]').val('').trigger('change');
                $('#formstudent input[name="currencysymbol"]').val('');
                $('#formstudent select[name="resource"]').val('').trigger(
                'change');
                $('#formstudent select[name="marketingagencies"]').val('').trigger(
                    'change');
                $('#formstudent input[name="referencename"]').val('');
                $('#formstudent input[name="referenceemail"]').val('');
                $('#formstudent input[name="whatsApp"]').val('');

                $('#formstudent input[name="skype1"]').val('');
                $('#formstudent input[name="skype2"]').val('');

                

            } else {


                $('#formstudent input[name="fathername"]').val(res.data.fathername);
               
                $('#formstudent input[name="contact_no"]').val(res.data.contact_no);
                $('#formstudent input[name="email"]').val(res.data.studentemail);
                $('#formstudent select[name="country"]').val(res.data.country).trigger('change');
                // $('#formstudent select[name="city"]').val(res.data.city).trigger('change');
                
                 $('#formstudent select[name="city"]').attr('data-id',res.data.city);
                 
                $('#formstudent select[name="timezone"]').val(res.data.timezone).trigger('change');
                $('#formstudent input[name="currencysymbol"]').val(res.data.payment_currency);
                $('#formstudent select[name="resource"]').val(res.data.joining_source).trigger(
                'change');
                $('#formstudent select[name="marketingagencies"]').val(res.data.agency_id).trigger(
                    'change');
                $('#formstudent input[name="referencename"]').val(res.data.ref_name);
                $('#formstudent input[name="referenceemail"]').val(res.data.ref_email);
                $('#formstudent input[name="whatsApp"]').val(res.data.whatsapp);

                $('#formstudent input[name="skype1"]').val(res.data.skypid_1);
                $('#formstudent input[name="skype2"]').val(res.data.skypid_2);

                // $('#daysDrp').val(day_arrrrr.split(',')).trigger('change');


                



            }
        })
    } else {
        console.log(Number.isInteger(parseInt(groupno)))
    }
})


$(document).on('change', '.teacherassign', function() {

    var value = $(this).val();
    console.log(value);
    $('#formstudent input[name="teacherscduledate"]').closest('.row').hide();
    $('#formstudent select[name="teacherid"]').closest('.row').hide();

    
    if (value == 1) {
        $('#formstudent input[name="teacherscduledate"]').closest('.row').hide();
        $('#formstudent select[name="teacherid"]').closest('.row').show();
        $('#formstudent #selectteachercountry').closest('.row').show();
    } else if(value == 2) {
        $('#formstudent input[name="teacherscduledate"]').closest('.row').show();
        $('#formstudent select[name="teacherid"]').closest('.row').hide();
         $('#formstudent #selectteachercountry').closest('.row').hide();
    }
})


</script>
@endpush