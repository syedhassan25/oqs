<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('assets/weeklyscdule/dist/jquery.schedule.css') }}">
<link rel="stylesheet" href="{{ asset('assets/weeklyscdule/dist/jquery.schedule-demo.css') }}">


<div class="row">
          <div class="col-lg-12">
            <div id="schedule5" class="jqs-demo mb-3"></div>
          </div>
         
</div>

@push('scripts')

 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('assets/weeklyscdule/dist/jquery.schedule.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>


<script>

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
   
});
</script>
@endpush