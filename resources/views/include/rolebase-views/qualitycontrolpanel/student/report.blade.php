 <div class="row">
                     
                    <div class="col-12">
                        <div class="card">

                        <input type="hidden" value="{{$studentdata->id}}" name="studentid"  />
                            <!-- /.card-header -->
                            <div class="card-body">

                            <div class="table-responsive">
                                    <table class="table">
                                    <tr>
                                        <td colspan="6">{{$studentdata->examination_date}}</td>
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
                                                 <td>{{$studentdata->studentname}}</td>
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
                                                  <td>{{$studentdata->age}}</td>
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
                                                  <td>{{$studentdata->employeename}}</td>
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
                                                  <td>{{$studentdata->joining_date}}</td>
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
                                                  <td>{{$totalClassess->totalattendance}}</td>
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
                                                  <td>{{$totalClassess->totalPresentattendance}}</td>
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
                                                  <td>{{$totalClassess->totalAbsentattendance}}</td>
                                                 <td></td>
                                                 <td></td>
                                             </tr>
                                             
                                             <tr>
                                                 <td colspan="4">Last Exam To Current Exam Between classes Record</td>
                                                 
                                             </tr>
                                             <tr>
                                                 <td>Total Classess</td>
                                                  <td>{{isset($totalClassessaftertest->totalattendance) ? $totalClassessaftertest->totalattendance : 0}}</td>
                                                 <td></td>
                                                 <td></td>
                                             </tr>
                                             <tr>
                                                 <td>Prsent</td>
                                                  <td>{{isset($totalClassessaftertest->totalPresentattendance) ? $totalClassessaftertest->totalPresentattendance : 0}}</td>
                                                 <td></td>
                                                 <td></td>
                                             </tr>
                                             <tr>
                                                 <td>Absent</td>
                                                  <td>{{isset($totalClassessaftertest->totalAbsentattendance) ? $totalClassessaftertest->totalAbsentattendance : 0}}</td>
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
                                        
                                        <td colspan="2">Teacher's Comment</td>
                                        <td colspan="2"></td>
                                        <td colspan="2">Administration's Comment</td>
                                        
                                    </tr>
                                    <tr>
                                        
                                        <td colspan="2"><textarea name="TeacherComments" class="form-control"></textarea></td>
                                        <td colspan="2"></td>
                                        <td colspan="2"><textarea name="AdministratorComments" class="form-control"></textarea></td>
                                        
                                    </tr>
                                    
                                    </table>

                                </div>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>