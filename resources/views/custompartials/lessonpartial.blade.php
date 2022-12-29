@if (!$saveWithParentForm)
    <div id="LessonModalNEw" class="modal fade  new" role="dialog">
        <div style="width:1250px !important" class="modal-dialog modal-lg">
            <form id="formlessonstudentnew" action="{{ $SaveRoute }}" method="POST" role="form">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Lesson</h4>
                    </div>
                    <div class="modal-body">
@endif

<div class="row">
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>Course </label>



            <input type="hidden" name="lastattendance_id" value="{{ $lessonlastAttendanceId }}" />
            <input type="hidden" name="attendance_id" value="{{ $lessonattendance_id }}" />
            <input type="hidden" name="student_id" value="{{ $lessonstudentid }}" />
            <input type="hidden" name="id" value="{{ $lessonid }}" />
            <input type="hidden" name="teacher_id" value="{{ $lessonteacherid }}" />


            <select name="course" id="coursetype" class="form-control @error('course') is-invalid @enderror">
                <option value="">Select Course</option>
                @foreach ($course as $data)
                    <option value="{{ $data->id }}">
                        {{ $data->courseName }}</option>
                @endforeach
            </select>
            <span class="text-danger">
                @error('course')
                    {{ $message }}
                @enderror
            </span>

        </div>
    </div>
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>Start Lesson <span class="text-danger">
                    @error('startlesson')
                        {{ $message }}
                    @enderror
                </span></label>

            <select name="startlesson" class="form-control @error('startlesson') is-invalid @enderror">
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
                    @foreach ($Subjectquran as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->subjectName }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('quransubject')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-2">
            <!-- text input -->
            <div class="form-group">
                <label>JuzNumber/chapter </label>

                <input type="number" name="quranjuznumber"
                    class="form-control @error('quranjuznumber') is-invalid @enderror" />

                <span class="text-danger">
                    @error('quranjuznumber')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="quranstartpage"
                    class="form-control @error('quranstartpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranstartpage')
                        {{ $message }}
                    @enderror
                </span>

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

                <input type="number" name="quranendpage"
                    class="form-control @error('quranendpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranendpage')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Aya </label>

                <input type="number" name="quranstartaya"
                    class="form-control @error('quranstartaya') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranstartaya')
                        {{ $message }}
                    @enderror
                </span>

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

                <input type="number" name="quranendaya"
                    class="form-control @error('quranendaya') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranendaya')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
    </div>
    <div class="qurancomm">
        <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
                <label>Quran comments </label>

                <textarea name="qurancomments" class="form-control @error('qurancomments') is-invalid @enderror"></textarea>
                <span class="text-danger">
                    @error('qurancomments')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
    </div>
</div>
<div class="row courserenderDiv" style="display:none" data-coursetype="2">
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>Quran Hifz Subject <span class="text-danger">
                    @error('quranhifzsubject')
                        {{ $message }}
                    @enderror
                </span></label>


            <select name="quranhifzsubject" class="form-control @error('quranhifzsubject') is-invalid @enderror">
                <option value="">Select Quran Hifz</option>
                @foreach ($quranhifz as $data)
                    <option value="{{ $data->id }}">
                        {{ $data->subjectName }}</option>
                @endforeach
            </select>

        </div>
    </div>
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>Page Line <span class="text-danger">
                    @error('quranhifzpageline')
                        {{ $message }}
                    @enderror
                </span></label>


            <input type="text" name="quranhifzpageline"
                class="form-control @error('quranhifzpageline') is-invalid @enderror" />

        </div>
    </div>

    <div class="rowsabaq">
        <div class="col-sm-3">
            <!-- text input -->
            <div class="form-group">
                <label>Sabaq </label>


                <input type="text" readonly value="Sabaq" name="quranhifzsabaq"
                    class="form-control @error('quranhifzsabaq') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaq')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-2">
            <!-- text input -->
            <div class="form-group">
                <label>Juz Number </label>

                <input type="number" name="quranhifzsabaqjuznumber"
                    class="form-control @error('quranhifzsabaqjuznumber') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaqjuznumber')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="quranhifzsabaqstartpage"
                    class="form-control @error('quranhifzsabaqstartpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaqstartpage')
                        {{ $message }}
                    @enderror
                </span>

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

                <input type="number" name="quranhifzsabaqendpage"
                    class="form-control @error('quranhifzsabaqendpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaqendpage')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Aya </label>

                <input type="number" name="quranhifzsabaqstartaya"
                    class="form-control @error('quranhifzsabaqstartaya') is-invalid @enderror" />

                <span class="text-danger">
                    @error('quranhifzsabaqstartaya')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="quranhifzsabaqendaya"
                    class="form-control @error('quranhifzsabaqendaya') is-invalid @enderror" />

                <span class="text-danger">
                    @error('quranhifzsabaqendaya')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
    </div>
    <div class="rowsabaqi">
        <div class="col-sm-3">
            <!-- text input -->
            <div class="form-group">
                <label>Sabaqi </label>


                <input type="text" readonly value="Sabaqi" name="quranhifzsabaqi"
                    class="form-control @error('quranhifzsabaqi') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaqi')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-2">
            <!-- text input -->
            <div class="form-group">
                <label>Juz Number </label>

                <input type="number" name="quranhifzsabaqijuznumber"
                    class="form-control @error('quranhifzsabaqijuznumber') is-invalid @enderror" />

                <span class="text-danger">
                    @error('quranhifzsabaqijuznumber')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="quranhifzsabaqistartpage"
                    class="form-control @error('quranhifzsabaqistartpage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('quranhifzsabaqistartpage')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="quranhifzsabaqiendpage"
                    class="form-control @error('quranhifzsabaqiendpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaqiendpage')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Aya </label>

                <input type="number" name="quranhifzsabaqistartaya"
                    class="form-control @error('quranhifzsabaqistartaya') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaqistartaya')
                        {{ $message }}
                    @enderror
                </span>

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

                <input type="number" name="quranhifzsabaqiendaya"
                    class="form-control @error('quranhifzsabaqiendaya') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzsabaqiendaya')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
    </div>
    <div class="rowmanzil">
        <div class="col-sm-3">
            <!-- text input -->
            <div class="form-group">
                <label>Manzil </label>


                <input type="text" readonly value="Manzil" name="quranhifzmanzil"
                    class="form-control @error('quranhifzmanzil') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzmanzil')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-2">
            <!-- text input -->
            <div class="form-group">
                <label>Juz Number </label>

                <input type="number" name="quranhifzmanziljuznumber"
                    class="form-control @error('quranhifzmanziljuznumber') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzmanziljuznumber')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="quranhifzmanzilstartpage"
                    class="form-control @error('quranhifzmanzilstartpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzmanzilstartpage')
                        {{ $message }}
                    @enderror
                </span>

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

                <input type="number" name="quranhifzmanzilendpage"
                    class="form-control @error('quranhifzmanzilendpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzmanzilendpage')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Aya </label>

                <input type="number" name="quranhifzmanzilstartaya"
                    class="form-control @error('quranhifzmanzilstartaya') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzmanzilstartaya')
                        {{ $message }}
                    @enderror
                </span>

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

                <input type="number" name="quranhifzmanzilendaya"
                    class="form-control @error('quranhifzmanzilendaya') is-invalid @enderror" />
                <span class="text-danger">
                    @error('quranhifzmanzilendaya')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
    </div>
    <div class="quranhifzcomm">
        <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
                <label>Quran Hifz comments <span class="text-danger">
                        @error('quranhifzcomments')
                            {{ $message }}
                        @enderror
                    </span></label>

                <textarea name="quranhifzcomments" class="form-control @error('quranhifzcomments') is-invalid @enderror"></textarea>

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
                    @foreach ($SubjectHadeeth as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->subjectName }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('hadeethsubject')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="hadeethstartpage"
                    class="form-control @error('hadeethstartpage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('hadeethstartpage')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="hadeethendpage"
                    class="form-control @error('hadeethendpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('hadeethendpage')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Line </label>

                <input type="number" name="hadeethstartline"
                    class="form-control @error('hadeethstartline') is-invalid @enderror" />

                <span class="text-danger">
                    @error('hadeethstartline')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="hadeethendline"
                    class="form-control @error('hadeethendline') is-invalid @enderror" />
                <span class="text-danger">
                    @error('hadeethendline')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
    </div>
    <div class="hadeethcomm">
        <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
                <label>Hadeeth comments <span class="text-danger">
                        @error('hadeethcomments')
                            {{ $message }}
                        @enderror
                    </span></label>

                <textarea name="hadeethcomments" class="form-control @error('hadeethcomments') is-invalid @enderror"></textarea>

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
                    @foreach ($SubjectQaida as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->subjectName }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('qaidasubject')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-2">
            <!-- text input -->
            <div class="form-group">
                <label>Chapter / Lesson </label>

                <input type="number" name="qaidachapterlesson"
                    class="form-control @error('qaidachapterlesson') is-invalid @enderror" />

                <span class="text-danger">
                    @error('qaidachapterlesson')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="qaidastartpage"
                    class="form-control @error('qaidastartpage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('qaidastartpage')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="qaidaendpage"
                    class="form-control @error('qaidaendpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('qaidaendpage')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Line </label>

                <input type="number" name="qaidastartline"
                    class="form-control @error('qaidastartline') is-invalid @enderror" />

                <span class="text-danger">
                    @error('qaidastartline')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="qaidaendline"
                    class="form-control @error('qaidaendline') is-invalid @enderror" />

                <span class="text-danger">
                    @error('qaidaendline')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
    </div>
    <div class="qaidacomm">
        <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
                <label>Qaida comments <span class="text-danger">
                        @error('qaidacomments')
                            {{ $message }}
                        @enderror
                    </span></label>

                <textarea name="qaidacomments" class="form-control @error('qaidacomments') is-invalid @enderror"></textarea>

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
                    @foreach ($SubjectLangauges as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->subjectName }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('languagesubject')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="languagestartpage"
                    class="form-control @error('languagestartpage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('languagestartpage')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="languageendpage"
                    class="form-control @error('languageendpage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('languageendpage')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Line </label>

                <input type="number" name="languagestartline"
                    class="form-control @error('languagestartline') is-invalid @enderror" />

                <span class="text-danger">
                    @error('languagestartline')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="languageendline"
                    class="form-control @error('languageendline') is-invalid @enderror" />
                <span class="text-danger">
                    @error('languageendline')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
    </div>
    <div class="qaidacomm">
        <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
                <label>Language comments <span class="text-danger">
                        @error('languagecomments')
                            {{ $message }}
                        @enderror
                    </span></label>

                <textarea name="languagecomments" class="form-control @error('languagecomments') is-invalid @enderror"></textarea>

            </div>
        </div>
    </div>
</div>
<div class="row courserenderDiv" style="display:none" data-coursetype="6">
    <div class="islamichistorysection">
        <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
                <label>Islamic History Book </label>


                <input type="text" name="islamichistorybook"
                    class="form-control @error('islamichistorybook') is-invalid @enderror" />
                <span class="text-danger">
                    @error('islamichistorybook')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
                <label>page No </label>

                <input type="number" name="islamichistorypage"
                    class="form-control @error('islamichistorypage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('islamichistorypage')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>


    </div>
    <div class="islamichistorycomm">
        <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
                <label>Islamic History comments <span class="text-danger">
                        @error('languagecomments')
                            {{ $message }}
                        @enderror
                    </span></label>

                <textarea name="islamichistorycomments" class="form-control @error('islamichistorycomments') is-invalid @enderror"></textarea>

            </div>
        </div>
    </div>
</div>
<div class="row courserenderDiv" style="display:none" data-coursetype="7">
    <div class="islamicKnowledgesection">
        <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
                <label>Islamic Knowledge Book </label>


                <input type="text" name="islamicKnowledgebook"
                    class="form-control @error('islamicKnowledgebook') is-invalid @enderror" />
                <span class="text-danger">
                    @error('islamicKnowledgebook')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
                <label>page No </label>

                <input type="number" name="islamicKnowledgepage"
                    class="form-control @error('islamicKnowledgepage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('islamicKnowledgepage')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>


    </div>
    <div class="islamichistorycomm">
        <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
                <label>Islamic Knowledge comments <span class="text-danger">
                        @error('islamicKnowledgecomments')
                            {{ $message }}
                        @enderror
                    </span></label>

                <textarea name="islamicKnowledgecomments"
                    class="form-control @error('islamicKnowledgecomments') is-invalid @enderror"></textarea>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <!-- text input -->
        <div class="form-group">
            <label>Memorization <span class="text-danger">
                    @error('memorizarion')
                        {{ $message }}
                    @enderror
                </span></label>


            <select name="memorizarion" id="memorizariontype"
                class="form-control @error('memorizarion') is-invalid @enderror">
                <option value="">Select Memorizarion</option>
                @foreach ($Memorizationdata as $data)
                    <option value="{{ $data->id }}">
                        {{ $data->memorizationname }}</option>
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
                <span class="text-danger">
                    @error('kalma')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <div class="col-sm-3">
            <!-- text input -->
            <div class="form-group">
                <label>Mark </label>

                <input type="number" name="kalmastartmark"
                    class="form-control @error('kalmastartmark') is-invalid @enderror" />

                <span class="text-danger">
                    @error('kalmastartmark')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="kalmaendmark"
                    class="form-control @error('kalmaendmark') is-invalid @enderror" />
                <span class="text-danger">
                    @error('kalmaendmark')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>

    </div>

</div>
<div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="2">
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>Page No </label>

            <input type="number" name="masnoonduapageno"
                class="form-control @error('masnoonduapageno') is-invalid @enderror" />

            <span class="text-danger">
                @error('masnoonduapageno')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>Dua No </label>

            <input type="text" name="masnoonduaduano"
                class="form-control @error('masnoonduaduano') is-invalid @enderror" />

            <span class="text-danger">
                @error('masnoonduaduano')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>



</div>
<div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="3">
    <div class="col-sm-5">
        <!-- text input -->
        <div class="form-group">
            <label>Surah Name </label>

            <input type="text" name="surahname" class="form-control @error('surahname') is-invalid @enderror" />

            <span class="text-danger">
                @error('surahname')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-sm-3">
        <!-- text input -->
        <div class="form-group">
            <label>Aya </label>

            <input type="number" name="surahstartaya"
                class="form-control @error('surahstartaya') is-invalid @enderror" />
            <span class="text-danger">
                @error('surahstartaya')
                    {{ $message }}
                @enderror
            </span>

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

            <input type="number" name="surahendaya" class="form-control @error('surahendaya') is-invalid @enderror" />

            <span class="text-danger">
                @error('surahendaya')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>



</div>
<div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="4">
    <div class="col-sm-5">
        <!-- text input -->
        <div class="form-group">
            <label>Dua Name </label>

            <input type="text" name="duaname" class="form-control @error('duaname') is-invalid @enderror" />
            <span class="text-danger">
                @error('duaname')
                    {{ $message }}
                @enderror
            </span>

        </div>
    </div>
    <div class="col-sm-3">
        <!-- text input -->
        <div class="form-group">
            <label>Mark </label>

            <input type="number" name="duanamestartline"
                class="form-control @error('duanamestartline') is-invalid @enderror" />

            <span class="text-danger">
                @error('duanamestartline')
                    {{ $message }}
                @enderror
            </span>
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

            <input type="number" name="duanameendline"
                class="form-control @error('duanameendline') is-invalid @enderror" />
            <span class="text-danger">
                @error('duanameendline')
                    {{ $message }}
                @enderror
            </span>

        </div>
    </div>



</div>
<div class="row memorizationrenderDiv" style="display:none" data-memorizationtype="5">
    <div class="col-sm-5">
        <!-- text input -->
        <div class="form-group">
            <label>Surah Name </label>

            <input type="text" name="longsurahname" class="form-control @error('longsurahname') is-invalid @enderror" />

            <span class="text-danger">
                @error('longsurahname')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div>
    <div class="col-sm-3">
        <!-- text input -->
        <div class="form-group">
            <label>Aya </label>

            <input type="number" name="longsurahstartaya"
                class="form-control @error('longsurahstartaya') is-invalid @enderror" />
            <span class="text-danger">
                @error('longsurahstartaya')
                    {{ $message }}
                @enderror
            </span>

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

            <input type="number" name="longsurahendaya" class="form-control @error('longsurahendaya') is-invalid @enderror" />

            <span class="text-danger">
                @error('longsurahendaya')
                    {{ $message }}
                @enderror
            </span>
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
                    @foreach ($Fundamentalislam as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->fundamental_islam_name }}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('fundamentalislam')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>page </label>

                <input type="number" name="fundamentalislamstartpage"
                    class="form-control @error('fundamentalislamstartpage') is-invalid @enderror" />

                <span class="text-danger">
                    @error('fundamentalislamstartpage')
                        {{ $message }}
                    @enderror
                </span>
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

                <input type="number" name="fundamentalislamendpage"
                    class="form-control @error('fundamentalislamendpage') is-invalid @enderror" />
                <span class="text-danger">
                    @error('fundamentalislamendpage')
                        {{ $message }}
                    @enderror
                </span>

            </div>
        </div>
        <div class="col-sm-1">
            <!-- text input -->
            <div class="form-group">
                <label>Line </label>

                <input type="number" name="fundamentalislamstartline"
                    class="form-control @error('fundamentalislamstartline') is-invalid @enderror" />
                <span class="text-danger">
                    @error('fundamentalislamstartline')
                        {{ $message }}
                    @enderror
                </span>

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

                <input type="number" name="fundamentalislamendline"
                    class="form-control @error('fundamentalislamendline') is-invalid @enderror" />

                <span class="text-danger">
                    @error('fundamentalislamendline')
                        {{ $message }}
                    @enderror
                </span>
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
                @foreach ($Ethicsdata as $data)
                    <option value="{{ $data->id }}">
                        {{ $data->ethicsname }}</option>
                @endforeach
            </select>
            <span class="text-danger">
                @error('ethics')
                    {{ $message }}
                @enderror
            </span>

        </div>
    </div>
    <div class="col-sm-1">
        <!-- text input -->
        <div class="form-group">
            <label>page </label>

            <input type="number" name="ethicsstartpage"
                class="form-control @error('ethicsstartpage') is-invalid @enderror" />
            <span class="text-danger">
                @error('ethicsstartpage')
                    {{ $message }}
                @enderror
            </span>

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

            <input type="number" name="ethicsendpage"
                class="form-control @error('ethicsendpage') is-invalid @enderror" />
            <span class="text-danger">
                @error('ethicsendpage')
                    {{ $message }}
                @enderror
            </span>

        </div>
    </div>
    <div class="col-sm-1">
        <!-- text input -->
        <div class="form-group">
            <label>Line </label>

            <input type="number" name="ethicsstartline"
                class="form-control @error('ethicsstartline') is-invalid @enderror" />
            <span class="text-danger">
                @error('ethicsstartline')
                    {{ $message }}
                @enderror
            </span>

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

            <input type="number" name="ethicsendline"
                class="form-control @error('ethicsendline') is-invalid @enderror" />
            <span class="text-danger">
                @error('ethicsendline')
                    {{ $message }}
                @enderror
            </span>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <!-- text input -->
        <div class="form-group">
            <label>Comments <span class="text-danger">
                    @error('comments')
                        {{ $message }}
                    @enderror
                </span></label>

            <textarea name="comments" class="form-control @error('comments') is-invalid @enderror"></textarea>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <!-- text input -->
        <div class="form-group">
            <label>Informative Comments <span class="text-danger">
                    @error('informativecomment')
                        {{ $message }}
                    @enderror
                </span></label>

            <textarea {{ $isInformativeDisabled ? 'disabled' : '' }} name="informativecomment"
                class="form-control @error('informativecomment') is-invalid @enderror"></textarea>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <!-- text input -->
        <div class="form-group">

            <label>Method <span class="text-danger">
                    @error('accent_type')
                        {{ $message }}
                    @enderror
                </span></label>
            <select name="accent_type" class="form-control @error('accent_type') is-invalid @enderror">
                <option value="">Select Accent</option>
                <option value="1">Asian</option>
                <option value="2">Arabic</option>
            </select>

        </div>
    </div>
</div>

@if (!$saveWithParentForm)
    </div>
    @if (!$isFeildsDisabled)
        <div class="modal-footer">
            <button type="button" id="btnsavelessonnew" class="btn btn-primary btn-block">Save</button>
        </div>
    @endif

    </div>
    </form>
    </div>
    </div>
@endif


@push('partail-scripts')
    <script type="text/javascript">
        /* Datatables responsive */

        $(document).ready(function() {




            $(document).on('click', '.addLessonbtn', function(e) {

                e.preventDefault();



                

                $(`.courserenderDiv`).hide();
                $(`.memorizationrenderDiv`).hide();

                $(`#formlessonstudentnew input[name="id"]`).val('')
                $(`#formlessonstudentnew select`).val('');
                $(`#formlessonstudentnew input`).val('')
                $(`#formlessonstudentnew textarea`).val('')
                $(`#formlessonstudentnew input[name="quranhifzsabaq"]`).val('Sabaq')
                $(`#formlessonstudentnew input[name="quranhifzsabaqi"]`).val('Sabaqi')
                $(`#formlessonstudentnew input[name="quranhifzmanzil"]`).val('Manzil')
                $(`#formlessonstudentnew input[name="student_id"]`).val('{{ request()->route('id') }}')

                @if ($isInformativeDisabled)
                    $(`#formlessonstudentnew textarea[name="informativecomment"]`).attr('disabled', true);
                    $(`#formlessonstudentnew input[name="lastattendance_id"]`).val($('#lastattendanceid').val());
                @endif
                //  $('#LessonModalNEw').modal('show');


                var id = '{{ $lessonstudentid }}';

                var route = '{{ $lastLessonRoute }}';

                route = route.replace(':id', id);

                $.get(route, {}, function(res) {


                    let coursid = res.course_id;
                    let memorizationid = res.memorization_id;
                    $(`.courserenderDiv`).hide();
                    $(`.courserenderDiv[data-coursetype="${coursid}"]`).show();
                    if (coursid == '2') {
                        $(`.memorizationrenderDiv`).hide();
                        $(`#memorizariontype`).closest('.row').hide();
                        $(`#memorizariontype`).val('');
                    } else {
                        $(`#memorizariontype`).closest('.row').show();
                        $(`#memorizariontype`).val('');
                    }


                    $(`.memorizationrenderDiv`).hide();
                    if (coursid != '2') {
                        if (memorizationid != "") {

                            $(`.memorizationrenderDiv[data-memorizationtype="${memorizationid}"]`)
                                .show();
                        }
                    } else {
                        $(`#memorizariontype`).closest('.row').hide();
                        $(`#memorizariontype`).val('');
                    }

                    $(`#formlessonstudentnew select[name="course"]`).val(res.course_id);
                    $(`#formlessonstudentnew input[name="id"]`).val('');
                    $(`#formlessonstudentnew select[name="accent_type"]`).val(res.accent_type);
                    $(`#formlessonstudentnew textarea[name="comments"]`).val(res.comments);
                    $(`#formlessonstudentnew textarea[name="informativecomment"]`).val(res
                        .informativecomment);
                    $(`#formlessonstudentnew input[name="teacher_id"]`).val(res.teacher_id);
                    $(`#formlessonstudentnew select[name="startlesson"]`).val(res.startlesson);



                    if (coursid == 1) {



                        $(`#formlessonstudentnew select[name="quransubject"]`).val(res.subject_id);
                        $(`#formlessonstudentnew input[name="quranjuznumber"]`).val(res.juz_number);
                        $(`#formlessonstudentnew input[name="quranstartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="quranendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="quranstartaya"]`).val(res
                            .startaya_course);
                        $(`#formlessonstudentnew input[name="quranendaya"]`).val(res.endaya_course);
                        $(`#formlessonstudentnew textarea[name="qurancomments"]`).val(res
                            .comments_course);

                    }

                    if (coursid == 2) {




                        $(`#formlessonstudentnew select[name="quranhifzsubject"]`).val(res
                            .subject_id);
                        $(`#formlessonstudentnew input[name="quranhifzpageline"]`).val(res
                            .quranhifzpageline);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqjuznumber"]`).val(res
                            .juz_number);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqstartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqstartaya"]`).val(res
                            .startaya_course);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqendaya"]`).val(res
                            .endaya_course);





                        $(`#formlessonstudentnew input[name="quranhifzsabaqijuznumber"]`).val(res
                            .sabaqi_juz_number);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqistartpage"]`).val(res
                            .sabaqi_start_page);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqiendpage"]`).val(res
                            .sabaqi_end_page);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqistartaya"]`).val(res
                            .sabaqi_start_aya);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqiendaya"]`).val(res
                            .sabaqi_end_aya);





                        $(`#formlessonstudentnew input[name="quranhifzmanziljuznumber"]`).val(res
                            .manzil__juz_number);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilstartpage"]`).val(res
                            .manzil_start_page);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilendpage"]`).val(res
                            .manzil_end_page);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilstartaya"]`).val(res
                            .manzil_start_aya);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilendaya"]`).val(res
                            .manzil_end_aya);



                        $(`#formlessonstudentnew textarea[name="quranhifzcomments"]`).val(res
                            .comments_course);



                    }

                    if (coursid == 3) {

                        $(`#formlessonstudentnew select[name="hadeethsubject"]`).val(res
                            .subject_id);
                        $(`#formlessonstudentnew input[name="hadeethstartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="hadeethendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="hadeethstartline"]`).val(res
                            .startline_course);
                        $(`#formlessonstudentnew input[name="hadeethendline"]`).val(res
                            .endline_course);
                        $(`#formlessonstudentnew textarea[name="hadeethcomments"]`).val(res
                            .comments_course);

                    }

                    if (coursid == 4) {



                        $(`#formlessonstudentnew select[name="qaidasubject"]`).val(res.subject_id);
                        $(`#formlessonstudentnew input[name="qaidastartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="qaidaendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="qaidastartline"]`).val(res
                            .startline_course);
                        $(`#formlessonstudentnew input[name="qaidaendline"]`).val(res
                            .endline_course);
                        $(`#formlessonstudentnew textarea[name="qaidacomments"]`).val(res
                            .comments_course);
                        $(`#formlessonstudentnew input[name="qaidachapterlesson"]`).val(res
                            .qaidachapterlesson);


                    }

                    if (coursid == 5) {


                        $(`#formlessonstudentnew select[name="languagesubject"]`).val(res
                            .subject_id);
                        $(`#formlessonstudentnew input[name="languagestartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="languageendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="languagestartline"]`).val(res
                            .startline_course);
                        $(`#formlessonstudentnew input[name="languageendline"]`).val(res
                            .endline_course);
                        $(`#formlessonstudentnew textarea[name="languagecomments"]`).val(res
                            .comments_course);


                    }

                    if (coursid == 6) {


                        $(`#formlessonstudentnew input[name="islamichistorybook"]`).val(res
                            .islamic_history_book);
                        $(`#formlessonstudentnew input[name="islamichistorypage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew textarea[name="islamichistorycomments"]`).val(res
                            .comments_course);

                    }
                    if (coursid == 7) {


                        $(`#formlessonstudentnew input[name="islamicKnowledgebook"]`).val(res
                            .islamic_knowlege_book);
                        $(`#formlessonstudentnew input[name="islamicKnowledgepage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew textarea[name="islamicKnowledgecomments"]`).val(res
                            .comments_course);

                    }

                    $(`#formlessonstudentnew select[name="fundamentalislam"]`).val(res
                        .fundamental_islam_id);
                    if (res.fundamental_islam_id) {
                        $(`#formlessonstudentnew input[name="fundamentalislamstartpage"]`).val(res
                            .startpage_fundamentalislam);
                        $(`#formlessonstudentnew input[name="fundamentalislamendpage"]`).val(res
                            .endpage_fundamentalislam);
                        $(`#formlessonstudentnew input[name="fundamentalislamstartline"]`).val(res
                            .startline_fundamentalislam);
                        $(`#formlessonstudentnew input[name="fundamentalislamendline"]`).val(res
                            .endline_fundamentalislam);
                    }
                    $(`#formlessonstudentnew select[name="memorizarion"]`).val(memorizationid);
                    if (memorizationid) {

                        if (memorizationid == 1) {

                            $(`#formlessonstudentnew select[name="kalma"]`).val(res.kalma_no);
                            $(`#formlessonstudentnew input[name="kalmastartmark"]`).val(res
                                .startmark);
                            $(`#formlessonstudentnew input[name="kalmaendmark"]`).val(res.endmark);

                        }
                        if (memorizationid == 2) {



                            $(`#formlessonstudentnew input[name="masnoonduapageno"]`).val(res
                                .pageno_masnoondua);
                            $(`#formlessonstudentnew input[name="masnoonduaduano"]`).val(res
                                .dua_no_masnoondua);

                        }
                        if (memorizationid == 3) {

                            $(`#formlessonstudentnew input[name="surahname"]`).val(res
                                .surah_name_shortsurah);
                            $(`#formlessonstudentnew input[name="surahstartaya"]`).val(res
                                .startaya_shortsurah);
                            $(`#formlessonstudentnew input[name="surahendaya"]`).val(res
                                .endaya_shortsurah);

                        }
                        if (memorizationid == 5) {

                            $(`#formlessonstudentnew input[name="longsurahname"]`).val(res
                                .surah_name_shortsurah);
                            $(`#formlessonstudentnew input[name="longsurahstartaya"]`).val(res
                                .startaya_shortsurah);
                            $(`#formlessonstudentnew input[name="longsurahendaya"]`).val(res
                                .endaya_shortsurah);

                            }
                        if (memorizationid == 4) {


                            $(`#formlessonstudentnew input[name="duaname"]`).val(res
                                .dua_Name_mainduas);
                            $(`#formlessonstudentnew input[name="duanamestartline"]`).val(res
                                .startline_mainduas);
                            $(`#formlessonstudentnew input[name="duanameendline"]`).val(res
                                .endline_mainduas);
                        }

                    }
                    $(`#formlessonstudentnew select[name="ethics"]`).val(res.ethics_id);
                    if (res.ethics_id) {
                        $(`#formlessonstudentnew input[name="ethicsstartpage"]`).val(res
                            .startpage_ethics);
                        $(`#formlessonstudentnew input[name="ethicsendpage"]`).val(res
                            .endpage_ethics);
                        $(`#formlessonstudentnew input[name="ethicsstartline"]`).val(res
                            .startline_ethics);
                        $(`#formlessonstudentnew input[name="ethicsendline"]`).val(res
                            .endline_ethics);
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
            $(document).on('click', '#btnsavelessonnew', function(e) {
                e.preventDefault();

                $('.text-danger').text('');
                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('textarea').removeClass('is-invalid');
                @if ($isInformativeDisabled)
                    $(`#formlessonstudentnew textarea[name="informativecomment"]`).attr('disabled', true);
                @endif
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                        type: "POST",
                        url: $('#formlessonstudentnew').attr('action'),
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: new FormData($('#formlessonstudentnew')[0])
                    })
                    .done(function(data) {
                        // console.log(data);
                        if (data.error) {
                            $.each(data.error, function(key, value) {
                                var input = `#formlessonstudentnew input[name="${key}"]`;
                                var inputtextarea =
                                    `#formlessonstudentnew textarea[name="${key}"]`;
                                var inputselect = `#formlessonstudentnew select[name="${key}"]`;
                                var inputselectid = `#formlessonstudentnew select[id="${key}"]`;
                                // console.log(input)
                                $(input).parents('.form-group').find('.text-danger').text(
                                    value);
                                $(inputtextarea).parents('.form-group').find('.text-danger')
                                    .text(
                                        value);
                                $(inputselect).parents('.form-group').find('.text-danger').text(
                                    value);
                                $(inputselectid).parents('.form-group').find('.text-danger')
                                    .text(
                                        value);
                                $(input).addClass('is-invalid');
                                $(inputtextarea).addClass('is-invalid');
                                $(inputselect).addClass('is-invalid');
                                $(inputselectid).addClass('is-invalid');
                            });
                        }

                        if (data.Success  == true) {
                            swal({
                                title: "Good job!",
                                text: data.msg,
                                icon: "success",
                                button: "Close",
                            });
                            $('#formlessonstudentnew')[0].reset();
                            $('#LessonModalNEw').modal('hide');
                            $('#LessonDatatable').DataTable().draw(true);

                        }else{
                            if (!data.error) {
                                swal({
                                title: "Error!",
                                text: data.msg,
                                icon: "error",
                                button: "Close",
                            });
                            }
                            
                           

                        
                        }

                    })
                    .fail(function(data) {
                        console.log(data);

                    });
            });
            $(document).on('click', '.btneditleson', function() {
                var id = $(this).attr('data-id');

                $("#formlessonstudentnew input[type='text']").prop("disabled",
                    '{{ $isFeildsDisabled }}');
                $("#formlessonstudentnew input[type='number']").prop("disabled",
                    '{{ $isFeildsDisabled }}');
                $("#formlessonstudentnew select").prop("disabled", '{{ $isFeildsDisabled }}');
                $("#formlessonstudentnew textarea").prop("disabled", '{{ $isFeildsDisabled }}');

                $(`.courserenderDiv`).hide();
                $(`.memorizationrenderDiv`).hide();

                $(`#formlessonstudentnew input[name="id"]`).val('')
                $(`#formlessonstudentnew select`).val('');
                $(`#formlessonstudentnew input`).val('')
                $(`#formlessonstudentnew textarea`).val('')
                $(`#formlessonstudentnew input[name="quranhifzsabaq"]`).val('Sabaq')
                $(`#formlessonstudentnew input[name="quranhifzsabaqi"]`).val('Sabaqi')
                $(`#formlessonstudentnew input[name="quranhifzmanzil"]`).val('Manzil')
                $(`#formlessonstudentnew input[name="student_id"]`).val('{{ request()->route('id') }}')


                let studentname  = $(this).parents('tr').find('td:eq(1)').html();
                    studentname  = `${studentname} Lesson`;
                $('#LessonModalNEw .modal-title').html(studentname);

                var route = '{{ $EditRoute }}';

                route = route.replace(':id', id);

                $.get(route, {}, function(res) {


                    let coursid = res.course_id;
                    let memorizationid = res.memorization_id;
                    $(`.courserenderDiv`).hide();
                    $(`.courserenderDiv[data-coursetype="${coursid}"]`).show();
                    if (coursid == '2') {
                        $(`.memorizationrenderDiv`).hide();
                        $(`#memorizariontype`).closest('.row').hide();
                        $(`#memorizariontype`).val('');
                    } else {
                        $(`#memorizariontype`).closest('.row').show();
                        $(`#memorizariontype`).val('');
                    }


                    $(`.memorizationrenderDiv`).hide();
                    if (coursid != '2') {
                        if (memorizationid != "") {

                            $(`.memorizationrenderDiv[data-memorizationtype="${memorizationid}"]`)
                                .show();
                        }
                    } else {
                        $(`#memorizariontype`).closest('.row').hide();
                        $(`#memorizariontype`).val('');
                    }

                    $(`#formlessonstudentnew select[name="course"]`).val(res.course_id);
                    $(`#formlessonstudentnew input[name="id"]`).val(res.id);
                    $(`#formlessonstudentnew select[name="accent_type"]`).val(res.accent_type);
                    $(`#formlessonstudentnew textarea[name="comments"]`).val(res.comments);
                    $(`#formlessonstudentnew input[name="teacher_id"]`).val(res.teacher_id);
                    $(`#formlessonstudentnew textarea[name="informativecomment"]`).val(res
                        .informativecomment);
                    $(`#formlessonstudentnew select[name="startlesson"]`).val(res.startlesson);    

                    if (coursid == 1) {



                        $(`#formlessonstudentnew select[name="quransubject"]`).val(res.subject_id);
                        $(`#formlessonstudentnew input[name="quranjuznumber"]`).val(res.juz_number);
                        $(`#formlessonstudentnew input[name="quranstartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="quranendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="quranstartaya"]`).val(res
                            .startaya_course);
                        $(`#formlessonstudentnew input[name="quranendaya"]`).val(res.endaya_course);
                        $(`#formlessonstudentnew textarea[name="qurancomments"]`).val(res
                            .comments_course);
                        


                    }

                    if (coursid == 2) {




                        $(`#formlessonstudentnew select[name="quranhifzsubject"]`).val(res
                            .subject_id);
                        $(`#formlessonstudentnew input[name="quranhifzpageline"]`).val(res
                            .quranhifzpageline);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqjuznumber"]`).val(res
                            .juz_number);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqstartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqstartaya"]`).val(res
                            .startaya_course);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqendaya"]`).val(res
                            .endaya_course);





                        $(`#formlessonstudentnew input[name="quranhifzsabaqijuznumber"]`).val(res
                            .sabaqi_juz_number);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqistartpage"]`).val(res
                            .sabaqi_start_page);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqiendpage"]`).val(res
                            .sabaqi_end_page);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqistartaya"]`).val(res
                            .sabaqi_start_aya);
                        $(`#formlessonstudentnew input[name="quranhifzsabaqiendaya"]`).val(res
                            .sabaqi_end_aya);





                        $(`#formlessonstudentnew input[name="quranhifzmanziljuznumber"]`).val(res
                            .manzil__juz_number);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilstartpage"]`).val(res
                            .manzil_start_page);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilendpage"]`).val(res
                            .manzil_end_page);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilstartaya"]`).val(res
                            .manzil_start_aya);
                        $(`#formlessonstudentnew input[name="quranhifzmanzilendaya"]`).val(res
                            .manzil_end_aya);



                        $(`#formlessonstudentnew textarea[name="quranhifzcomments"]`).val(res
                            .comments_course);



                    }

                    if (coursid == 3) {

                        $(`#formlessonstudentnew select[name="hadeethsubject"]`).val(res
                            .subject_id);
                        $(`#formlessonstudentnew input[name="hadeethstartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="hadeethendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="hadeethstartline"]`).val(res
                            .startline_course);
                        $(`#formlessonstudentnew input[name="hadeethendline"]`).val(res
                            .endline_course);
                        $(`#formlessonstudentnew textarea[name="hadeethcomments"]`).val(res
                            .comments_course);

                    }

                    if (coursid == 4) {



                        $(`#formlessonstudentnew select[name="qaidasubject"]`).val(res.subject_id);
                        $(`#formlessonstudentnew input[name="qaidastartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="qaidaendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="qaidastartline"]`).val(res
                            .startline_course);
                        $(`#formlessonstudentnew input[name="qaidaendline"]`).val(res
                            .endline_course);
                        $(`#formlessonstudentnew textarea[name="qaidacomments"]`).val(res
                            .comments_course);
                        $(`#formlessonstudentnew input[name="qaidachapterlesson"]`).val(res
                            .qaidachapterlesson);

                    }

                    if (coursid == 5) {


                        $(`#formlessonstudentnew select[name="languagesubject"]`).val(res
                            .subject_id);
                        $(`#formlessonstudentnew input[name="languagestartpage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew input[name="languageendpage"]`).val(res
                            .endpage_course);
                        $(`#formlessonstudentnew input[name="languagestartline"]`).val(res
                            .startline_course);
                        $(`#formlessonstudentnew input[name="languageendline"]`).val(res
                            .endline_course);
                        $(`#formlessonstudentnew textarea[name="languagecomments"]`).val(res
                            .comments_course);


                    }

                    if (coursid == 6) {


                        $(`#formlessonstudentnew input[name="islamichistorybook"]`).val(res
                            .islamic_history_book);
                        $(`#formlessonstudentnew input[name="islamichistorypage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew textarea[name="islamichistorycomments"]`).val(res
                            .comments_course);

                    }
                    if (coursid == 7) {


                        $(`#formlessonstudentnew input[name="islamicKnowledgebook"]`).val(res
                            .islamic_knowlege_book);
                        $(`#formlessonstudentnew input[name="islamicKnowledgepage"]`).val(res
                            .startpage_course);
                        $(`#formlessonstudentnew textarea[name="islamicKnowledgecomments"]`).val(res
                            .comments_course);

                    }


                    $(`#formlessonstudentnew select[name="fundamentalislam"]`).val(res
                        .fundamental_islam_id);
                    if (res.fundamental_islam_id) {
                        $(`#formlessonstudentnew input[name="fundamentalislamstartpage"]`).val(res
                            .startpage_fundamentalislam);
                        $(`#formlessonstudentnew input[name="fundamentalislamendpage"]`).val(res
                            .endpage_fundamentalislam);
                        $(`#formlessonstudentnew input[name="fundamentalislamstartline"]`).val(res
                            .startline_fundamentalislam);
                        $(`#formlessonstudentnew input[name="fundamentalislamendline"]`).val(res
                            .endline_fundamentalislam);
                    }
                    $(`#formlessonstudentnew select[name="memorizarion"]`).val(memorizationid);
                    if (memorizationid) {

                        if (memorizationid == 1) {

                            $(`#formlessonstudentnew select[name="kalma"]`).val(res.kalma_no);
                            $(`#formlessonstudentnew input[name="kalmastartmark"]`).val(res
                                .startmark);
                            $(`#formlessonstudentnew input[name="kalmaendmark"]`).val(res.endmark);

                        }
                        if (memorizationid == 2) {



                            $(`#formlessonstudentnew input[name="masnoonduapageno"]`).val(res
                                .pageno_masnoondua);
                            $(`#formlessonstudentnew input[name="masnoonduaduano"]`).val(res
                                .dua_no_masnoondua);

                        }
                        if (memorizationid == 3) {

                            $(`#formlessonstudentnew input[name="surahname"]`).val(res
                                .surah_name_shortsurah);
                            $(`#formlessonstudentnew input[name="surahstartaya"]`).val(res
                                .startaya_shortsurah);
                            $(`#formlessonstudentnew input[name="surahendaya"]`).val(res
                                .endaya_shortsurah);

                        }
                        if (memorizationid == 5) {

                        $(`#formlessonstudentnew input[name="longsurahname"]`).val(res
                            .surah_name_shortsurah);
                        $(`#formlessonstudentnew input[name="longsurahstartaya"]`).val(res
                            .startaya_shortsurah);
                        $(`#formlessonstudentnew input[name="longsurahendaya"]`).val(res
                            .endaya_shortsurah);

                        }
                        if (memorizationid == 4) {


                            $(`#formlessonstudentnew input[name="duaname"]`).val(res
                                .dua_Name_mainduas);
                            $(`#formlessonstudentnew input[name="duanamestartline"]`).val(res
                                .startline_mainduas);
                            $(`#formlessonstudentnew input[name="duanameendline"]`).val(res
                                .endline_mainduas);
                        }

                    }
                    $(`#formlessonstudentnew select[name="ethics"]`).val(res.ethics_id);
                    if (res.ethics_id) {
                        $(`#formlessonstudentnew input[name="ethicsstartpage"]`).val(res
                            .startpage_ethics);
                        $(`#formlessonstudentnew input[name="ethicsendpage"]`).val(res
                            .endpage_ethics);
                        $(`#formlessonstudentnew input[name="ethicsstartline"]`).val(res
                            .startline_ethics);
                        $(`#formlessonstudentnew input[name="ethicsendline"]`).val(res
                            .endline_ethics);
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

            $(document).on('change', '#coursetype', function() {

                let coursid = $(this).val();
                $(`.courserenderDiv`).hide();
                if (coursid != "") {
                    $(`.courserenderDiv[data-coursetype="${coursid}"]`).show();

                    if (coursid == '2') {
                        $(`.memorizationrenderDiv`).hide();
                        $(`#memorizariontype`).closest('.row').hide();
                        $(`#memorizariontype`).val('');
                    } else {
                        $(`#memorizariontype`).closest('.row').show();
                        $(`#memorizariontype`).val('');
                    }
                }

            })

            $(document).on('change', '#memorizariontype', function() {

                let memorizationid = $(this).val();

                //   console.log(memorizationid)
                $(`.memorizationrenderDiv`).hide();
                let coursid = $('#coursetype').val();
                if (coursid != '2') {
                    if (memorizationid != "") {


                        $(`.memorizationrenderDiv[data-memorizationtype="${memorizationid}"]`).show();
                    }
                } else {
                    $(`#memorizariontype`).closest('.row').hide();
                    $(`#memorizariontype`).val('');
                }

            })


            $("input[type='number']").attr({
                "max": 100000, // substitute your own
                "min": 1 // values (or variables) here
            });






        });
    </script>
@endpush
