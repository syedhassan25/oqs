<?php 


Route::group(['prefix' => 'teacher', 'middleware' => ['auth','role:teacher']], function () {
    
            Route::get('/', 'Teacher\DashboardController@index');
            Route::get('/dashboard', 'Teacher\DashboardController@index')->name('teacherpanel.dasboard.index');
            Route::post('/teacher-atttendance/store', 'Teacher\DashboardController@saveattendance')->name('teacherpanel.teacher.atttendance.save');
            Route::get('/schedule', 'Teacher\TeacherController@index')->name('teacherpanel.students.schdule');
             Route::get('/schedule/{teachid}', 'Teacher\TeacherController@Studentscdule')->name('teacherpanel.students.getStudentscdule');
            Route::prefix('student')->group(function () {
            Route::get('detail/{id}', 'Teacher\StudentController@detail')->name('teacherpanel.student.detail');
            Route::get('/lesson-student-datatable', 'Teacher\StudentController@get_lesson_forms')->name('teacherpanel.student.lesson.lessondatatable');
            Route::post('/leesson/store', 'Teacher\StudentController@savelesson')->name('teacherpanel.student.lesson.save');
            Route::get('/students-today-classess', 'Teacher\StudentController@Classtodaymonitoring')->name('teacherpanel.students.classes.today');
            Route::get('/students-today-classess-datatable', 'Teacher\StudentController@get_today_classes')->name('teacherpanel.student.classes.today.attendance.datatable');
            
            
            Route::get('/leesson/{id}/edit', 'Teacher\StudentController@editlesson')->name('teacherpanel.student.lesson.edit');
              Route::get('/lesson/{id}/getlatestlesson', 'Teacher\StudentController@getlastlesson')->name('teacherpanel.student.lesson.getlastlesson');
            Route::get('/student-datatable', 'Teacher\StudentController@get_student_schdule_forms')->name('teacherpanel.schdulestudent.datatable');
            // Route::get('/student-datatable', 'Teacher\StudentController@get_student_schdule_forms')->name('teacherpanel.schdulestudent.datatable');
            Route::post('/atttendance/store', 'Teacher\StudentController@saveattendance')->name('teacherpanel.student.attendancesave');
            Route::post('/atttendance/comment/save', 'Teacher\StudentController@saveattendancecomment')->name('teacherpanel.student.attendance.comment.save');
            });
            
             Route::prefix('my-students')->group(function () {
                Route::get('/', 'Teacher\ClassController@index')->name('teacherpanel.class.index');
                Route::get('/current-classes-datatable', 'Teacher\ClassController@get_current_classes')->name('teacherpanel.student.currentclasses.datatable');
                Route::get('/today-classes-datatable', 'Teacher\ClassController@get_today_classes')->name('teacherpanel.student.todayclasses.datatable');
                Route::get('/recovery-classes-datatable', 'Teacher\ClassController@get_recovery_classes')->name('teacherpanel.student.recoveryclasses.datatable');
            });
            
              Route::prefix('suggestion')->group(function () {
                  Route::get('/', 'Teacher\SuggestController@index')->name('teacherpanel.suggestion.index');
                  Route::post('/store', 'Teacher\SuggestController@store')->name('teacherpanel.suggestion.save');
                  Route::get('/edit/{id}', 'Teacher\SuggestController@editsuggestion')->name('teacherpanel.suggestion.edit');
                  Route::get('/suggestion-datatable', 'Teacher\SuggestController@get_suggest_forms')->name('teacherpanel.suggestion.datatable');
              });
              
               Route::prefix('complain')->group(function () {
                Route::get('/', 'Teacher\ComplainController@index')->name('teacherpanel.complain.index');
                Route::post('/store', 'Teacher\ComplainController@store')->name('teacherpanel.complain.save');
                Route::get('/edit/{id}', 'Teacher\ComplainController@editcomplain')->name('teacherpanel.complain.edit');
                Route::get('/complain-datatable', 'Teacher\ComplainController@get_complain_forms')->name('teacherpanel.complain.datatable');
                 
                 
              });
              
              
              
               Route::prefix('reminder')->group(function () {
                Route::get('/', 'Teacher\ReminderController@index')->name('teacherpanel.reminder.index');
                     Route::post('/store', 'Teacher\ReminderController@store')->name('teacherpanel.reminder.save');
                  Route::get('/edit/{id}', 'Teacher\ReminderController@editsuggestion')->name('teacherpanel.reminder.edit');
                  Route::get('/reminder-datatable', 'Teacher\ReminderController@get_reminder_forms')->name('teacherpanel.reminder.datatable');
              });
              
               Route::prefix('task')->group(function () {
                Route::get('/', 'Teacher\TaskController@index')->name('teacherpanel.task.index');
                Route::get('/Detail/{id}', 'Teacher\TaskController@index')->name('teacherpanel.task.detail');
                Route::get('/datatable', 'Teacher\TaskController@get_task_forms')->name('teacherpanel.task.datatable');
                Route::get('/{id}/detail', 'Teacher\TaskController@detail')->name('teacherpanel.task.detail');
                
                Route::post('/comment/add', 'Teacher\TaskController@comment_add')->name('teacherpanel.task.comment');
                Route::get('/comment/datatable', 'Teacher\TaskController@get_comment_forms')->name('teacherpanel.task.comment.datatable');
                Route::post('status-change-detail','Teacher\TaskController@task_status_change_detail')->name('teacherpanel.task.status.detail.change');
                
                
              });
              
               Route::prefix('rules')->group(function () {
                Route::get('/', 'Teacher\GeneralController@rules')->name('teacherpanel.rules.index');
              });
              
                Route::prefix('salary')->group(function () {
                Route::get('/', 'Teacher\GeneralController@salary')->name('teacherpanel.salary.index');
                Route::get('/datatable/detail', 'Teacher\GeneralController@detail_payroll_forms')->name('teacherpanel.salary.detail.payroll.datatable');
                Route::get('/slip/{id}', 'Teacher\GeneralController@payroll_detail_slip')->name('teacherpanel.salary.detail.payroll.slip');
                
                
                Route::get('/datatable/concern/{id}', 'Teacher\GeneralController@Concern_Payrol_forms')->name('teacherpanel.concern.payroll.datatable');
                Route::post('/concern/add', 'Teacher\GeneralController@addConcernPayrol')->name('teacherpanel.concern.add.payroll');
                Route::get('/slip/password/generate', 'Teacher\GeneralController@payroll_slip_password')->name('teacherpanel.salary.payroll.slip.password.generate');
                Route::post('/slip/password/save', 'Teacher\GeneralController@paswword_Generate')->name('teacherpanel.salary.payroll.slip.password.generate.save');
                Route::post('/slip/password/validate', 'Teacher\GeneralController@paswword_validate')->name('teacherpanel.salary.payroll.slip.password.generate.validate');
                
                
              });
              
              Route::prefix('improvement')->group(function () {
                Route::get('/', 'Teacher\GeneralController@improvement')->name('teacherpanel.improvement.index');
              });
   

});



?>