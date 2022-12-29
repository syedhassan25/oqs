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



 <form id="testreport" action="{{ route('qualitycontrolpanel.student.test.save') }}" method="POST" role="form">
    <div id="page-title">
        <h2>{{ $pageTitle }}  <input id="btnformsubmitstudent" type="submit" class="btn btn-primary float-right" value="Post Report" /></h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>

    <div class="panel">
        <div class="panel-body">

            <div class="example-box-wrapper">
              
                                    @csrf
                                      
                  
    
                    @include('include.rolebase-views.qualitycontrolpanel.student.report')
               

                <div class="row">
                     <h3>Lessons</h3>
                                                            <br />
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">

                            <div class="table-responsive">
                                    <table id="LessonDatatable" data-link="{{route('qualitycontrolpanel.student.lesson.lessondatatable')}}"
                            class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Fundamental islam</th>
                                    <th>Memorization</th>
                                    <th>Ethics</th>
                                    <th>Accent Type</th>
                                    <th>Comment</th>
                                     <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>

                                </div>

                               <div class="table-responsive">
                                    <table data-link="{{route('qualitycontrolpanel.student.classess.all')}}" id="todayclasses-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                               
                                                <th>Teacher Name</th>
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                <th>Attendance Status</th>
                                                <th>Attendance Status</th>
                                                <th>Attendance Day</th>
                                                <th>Class time</th>
                                                <th>Attdendance Time</th>
                                                <th>Student Name</th>
                                                <th>Attendance Date</th>
                                              
                                              
                                              
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
    </form>
</div>

<div id="LessonModalNEw" class="modal fade" role="dialog">
    <div style="width:1250px !important" class="modal-dialog modal-lg">
        <form id="formlessonstudentnew">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">View Lesson</h4>
                </div>

                <div class="modal-body">
                     <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Course </label>

                               
                                
                                <select name="course" id="coursetype" class="form-control @error('course') is-invalid @enderror">
                                    <option value="">Select Course</option>
                                    @foreach($course as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->courseName}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('course')
                                        {{ $message }}
                                        @enderror</span>
                              
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Start Lesson <span class="text-danger">@error('startlesson')
                                        {{ $message }}
                                        @enderror</span></label>

                                <select name="startlesson"
                                    class="form-control @error('startlesson') is-invalid @enderror">
                                    <option value="">Select Start Lesson</option>
                                    <option value="1">Start TO End</option>
                                    <option value="2">End TO Start</option>

                                </select>


                            </div>
                        </div>

                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="1">
                         <div class="quransection"> 
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran Subject </label>


                                <select name="quransubject" class="form-control @error('quransubject') is-invalid @enderror">
                                    <option value="">Select Quran Subject</option>
                                    @foreach($Subjectquran as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('quransubject')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>JuzNumber/chapter </label>

                                <input type="number" name="quranjuznumber"  class="form-control @error('quranjuznumber') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranjuznumber')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranstartpage"  class="form-control @error('quranstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranendpage"  class="form-control @error('quranendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranstartaya"  class="form-control @error('quranstartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranstartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranendaya"  class="form-control @error('quranendaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranendaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="qurancomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran comments </label>

                                <textarea name="qurancomments"
                                    class="form-control @error('qurancomments') is-invalid @enderror"></textarea>
<span class="text-danger">@error('qurancomments')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="2">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran Hifz Subject <span class="text-danger">@error('quranhifzsubject')
                                        {{ $message }}
                                        @enderror</span></label>


                                <select name="quranhifzsubject" class="form-control @error('quranhifzsubject') is-invalid @enderror">
                                    <option value="">Select Quran Hifz</option>
                                    @foreach($quranhifz as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Page Line <span class="text-danger">@error('quranhifzpageline')
                                        {{ $message }}
                                        @enderror</span></label>


                              <input type="text" name="quranhifzpageline"
                                    class="form-control @error('quranhifzpageline') is-invalid @enderror" />
                               
                            </div>
                        </div>
                        
                        <div class="rowsabaq">
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Sabaq </label>


                                <input type="text" readonly value="Sabaq" name="quranhifzsabaq"  class="form-control @error('quranhifzsabaq') is-invalid @enderror" />
                               <span class="text-danger">@error('quranhifzsabaq')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Juz Number </label>

                                <input type="number" name="quranhifzsabaqjuznumber"  class="form-control @error('quranhifzsabaqjuznumber') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqjuznumber')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranhifzsabaqstartpage"  class="form-control @error('quranhifzsabaqstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranhifzsabaqendpage"  class="form-control @error('quranhifzsabaqendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranhifzsabaqstartaya"  class="form-control @error('quranhifzsabaqstartaya') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqstartaya')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranhifzsabaqendaya"  class="form-control @error('quranhifzsabaqendaya') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqendaya')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                        <div class="rowsabaqi">
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Sabaqi </label>


                                <input type="text" readonly value="Sabaqi" name="quranhifzsabaqi"  class="form-control @error('quranhifzsabaqi') is-invalid @enderror" />
                               <span class="text-danger">@error('quranhifzsabaqi')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Juz Number </label>

                                <input type="number" name="quranhifzsabaqijuznumber"  class="form-control @error('quranhifzsabaqijuznumber') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqijuznumber')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranhifzsabaqistartpage"  class="form-control @error('quranhifzsabaqistartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('quranhifzsabaqistartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranhifzsabaqiendpage"  class="form-control @error('quranhifzsabaqiendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqiendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranhifzsabaqistartaya"  class="form-control @error('quranhifzsabaqistartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqistartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranhifzsabaqiendaya"  class="form-control @error('quranhifzsabaqiendaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzsabaqiendaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                        <div class="rowmanzil">
                         <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Manzil </label>


                                <input type="text" readonly value="Manzil" name="quranhifzmanzil"  class="form-control @error('quranhifzmanzil') is-invalid @enderror" />
                               <span class="text-danger">@error('quranhifzmanzil')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Juz Number </label>

                                <input type="number" name="quranhifzmanziljuznumber"  class="form-control @error('quranhifzmanziljuznumber') is-invalid @enderror" />
                                <span class="text-danger">@error('quranhifzmanziljuznumber')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="quranhifzmanzilstartpage"  class="form-control @error('quranhifzmanzilstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="quranhifzmanzilendpage"  class="form-control @error('quranhifzmanzilendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="quranhifzmanzilstartaya"  class="form-control @error('quranhifzmanzilstartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilstartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="quranhifzmanzilendaya"  class="form-control @error('quranhifzmanzilendaya') is-invalid @enderror" />
                        <span class="text-danger">@error('quranhifzmanzilendaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="quranhifzcomm">
                            <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Quran Hifz comments <span class="text-danger">@error('quranhifzcomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="quranhifzcomments"
                                    class="form-control @error('quranhifzcomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="3">
                         <div class="hadeethsection"> 
                         <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Hadeeth Subject </label>


                                <select name="hadeethsubject" class="form-control @error('hadeethsubject') is-invalid @enderror">
                                    <option value="">Select Hadeeth Subject</option>
                                    @foreach($SubjectHadeeth as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('hadeethsubject')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="hadeethstartpage"  class="form-control @error('hadeethstartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('hadeethstartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="hadeethendpage"  class="form-control @error('hadeethendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('hadeethendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="hadeethstartline"  class="form-control @error('hadeethstartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('hadeethstartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="hadeethendline"  class="form-control @error('hadeethendline') is-invalid @enderror" />
                        <span class="text-danger">@error('hadeethendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="hadeethcomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Hadeeth comments <span class="text-danger">@error('hadeethcomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="hadeethcomments"
                                    class="form-control @error('hadeethcomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="4">
                         <div class="qaidasection"> 
                         <div class="col-sm-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Qaida Subject </label>


                                <select name="qaidasubject" class="form-control @error('qaidasubject') is-invalid @enderror">
                                    <option value="">Select Qaida Subject</option>
                                    @foreach($SubjectQaida as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('qaidasubject')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Chapter / Lesson </label>

                                <input type="number" name="qaidachapterlesson"  class="form-control @error('qaidachapterlesson') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidachapterlesson')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="qaidastartpage"  class="form-control @error('qaidastartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidastartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="qaidaendpage"  class="form-control @error('qaidaendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('qaidaendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="qaidastartline"  class="form-control @error('qaidastartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidastartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="qaidaendline"  class="form-control @error('qaidaendline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('qaidaendline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                         <div class="qaidacomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Qaida comments <span class="text-danger">@error('qaidacomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="qaidacomments"
                                    class="form-control @error('qaidacomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row courserenderDiv" style="display:none" data-coursetype="5">
                         <div class="languagesection"> 
                         <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Langauges Subject </label>


                                <select name="languagesubject" class="form-control @error('languagesubject') is-invalid @enderror">
                                    <option value="">Select Langauges Subject</option>
                                    @foreach($SubjectLangauges as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->subjectName}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('languagesubject')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="languagestartpage"  class="form-control @error('languagestartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('languagestartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="languageendpage"  class="form-control @error('languageendpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('languageendpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="languagestartline"  class="form-control @error('languagestartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('languagestartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="languageendline"  class="form-control @error('languageendline') is-invalid @enderror" />
                        <span class="text-danger">@error('languageendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        </div>
                         <div class="qaidacomm"> 
                         <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Language comments <span class="text-danger">@error('languagecomments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="languagecomments"
                                    class="form-control @error('languagecomments') is-invalid @enderror"></textarea>

                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Memorization <span class="text-danger">@error('memorizarion')
                                        {{ $message }}
                                        @enderror</span></label>


                                <select name="memorizarion" id="memorizariontype" class="form-control @error('memorizarion') is-invalid @enderror">
                                    <option value="">Select Memorizarion</option>
                                    @foreach($Memorizationdata as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->memorizationname}}</option>
                                    @endforeach
                                </select>
                              
                            </div>
                        </div>

                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="1">
                         <div class="kalmasection"> 
                         <div class="col-sm-5">
                            <!-- text input -->
                            <div class="form-group">
                                <label>kalma </label>


                                <select name="kalma" class="form-control @error('kalma') is-invalid @enderror">
                                      <option value="">Select Kalma</option>
                                      <option value="1">Kalma 1</option>
                                      <option value="2">Kalma 2</option>
                                      <option value="3">Kalma 3</option>
                                      <option value="4">Kalma 4</option>
                                      <option value="5">Kalma 5</option>
                                      <option value="6">Kalma 6</option>
                                </select>
                               <span class="text-danger">@error('kalma')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                      
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                <input type="number" name="kalmastartmark"  class="form-control @error('kalmastartmark') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('kalmastartmark')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-3">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                 <input type="number" name="kalmaendmark"  class="form-control @error('kalmaendmark') is-invalid @enderror" />
                        <span class="text-danger">@error('kalmaendmark')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                       
                        </div>
                        
                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="2">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Page No </label>
                                        
                                <input type="number" name="masnoonduapageno" class="form-control @error('masnoonduapageno') is-invalid @enderror" /> 
                                   
                               <span class="text-danger">@error('masnoonduapageno')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Dua No </label>
                                        
                                <input type="text" name="masnoonduaduano" class="form-control @error('masnoonduaduano') is-invalid @enderror" /> 
                                   
                               <span class="text-danger">@error('masnoonduaduano')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                       
                        
                       
                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="3">
                        <div class="col-sm-5">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Surah Name </label>
                                        
                                <input type="text" name="surahname" class="form-control @error('surahname') is-invalid @enderror" /> 
                                   
                               <span class="text-danger">@error('surahname')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                <input type="number" name="surahstartaya"  class="form-control @error('surahstartaya') is-invalid @enderror" />
                        <span class="text-danger">@error('surahstartaya')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-3">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Aya </label>

                                 <input type="number" name="surahendaya"  class="form-control @error('surahendaya') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('surahendaya')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                       
                        
                       
                    </div>
                     <div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="4">
                        <div class="col-sm-5">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Dua Name </label>
                                        
                                <input type="text" name="duaname" class="form-control @error('duaname') is-invalid @enderror" /> 
                                   <span class="text-danger">@error('duaname')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                <input type="number" name="duanamestartline"  class="form-control @error('duanamestartline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('duanamestartline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-3">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Mark </label>

                                 <input type="number" name="duanameendline"  class="form-control @error('duanameendline') is-invalid @enderror" />
                        <span class="text-danger">@error('duanameendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                       
                        
                       
                    </div>
                     <div class="row fundamentalislamDiv">
                         <div class="languagesection"> 
                         <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Fundamental Islam </label>


                                <select name="fundamentalislam" class="form-control @error('fundamentalislam') is-invalid @enderror">
                                    <option value="">Select Fundamental Islam</option>
                                    @foreach($Fundamentalislam as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->fundamental_islam_name}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger">@error('fundamentalislam')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                   
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="fundamentalislamstartpage"  class="form-control @error('fundamentalislamstartpage') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('fundamentalislamstartpage')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="fundamentalislamendpage"  class="form-control @error('fundamentalislamendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('fundamentalislamendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="fundamentalislamstartline"  class="form-control @error('fundamentalislamstartline') is-invalid @enderror" />
                        <span class="text-danger">@error('fundamentalislamstartline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="fundamentalislamendline"  class="form-control @error('fundamentalislamendline') is-invalid @enderror" />
                        
                               <span class="text-danger">@error('fundamentalislamendline')
                                        {{ $message }}
                                        @enderror</span>
                            </div>
                        </div>
                        </div>
                        
                    </div>
                     <div class="row ethicsDiv">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Ethics </label>


                                <select name="ethics" id="ethicstype" class="form-control @error('ethics') is-invalid @enderror">
                                    <option value="">Select Ethics</option>
                                    @foreach($Ethicsdata as $data)
                                    <option value="{{$data->id}}">
                                        {{$data->ethicsname}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('ethics')
                                        {{ $message }}
                                        @enderror</span>
                              
                            </div>
                        </div>
                          <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                <input type="number" name="ethicsstartpage"  class="form-control @error('ethicsstartpage') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsstartpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
 <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>page </label>

                                 <input type="number" name="ethicsendpage"  class="form-control @error('ethicsendpage') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsendpage')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                <input type="number" name="ethicsstartline"  class="form-control @error('ethicsstartline') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsstartline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                               
                                <label></label>
                               <div class="input-group" style="margin-top: 7px !important;">
                                    <span class="input-group-addon bg-black">
                                        to
                                    </span>
                                  
                                </div>
                        
                               
                            </div>
                        </div>
                         <div class="col-sm-1">
                            
                            <!-- text input -->
                            <div class="form-group">
                                <label>Line </label>

                                 <input type="number" name="ethicsendline"  class="form-control @error('ethicsendline') is-invalid @enderror" />
                        <span class="text-danger">@error('ethicsendline')
                                        {{ $message }}
                                        @enderror</span>
                               
                            </div>
                        </div>

                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Comments <span class="text-danger">@error('comments')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="comments"
                                    class="form-control @error('comments') is-invalid @enderror"></textarea>

                            </div>
                        </div>

                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">

                                <label>Method <span class="text-danger">@error('accent_type')
                                        {{ $message }}
                                        @enderror</span></label>
                                <select name="accent_type"
                                    class="form-control @error('accent_type') is-invalid @enderror">
                                    <option value="">Select Accent</option>
                                    <option value="1">Asian</option>
                                    <option value="2">Arabic</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
        </form>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
    integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
    crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/daterangepicker/daterangepicker-demo.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
</script>

<!-- Bootstrap Timepicker -->

<script type="text/javascript" src="{{ asset('assets/widgets/timepicker/timepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.1/moment-timezone-with-data-2010-2020.min.js">
</script>


<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {

 var oTable = $('#todayclasses-datatable').DataTable({
         processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#todayclasses-datatable').attr('data-link'),
             data: function(d) {
                d.id = '{{request()->route("id")}}';
            }
        },

        columns: [
            {
                data: 'employeename',
                name: 'employees.employeename'
            },
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
                data: 'attendancestatusColor',
                name: 'attendancestatusColor',
                orderable: false,
                searchable: false
            },
             {
                data: 'status_name',
                name: 'attendance_status.status_name',
                searchable: true, visible: false
            },
             {
                data: 'day_name',
                name: 'studentattendance.day_name'
            },
             {
                data: 'classtime',
                name: 'studentattendance.attdendancetime',
                orderable: false,
                searchable: false
            },
             {
                data: 'attdendancetime',
                name: 'attdendancetime',
                orderable: false,
                searchable: false
            },
            { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
            {
                data: 'attendancedate',
                name: 'studentattendance.created_at'
            },
            
        ],
        "drawCallback": function( settings ) {
        var api = this.api();
 
            $('.totalrecordsdatatable').html(api.rows( {page:'current'} ).data().length)
        // Output the data for the visible rows to the browser's console
        console.log( api.rows( {page:'current'} ).data().length );
    }
    });
    var oTable = $('#LessonDatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#LessonDatatable').attr('data-link'),
            data: {
                id: '{{request()->route("id")}}'
            }
        },

        columns: [{
                data: 'courseName',
                name: 'course.courseName'
            },
            {
                data: 'fundamental_islam_name',
                name: 'fundamental_islam.fundamental_islam_name'
            },
             {
                data: 'memorizationname',
                name: 'memorization.memorizationname'
            },
             {
                data: 'ethicsname',
                name: 'ethics.ethicsname'
            },
            
            {
                data: 'accent',
                name: 'student_lesson_new.accent',
                orderable: false,
                searchable: false
            },
            {
                data: 'comments',
                name: 'student_lesson_new.comments'
            },
             {
                data: 'created_at_new',
                name: 'created_at_new',
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
    
     $(document).on('click', '.btneditleson', function() {
        var id = $(this).attr('data-id');
        
        $(`.courserenderDiv`).hide();
         $(`.memorizationrenderDiv`).hide();
         
         
         
         
         $("#formlessonstudentnew input[type='text']").prop("disabled", true);
        $("#formlessonstudentnew input[type='number']").prop("disabled", true);
        $("#formlessonstudentnew select").prop("disabled", true);
        $("#formlessonstudentnew textarea").prop("disabled", true);
        

         
         

         $(`#formlessonstudentnew input[name="id"]`).val('')
         $(`#formlessonstudentnew select`).val('');
         $(`#formlessonstudentnew input`).val('')
         $(`#formlessonstudentnew textarea`).val('')
         $(`#formlessonstudentnew input[name="quranhifzsabaq"]`).val('Sabaq')
         $(`#formlessonstudentnew input[name="quranhifzsabaqi"]`).val('Sabaqi')
         $(`#formlessonstudentnew input[name="quranhifzmanzil"]`).val('Manzil')
          $(`#formlessonstudentnew input[name="student_id"]`).val('{{request()->route("id")}}')

        var route = '{{ route("qualitycontrolpanel.student.lesson.edit", ":id") }}';

        route = route.replace(':id', id);

        $.get(route, {}, function(res) {


            let coursid =  res.course_id;
            let memorizationid =  res.memorization_id;
                 $(`.courserenderDiv`).hide();
                 $(`.courserenderDiv[data-coursetype="${coursid}"]`).show();
                 if(coursid == '2'){
                     $(`.memorizationrenderDiv`).hide();
                       $(`#memorizariontype`).closest('.row').hide();
                       $(`#memorizariontype`).val('');
                 }else{
                       $(`#memorizariontype`).closest('.row').show();
                       $(`#memorizariontype`).val('');
                 }
                 
                 
                  $(`.memorizationrenderDiv`).hide();
                  if(coursid !=  '2'){
                     if(memorizationid != ""){
                  
                        $(`.memorizationrenderDiv[data-memorizationtype="${memorizationid}"]`).show();
                   }
                  }else{
                       $(`#memorizariontype`).closest('.row').hide();
                       $(`#memorizariontype`).val('');
                  }
            
               $(`#formlessonstudentnew select[name="course"]`).val(res.course_id);
               $(`#formlessonstudentnew input[name="id"]`).val(res.id);
               $(`#formlessonstudentnew select[name="accent_type"]`).val(res.accent_type);
               $(`#formlessonstudentnew textarea[name="comments"]`).val(res.comments);
               $(`#formlessonstudentnew input[name="teacher_id"]`).val(res.teacher_id);
               
               
               if(coursid == 1){
               
                
                
               $(`#formlessonstudentnew select[name="quransubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="quranjuznumber"]`).val(res.juz_number);
               $(`#formlessonstudentnew input[name="quranstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="quranendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="quranstartaya"]`).val(res.startaya_course);
               $(`#formlessonstudentnew input[name="quranendaya"]`).val(res.endaya_course);
               $(`#formlessonstudentnew textarea[name="qurancomments"]`).val(res.comments_course);
               $(`#formlessonstudentnew select[name="startlesson"]`).val(res.startlesson);
                
                
             }
            
             if(coursid == 2){
               
             
                
                
               $(`#formlessonstudentnew select[name="quranhifzsubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="quranhifzpageline"]`).val(res.quranhifzpageline);
               $(`#formlessonstudentnew input[name="quranhifzsabaqjuznumber"]`).val(res.juz_number);
               $(`#formlessonstudentnew input[name="quranhifzsabaqstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqstartaya"]`).val(res.startaya_course);
               $(`#formlessonstudentnew input[name="quranhifzsabaqendaya"]`).val(res.endaya_course);
              
                
            
                
                
               $(`#formlessonstudentnew input[name="quranhifzsabaqijuznumber"]`).val(res.sabaqi_juz_number);
               $(`#formlessonstudentnew input[name="quranhifzsabaqistartpage"]`).val(res.sabaqi_start_page);
               $(`#formlessonstudentnew input[name="quranhifzsabaqiendpage"]`).val(res.sabaqi_end_page);
               $(`#formlessonstudentnew input[name="quranhifzsabaqistartaya"]`).val(res.sabaqi_start_aya);
               $(`#formlessonstudentnew input[name="quranhifzsabaqiendaya"]`).val(res.sabaqi_end_aya);
                
                
        
                
                
               $(`#formlessonstudentnew input[name="quranhifzmanziljuznumber"]`).val(res.manzil__juz_number);
               $(`#formlessonstudentnew input[name="quranhifzmanzilstartpage"]`).val(res.manzil_start_page);
               $(`#formlessonstudentnew input[name="quranhifzmanzilendpage"]`).val(res.manzil_end_page);
               $(`#formlessonstudentnew input[name="quranhifzmanzilstartaya"]`).val(res.manzil_start_aya);
               $(`#formlessonstudentnew input[name="quranhifzmanzilendaya"]`).val(res.manzil_end_aya);
                
                
                
               $(`#formlessonstudentnew textarea[name="quranhifzcomments"]`).val(res.comments_course);
                
                
                
             }
         
             if(coursid == 3){
                  
               $(`#formlessonstudentnew select[name="hadeethsubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="hadeethstartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="hadeethendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="hadeethstartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="hadeethendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="hadeethcomments"]`).val(res.comments_course);
               
             } 
            
             if(coursid == 4){
                  

                
               $(`#formlessonstudentnew select[name="qaidasubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="qaidastartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="qaidaendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="qaidastartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="qaidaendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="qaidacomments"]`).val(res.comments_course);
                
                
            }
            
             if(coursid == 5){
                 
                 
               $(`#formlessonstudentnew select[name="languagesubject"]`).val(res.subject_id);
               $(`#formlessonstudentnew input[name="languagestartpage"]`).val(res.startpage_course);
               $(`#formlessonstudentnew input[name="languageendpage"]`).val(res.endpage_course);
               $(`#formlessonstudentnew input[name="languagestartline"]`).val(res.startline_course);
               $(`#formlessonstudentnew input[name="languageendline"]`).val(res.endline_course);
               $(`#formlessonstudentnew textarea[name="languagecomments"]`).val(res.comments_course);
            
            
           }
               
               
               $(`#formlessonstudentnew select[name="fundamentalislam"]`).val(res.fundamental_islam_id);
               if(res.fundamental_islam_id){
                   $(`#formlessonstudentnew input[name="fundamentalislamstartpage"]`).val(res.startpage_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamendpage"]`).val(res.endpage_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamstartline"]`).val(res.startline_fundamentalislam);
                   $(`#formlessonstudentnew input[name="fundamentalislamendline"]`).val(res.endline_fundamentalislam);
               }
               $(`#formlessonstudentnew select[name="memorizarion"]`).val(memorizationid);
               if(memorizationid){
                  
                   if(memorizationid == 1){
                   
                    $(`#formlessonstudentnew select[name="kalma"]`).val(res.kalma_no);
                    $(`#formlessonstudentnew input[name="kalmastartmark"]`).val(res.startmark);
                    $(`#formlessonstudentnew input[name="kalmaendmark"]`).val(res.endmark);
                    
                   }
                 if(memorizationid == 2){
                   
               
                    
                    $(`#formlessonstudentnew input[name="masnoonduapageno"]`).val(res.pageno_masnoondua);
                    $(`#formlessonstudentnew input[name="masnoonduaduano"]`).val(res.dua_no_masnoondua);
                    
                 }
                 if(memorizationid == 3){
                    
                    $(`#formlessonstudentnew input[name="surahname"]`).val(res.surah_name_shortsurah);
                    $(`#formlessonstudentnew input[name="surahstartaya"]`).val(res.startaya_shortsurah);
                    $(`#formlessonstudentnew input[name="surahendaya"]`).val(res.endaya_shortsurah);
                    
                 }
                 if(memorizationid == 4){
                  
                    
                    $(`#formlessonstudentnew input[name="duaname"]`).val(res.dua_Name_mainduas);
                    $(`#formlessonstudentnew input[name="duanamestartline"]`).val(res.startline_mainduas);
                    $(`#formlessonstudentnew input[name="duanameendline"]`).val(res.endline_mainduas);
                 }
                   
               }
               $(`#formlessonstudentnew select[name="ethics"]`).val(res.ethics_id);
               if(res.ethics_id){
                   $(`#formlessonstudentnew input[name="ethicsstartpage"]`).val(res.startpage_ethics);
                   $(`#formlessonstudentnew input[name="ethicsendpage"]`).val(res.endpage_ethics);
                   $(`#formlessonstudentnew input[name="ethicsstartline"]`).val(res.startline_ethics);
                   $(`#formlessonstudentnew input[name="ethicsendline"]`).val(res.endline_ethics);
               }
               
               
               
            // $(`#formlessonstudent input[name="id"]`).val(res.id)
            // $(`#formlessonstudent select[name="fundamentalislam"]`).val(res.fundamental_islam_id);
            // $(`#formlessonstudent select[name="memorizationLesson"]`).val(res.ethics_id)
            // $(`#formlessonstudent select[name="ethics"]`).val(res.memorization_id);
            // $(`#formlessonstudent input[name="chapter"]`).val(res.chapter)
            // $(`#formlessonstudent select[name="subject"]`).val(res.subject_id);
            // $(`#formlessonstudent select[name="startlesson"]`).val(res.start_to_end)
            // $(`#formlessonstudent input[name="average"]`).val(res.average)
            // $(`#formlessonstudent input[name="frompage"]`).val(res.page_to_from)
            // $(`#formlessonstudent input[name="fromayah"]`).val(res.ayah_line)
            // $(`#formlessonstudent select[name="memorization"]`).val(res.memorization)
            // $(`#formlessonstudent textarea[name="memorizationdetail"]`).val(res
            //     .memorization_detail)
            // $(`#formlessonstudent select[name="accent_type"]`).val(res.accent_type);

            $('#LessonModalNEw').modal('show');
        })


    })
    


    
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
                    window.location.replace("{{route('qualitycontrolpanel.student.test.save.view')}}")
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