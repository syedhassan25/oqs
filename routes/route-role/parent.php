<?php 


Route::group(['prefix' => 'parent', 'middleware' => ['auth','role:parent']], function () {
    Route::get('/', 'Parent\DashboardController@index');
    Route::get('/dashboard', 'Parent\DashboardController@index')->name('parentpanel.dasboard.index');
    Route::get('/student', 'Parent\StudentController@index')->name('parentpanel.student.index');
    Route::get('/studentdata', 'Parent\StudentController@studentdata')->name('parentpanel.student.studentdata');
    Route::get('/student-datatable', 'Parent\StudentController@get_student_schdule_forms')->name('parentpanel.student.datatable');
            
    Route::get('/student/detail/{id}', 'Parent\StudentController@studentdetail')->name('parentpanel.student.detail');
            
    Route::get('/student/classes/attendance/history', 'Parent\StudentController@get_all_classes')->name('parentpanel.student.classes.attendancehistory');
    Route::get('/student/change/teacher/history', 'Parent\StudentController@teacherchangehistoryDatatable')->name('parentpanel.student.change.teacherhistory');
    Route::get('/days/history/view-history-datatable', 'Parent\StudentController@get_all_days_history_bystudent')->name('parentpanel.student.days.history.view.datatable');
    Route::get('/leesson/{id}/view', 'Admin\LessonController@edit')->name('parentpanel.student.lesson.edit');
    Route::get('/lesson-student-datatable', 'Parent\StudentController@get_lesson_forms')->name('parentpanel.student.lesson.lessondatatable');
    Route::get('/invoice', 'Parent\InvoiceController@all')->name('parentpanel.student.lesson.invoice_all');
    Route::get('/datatable', 'Parent\InvoiceController@datatable')->name('parentpanel.student.lesson.datatable');
    Route::get('/view_invoice/{id}', 'Parent\InvoiceController@view_invoice')->name('parentpanel.student.lesson.view_invoice');
    Route::post('/save_invoice', 'Parent\InvoiceController@save_invoice')->name('parentpanel.student.lesson.save_invoice');
});



?>