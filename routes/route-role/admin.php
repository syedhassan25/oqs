<?php

Route::get('/testing-relation', 'Admin\EmployeesController@TestingRelationship');
Route::get('/testingdata', 'Admin\StudentController@getTestingData');
Route::get('/send-chat-message', 'Chat\ChatController@sendMessage');

Route::get('send-my-mail', function () {

    $details = [
        'title' => 'Mail from sispm.com',
        'body' => 'This is for testing email using smtp',
    ];

//   $bauji =  \Mail::from('syedhassan25@hotmail.com');to('syedhassan25@hotmail.com')->send(new \App\Mail\dueDayMail($details));

//     dd("Email is Sent.".$bauji);

    $bauji = \Mail::raw("This is automatically generated Hourly Update", function ($message) {
        $message->from('testing@sispn.net');
        $message->to('syedhassan25@hotmail.com')->subject('Hourly Update');
    });

    dd("Email is Sent." . $bauji);

});

Route::get('/send-my-mail', 'Admin\InvoiceController@SendEmail');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {

    Route::get('/configdetails', function () {

        echo Config::get('app.timeChangeEuropeStatus');

        //   $languages = config('app');
        //   print_r($languages);
    });

    Route::post('/dashboardtest', 'Admin\DashboardController@getdashboardStatsTest')->name('admin.dasboard.stats.record.details');

    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::post('/dashboardclassesdata', 'Admin\DashboardController@getTotalClassess')->name('admin.dasboard.stats.classes.history,month');

    Route::post('/dashboard-stats-status-history', 'Admin\DashboardController@getDashboardStats')->name('admin.dasboard.stats.status.history');

    Route::resource('roles', 'Admin\RoleController')->middleware('permission:role-list');
    Route::get('/users/users-datatable', 'Admin\UserController@get_user_forms');

    Route::post('/blog-post-save', 'Custom\PostController@store')->name('admin.blog.post.save');
    Route::get('/blog-post-list', 'Custom\PostController@list')->name('admin.blog.post.list');

    Route::resource('users', 'Admin\UserController')->middleware('permission:user-list');
    Route::prefix('users')->group(function () {
        Route::get('/permission/{id}', 'Admin\UserController@permissionAdd')->name('admin.users.permission')->middleware('permission:user-list');
        Route::post('/permission/{id}', 'Admin\UserController@permissionStore')->name('admin.users.permission.store')->middleware('permission:user-list');
    });
    Route::prefix('parent')->group(function () {
        Route::get('/', 'Admin\ParentsController@index')->name('admin.parent.index');
        Route::get('/create', 'Admin\ParentsController@create')->name('admin.parent.create');
        Route::post('/store', 'Admin\ParentsController@store')->name('admin.parent.store');
        Route::get('/{id}/edit', 'Admin\ParentsController@edit')->name('admin.parent.edit');
        Route::get('/parent-datatable', 'Admin\ParentsController@get_par_forms')->name('admin.parent.datatable');
        Route::post('/update', 'Admin\ParentsController@update')->name('admin.parent.update');
        Route::get('/parent-student-datatable', 'Admin\ParentsController@get_student_schdule_forms')->name('admin.parent.student.datatable');

    });

    Route::prefix('employee')->group(function () {
        Route::get('/', 'Admin\EmployeesController@index')->name('admin.employee.index')->middleware('permission:Employees-list');
        Route::get('/{id}/edit', 'Admin\EmployeesController@edit')->name('admin.employee.edit')->middleware('permission:Employees-list');
        Route::get('/employee-datatable', 'Admin\EmployeesController@get_emp_forms')->name('admin.employee.datatable');
        Route::post('/update', 'Admin\EmployeesController@update')->name('admin.employee.update');
        Route::post('/store', 'Admin\EmployeesController@store')->name('admin.employee.store');
        Route::post('/leave/add', 'Admin\EmployeesController@store_leave')->name('admin.employee.leave.add');
        Route::post('/leave/delete', 'Admin\EmployeesController@delete_leave')->name('admin.employee.leave.delete');
        Route::get('/employee-leave-datatable', 'Admin\EmployeesController@get_emp_leave_forms')->name('admin.employee.leave.datatable');
        Route::get('/employee/leave', 'Admin\EmployeesController@Leave_forms_View')->name('admin.employee.leave.view');


        Route::get('/attendance-add', 'Admin\EmployeesController@employeeattendance')->name('admin.employee.create.attendance');
        Route::post('/attendance-save', 'Admin\EmployeesController@saveattendance')->name('admin.employee.save.attendance');
        Route::post('/attendance-update-save', 'Admin\EmployeesController@updateaAttendance')->name('admin.employee.update.status.attendance');
        Route::get('/emp-attendance', 'Admin\EmployeesController@attendancelist')->name('admin.employee.create.attendance.list');
        Route::get('/attendance-datatable', 'Admin\EmployeesController@get_emp_attendance_forms')->name('admin.employee.attendance.datatable');

    });

    Route::prefix('teacher')->group(function () {
        Route::get('/', 'Admin\TeacherController@index')->name('admin.teacher.index')->middleware('permission:Teachers-list');
        Route::get('/create', 'Admin\TeacherController@create')->name('admin.teacher.create');
        Route::get('/{id}/edit', 'Admin\TeacherController@edit')->name('admin.teacher.edit')->middleware('permission:Teachers-list');
        Route::get('/employee-datatable', 'Admin\TeacherController@get_emp_forms')->name('admin.teacher.datatable');
        Route::post('/update', 'Admin\TeacherController@update')->name('admin.teacher.update');
        Route::post('/store', 'Admin\TeacherController@store')->name('admin.teacher.store');

        Route::get('/student-teacher-datatable', 'Admin\TeacherController@get_students_by_teacher_forms')->name('admin.teacher.students');
        Route::get('/student-teacher-leave-datatable', 'Admin\TeacherController@get_students_by_teacher_leave_forms')->name('admin.teacher.students.leave');
        Route::get('/student-teacher-otherstatus-datatable', 'Admin\TeacherController@get_students_by_teacher_otherstatus_forms')->name('admin.teacher.students.otherstatus');
        Route::get('/past-student-teacher-datattable', 'Admin\TeacherController@get_past_students_by_teacher_forms')->name('admin.teacher.students.past');
        Route::get('/student-teacher-feedback-datattable', 'Admin\TeacherController@get_student_feedback_forms')->name('admin.teacher.allstudents.feedback');

        Route::get('/freeTimeSearch/{id}', 'Admin\TeacherController@GetTimeByteachers');
        Route::post('/search/time', 'Admin\TeacherController@searchFreeTimefuncTestDev')->name('admin.teacher.search');

        Route::post('/search/time/testdev', 'Admin\TeacherController@searchFreeTimefuncTestDev')->name('admin.teacher.search.testdev');
        Route::post('/search/time/attendancecreate', 'Admin\TeacherController@searchFreeTimeattendancecreate')->name('admin.teacher.search.testdev.attendancecreate');

        Route::get('/student/schedule', 'Admin\TeacherController@schduleCalender')->name('admin.teacher.student.weekly.schedule');
        Route::get('/student/calender/schedule/{id}', 'Admin\TeacherController@schduleCalenderNewbyID')->name('admin.teacher.student.weekly.schedule.calender');
        // Route::get('/student/calender/schedule/{id}','Admin\TeacherController@LoadscduleCalenderByTeacher')->name('admin.teacher.student.weekly.schedule.calender');

        Route::post('/group/get-teacher', 'Admin\TeacherController@getteacherbyGroup')->name('admin.teacher.group.get.teacher.data');

        Route::get('/student/transfer/history', 'Admin\TeacherController@studentTransferhistory')->name('admin.teacher.student.transfer.history');
        Route::get('/student/transfer/historyforms', 'Admin\TeacherController@studentTransferhistory_forms')->name('admin.teacher.student.transfer.history.forms');
        Route::get('/student/packagechange/historyforms', 'Admin\TeacherController@get_all_days_history_bystudent')->name('admin.teacher.student.package.change.history.forms');
        Route::get('/student/academicstatuschange/historyforms', 'Admin\TeacherController@acdemichistoryDatatable')->name('admin.teacher.student.academicstatus.change.history.forms');

        Route::get('/old/students', 'Admin\TeacherController@oldStudentTeacher')->name('admin.teacher.old.student.transfer.history');
        Route::get('/old/student/studentoldhistoryforms', 'Admin\TeacherController@oldStudentTeacher_forms')->name('admin.teacher.old.student.history.forms');

        Route::get('/attendance-add', 'Admin\TeacherController@createattendance')->name('admin.teacher.create.attendance');
        Route::post('/attendance-save', 'Admin\TeacherController@saveattendance')->name('admin.teacher.save.attendance');
        Route::post('/attendance-update-save', 'Admin\TeacherController@updateaAttendance')->name('admin.teacher.update.status.attendance');
        Route::get('/attendance-list', 'Admin\TeacherController@attendancelist')->name('admin.teacher.create.attendance.list');
        Route::get('/attendance-datatable', 'Admin\TeacherController@get_emp_attendance_forms')->name('admin.teacher.attendance.datatable');

        Route::post('/attendance-generate', 'Admin\StudentController@generateAttendance')->name('admin.teacher.generate.attendance');
        Route::post('/attendance-delete-all-today', 'Admin\StudentController@DeleteGenerateAttendance')->name('admin.teacher.delete.today.attendance');

        Route::get('/spend/time', 'Admin\TeacherController@getTeachersTime')->name('admin.teacher.view.by.hour.time');
        Route::post('/spend/time/get', 'Admin\TeacherController@getTeachersByHourTime')->name('admin.teacher.get.by.hour.time');

        Route::get('/view/detail/allowance/{id}', 'Admin\TeacherController@viewEmployeesShort')->name('admin.teacher.view.detail.allowance');
        Route::get('/view/add/allowance/{id}', 'Admin\TeacherController@viewAddEmployeesAllowance')->name('admin.teacher.view.add.allowance');
        Route::get('/view/add/deduction/{id}', 'Admin\TeacherController@viewAddEmployeesDeduction')->name('admin.teacher.view.add.deduction');

        Route::post('/delete/allowance', 'Admin\TeacherController@deleteEmployeesAllowance')->name('admin.teacher.view.delete.allowance');
        Route::post('/delete/deduction', 'Admin\TeacherController@deleteEmployeesDeduction')->name('admin.teacher.view.delete.deduction');

        Route::post('/save/allowance', 'Admin\TeacherController@saveEmployeesAllowance')->name('admin.teacher.view.save.allowance');
        Route::post('/save/deduction', 'Admin\TeacherController@saveEmployeesDeduction')->name('admin.teacher.view.save.deduction');

        Route::get('/referral', 'Admin\TeacherController@referralTeacher')->name('admin.teacher.view.student.referral');
        Route::get('/referral/forms', 'Admin\TeacherController@studentreferralhistory_forms')->name('admin.teacher.student.referral.forms');

        Route::post('/referral/paid', 'Admin\TeacherController@referralpaidTeacher')->name('admin.teacher.student.referral.paid');

        Route::get('/free/time/availabiltiy', 'Admin\TeacherController@FreeTeachersavailabiltiyTime')->name('admin.teacher.get.free.time.availabiltiy');
        Route::post('/free/time/get', 'Admin\TeacherController@getFreeTeachersTime')->name('admin.teacher.get.by.hour.free.time');

        Route::get('/free/time/whole/academic', 'Admin\TeacherController@getFreeTeachersTimeWholeAcademic')->name('admin.teacher.get.free.time.whole.academic.availabiltiy');
        Route::post('/free/time/whole/availabiltiy', 'Admin\TeacherController@getFreeTeachersTimeWholeacademictime')->name('admin.teacher.get.free.time.whole.availabiltiy');

        Route::get('/non-active/student', 'Admin\TeacherController@studentNonActive')->name('admin.teacher.student.non.active');
        Route::get('/active/student', 'Admin\TeacherController@get_student_active_form')->name('admin.teacher.student.active');
        Route::get('/inactive/student', 'Admin\TeacherController@get_student_inactive_form')->name('admin.teacher.student.inactive');
        Route::get('/leave/student', 'Admin\TeacherController@get_student_leave_form')->name('admin.teacher.student.leave');
        Route::get('/close/student', 'Admin\TeacherController@get_student_close_form')->name('admin.teacher.student.close');
        Route::get('/teacher-complain-datatable', 'Admin\TeacherController@get_teacher_complain_forms')->name('admin.teacher.complain.datatable');

        Route::post('/save/complain/teacher', 'Admin\TeacherController@saveComplainAboutTeacherForm')->name('admin.teacher.about.complain.save');
        Route::get('/complain-about-teacher-datatable', 'Admin\TeacherController@getComplainAboutTeacherforms')->name('admin.teacher.about.complain.datatable');
        


    });

    Route::prefix('student')->group(function () {
        Route::get('/', 'Admin\StudentController@index')->name('admin.student.index');
        Route::get('/by/{group}', 'Admin\StudentController@index')->name('admin.student.index.group');

        Route::get('/status/{status}', 'Admin\StudentController@index')->name('admin.student.index.status');
        Route::get('/create', 'Admin\StudentController@create')->name('admin.student.create');
        Route::get('/create/{group}', 'Admin\StudentController@create')->name('admin.student.create.group');
        Route::post('/storefullform', 'Admin\StudentController@storefullform')->name('admin.student.storefullform');
        Route::get('/new', 'Admin\StudentController@NewForm')->name('admin.student.new');
        Route::get('/schdule', 'Admin\StudentController@SchduleForm')->name('admin.student.schdule');
        Route::get('/trailpending', 'Admin\StudentController@TrailPendingForm')->name('admin.student.trailpending');
        Route::get('/trailstarted', 'Admin\StudentController@TrailStartedForm')->name('admin.student.trailstarted');
        Route::get('/trailcompleted', 'Admin\StudentController@TrailCompletedForm')->name('admin.student.trailcompleted');

        Route::get('/student/detail/{id}', 'Admin\StudentController@getStudentDetail')->name('admin.student.detail');
        Route::get('/teacher/schdule', 'Admin\StudentController@TeacherSchduleForm')->name('admin.student.teacher.schdule');
        Route::post('/schdule/save', 'Admin\StudentController@studentSchdulesave')->name('admin.student.demo.schdule.save');
        Route::post('/meeting/schdule/save', 'Admin\StudentController@studentMeetingSchdulesave')->name('admin.student.meeting.schdule.save');
        Route::post('/store', 'Admin\StudentController@store')->name('admin.student.store');
        Route::get('/{id}/edit', 'Admin\StudentController@edit')->name('admin.student.edit');
        Route::get('/{id}/editnewform', 'Admin\StudentController@editnewform')->name('admin.student.editnewform');
        Route::post('/update', 'Admin\StudentController@update')->name('admin.student.update');
        Route::post('/updatenewform', 'Admin\StudentController@updatenewform')->name('admin.student.updatenewform');

        Route::get('/student-datatable', 'Admin\StudentController@get_student_forms')->name('admin.student.datatable');
        Route::get('/schdule-student-datatable', 'Admin\StudentController@get_student_schdule_forms')->name('admin.student.schdule.datatable');
        Route::get('/new-student-datatable', 'Admin\StudentController@get_new_student_forms')->name('admin.student.newFormdatatable');
        Route::get('/schdule-demo-student-datatable', 'Admin\StudentController@get_demo_schdule_student_forms')->name('admin.student.demoScduledatatablenew');
        Route::get('/schdule-meeting-student-datatable', 'Admin\StudentController@get_meeting_schdule_student_forms')->name('admin.student.meetingScduledatatable');

        Route::get('/schdule-demo-student-today-datatable', 'Admin\StudentController@get_demo_schdule_student_today_forms')->name('admin.student.demoScduledatatablenew.today');
        Route::get('/schdule-meeting-studen-today-datatable', 'Admin\StudentController@get_meeting_schdule_student_today_forms')->name('admin.student.meetingScduledatatable.today');

        Route::get('/assign-teacher-student-datatable', 'Admin\StudentController@get_assingnteacher_forms')->name('admin.student.assign.teacher.datatable');
        Route::get('/student-trail-pending-datatable', 'Admin\StudentController@get_trailPending_forms')->name('admin.student.trail.pending.datatable');
        Route::get('/student-trail-started-datatable', 'Admin\StudentController@get_trailstarted_forms')->name('admin.student.trail.started.datatable');
        Route::get('/student-trail-completed-datatable', 'Admin\StudentController@get_trailcompleted_forms')->name('admin.student.trail.completed.datatable');

        Route::post('/schdule-group-search', 'Admin\StudentController@get_student_by_group')->name('student.group.search');
        Route::get('/lesson-student-datatable', 'Admin\LessonController@get_lesson_forms')->name('admin.student.lesson.lessondatatable');
        Route::post('/leesson/store', 'Admin\LessonController@save')->name('admin.student.lesson.save');
        Route::get('/leesson/{id}/edit', 'Admin\LessonController@edit')->name('admin.student.lesson.edit');
        Route::get('/leesson/{id}/latest', 'Admin\LessonController@getlastlesson')->name('admin.student.lesson.getlastlesson');

        Route::get('/teacher-feedback-datatable', 'Admin\StudentController@get_student_feedback_forms')->name('admin.student.teacher.feedbackdatatable');

        Route::post('/academic/status/save', 'Admin\StudentController@AcademicStatusSave')->name('admin.student.academicstatus');
        Route::post('/billing/status/save', 'Admin\StudentController@BillingStatusSave')->name('admin.student.billingstatus');
        Route::post('/teacher/feedback/save', 'Admin\StudentController@teacherFeedbackSave')->name('admin.student.teacher.feedback');

        Route::get('/acdemic-history-datatable', 'Admin\StudentController@acdemichistoryDatatable')->name('admin.student.teacher.acdemichistoryDatatable');
        Route::get('/teacher-change-history-datatable', 'Admin\StudentController@teacherchangehistoryDatatable')->name('admin.student.teacher.teacherchangehistoryDatatable');

        Route::get('/report-comment-history-datatable', 'Admin\StudentController@getStudentReportCommentsforms')->name('admin.report.student.new.comment.datatable');

        Route::post('/teacher/recovery/class', 'Admin\StudentController@setStudentRecoveryclass')->name('admin.teacher.student.recovery.attendance');

        Route::post('/teacher/recovery/class/schdule', 'Admin\StudentController@SchduleStudentRecoveryclass')->name('admin.student.recovery.class.schdule.save');

        Route::get('/classes/monitoring', 'Admin\StudentController@Classmonitoring')->name('admin.student.monitoring');
        Route::get('/today-classes-datatable', 'Admin\StudentController@get_today_classes')->name('admin.student.todayclasses.datatable');

        Route::get('/classes/attendance/history', 'Admin\StudentController@GetAttendanceHistory')->name('admin.student.getattendancehistory');

        Route::get('/classes/attendance', 'Admin\StudentController@Classallmonitoring')->name('admin.student.classall.monitoring');
        Route::get('/classes-attendance-datatable', 'Admin\StudentController@get_all_classes')->name('admin.student.classall.attendance.datatable');
        Route::get('/by-student/classes-attendance-datatable/{id}', 'Admin\StudentController@get_all_classes_bystudent')->name('admin.student.bystudent.attendance.datatable');

        Route::post('/relica-create', 'Admin\StudentController@storeReplicaform')->name('admin.student.relica.create');

        Route::get('/academic-stats-status-history-by-date/{status}/{startdate}/{enddate}', 'Admin\StudentController@AcademichistorystatsBydate')->name('admin.dasboard.stats.status.history.by.date');
        Route::get('/academic-stats-status-history-by-date/{type}/{status}/{startdate}/{enddate}', 'Admin\StudentController@AcademichistorystatsBydate')->name('admin.dasboard.stats.type.status.history.by.date');
        Route::get('/academic-stats-status-history-by-date-datatable', 'Admin\StudentController@acdemichistoryDatatableforstatsbydate')->name('admin.dasboard.stats.status.history.by.date.datatable');
        Route::get('/academic-stats-status-history-by-teacher-date-datatable', 'Admin\StudentController@acdemichistoryDatatableforstatsbyteacher')->name('admin.dasboard.stats.status.history.by.teacher.date.datatable');

        Route::get('/uploadstudent', 'Admin\StudentController@uploadstudent');
        Route::post('/uploadFile', 'Admin\StudentController@uploadFile_newdata')->name('admin.upload.student.record');

        Route::get('/timeconversion', 'Admin\StudentController@timeconversion')->name('admin.student.timeconversion');

        Route::get('/student-all-task-datatable', 'Admin\TaskController@get_student_task_forms')->name('admin.student.all.task.forms');

        Route::post('/atttendance/store', 'Admin\StudentController@saveattendance')->name('admin.student.attendance.save');
        Route::post('/atttendance/delete', 'Admin\StudentController@deleteattendance')->name('admin.student.attendance.delete');

        Route::post('/academic-status/billing-status', 'Admin\StudentController@saveacademicstatusbilling')->name('admin.student.academic-status.billing-status');

        Route::post('/comments/save', 'Admin\StudentController@saveStudentCommentForm')->name('admin.student.new.comment.save');

        Route::get('/student-new-comments-datatable', 'Admin\StudentController@getStudentCommentsforms')->name('admin.student.new.comment.datatable');

        Route::get('/days-attendance-except-active', 'Admin\StudentController@last3daysAttendanceStatus')->name('admin.student.last3daysAttendanceStatus');
        Route::get('/student-active-AttendanceStatus-datatable', 'Admin\StudentController@getAttendanceStatusExceptOnlineforms')->name('admin.student.except.active.AttendanceStatus');
        Route::get('/get-days-attendance-except-active-hitory', 'Admin\StudentController@GetExceptActiveAttendanceHistory')->name('admin.student.except.active.AttendanceStatus.history.get');

        Route::get('/test/save/view', 'Admin\StudentController@studentReportResult')->name('admin.student.test.save.view');
        Route::get('/test/save/view-datatable', 'Admin\StudentController@get_test_student_save')->name('admin.student.test.save.view.datatable');
        Route::get('/test/report/edit/{id}', 'Admin\StudentController@StudentTestAttendreportedit')->name('admin.student.test.attend.report.edit');

        Route::get('/days/history/view-history-datatable', 'Admin\StudentController@get_all_days_history_bystudent')->name('admin.student.days.history.view.datatable');

        Route::post('/salary/deduction/store', 'Admin\StudentController@savedeductionstatus')->name('admin.student.attendance.salary.deduction.save');

        Route::post('/comments/followup-attendance/save', 'Admin\StudentController@saveFollowUpAttendanceCommentForm')->name('admin.student.new.comment.followupattendance.save');
        Route::get('/student-new-followupattendance-comments-datatable', 'Admin\StudentController@getStudentFollowUpAttendanceCommentsforms')->name('admin.student.new.comment.followupattendance.datatable');
        Route::get('/student-recovery-class-datatable', 'Admin\StudentController@get_recovery_classes')->name('admin.student.teacher.classrecoveryhistory.datatable');
        Route::get('/student-attendance-export', 'Admin\StudentController@export_attendace')->name('admin.student.attendance.export');
    });

    Route::prefix('task')->group(function () {
        Route::get('/', 'Admin\TaskController@index')->name('admin.task.index')->middleware('permission:task-list');
        Route::get('/create', 'Admin\TaskController@create')->name('admin.task.create')->middleware('permission:task-create');
        Route::post('/store', 'Admin\TaskController@store')->name('admin.task.store')->middleware('permission:task-create');
        Route::get('/{id}/edit', 'Admin\TaskController@edit')->name('admin.task.edit')->middleware('permission:task-edit');

        Route::get('/{id}/detail', 'Admin\TaskController@detail')->name('admin.task.detail')->middleware('permission:task-edit');

        Route::post('/update', 'Admin\TaskController@update')->name('admin.task.update')->middleware('permission:task-edit');
        Route::get('/{id}/delete', 'Admin\TaskController@delete')->name('admin.task.delete')->middleware('permission:task-delete');
        Route::get('/datatable', 'Admin\TaskController@get_task_forms')->name('admin.task.datatable')->middleware('permission:task-list');
        Route::get('/pending-datatable', 'Admin\TaskController@get_task_pending_forms')->name('admin.task.pending.datatable')->middleware('permission:task-list');
        Route::get('/completed-datatable', 'Admin\TaskController@get_task_completed_forms')->name('admin.task.completed.datatable')->middleware('permission:task-list');
        Route::get('/cancel-datatable', 'Admin\TaskController@get_task_cancel_forms')->name('admin.task.cancel.datatable')->middleware('permission:task-list');
        Route::get('/assigned-datatable', 'Admin\TaskController@get_task_AssignFrom')->name('admin.taskAssigned.datatable')->middleware('permission:task-list');
        Route::get('/future-datatable', 'Admin\TaskController@get_task_Future_forms')->name('admin.task.future.datatable')->middleware('permission:task-list');

        Route::post('/get-users-by-role', 'Admin\TaskController@getUserRolewise')->name('admin.task.getUserRolewise')->middleware('permission:task-create');
        Route::get('/get-student-by-group', 'Admin\TaskController@getStudentBygroup')->name('admin.task.getStudentBygroup')->middleware('permission:task-create');
        Route::get('/get-student-by-teacher', 'Admin\TaskController@getStudentByteacher')->name('admin.task.getStudentByteacher')->middleware('permission:task-create');

        Route::post('/comment/add', 'Admin\TaskController@comment_add')->name('admin.task.comment')->middleware('permission:task-create');
        Route::get('/comment/datatable', 'Admin\TaskController@get_comment_forms')->name('admin.task.comment.datatable');

        Route::post('status-change', 'Admin\TaskController@task_status_change')->name('admin.task.status.change');

        Route::post('status-change-detail', 'Admin\TaskController@task_status_change_detail')->name('admin.task.status.detail.change');

        Route::get('total-user-task-assigner-', 'Admin\TaskController@get_task_users_assign')->name('admin.task.AssignUsers');

        Route::post('user-task-ReAssign-user', 'Admin\TaskController@Save_task_users_Reassign')->name('admin.task.ReAssignuser.store');

        Route::post('user-task-extendDate', 'Admin\TaskController@Save_task_extendate')->name('admin.task.extendDate.store');

        Route::post('multiple-task-status-change', 'Admin\TaskController@multiple_task_status_change')->name('admin.task.multiple.status.change');

        Route::post('multiple-task-assign-user', 'Admin\TaskController@Multiple_task_users_Reassign')->name('admin.task.multiple.assign.user');

        Route::get('/monitoring', 'Admin\TaskController@TaskMonitoring')->name('admin.task.monitoring')->middleware('permission:task-edit');

        Route::post('/monitoring-list', 'Admin\TaskController@getTaskAttemptBydate')->name('admin.task.monitoring.list')->middleware('permission:task-edit');

    });

    Route::prefix('country')->group(function () {
        Route::get('/', 'Admin\CountryController@index')->name('admin.country.index')->middleware('permission:country-list');
        Route::get('/create', 'Admin\CountryController@create')->name('admin.country.create')->middleware('permission:country-create');
        Route::post('/store', 'Admin\CountryController@store')->name('admin.country.store')->middleware('permission:country-create');
        Route::get('/{id}/edit', 'Admin\CountryController@edit')->name('admin.country.edit')->middleware('permission:country-edit');
        Route::post('/update', 'Admin\CountryController@update')->name('admin.country.update')->middleware('permission:country-edit');
        Route::get('/{id}/delete', 'Admin\CountryController@delete')->name('admin.country.delete')->middleware('permission:country-delete');
        Route::get('/datatable', 'Admin\CountryController@get_country_forms')->middleware('permission:country-list');;
    });

    Route::prefix('city')->group(function () {
        Route::get('/', 'Admin\CityController@index')->name('admin.city.index')->middleware('permission:city-list');
        Route::get('/create', 'Admin\CityController@create')->name('admin.city.create')->middleware('permission:city-create');
        Route::post('/store', 'Admin\CityController@store')->name('admin.city.store')->middleware('permission:city-create');
        Route::get('/{id}/edit', 'Admin\CityController@edit')->name('admin.city.edit')->middleware('permission:city-edit');
        Route::post('/update', 'Admin\CityController@update')->name('admin.city.update')->middleware('permission:city-edit');
        Route::get('/{id}/delete', 'Admin\CityController@delete')->name('admin.city.delete')->middleware('permission:city-delete');
        Route::get('/datatable', 'Admin\CityController@get_city_forms')->middleware('permission:city-list');;
    });

    Route::prefix('language')->group(function () {
        Route::get('/', 'Admin\LanguageController@index')->name('admin.language.index')->middleware('permission:language-list');
        Route::get('/create', 'Admin\LanguageController@create')->name('admin.language.create')->middleware('permission:language-create');
        Route::post('/store', 'Admin\LanguageController@store')->name('admin.language.store')->middleware('permission:language-create');
        Route::get('/{id}/edit', 'Admin\LanguageController@edit')->name('admin.language.edit')->middleware('permission:language-edit');
        Route::post('/update', 'Admin\LanguageController@update')->name('admin.language.update')->middleware('permission:language-edit');
        Route::get('/{id}/delete', 'Admin\LanguageController@delete')->name('admin.language.delete')->middleware('permission:language-delete');
        Route::get('/datatable', 'Admin\LanguageController@get_language_forms')->middleware('permission:language-list');;
    });

    Route::prefix('agency')->group(function () {
        Route::get('/', 'Admin\AgencyController@index')->name('admin.agency.index')->middleware('permission:agency-list');
        Route::get('/create', 'Admin\AgencyController@create')->name('admin.agency.create')->middleware('permission:agency-create');
        Route::post('/store', 'Admin\AgencyController@store')->name('admin.agency.store')->middleware('permission:agency-create');
        Route::get('/{id}/edit', 'Admin\AgencyController@edit')->name('admin.agency.edit')->middleware('permission:agency-edit');
        Route::post('/update', 'Admin\AgencyController@update')->name('admin.agency.update')->middleware('permission:agency-edit');
        Route::get('/{id}/delete', 'Admin\AgencyController@delete')->name('admin.agency.delete')->middleware('permission:agency-delete');
        Route::get('/datatable', 'Admin\AgencyController@get_agency_forms')->middleware('permission:agency-list');;
    });

    Route::prefix('skill')->group(function () {
        Route::get('/', 'Admin\SkillController@index')->name('admin.skill.index')->middleware('permission:skill-list');
        Route::get('/create', 'Admin\SkillController@create')->name('admin.skill.create')->middleware('permission:skill-create');
        Route::post('/store', 'Admin\SkillController@store')->name('admin.skill.store')->middleware('permission:skill-create');
        Route::get('/{id}/edit', 'Admin\SkillController@edit')->name('admin.skill.edit')->middleware('permission:skill-edit');
        Route::post('/update', 'Admin\SkillController@update')->name('admin.skill.update')->middleware('permission:skill-edit');
        Route::get('/{id}/delete', 'Admin\SkillController@delete')->name('admin.skill.delete')->middleware('permission:skill-delete');
        Route::get('/datatable', 'Admin\SkillController@get_skill_forms')->middleware('permission:skill-list');;
    });

    Route::prefix('subject')->group(function () {
        Route::get('/', 'Admin\SubjectController@index')->name('admin.subject.index')->middleware('permission:subject-list');
        Route::get('/create', 'Admin\SubjectController@create')->name('admin.subject.create')->middleware('permission:subject-create');
        Route::post('/store', 'Admin\SubjectController@store')->name('admin.subject.store')->middleware('permission:subject-create');
        Route::get('/{id}/edit', 'Admin\SubjectController@edit')->name('admin.subject.edit')->middleware('permission:subject-edit');
        Route::post('/update', 'Admin\SubjectController@update')->name('admin.subject.update')->middleware('permission:subject-edit');
        Route::get('/{id}/delete', 'Admin\SubjectController@delete')->name('admin.subject.delete')->middleware('permission:subject-delete');
        Route::get('/datatable', 'Admin\SubjectController@get_subject_forms')->middleware('permission:subject-list');;
    });
    Route::prefix('reason')->group(function () {
        Route::get('/', 'Admin\ReasonController@index')->name('admin.reason.index')->middleware('permission:reason-list');
        Route::get('/create', 'Admin\ReasonController@create')->name('admin.reason.create')->middleware('permission:reason-create');
        Route::post('/store', 'Admin\ReasonController@store')->name('admin.reason.store')->middleware('permission:reason-create');
        Route::post('/storeajax', 'Admin\ReasonController@storeajax')->name('admin.reason.storeajax');
        Route::get('/{id}/edit', 'Admin\ReasonController@edit')->name('admin.reason.edit')->middleware('permission:reason-edit');
        Route::post('/update', 'Admin\ReasonController@update')->name('admin.reason.update')->middleware('permission:reason-edit');
        Route::get('/{id}/delete', 'Admin\ReasonController@delete')->name('admin.reason.delete')->middleware('permission:reason-delete');
        Route::get('/datatable', 'Admin\ReasonController@get_reason_forms')->middleware('permission:reason-list');
    });

    Route::prefix('ethics')->group(function () {
        Route::get('/', 'Admin\EthicsController@index')->name('admin.ethics.index');
        Route::get('/create', 'Admin\EthicsController@create')->name('admin.ethics.create');
        Route::post('/store', 'Admin\EthicsController@store')->name('admin.ethics.store');
        Route::get('/{id}/edit', 'Admin\EthicsController@edit')->name('admin.ethics.edit');
        Route::post('/update', 'Admin\EthicsController@update')->name('admin.ethics.update');
        Route::get('/{id}/delete', 'Admin\EthicsController@delete')->name('admin.ethics.delete');
        Route::get('/datatable', 'Admin\EthicsController@get_ethics_forms')->name('admin.ethics.ethicsforms');
    });

    Route::prefix('fundamentalislam')->group(function () {
        Route::get('/', 'Admin\FundamentislamController@index')->name('admin.fundamentalislam.index');
        Route::get('/create', 'Admin\FundamentislamController@create')->name('admin.fundamentalislam.create');
        Route::post('/store', 'Admin\FundamentislamController@store')->name('admin.fundamentalislam.store');
        Route::get('/{id}/edit', 'Admin\FundamentislamController@edit')->name('admin.fundamentalislam.edit');
        Route::post('/update', 'Admin\FundamentislamController@update')->name('admin.fundamentalislam.update');
        Route::get('/{id}/delete', 'Admin\FundamentislamController@delete')->name('admin.fundamentalislam.delete');
        Route::get('/datatable', 'Admin\FundamentislamController@get_fundamentalislam_forms')->name('admin.fundamentalislam.fundamentalislamforms');
    });

    Route::prefix('memorization')->group(function () {
        Route::get('/', 'Admin\MemorizationController@index')->name('admin.memorization.index');
        Route::get('/create', 'Admin\MemorizationController@create')->name('admin.memorization.create');
        Route::post('/store', 'Admin\MemorizationController@store')->name('admin.memorization.store');
        Route::get('/{id}/edit', 'Admin\MemorizationController@edit')->name('admin.memorization.edit');
        Route::post('/update', 'Admin\MemorizationController@update')->name('admin.memorization.update');
        Route::get('/{id}/delete', 'Admin\MemorizationController@delete')->name('admin.memorization.delete');
        Route::get('/datatable', 'Admin\MemorizationController@get_Memorization_forms')->name('admin.memorization.memorizationforms');
    });

    Route::prefix('inventory')->group(function () {
        Route::get('/', 'Admin\InventoryController@index')->name('admin.inventory.index');
        Route::get('/create', 'Admin\InventoryController@create')->name('admin.inventory.create');
        Route::post('/store', 'Admin\InventoryController@store')->name('admin.inventory.store');
        Route::get('/{id}/edit', 'Admin\InventoryController@edit')->name('admin.inventory.edit');
        Route::post('/update', 'Admin\InventoryController@update')->name('admin.inventory.update');
        Route::get('/{id}/delete', 'Admin\InventoryController@delete')->name('admin.inventory.delete');
        Route::get('/datatable', 'Admin\InventoryController@get_inventory_forms')->name('admin.inventory.inventoryforms');
        Route::post('/get-users-by-role', 'Admin\InventoryController@getUserRolewise')->name('admin.inventory.getUserRolewise');
    });

    Route::prefix('payroll')->group(function () {
        Route::get('/', 'Admin\PayrollController@index')->name('admin.payroll.index')->middleware('permission:payroll-list');
        Route::get('/datatable', 'Admin\PayrollController@get_payroll_forms')->name('admin.payroll.payrollforms');
        Route::get('/view/form', 'Admin\PayrollController@view_payroll_forms')->name('admin.teacher.view.payroll.forms');
        Route::get('/edit/form/{id}', 'Admin\PayrollController@edit_payroll_forms')->name('admin.teacher.edit.payroll.forms');
        Route::post('/view/form/save', 'Admin\PayrollController@store')->name('admin.teacher.view.payroll.forms.save');
        Route::post('/calculate', 'Admin\PayrollController@calculatePayroll')->name('admin.teacher.calculate.payroll');
        Route::post('/delete', 'Admin\PayrollController@destroy')->name('admin.teacher.delete.payroll');
        Route::get('/detail/{id}', 'Admin\PayrollController@detail_payroll')->name('admin.teacher.detail.payroll.forms');
        Route::get('/datatable/detail/{id}', 'Admin\PayrollController@detail_payroll_forms')->name('admin.detail.payroll.datatable');
        Route::get('/datatable/export-detail/{id}', 'Admin\PayrollController@detail_payroll_export_forms')->name('admin.detail.export.payroll.datatable');

        Route::post('/checkpayrolgeneratebyemployeeid', 'Admin\PayrollController@calculatePayrollByEmployeeId')->name('admin.payroll.generate.employee.id');
        Route::get('/check-payrol-generate/{id}/{start}/{end}', 'Admin\PayrollController@employee_check_payrollgenerate')->name('admin.payroll.generate.employee.view');
        Route::get('/datatable/payrol-generate', 'Admin\PayrollController@employee_check_payroll_forms')->name('admin.payroll.generate.employee.datatable');

        Route::get('/slip/{id}', 'Admin\PayrollController@payroll_detail_slip')->name('admin.detail.payroll.slip');

        Route::post('/publish', 'Admin\PayrollController@publishedPayrol')->name('admin.teacher.publish.payroll');

        Route::post('/payment-transfer', 'Admin\PayrollController@SalaryTransfer')->name('admin.teacher.payment.transfer.payroll');

        Route::post('/re-calculate', 'Admin\PayrollController@RecalculateSinlgePayroll')->name('admin.teacher.recalculate.payroll');

        Route::get('/datatable/concern/{id}', 'Admin\PayrollController@Concern_Payrol_forms')->name('admin.concern.payroll.datatable');
        Route::post('/concern/add', 'Admin\PayrollController@addConcernPayrol')->name('admin.concern.add.payroll');

        Route::get('/export-detail/{id}', 'Admin\PayrollController@export_detail_payroll')->name('admin.teacher.export.detail.payroll.forms');

        Route::post('/extra/allowance/add', 'Admin\PayrollController@storeAllowance')->name('admin.extra.allowance.add.payroll');

        Route::post('/extra/allowance/deduct', 'Admin\PayrollController@deductAllowance')->name('admin.extra.allowance.deduct.payroll');

        Route::get('/extra/allowance/add/{id}', 'Admin\PayrollController@getstoreAllowance')->name('admin.extra.allowance.add.get.payroll');
        Route::get('/extra/allowance/deduct/{id}', 'Admin\PayrollController@getdeductAllowance')->name('admin.extra.allowance.deduct.get.payroll');

        Route::post('/credit/loan/add', 'Admin\PayrollController@addcreditLoan')->name('admin.credit.loan.add.payroll');
        Route::get('/credit/loan/list', 'Admin\PayrollController@creditLoanList')->name('admin.credit.loan.list.payroll');
        Route::get('/datatable/creditloan', 'Admin\PayrollController@getCreditLoanForms')->name('admin.creditloan.payroll.datatable');

        Route::delete('/credit/loan/delete/{id}', 'Admin\PayrollController@destroyCreditLoan')->name('admin.creditloan.payroll.forms.delete');

        Route::get('/datatable/employee/detail', 'Admin\PayrollController@employee_payroll_forms')->name('admin.detail.payroll.employee.datatable');

        Route::post('/update/payroll/status', 'Admin\PayrollController@updatePayrolStatus')->name('admin.teacher.update.payroll.status');

        Route::get('employee/payroll-date/{id}', 'Admin\PayrollController@payrolDateById')->name('admin.payroll.employee.load.date.wise');

        Route::get('employee/loan-list', 'Admin\PayrollController@loanListEmployees')->name('admin.payroll.employee.loan.list.all');

    });

    Route::prefix('spotcheck')->group(function () {
        Route::get('/', 'Admin\SpotcheckController@index')->name('admin.spotcheck.index');
        Route::get('/datatable', 'Admin\SpotcheckController@get_spotcheck_forms')->name('admin.spotcheck.get_spotcheck_forms');
        Route::get('/detail/{id}', 'Admin\SpotcheckController@get_spotcheck_detail')->name('admin.spotcheck.detail');
        Route::get('/get-student-by-teacher', 'Admin\SpotcheckController@getStudentByteacher')->name('admin.spotcheck.getStudentByteacher');
    });

    Route::prefix('project-management')->group(function () {
        Route::get('/', 'Admin\ProjectsController@index')->name('admin.project.management.index');
        Route::get('/datatable', 'Admin\ProjectsController@get_Projects_forms')->name('admin.project.management.get_Projects_forms');
        Route::get('/create', 'Admin\ProjectsController@create')->name('admin.project.management.create');
        Route::post('/store', 'Admin\ProjectsController@store')->name('admin.project.management.store');
        Route::get('/edit/{id}', 'Admin\ProjectsController@edit')->name('admin.project.management.edit');
        Route::get('/detail/{id}', 'Admin\ProjectsController@get_project_detail')->name('admin.project.management.detail');
        Route::post('/delete', 'Admin\ProjectsController@delete_project')->name('admin.project.management.delete');
    });
    
    Route::get('/sideBarStudentStats', 'Admin\StudentController@getSideBarStats')->name('admin.sidebar.student.stats');

});

//packages
Route::prefix('packages')->group(function () {
    Route::get('all', 'PackagesController@all')->name('admin.packages.all');
    Route::get('create', 'PackagesController@create')->name('admin.packages.create');
    Route::post('store', 'PackagesController@store')->name('admin.packages.store');
    Route::get('datatable', 'PackagesController@datatable')->name('admin.packages.datatable');
    Route::get('/{id}/edit', 'PackagesController@edit')->name('admin.packages.edit');
    Route::get('/{id}/delete', 'PackagesController@delete')->name('admin.packages.delete');
    Route::post('/update', 'PackagesController@update')->name('admin.packages.update')->middleware('permission:language-edit');
});

Route::prefix('invoices')->group(function () {
    Route::get('all', 'InvoiceController@all')->name('admin.invoices.all');
    Route::get('create', 'InvoiceController@create')->name('admin.invoice.create');
    Route::post('fatchParent', 'InvoiceController@fatchParent')->name('admin.invoices.fatchParent');
    Route::get('fatchParent', 'InvoiceController@fatchParent')->name('admin.invoices.fatchParent');
    Route::post('saveInvoice', 'InvoiceController@saveInvoice')->name('admin.invoices.saveInvoice');
    Route::get('datatable', 'InvoiceController@datatable')->name('admin.invoices.datatable');
    Route::get('/{id}/edit', 'InvoiceController@edit')->name('admin.invoices.edit');
    Route::get('delete', 'InvoiceController@delete')->name('admin.invoices.delete');
    Route::get('commandrun', 'InvoiceController@commandrun')->name('admin.invoices.commandrun');
});

Route::prefix('billing')->group(function () {
    Route::get('all', 'BillingController@all')->name('admin.billing.all');
    Route::get('datatable', 'BillingController@datatable')->name('admin.billing.datatable');
    Route::get('ledger', 'BillingController@ledger')->name('admin.billing.ledger');
    Route::post('create_custom_invoice', 'BillingController@create_custom_invoice')->name('admin.billing.create_custom_invoice');
    Route::get('ledger_details', 'BillingController@ledger_details')->name('admin.billing.ledger_details');
    Route::post('create_new_invoice', 'BillingController@create_new_invoice')->name('admin.billing.create_new_invoice');
    Route::post('createBillingCycle', 'BillingController@createBillingCycle')->name('admin.billing.cycle.store');
    Route::get('viewBillingCycle', 'BillingController@viewBillingCycle')->name('admin.billing.cycle.view');
    Route::post('datatableBillingCycle', 'BillingController@datatableBillingCycle')->name('admin.billing.cycle.datatableBillingCycle');

    Route::get('dashboard', 'BillingController@dashboard')->name('admin.billing.dashboard');
});

Route::prefix('billing/dashboard')->group(function () {
    Route::get('unpaidLedger', 'BillingDashboard@unpaidLedger')->name('admin.dashboard.billing.unpaidLedger');
    Route::get('unpaidLedgerDatatable', 'BillingDashboard@unpaidLedgerDatatable')->name('admin.dashboard.billing.unpaidLedgerDatatable');

    Route::get('paidLedger', 'BillingDashboard@paidLedger')->name('admin.dashboard.billing.paidLedger');
    Route::get('paidLedgerDatatable', 'BillingDashboard@paidLedgerDatatable')->name('admin.dashboard.billing.paidLedgerDatatable');

    Route::get('LeavesLedger', 'BillingDashboard@LeavesLedger')->name('admin.dashboard.billing.LeavesLedger');
    Route::get('LeavesLedgerDatatable', 'BillingDashboard@LeavesLedgerDatatable')->name('admin.dashboard.billing.LeavesLedgerDatatable');

    Route::get('CloseStudentLedger', 'BillingDashboard@CloseStudentLedger')->name('admin.dashboard.billing.CloseStudentLedger');
    Route::get('CloseStudentLedgerDatatable', 'BillingDashboard@CloseStudentLedgerDatatable')->name('admin.dashboard.billing.CloseStudentLedgerDatatable');

    Route::get('changeInPackageLedger', 'BillingDashboard@changeInPackageLedger')->name('admin.dashboard.billing.changeInPackageLedger');
    Route::get('changeInPackageLedgerDatatable', 'BillingDashboard@changeInPackageLedgerDatatable')->name('admin.dashboard.billing.changeInPackageLedgerDatatable');

    Route::get('sixtyMinLedger', 'BillingDashboard@sixtyMinLedger')->name('admin.dashboard.billing.sixtyMinLedger');
    Route::get('sixtyMinLedgerLedgerDatatable', 'BillingDashboard@sixtyMinLedgerLedgerDatatable')->name('admin.dashboard.billing.sixtyMinLedgerLedgerDatatable');

    Route::get('daysPackage', 'BillingDashboard@daysPackage')->name('admin.dashboard.billing.daysPackage');
    Route::get('daysPackageDatatable', 'BillingDashboard@daysPackageDatatable')->name('admin.dashboard.billing.daysPackageDatatable');

    Route::get('invoiceEdited', 'BillingDashboard@invoiceEdited')->name('admin.dashboard.billing.invoiceEdited');
    Route::get('invoiceEditedDatatable', 'BillingDashboard@invoiceEditedDatatable')->name('admin.dashboard.billing.invoiceEditedDatatable');

    Route::get('invoiceTillDueDate', 'BillingDashboard@invoiceTillDueDate')->name('admin.dashboard.billing.invoiceTillDueDate');
    Route::get('invoiceTillDueDateDatatable', 'BillingDashboard@invoiceTillDueDateDatatable')->name('admin.dashboard.billing.invoiceTillDueDateDatatable');
});

Route::prefix('invoices/reminder')->group(function () {
    Route::get('get/{invoice_id}', 'ReminderInvoice@getInvoiceReminder')->name('admin.dashboard.invoices.reminder.getInvoiceReminder');
    Route::get('ReminderDataTable', 'ReminderInvoice@ReminderDataTable')->name('admin.dashboard.invoices.reminder.ReminderDataTable');
    Route::post('save', 'ReminderInvoice@saveReminder')->name('admin.dashboard.invoices.reminder.saveReminder');
});

Route::prefix('invoices/histories')->group(function () {
    Route::get('/', 'Admin\InvoiceHistoryController@all')->name('admin.dashboard.invoices.history.all');
});
