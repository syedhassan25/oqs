@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/easycal/easycal.css') }}">
<style>
    
.ec-time-range{
    padding-bottom:0 !important
}
.easycal table.ec-head-table {
   
    background-color: bisque;
}
    
.easycal table.ec-time-grid-table tr td .table-cell.ec-slot {
    background-color: #e5ae5b;
}
.easycal table.ec-time-grid-table tr td .table-cell {
    background-color: bisque;
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
          <div class="mycal" style="width:100%;"></div>
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




   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
    <script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('assets/easycal/easycal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/easycal/dataset.js') }}"></script>

<script>


  
  
$(function () {
    
    $('.js-example-basic-single').select2();
    
      $(document).on('click', '.btnsearchForm', function() {

             $('#schedule5').html('')
           let id = $('#employeeDrp').val();
        var route = '{{ route("admin.teacher.student.weekly.schedule.calender", ":id") }}';
        route = route.replace(':id', id);
    
          window.location.href = route;
    })
    
    
    console.log(JSON.parse("{{json_encode($scduledata)}}".replace(/&quot;/g,'"')))
    
    $('.mycal').easycal({
			
			timeFormat : 'hh:mm A',
			columnDateFormat : 'dddd, DD MMM',
			minTime : '00:00:00',
			maxTime : '24:00:00',
			slotDuration : 30,
			timeGranularity : 15,
			
			dayClick : function(el, startTime){
				console.log('Slot selected: ' + startTime);
			},
			eventClick : function(eventId){
				console.log('Event was clicked with id: ' + eventId);
                var arr = eventId.split("-");
                var id  = arr[0];
                var route = '{{ route("admin.student.edit", ":id") }}';
                route = route.replace(':id', id);
                // window.location.href = route;
                
                window.open(route, '_blank');

			},

			events : JSON.parse("{{json_encode($scduledata)}}".replace(/&quot;/g,'"')),
			
			overlapColor : '#FF0',
			overlapTextColor : '#000',
			overlapTitle : 'Multiple'
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
         

        var route = '{{ route("admin.teacher.group.get.teacher.data") }}';
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
    
    
    
    
    

    
    
   
   
});
</script>
@endpush