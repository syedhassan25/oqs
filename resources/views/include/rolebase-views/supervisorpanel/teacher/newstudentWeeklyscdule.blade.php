@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<link rel="stylesheet"
      href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/weeklyscdule/dist/jquery.schedule.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/weeklyscdule/dist/jquery.schedule-demo.css') }}">
    <link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<style>
    
    
    .schedule-rows td {
  width: 80px;
  height: 30px;
  margin: 3px;
  padding: 5px;
  background-color: #3498DB;
  cursor: pointer;
  border:1px solid #fff;
}

.schedule-rows td:first-child {
  background-color: transparent;
  text-align: right;
  position: relative;
  top: -12px;
}

.schedule-rows td[data-selected],
.schedule-rows td[data-selecting] { background-color: #E74C3C; }

.schedule-rows td[data-disabled] { opacity: 0.55; }




.active10 {
        color: blue;
  }
.active15 {
    color: blueviolet;
}
.active20 {
    color:chartreuse;
}
.active30 {
    color:cyan;
}
.active45 {
    color:deeppink;
}
.active60 {
    color: gold;
}

.jqs-demo {
    height: 1200px !important;
}

.jqs-period-time {
    cursor: pointer !important;
}

</style>


<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }}</h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>

    <div class="panel">
        <div class="panel-body">

            <div class="example-box-wrapper">
 <div class="row">
  <div class="col-md-4">
                                       <input type="text" value="" class="form-control groupteacherval" placeholder="Group No" />
                                    </div>
                                 
                                       <div class="col-md-2">
                                        <button class="btn btn-primary btngetteacherbygroup">Get Teacher</button>
                                    </div>                                    
                                      <div class="col-md-4">
                                        <select class="form-control js-example-basic-single" id="employeeDrp">
                                            <option value="">Select Teacher</option>
                                            @foreach($Employee as $val)
                                                <option {{($val->id == $id) ? 'selected' : ''}}  value="{{($val->id)}}">{{$val->employeename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                 
                                       <div class="col-md-2">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br/>
    <div class="row">
          <div class="col-lg-12">
            <div id="schedule5" class="jqs-demo mb-3"></div>
          </div>
         
        </div>

                <!--<div class="row">-->
                <!--    <div class="col-12">-->
                <!--        <div id="day-schedule"></div>-->
                <!--    </div>-->
                    <!-- /.col -->
                <!--</div>-->
            </div>
        </div>
    </div>

</div>

@endsection
@push('scripts')

 
   <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
   <script src="{{ asset('assets/weeklyscdule/dist/jquery.schedule.js') }}"></script>
   <script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>


<script>


  
  
$(function () {
    
    $('.js-example-basic-single').select2();
    
      $(document).on('click', '.btnsearchForm', function() {

             $('#schedule5').html('')
           let id = $('#employeeDrp').val();
        var route = '{{ route("supervisorpanel.teacher.student.weekly.schedule.calender", ":id") }}';
        route = route.replace(':id', id);
    
          window.location.href = route;
    })
    
    
    console.log(JSON.parse("{{json_encode($scduledata)}}".replace(/&quot;/g,'"')))
    
     $('#schedule5').jqs({
      mode: 'read',
      days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      hour: 12,
      periodDuration: 15,
      periodOptions: false,
      data: JSON.parse("{{json_encode($scduledata)}}".replace(/&quot;/g,'"')),
    });
    
    
    
    $(document).on('click','.jqs-period',function(){
    
        var id  = $(this).attr('studentid');
        var route = '{{ route("admin.student.edit", ":id") }}';
        route = route.replace(':id', id);
        // window.location.href = route;
        
        window.open(route, '_blank');
        
    })
    
    
     $(document).on('click','.btngetteacherbygroup',function(){
          
         let group =    $('.groupteacherval').val();
         

        var route = '{{ route("supervisorpanel.teacher.group.get.teacher.data") }}';
            // route = route.replace(':group', group);
         let _token  = $('meta[name="csrf-token"]').attr('content');
    
       $.post(route,{group:group,_token:_token},function(res){
           console.log(res)
           
            if (res.length > 0) {
                $('#employeeDrp').html('')
               
                  let html = "<option value=''>Select Teachers</option>"
                    $.each(res, function($i, $val) {
                        console.log($val)
                        html += `<option value="${$val['id']}">${$val['employeename']}</option>`;
                    })
                   $('#employeeDrp').html(html)
                
                console.log(res)
            }
           
       })
        
    })
    
    
    
    
    

    
    
   
    // $('#schedule5').jqs({
    //   mode: 'read',
    //   days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
    //   hour: 12,
    //   periodDuration: 15,
    //   periodOptions: false,
    //   data: [
    //     {
    //       day: 0,
    //       periods: [
    //      {
    //       start: '2:00am',
    //       end: '2:30am',
    //       title: 'A black period',
    //       backgroundColor: '#000',
    //       borderColor: '#000',
    //       textColor: '#fff'
    //      },
    //      {
    //       start: '2:30am',
    //       end: '3:00am',
    //       title: 'A Studen period',
    //       backgroundColor: 'red',
    //       borderColor: '#fff',
    //       textColor: '#ccc'
    //      },
    //      {
    //       start: '3:00am',
    //       end: '3:30am',
    //       title: 'A black period',
    //       backgroundColor: 'green',
    //       borderColor: '#000',
    //       textColor: '#fff'
    //      },
    //      {
    //       start: '3:30am',
    //       end: '3:45am',
    //       title: 'A Studen period',
    //       backgroundColor: 'yellow',
    //       borderColor: '#fff',
    //       textColor: '#ccc'
    //      }
    //       ]
    //     }, {
    //       day: 1,
    //       periods: [
    //         ['1:45am', '5:15am']
    //       ]
    //     }, {
    //       day: 2,
    //       periods: [
    //         ['2', '2p'] // Compact 12 hour
    //       ]
    //     }
    //   ]
    // });
});
</script>
@endpush