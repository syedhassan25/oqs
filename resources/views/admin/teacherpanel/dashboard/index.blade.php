@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<style>

.alert-warning .btn-warning {
  float: right;
}

.alert-warning span {
  line-height: 34px;
}

.alert-warning > div:after {
  clear: both;
  content: '';
  display: table;
}

.chapter{
    position: relative;
    height: 294px;
    z-index: 1;
}


div.chapter1 {
   background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url({{url('project/public/Ramzan.jpg')}});
  height: 88%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  margin-bottom:10px!important;
}

</style>
<div class="container">


    <div class="chapter" >
       <div class="chapter1" id="page-title">
           <!--<div>-->
           <!--     <h2>Dashboard</h2>-->
           <!--  <p>All Stats</p>-->
           <!--</div>-->
       </div>
       
    </div>
    <div style="clear:both"></div>
    
    <div style="display:none" class="row teachetAttendanceAlert">
         @if(count($attendanceTeacher) > 0)
            <div style="display:{{($attendanceTeacher[0]->attendance_status == 0)?'block':'none'}}" class="col-md-12">
            <div id="errorsViewAndAck">
                <div class="alert alert-warning">
                    <div>
                        <span><strong>Please Must Mark Attendance Before 12 PM</strong></span>
                         <button class="btn btn-warning btnsaveattendanceteacher">Present</button>
                    </div>
                </div>
            </div>
        </div>
                
         @endif
    </div>

    

</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
    integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>    
<script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>

<script>


  $(document).on('click','.btnsaveattendanceteacher',function(){
        
        
        var route = '{{ route("teacherpanel.teacher.atttendance.save") }}';

        $.post(route, {attendance:true,_token:$('meta[name="csrf-token"]').attr('content')}, function(data) {

            swal({
                        title: "Attendance!",
                        text: data.msg,
                        icon: "success",
                        button: "Close",
                    });
                    
                    
                    $('.teachetAttendanceAlert').remove();
        })
        
    })


  function CheckTeacherAttendanceAlaert(){
     var format = 'hh:mm:ss'
     var time = moment(),
      beforeTime = moment('20:00:00', format),
      afterTime = moment('24:00:00', format);
    
    if (time.isBetween(beforeTime, afterTime)) {
      $('.teachetAttendanceAlert').show();
    } else {
        $('.teachetAttendanceAlert').hide();
    
    } 
 } 
 
  setInterval(function(){ CheckTeacherAttendanceAlaert(); }, 1000);
 
</script >

@endpush