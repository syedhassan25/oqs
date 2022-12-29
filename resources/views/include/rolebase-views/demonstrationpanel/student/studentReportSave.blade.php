@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
table, th, td {
  border: 1px solid #ddd;
  text-align:center;
}    
</style>
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/widgets/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
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
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">

                            <div class="table-responsive">
                                    <table data-link="{{route('demonstrationpanel.student.test.save.view.datatable')}}" id="student-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                  <th>Group</th>
                                                  <th>Student Name</th>
                                                  <th>Student Name</th>
                                                  <th>Skype id 2</th>
                                                  <th>Conduct</th>
                                                  <th>Cooperative</th>
                                                  <th>Punctual</th>
                                                  <th>Attentive</th>
                                                  <th>GoodListener</th>
                                                  <th>HardWorking</th>
                                                  <th>PoliteAndKind</th>
                                                  <th>Exmination Date</th>
                                                  <th>Action</th>
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
    
    
    <div id="testReportModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Test Report</h4>
      </div>
           <form id="testreport" action="{{ route('demonstrationpanel.student.test.save') }}" method="POST" role="form">
           <div class="modal-body">
            <div class="row">
                         
                        <div class="col-12">
                          
                                <div class="card">
                              @csrf
                             <input type="hidden" class="studentid" value="" name="studentid"  />
                             <input type="hidden" class="id" value="" name="id"  />
                                <!-- /.card-header -->
                                <div class="card-body">
    
                                <div class="table-responsive">
                                        <table class="table">
                                        <tr>
                                            <td colspan="6" class="examination_date"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"><h1 style="text-align:center">Report</h1></td>
                                        </tr>
                                        <tr>
                                            
                                                @foreach($grade as $val)
                                                       
                                                       <td>{{$val->grade}}</td>
                                                    @endforeach
                                            
                                            
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="4">
                                                <table class="table">
                                                 <tr>
                                                     <td>Student Name</td>
                                                     <td class="studentname"></td>
                                                     <td>Conduct</td>
                                                     <td>
                                                    <select name="ConductGrade" class="form-control">
                                                    <option  value="">Select Grade</option>  
                                                    @foreach($grade as $val)
                                                       <option value="{{$val->grade_val}}">{{$val->grade}}</option>  
                                                    @endforeach
                                                     </select></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Age</td>
                                                      <td class="age"></td>
                                                     <td>Cooperative</td>
                                                     <td><select name="CooperativeGrade" class="form-control">
                                                    <option value="">Select Grade</option>  
                                                    @foreach($grade as $val)
                                                       <option value="{{$val->grade_val}}">{{$val->grade}}</option>  
                                                    @endforeach
                                                     </select></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Level</td>
                                                      <td></td>
                                                     <td>Punctual</td>
                                                     <td><select name="PunctualGrade" class="form-control">
                                                    <option value="">Select Grade</option>  
                                                    @foreach($grade as $val)
                                                       <option value="{{$val->grade_val}}">{{$val->grade}}</option>  
                                                    @endforeach
                                                     </select></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Teacher</td>
                                                      <td class="employeename"></td>
                                                     <td>Attentive</td>
                                                     <td><select name="AttentiveGrade" class="form-control">
                                                    <option value="">Select Grade</option>  
                                                    @foreach($grade as $val)
                                                       <option value="{{$val->grade_val}}">{{$val->grade}}</option>  
                                                    @endforeach
                                                     </select></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Started Date</td>
                                                      <td class="joining_date"></td>
                                                     <td>Good Listener</td>
                                                     <td><select name="GoodListenerGrade" class="form-control">
                                                    <option value="">Select Grade</option>  
                                                    @foreach($grade as $val)
                                                       <option value="{{$val->grade_val}}">{{$val->grade}}</option>  
                                                    @endforeach
                                                     </select></td>
                                                 </tr>
                                                 
                                                 <tr>
                                                     <td colspan="4">Over all Classes Record</td>
                                                     
                                                 </tr>
                                                 <tr>
                                                     <td>Total Classess</td>
                                                      <td class="totalattendance"></td>
                                                     <td>Hard Working</td>
                                                     <td><select name="HardWorkingGrade" class="form-control">
                                                    <option value="">Select Grade</option>  
                                                    @foreach($grade as $val)
                                                       <option value="{{$val->grade_val}}">{{$val->grade}}</option>  
                                                    @endforeach
                                                     </select></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Prsent</td>
                                                      <td class="totalPresentattendance"></td>
                                                     <td>Polite And Kind To Teacher</td>
                                                     <td><select name="PoliteGrade" class="form-control">
                                                    <option value="">Select Grade</option>  
                                                    @foreach($grade as $val)
                                                       <option value="{{$val->grade_val}}">{{$val->grade}}</option>  
                                                    @endforeach
                                                     </select></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Absent</td>
                                                      <td class="totalAbsentattendance"></td>
                                                     <td></td>
                                                     <td></td>
                                                 </tr>
                                                 
                                                 <tr>
                                                     <td colspan="4">Last Exam To Current Exam Between classes Record</td>
                                                     
                                                 </tr>
                                                 <tr>
                                                     <td>Total Classess</td>
                                                      <td class="totalattendance"></td>
                                                     <td></td>
                                                     <td></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Prsent</td>
                                                      <td class="totalPresentattendance"></td>
                                                     <td></td>
                                                     <td></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Absent</td>
                                                      <td class="totalAbsentattendance"></td>
                                                     <td></td>
                                                     <td></td>
                                                 </tr>
                                                 
                                                </table>
                                            </td>
                                            <td></td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">Completed</td>
                                            <td colspan="2">Remarks</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Qaida+Tajweed 50 Pages</td>
                                            <td colspan="2"><input type="text" name="Qaida_TajweedComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="Qaida_TajweedRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">4 Kalmas Hifz</td>
                                            <td colspan="2"><input type="text" name="KalmasHifzComments4" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="KalmasHifzRemarks4" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">20 Duas Hifz</td>
                                            <td colspan="2"><input type="text" name="DuasHifzComments20" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="DuasHifzRemarks20" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">8 Surah Hifz</td>
                                            <td colspan="2"><input type="text" name="SurahHifzComments8" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="SurahHifzRemarks8" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">10 Ahadith Hifz</td>
                                            <td colspan="2"><input type="text" name="AhadithHifzComments10" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="AhadithHifzRemarks10" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Wudhu( Ablution)</td>
                                            <td colspan="2"><input type="text" name="WudhuComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="WudhuRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Basic Beliefs</td>
                                            <td colspan="2"><input type="text" name="BasicBeliefsComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="BasicBeliefsRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Manners</td>
                                            <td colspan="2"><input type="text" name="MannersComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="MannersRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Quran+Tajweed</td>
                                            <td colspan="2"><input type="text" name="QuranTajweedComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="QuranTajweedRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">20 Surah Hifz</td>
                                            <td colspan="2"><input type="text" name="SurahHifzComments20" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="SurahHifzRemarks20" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Complete Kalma</td>
                                            <td colspan="2"><input type="text" name="CompleteKalmaComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="CompleteKalmaRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Complete Dua</td>
                                            <td colspan="2"><input type="text" name="CompleteDuaComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="CompleteDuaRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">40+ Ahadith</td>
                                            <td colspan="2"><input type="text" name="AhadithComments40" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="AhadithRemarks40" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Prayer</td>
                                            <td colspan="2"><input type="text" name="PrayerComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="PrayerRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Hifz ul Quran</td>
                                            <td colspan="2"><input type="text" name="HifzulQuranComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="HifzulQuranRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Translation</td>
                                            <td colspan="2"><input type="text" name="TranslationComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="TranslationRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Tafseer</td>
                                            <td colspan="2"><input type="text" name="TafseerComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="TafseerRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Fiqh</td>
                                            <td colspan="2"><input type="text" name="FiqhComments" class="form-control" placeholder="Comments"/></td>
                                            <td colspan="2"><input type="text" name="FiqhRemarks" class="form-control" placeholder="Remarks"/></td>
                                        </tr>
                                        <tr>
                                            
                                            <td colspan="2" class="">Teacher's Comment</td>
                                            <td colspan="2"></td>
                                            <td colspan="2" class="">Administration's Comment</td>
                                            
                                        </tr>
                                        <tr>
                                            
                                            <td colspan="2"><textarea name="TeacherComments" class="form-control teacherComments"></textarea></td>
                                            <td colspan="2"></td>
                                            <td colspan="2"><textarea name="AdministratorComments" class="form-control AdministrationComments"></textarea></td>
                                            
                                        </tr>
                                        
                                        </table>
    
                                    </div>
    
    
                                </div>
                                <!-- /.card-body -->
                            </div>
                           
    
                        </div>
                        <!-- /.col -->
                    </div>
          </div>
           <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-block" >Save</button>
          </div>
           </form>
    </div>

  </div>
</div>

</div>



@endsection
@push('scripts')

<!-- Data tables -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>
<script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
<script src="{{ asset('assets/widgets/sweetalert/sweetalert2.min.js') }}" defer></script>

<script type="text/javascript" src="{{ asset('assets/widgets/datepicker/datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
    integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
    crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker-demo.js') }}"></script>

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>


<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {
    
    
    
        let _token  = $('meta[name="csrf-token"]').attr('content');

			$(document).on('click','.viewReportID',function(){
			    
				var $id = $(this).attr('data-id');
			    var url = '{{ route("demonstrationpanel.student.test.attend.report.edit", ":id") }}';
                url = url.replace(':id',$id);
				$.get(url,function(res){
                    console.log(res.studentdata.administratorComments);
                    $('#testReportModal').modal('show');
                    
                    
                    
                    $('#testReportModal input[name="id"]').val(res.studentdata.id);
                    $('#testReportModal input[name="studentid"]').val(res.studentdata.studentid);
                    // testReportModal
                    $('#testReportModal .examination_date').html(res.studentdata.reportTestexamination_date);
                    $('#testReportModal .studentname').html(res.studentdata.studentname);
                    $('#testReportModal .age').html(res.studentdata.age);
                    $('#testReportModal .employeename').html(res.studentdata.employeename);
                    $('#testReportModal .joining_date').html(res.studentdata.joining_date);
                    $('#testReportModal .totalattendance').html(res.totalClassess.totalattendance);
                    $('#testReportModal .totalPresentattendance').html(res.totalClassess.totalPresentattendance);
                    $('#testReportModal .totalAbsentattendance').html(res.totalClassess.totalAbsentattendance);
                    $('#testReportModal .totalattendance').html(res.totalClassessaftertest.totalattendance);
                    $('#testReportModal .totalPresentattendance').html(res.totalClassessaftertest.totalPresentattendance);
                    $('#testReportModal .totalAbsentattendance').html(res.totalClassessaftertest.totalAbsentattendance);
                    
                    
                  
              
                    $('#testReportModal select[name="ConductGrade"]').val(res.studentdata.Conduct);
                    $('#testReportModal select[name="CooperativeGrade"]').val(res.studentdata.Cooperative);
                    $('#testReportModal select[name="PunctualGrade"]').val(res.studentdata.Punctual);
                    $('#testReportModal select[name="AttentiveGrade"]').val(res.studentdata.Attentive);
                    $('#testReportModal select[name="GoodListenerGrade"]').val(res.studentdata.GoodListener);
                    $('#testReportModal select[name="HardWorkingGrade"]').val(res.studentdata.HardWorking);
                    $('#testReportModal select[name="PoliteGrade"]').val(res.studentdata.PoliteAndKind);
                    
                    
                    $('#testReportModal input[name="Qaida_TajweedComments"]').val(res.studentdata.QaidaTajweedComplete);
                    $('#testReportModal input[name="Qaida_TajweedRemarks"]').val(res.studentdata.QaidaTajweedRemarks);
                    $('#testReportModal input[name="KalmasHifzComments4"]').val(res.studentdata.KalmasHifzComplete);
                    $('#testReportModal input[name="KalmasHifzRemarks4"]').val(res.studentdata.KalmasHifzRemarks);
                    $('#testReportModal input[name="DuasHifzComments20"]').val(res.studentdata.DuasHifzComplete);
                    $('#testReportModal input[name="DuasHifzRemarks20"]').val(res.studentdata.DuasHifzRemarks);
                    $('#testReportModal input[name="SurahHifzComments8"]').val(res.studentdata.SurahHifzComplete8);
                    $('#testReportModal input[name="SurahHifzRemarks8"]').val(res.studentdata.SurahHifzRemarks8);
                    $('#testReportModal input[name="AhadithHifzComments10"]').val(res.studentdata.AhadithHifzComplete);
                    $('#testReportModal input[name="AhadithHifzRemarks10"]').val(res.studentdata.AhadithHifzRemarks);
                    $('#testReportModal input[name="WudhuComments"]').val(res.studentdata.WudhuComplete);
                    $('#testReportModal input[name="WudhuRemarks"]').val(res.studentdata.WudhuRemarks);
                    $('#testReportModal input[name="BasicBeliefsComments"]').val(res.studentdata.BasicBeliefsComplete);
                    $('#testReportModal input[name="BasicBeliefsRemarks"]').val(res.studentdata.BasicBeliefsRemarks);
                    $('#testReportModal input[name="MannersComments"]').val(res.studentdata.MannersComplete);
                    $('#testReportModal input[name="MannersRemarks"]').val(res.studentdata.MannersRemarks);
                    
                    
                    $('#testReportModal input[name="QuranTajweedComments"]').val(res.studentdata.QuranTajweedComplete);
                    $('#testReportModal input[name="QuranTajweedRemarks"]').val(res.studentdata.QuranTajweedRemarks);
                    $('#testReportModal input[name="SurahHifzComments20"]').val(res.studentdata.SurahHifzComplete20);
                    $('#testReportModal input[name="SurahHifzRemarks20"]').val(res.studentdata.SurahHifzRemarks20);
                    $('#testReportModal input[name="CompleteKalmaComments"]').val(res.studentdata.CompleteKalmaComplete);
                    $('#testReportModal input[name="CompleteKalmaRemarks"]').val(res.studentdata.CompleteKalmaRemarks);
                    $('#testReportModal input[name="CompleteDuaComments"]').val(res.studentdata.CompleteDuaComplete);
                    $('#testReportModal input[name="CompleteDuaRemarks"]').val(res.studentdata.CompleteDuaRemarks);
                    $('#testReportModal input[name="AhadithComments40"]').val(res.studentdata.AhadithComplete);
                    $('#testReportModal input[name="AhadithRemarks40"]').val(res.studentdata.AhadithRemarks);
                    $('#testReportModal input[name="PrayerComments"]').val(res.studentdata.PrayerComplete);
                    $('#testReportModal input[name="PrayerRemarks"]').val(res.studentdata.PrayerRemarks);
                    $('#testReportModal input[name="HifzulQuranComments"]').val(res.studentdata.HifzulQuranComplete);
                    $('#testReportModal input[name="HifzulQuranRemarks"]').val(res.studentdata.HifzulQuranRemarks);
                    $('#testReportModal input[name="TranslationComments"]').val(res.studentdata.TranslationComplete);
                    $('#testReportModal input[name="TranslationRemarks"]').val(res.studentdata.TranslationRemarks);
                    $('#testReportModal input[name="TafseerComments"]').val(res.studentdata.TafseerComplete);
                    $('#testReportModal input[name="TafseerRemarks"]').val(res.studentdata.TafseerRemarks);
                    $('#testReportModal input[name="FiqhComments"]').val(res.studentdata.FiqhComplete);
                    $('#testReportModal input[name="FiqhRemarks"]').val(res.studentdata.FiqhRemarks);
                    $('#testReportModal textarea[name="TeacherComments"]').val(res.studentdata.teacherComments);
                    // $('#testReportModal .AdministratorComments').val(res.studentdata.administratorComments);
                    
                    $('#testReportModal textarea[name="AdministratorComments"]').val(res.studentdata.administratorComments)
                })
				
			
				
			});
    

        var oTable = $('#student-datatable').DataTable({
        processing: true,
        serverSide: true,
      
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
            data: function(d) {
                d.date = $('.joiningDate').val();
                d.academicStatus = $('.academicStatus').val();
                d.teacherId = $("#employeeDrp").val();
                d.groupno = $("#txtserachgroup").val();
            }
        },

        columns: [
            
             {
                data: 'group',
                name: 'student.group'
            },
           
             {
                data: 'studentprofile',
                name: 'studentprofile',
                orderable: false,
                searchable: false
            },
            {
                data: 'studentname',
                name: 'student.studentname',
                searchable: true,
                visible: false
            },
           
            
             {
                data: 'skypid_2',
                name: 'student.skypid_2',
                 searchable: true,
                visible: false
            },
            {
               data: 'Conduct',
                name: 'Conduct',
                orderable: false,
                searchable: false
            },
            {
               data: 'Cooperative',
                name: 'Cooperative',
                orderable: false,
                searchable: false
            },
            {
               data: 'Punctual',
                name: 'Punctual',
                orderable: false,
                searchable: false
            },
            {
                data: 'Attentive',
                name: 'Attentive',
                orderable: false,
                searchable: false
            },
            {
               data: 'GoodListener',
                name: 'GoodListener',
                orderable: false,
                searchable: false
            },
            {
                data: 'HardWorking',
                name: 'HardWorking',
                orderable: false,
                searchable: false
            },
            {
                data: 'PoliteAndKind',
                name: 'PoliteAndKind',
                orderable: false,
                searchable: false
            },
             {
                data: 'examination_date',
                name: 'student.examination_date'
            },
             {
                data: 'detail',
                name: 'detail',
                orderable: false,
                searchable: false
            }
        ]
    });
    
        $("#testreport").validate({
        rules: {
            ConductGrade: {
                required: true,
            },
            CooperativeGrade: {
                required: true,
            },
            PunctualGrade: {
                required: true,
            },
            AttentiveGrade: {
                required: true,
            },
            GoodListenerGrade: {
                required: true,
            },
            HardWorkingGrade: {
                required: true,
            },
            PoliteGrade: {
                required: true,
            },
            Qaida_TajweedComments: {
                required: true,
            },
            Qaida_TajweedRemarks: {
                required: true,
            },
            KalmasHifzComments4: {
                required: true,
            },
            KalmasHifzRemarks4: {
                required: true,
            },
            DuasHifzComments20: {
                required: true,
            },
            DuasHifzRemarks20: {
                required: true,
            },
            SurahHifzComments8: {
                required: true,
            },
            SurahHifzRemarks8: {
                required: true,
            }
            ,
            AhadithHifzComments10: {
                required: true,
            },
            AhadithHifzRemarks10: {
                required: true,
            },
            WudhuComments: {
                required: true,
            }
            ,
            WudhuRemarks: {
                required: true,
            },
            BasicBeliefsComments: {
                required: true,
            },
            BasicBeliefsRemarks: {
                required: true,
            }
            ,
            MannersComments: {
                required: true,
            },
            MannersRemarks: {
                required: true,
            },
            QuranTajweedComments: {
                required: true,
            }
            ,
            QuranTajweedRemarks: {
                required: true,
            },
            SurahHifzComments20: {
                required: true,
            },
            SurahHifzRemarks20: {
                required: true,
            }
            ,
            CompleteKalmaComments: {
                required: true,
            },
            CompleteKalmaRemarks: {
                required: true,
            },
            CompleteDuaComments: {
                required: true,
            }
            ,
            CompleteDuaRemarks: {
                required: true,
            },
             AhadithComments40: {
                required: true,
            }
            ,
            AhadithRemarks40: {
                required: true,
            },
             PrayerComments: {
                required: true,
            }
            ,
            PrayerRemarks: {
                required: true,
            },
             HifzulQuranComments: {
                required: true,
            }
            ,
            HifzulQuranRemarks: {
                required: true,
            },
             TranslationComments: {
                required: true,
            }
            ,
            TranslationRemarks: {
                required: true,
            },
             TafseerComments: {
                required: true,
            }
            ,
            TafseerRemarks: {
                required: true,
            },
             FiqhComments: {
                required: true,
            }
            ,
            FiqhRemarks: {
                required: true,
            },
             AdministratorComments: {
                required: true,
            }
        },
        submitHandler: function(form) {

            var valuesToSubmit = $(form).serialize();
            $.ajax({
                url: $(form).attr('action'),
                data: valuesToSubmit,
                dataType: 'json',
                type: 'POST',
                beforeSend: function() { 
                  $("#btnformsubmitstudent").prop('disabled', true); // disable button
                },
                success: function(data) {
                    
                    console.log(data)
                    
                    $("#btnformsubmitstudent").prop('disabled', false);
                           swal("Student Save Successfully");
                           
                           $('#testReportModal').modal('hide');
                    // window.location.replace("{{route('demonstrationpanel.student.test.save.view')}}")
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