<div class="">
    <div class="panel-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <h3>Employee Leave <button type="button" class="btn btn-primary btnempleave">Add Leave</button>
                        </h3>
                        <br />

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table data-link="{{ route('admin.employee.leave.datatable') }}"
                                        id="employee-leave-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Leave Days</th>
                                                <th>Comments</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="empleaveModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
       

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            
                            <input name="id" value="" type="hidden">
                            @if ($id)
                                <input name="leaveemployee" class="leaveemployee" value="{{ $id }}" type="hidden">
                            @else
                                <div class="form-group">
                                    <label>Employee <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                    <select class="form-control leaveemployee" name="leaveemployee" id="employeeDrp">
                                        <option value="">Select Teacher</option>
                                        @foreach ($Employee as $val)
                                            <option value="{{ $val->id }}">{{ $val->employeename }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Type <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                <select name="leaveType" class="form-control leaveTypeclass leaveType">
                                    <option value="">Select Leave Type</option>
                                    <option value="half">Half</option>
                                    <option value="full">Full</option>
                                </select>
                                <span class="text-danger"></span>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Start Date <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                <input placeholder="Leave Date" class="form-control  LeaveDate" name="LeaveDate"
                                    type="text">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>End Date <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                <input placeholder="End Leave Date" class="form-control  EndLeaveDate" name="EndLeaveDate"
                                    type="text">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Comments <span class="m-l-5 text-danger  errorlabelmy"></span></label>
                                <textarea name="levecomments" class="form-control levecomments"></textarea>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveempleaveNew" class="btn btn-primary">Save changes</button>
                </div>
            </div>
      
    </div>
</div>

@push('partail-scripts')
    <script type="text/javascript">
        $('.LeaveDate').datepicker({
            format: 'yyyy-mm-dd',

        }).datepicker("setDate",'now');
        $('.EndLeaveDate').datepicker({
            format: 'yyyy-mm-dd',
        }).datepicker("setDate",'now');


        $(".LeaveDate").on('change',function () {
        var date = Date.parse($('.LeaveDate').val());
        var Enddate = Date.parse($('.EndLeaveDate').val());
        if (date == Enddate) {

        }
        else if (date >= Enddate) {
            alert('Selected Start date must be Less than or Equal End date');
            $(this).val('');
        }
        console.log(date,'----',Enddate)
    });

       
        $(".EndLeaveDate").on('change',function () {
        var date = Date.parse($(this).val());
        var startdate = Date.parse($('.LeaveDate').val());
        if(startdate){
            if (date == startdate) {

            }
            else if (date < startdate) {
                alert('Selected End date must be greater than or Equal Start date');
               $(this).val('');
            }
        }else{
            $(this).val('');
            alert('Please Must Select First Start Date');
        }
       
        console.log(date,'----',startdate)
    });
    
    $(document).on('click','.btndeleteemployeeleave' ,function(event) {
            event.preventDefault();
           var $this =  $(this);
            var formData = {id:$(this).attr('data-id'),_token:'{{csrf_token()}}'};

            $.ajax({
                url: "{{ route('admin.employee.leave.delete') }}",
                method: 'post',
                data: formData,
                beforeSend: function() {
                    $this.attr('disabled', 'disabled');
                },
                success: function(data) {

                    console.log(data)
                    $this.attr('disabled', false);
                    swal("Good job!", 'success', "Delete  Successfully");
                    $('#employee-leave-datatable').DataTable().draw(true);

                }
            })
        });
        $('#saveempleaveNew').on('click', function(event) {
            event.preventDefault();

            var formData = {
                id:$('#empleaveModal input[name="id"]').val(),
                leaveemployee:$('#empleaveModal .leaveemployee').val(),
                leaveType:$('#empleaveModal select[name="leaveType"]').val(),
                LeaveDate:$('#empleaveModal input[name="LeaveDate"]').val(),
                EndLeaveDate:$('#empleaveModal input[name="EndLeaveDate"]').val(),
                levecomments:$('#empleaveModal textarea[name="levecomments"]').val(),
                _token:'{{csrf_token()}}'
            }

            $.ajax({
                url: "{{ route('admin.employee.leave.add') }}",
                method: 'post',
                data: formData,
                beforeSend: function() {
                    $('#saveempleaveNew').attr('disabled', 'disabled');
                },
                success: function(data) {

                    console.log(data)

                    if (data.error) {

                        $('#saveempleaveNew').attr('disabled', false);
                        $(`.form-control`).removeClass('is-invalid')
                        $('.errorlabelmy').html('');
                        for (var k in data.error) {

                            let value = data.error[k];
                            k = k.replace(/\./g, "");
                            let classvak = '.' + k;

                            console.log(classvak)

                            $(`${classvak}`).addClass('is-invalid');
                            $(`${classvak}`).closest('.form-group').find('.errorlabelmy')
                                .html(value)

                        }
                    } else {
                        $('#saveempleaveNew').attr('disabled', false);
                        $('#employee-leave-datatable').DataTable().draw(true);
                        $('#empleaveModal').modal('hide');
                        $('.errorlabelmy').html('');
                        swal("Good job!", 'success', "Loan  Save Successfully");
                        
                    }

                    // else {
                    //   $('#student-new-comment-datatable').DataTable().draw(true);
                    //     $(`.form-control`).removeClass('is-invalid')
                    //     $('.errorlabelmy').html('');
                    //     $('#saveCommentsNew').attr('disabled', false);
                    //      swal("Good job!", data.success, data.alert);
                    //     $("#formstudentComments").get(0).reset();
                    //     // $('#CommentStudentModal').modal('hide');
                    //     $('#CommentStudentModal  input[name="id"]').val('')


                    // }


                }
            })
        });
        $(document).on('click', '.btnempleave', function() {
            $('.errorlabelmy').html('');
            $('#empleaveModal').find('select[name="leaveemployee"]').val("");
            $('#empleaveModal').find('input[name="id"]').val("");
            $('#empleaveModal').find('select[name="leaveType"]').val("");
            $('#empleaveModal').find('input[name="LeaveDate"]').val("");
            $('#empleaveModal').find('input[name="EndLeaveDate"]').val("");
            $('#empleaveModal').find('textarea[name="levecomments"]').val("");
            $('#empleaveModal').modal('show');
        })
        $(document).on('click', '.edit_employee_leaveclass', function() {
            var id  = $(this).attr('data-id');
            var leaveemployee  = $(this).attr('data-leaveemployee');
            var leaveType  = $(this).attr('data-leaveType');
            var LeaveDate  = $(this).attr('data-LeaveDate');
            var EndLeaveDate  = $(this).attr('data-EndLeaveDate');
            var levecomments  = $(this).attr('data-levecomments');

            $('#empleaveModal').find('input[name="id"]').val(id);
            $('#empleaveModal').find('.leaveemployee').val(leaveemployee);
            $('#empleaveModal').find('select[name="leaveType"]').val(leaveType);
            $('#empleaveModal').find('input[name="LeaveDate"]').val(LeaveDate);
            $('#empleaveModal').find('input[name="EndLeaveDate"]').val(EndLeaveDate);
            $('#empleaveModal').find('textarea[name="levecomments"]').val(levecomments);
            $('#empleaveModal').modal('show');
        })
        
        var oTable = $('#employee-leave-datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
            ],
            ajax: {
                url: $('#employee-leave-datatable').attr('data-link'),
                data: function(d) {
                    d.id = '{{ $id ? $id : '' }}';
                    d.empid = $('#empdrpleave').val();
                }
            },

            columns: [{
                    data: 'empprofile',
                    name: 'empprofile',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'employeename',
                    name: 'employees.employeename',
                    searchable: true,
                    visible: false
                },

                {
                    data: 'holiday_type',
                    name: 'employee_leaves.holiday_type'
                },
                {
                    data: 'holiday_date',
                    name: 'employee_leaves.holiday_date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'holiday_end_date',
                    name: 'employee_leaves.holiday_end_date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'leavedays',
                    name: 'leavedays',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'holiday_comments',
                    name: 'employee_leaves.holiday_comments',
                    searchable: true,
                    visible: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],


        });
    </script>
@endpush
