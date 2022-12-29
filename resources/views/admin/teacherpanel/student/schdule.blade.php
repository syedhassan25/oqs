@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<link rel="stylesheet"
      href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/weeklyscdule/dist/jquery.schedule.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/weeklyscdule/dist/jquery.schedule-demo.css') }}">

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

</style>


<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }}</h2>
        <p>{{ $subTitle }}</p>
       
    </div>

    <div class="panel">
        <div class="panel-body">

            <div class="example-box-wrapper">

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>


<script>

$( document ).ready(function() {
  let stringDays  =  ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat','Sun'];
  let days      =  [0, 1, 2, 3, 4, 5, 6];


  let classarray = {"1":[[{"start":"02:04","end":"02:34","status":"booked","dayname":"Tuesday","day":1,"duration":30,"studentid":8},{"start":"06:10","end":"06:30","status":"booked","dayname":"Tuesday","day":1,"duration":20,"studentid":22},{"start":"09:00","end":"09:20","status":"booked","dayname":"Tuesday","day":1,"duration":20,"studentid":23},{"start":"09:20","end":"09:30","status":"booked","dayname":"Tuesday","day":1,"duration":10,"studentid":23},{"start":"09:45","end":"10:00","status":"booked","dayname":"Tuesday","day":1,"duration":15,"studentid":23}]],"2":[[{"start":"03:05","end":"03:35","status":"booked","dayname":"Wednesday","day":2,"duration":30,"studentid":8}]],"3":[[{"start":"04:05","end":"04:35","status":"booked","dayname":"Thursday","day":3,"duration":30,"studentid":8},{"start":"06:10","end":"06:30","status":"booked","dayname":"Thursday","day":3,"duration":20,"studentid":22}]]}


//   let classarray =  {"1":[[{"start":"02:04","end":"02:34","status":"booked","dayname":"Tuesday","day":1,"duration":30,"studentid":8},{"start":"06:10","end":"06:30","status":"booked","dayname":"Tuesday","day":1,"duration":20,"studentid":22},{"start":"09:00","end":"09:20","status":"booked","dayname":"Tuesday","day":1,"duration":20,"studentid":23},{"start":"09:45","end":"10:00","status":"booked","dayname":"Tuesday","day":1,"duration":15,"studentid":23}]],"2":[[{"start":"03:05","end":"03:35","status":"booked","dayname":"Wednesday","day":2,"duration":30,"studentid":8}]],"3":[[{"start":"04:05","end":"04:35","status":"booked","dayname":"Thursday","day":3,"duration":30,"studentid":8},{"start":"06:10","end":"06:30","status":"booked","dayname":"Thursday","day":3,"duration":20,"studentid":22}]]};

//   let classarray =  {"1":[[{"start":"02:04","end":"02:34","status":"booked","dayname":"Tuesday","day":1,"duration":30,"studentid":8},{"start":"06:10","end":"06:30","status":"booked","dayname":"Tuesday","day":1,"duration":20,"studentid":22},{"start":"09:10","end":"09:55","status":"booked","dayname":"Tuesday","day":1,"duration":45,"studentid":23},{"start":"09:30","end":"09:50","status":"booked","dayname":"Tuesday","day":1,"duration":20,"studentid":23}]],"2":[[{"start":"03:05","end":"03:35","status":"booked","dayname":"Wednesday","day":2,"duration":30,"studentid":8}]],"3":[[{"start":"04:05","end":"04:35","status":"booked","dayname":"Thursday","day":3,"duration":30,"studentid":8},{"start":"06:10","end":"06:30","status":"booked","dayname":"Thursday","day":3,"duration":20,"studentid":22}]]}

//   let classarray   = {"1":[[{"start":"02:04","end":"02:34","status":"booked","dayname":"Tuesday","day":1,"duration":30},{"start":"06:10","end":"06:30","status":"booked","dayname":"Tuesday","day":1,"duration":20},{"start":"09:50","end":"10:35","status":"booked","dayname":"Tuesday","day":1,"duration":45}]],"2":[[{"start":"03:05","end":"03:35","status":"booked","dayname":"Wednesday","day":2,"duration":30}]],"3":[[{"start":"04:05","end":"04:35","status":"booked","dayname":"Thursday","day":3,"duration":30},{"start":"06:10","end":"06:30","status":"booked","dayname":"Thursday","day":3,"duration":20}]]};

  //   let classarray = {"1":[[{"start":"02:00","end":"02:10","status":"booked","dayname":"Tuesday","day":1,"duration":10},{"start":"06:10","end":"06:20","status":"booked","dayname":"Tuesday","day":1,"duration":10},{"start":"09:50","end":"10:00","status":"booked","dayname":"Tuesday","day":1,"duration":10}],[{"start":"02:00","end":"02:15","status":"booked","dayname":"Tuesday","day":1,"duration":15},{"start":"06:00","end":"06:15","status":"booked","dayname":"Tuesday","day":1,"duration":15},{"start":"09:45","end":"10:00","status":"booked","dayname":"Tuesday","day":1,"duration":15}],[{"start":"02:00","end":"02:20","status":"booked","dayname":"Tuesday","day":1,"duration":20},{"start":"06:00","end":"06:20","status":"booked","dayname":"Tuesday","day":1,"duration":20},{"start":"09:40","end":"10:00","status":"booked","dayname":"Tuesday","day":1,"duration":20}],[{"start":"02:00","end":"02:30","status":"booked","dayname":"Tuesday","day":1,"duration":30},{"start":"06:00","end":"06:30","status":"booked","dayname":"Tuesday","day":1,"duration":30},{"start":"09:30","end":"10:00","status":"booked","dayname":"Tuesday","day":1,"duration":30}],[{"start":"01:30","end":"02:15","status":"booked","dayname":"Tuesday","day":1,"duration":45},{"start":"06:00","end":"06:45","status":"booked","dayname":"Tuesday","day":1,"duration":45},{"start":"09:45","end":"10:30","status":"booked","dayname":"Tuesday","day":1,"duration":45}],[{"start":"02:00","end":"03:00","status":"booked","dayname":"Tuesday","day":1,"duration":60},{"start":"06:00","end":"07:00","status":"booked","dayname":"Tuesday","day":1,"duration":60},{"start":"09:00","end":"10:00","status":"booked","dayname":"Tuesday","day":1,"duration":60}]],"2":[[{"start":"15:00","end":"15:10","status":"booked","dayname":"Wednesday","day":2,"duration":10}],[{"start":"15:00","end":"15:15","status":"booked","dayname":"Wednesday","day":2,"duration":15}],[{"start":"15:00","end":"15:20","status":"booked","dayname":"Wednesday","day":2,"duration":20}],[{"start":"15:00","end":"15:30","status":"booked","dayname":"Wednesday","day":2,"duration":30}],[{"start":"15:00","end":"15:45","status":"booked","dayname":"Wednesday","day":2,"duration":45}],[{"start":"15:00","end":"16:00","status":"booked","dayname":"Wednesday","day":2,"duration":60}]],"3":[[{"start":"04:00","end":"04:10","status":"booked","dayname":"Thursday","day":3,"duration":10},{"start":"06:10","end":"06:20","status":"booked","dayname":"Thursday","day":3,"duration":10}],[{"start":"04:00","end":"04:15","status":"booked","dayname":"Thursday","day":3,"duration":15},{"start":"06:00","end":"06:15","status":"booked","dayname":"Thursday","day":3,"duration":15}],[{"start":"04:00","end":"04:20","status":"booked","dayname":"Thursday","day":3,"duration":20},{"start":"06:00","end":"06:20","status":"booked","dayname":"Thursday","day":3,"duration":20}],[{"start":"04:00","end":"04:30","status":"booked","dayname":"Thursday","day":3,"duration":30},{"start":"06:00","end":"06:30","status":"booked","dayname":"Thursday","day":3,"duration":30}],[{"start":"03:45","end":"04:30","status":"booked","dayname":"Thursday","day":3,"duration":45},{"start":"06:00","end":"06:45","status":"booked","dayname":"Thursday","day":3,"duration":45}],[{"start":"04:00","end":"05:00","status":"booked","dayname":"Thursday","day":3,"duration":60},{"start":"06:00","end":"07:00","status":"booked","dayname":"Thursday","day":3,"duration":60}]]}


  // for (var p in classarray) {
//     console.log(p);
// }

    newclass = [];

    $.each(days, function (i, _) { 
        
        
      

        if(classarray[i]){
            innernewarray = [];
            classarray[i].map(function(data,inc){
                       

                     

                        data.map(function(innerdata,incInner){
                           
                            // console.log(innerdata,'--',incInner);

                                    if(i == innerdata.day){
                                            // newclass.push(innerdata)  

                                            innernewarray.push(innerdata)

                                     }
                        })

                       
                       
        })
        newclass[i] = innernewarray;
        }
        

        
    
    
    });
    
    
    // console.log('newclass',newclass)
   

  var start = '22:00';
  var  end = '05:00';
  var interval = 30;

   let template     =  '<div class="day-schedule-selector">'         +
                    '<table class="schedule-table">'            +
                      '<thead class="schedule-header"></thead>' +
                      '<tbody class="schedule-rows"></tbody>'   +
                    '</table>'                                  +
                  '<div>';

     $('#day-schedule').html(template)      ;
     
    let  el =  $('#day-schedule')
    let html = '';
    $.each(days, function (i, _) { html += '<th>' + (stringDays[i] || '') + '</th>'; });
    el.find('.schedule-header').html('<tr><th></th>' + html + '</tr>');
 


    $.each(generateDates(start, end, interval), function (i, d) {
      var daysInARow = $.map(new Array(days.length), function (_, i) {

        // let getval  = classarray[d];
        var active = '';
        var   classhtml  = "";
        if(newclass[i]){
            // console.log( hhmm(d),'ttt',days[i],'getval',newclass[i]);

            newclass[i].map(function(data,inc){


                var currentTime= moment(hhmm(d),"hh:mm");    // e.g. 11:00 pm

                // var addTime =   moment(moment(hhmm(d),"hh:mm").add(60, 'minutes').format('hh:mm'),'hh:mm');

                var addTime =  moment(moment(hhmm(d), 'HH:mm:ss').add(interval, 'minutes').format('HH:mm'),"hh:mm");
                var startTime = moment(data.start, "hh:mm");
                var endTime = moment(data.end, "hh:mm");


                // console.log(currentTime,'-----',addTime,'-----',startTime ,'----', endTime)
                // amIBetween = (startTime.isBetween(currentTime , addTime) || startTime.isSame(currentTime)  || endTime.isSame(addTime) ? true : false);
               
               
                amIBetween = (startTime.isBetween(currentTime , addTime) || startTime.isSame(currentTime) ? true : false);
                // console.log(amIBetween);   //  returns false.  if date ignored I expect TRUE

              
             
                if(amIBetween){
                    if(data.duration == 10){

                       

                          active += '<span>active10</span>';
                          classhtml += `<span>${data.studentid}&nbsp;&nbsp;${data.start}&nbsp;&nbsp;${data.end}&nbsp;&nbsp;${data.duration}&nbsp;&nbsp;</span>`
                    }
                    else if(data.duration == 15){
                          active += 'active15';
                          classhtml += `<span>${data.studentid}&nbsp;&nbsp;${data.start}&nbsp;&nbsp;${data.end}&nbsp;&nbsp;${data.duration}&nbsp;&nbsp;</span>`
                    }
                    else if(data.duration == 20){
                        active += '<span>active20</span>';
                        classhtml += `<span>${data.studentid}&nbsp;&nbsp;${data.start}&nbsp;&nbsp;${data.end}&nbsp;&nbsp;${data.duration}&nbsp;&nbsp;</span>`
                    }
                    else if(data.duration == 30){
                        active += '<span>active30</span>';
                        classhtml += `<span>${data.studentid}&nbsp;&nbsp;${data.start}&nbsp;&nbsp;${data.end}&nbsp;&nbsp;${data.duration}&nbsp;&nbsp;</span>`
                    }
                    else if(data.duration == 45){
                        active += '<span>active45</span>';
                        classhtml += `<span>${data.studentid}&nbsp;&nbsp;${data.start}&nbsp;&nbsp;${data.end}&nbsp;&nbsp;${data.duration}&nbsp;&nbsp;</span>`
                    }else if(data.duration == 60){
                        active += '<span>active60</span>';
                        classhtml += `<span>${data.studentid}&nbsp;&nbsp;${data.start}&nbsp;&nbsp;${data.end}&nbsp;&nbsp;${data.duration}&nbsp;&nbsp;</span>`
                    }

                   
                    var fillpercent = ((data.duration / interval) * 100);
                    console.log('data.duration',data.duration,'fillpercent',fillpercent)
                }

                   
            })

            
        }

      
        return '<td class="time-slot '+active+'" data-time="' + hhmm(d) + '" data-day="' + days[i] + '">' + classhtml + '</td>'
      }).join();

      el.find('.schedule-rows').append('<tr><td class="time-label">' + hmmAmPm(d) + '</td>' + daysInARow + '</tr>');
    });

    function generateDates(start, end, interval) {
    var numOfRows = Math.ceil(timeDiffnew(start, end) / interval);
    return $.map(new Array(numOfRows), function (_, i) {
      // need a dummy date to utilize the Date object
      return new Date(new Date(2000, 0, 1, start.split(':')[0], start.split(':')[1]).getTime() + i * interval * 60000);
    });
  }

  function timeDiff(start, end) {   // time in HH:mm format
    // need a dummy date to utilize the Date object
    return (new Date(2000, 0, 1, end.split(':')[0], end.split(':')[1]).getTime() -
            new Date(2000, 0, 1, start.split(':')[0], start.split(':')[1]).getTime()) / 60000;
  }
  
  
   function timeDiffnew(start, end) {   // time in HH:mm format
    // need a dummy date to utilize the Date object
    return (new Date(2000, 0, 1, start.split(':')[0], start.split(':')[1]).getTime() - new Date(2000, 0, 1, end.split(':')[0], end.split(':')[1]).getTime()) / 60000;
  }

  function hhmm(date) {
    var hours = date.getHours()
      , minutes = date.getMinutes();
    return ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);
  }

  function hmmAmPm(date) {
    var hours = date.getHours()
      , minutes = date.getMinutes()
      , ampm = hours >= 12 ? 'pm' : 'am';
    return hours + ':' + ('0' + minutes).slice(-2) + ampm;
  }
  
});
  
  
$(function () {
    
    console.log(JSON.parse("{{json_encode($scduledata)}}".replace(/&quot;/g,'"')))
    
     $('#schedule5').jqs({
      mode: 'read',
      days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      hour: 12,
      periodDuration: 15,
      periodOptions: false,
      data: JSON.parse("{{json_encode($scduledata)}}".replace(/&quot;/g,'"')),
    });
   
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