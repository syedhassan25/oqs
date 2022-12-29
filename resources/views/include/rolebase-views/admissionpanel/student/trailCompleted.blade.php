@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/widgets/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />

<style>
.fa {
    font-size: 16px;
    padding: 19px;
}

.checked {
    color: orange;
}
</style>

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
                                <div class="row">
                                    <div class="col-md-4">
                                        <input placeholder="Joining Date" data-date-format="mm/dd/yy"
                                            class="form-control bootstrap-datepicker joiningDate" name="" type="text"
                                            value="">
                                    </div>

                                    <div class="col-md-4">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />
                                <div class="table-responsive">
                                    <table data-link="{{route('admissionpanel.student.trail.completed.datatable')}}"
                                        id="student-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Billing Status</th>
                                                <th>Student Name</th>

                                                <th>Group</th>
                                                <th>Contact No</th>

                                                <th>Country</th>
                                                <th>Feedback</th>
                                                <th>joining Date</th>
                                                <th>Total Attendance</th>
                                                <th>Total Days Trail Start</th>
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

</div>


<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="feedBackform" action="{{route('admin.student.teacher.feedback')}}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->

                            <div class="form-group">
                                <label>Question 1 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                <br />
                                <span data-attr="1" data-ques="1" id="rating-star-1-1" class="fa fa-star  btnrating"></span>
                                <span data-attr="2" data-ques="1" id="rating-star-1-2" class="fa fa-star  btnrating"></span>
                                <span data-attr="3" data-ques="1" id="rating-star-1-3" class="fa fa-star  btnrating"></span>
                                <span data-attr="4" data-ques="1" id="rating-star-1-4" class="fa fa-star  btnrating"></span>
                                <span data-attr="5" data-ques="1" id="rating-star-1-5" class="fa fa-star btnrating"></span>
                                <input type="hidden" name="ratingquestion1" class="ratingquestionval" id="ratingquestion1" value="0">
                            </div>
                            <div class="form-group">
                                <label>Question 2 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                <br />
                                <span data-attr="1" data-ques="2" id="rating-star-2-1" class="fa fa-star  btnrating"></span>
                                <span data-attr="2" data-ques="2" id="rating-star-2-2" class="fa fa-star  btnrating"></span>
                                <span data-attr="3" data-ques="2" id="rating-star-2-3" class="fa fa-star  btnrating"></span>
                                <span data-attr="4" data-ques="2" id="rating-star-2-4" class="fa fa-star  btnrating"></span>
                                <span data-attr="5" data-ques="2" id="rating-star-2-5" class="fa fa-star btnrating"></span>
                                <input type="hidden" name="ratingquestion2" class="ratingquestionval" id="ratingquestion2" value="0">
                            </div>
                            <div class="form-group">
                                <label>Question 3 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                <br />
                                <span data-attr="1" data-ques="3" id="rating-star-3-1" class="fa fa-star  btnrating"></span>
                                <span data-attr="2" data-ques="3" id="rating-star-3-2" class="fa fa-star  btnrating"></span>
                                <span data-attr="3" data-ques="3" id="rating-star-3-3" class="fa fa-star  btnrating"></span>
                                <span data-attr="4" data-ques="3" id="rating-star-3-4" class="fa fa-star  btnrating"></span>
                                <span data-attr="5" data-ques="3" id="rating-star-3-5" class="fa fa-star btnrating"></span>

                                <input type="hidden" name="ratingquestion3" class="ratingquestionval" id="ratingquestion3" value="0">
                            </div>
                            <div class="form-group">
                                <label>Question 4 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                <br />
                                <span data-attr="1" data-ques="4" id="rating-star-4-1" class="fa fa-star  btnrating"></span>
                                <span data-attr="2" data-ques="4" id="rating-star-4-2" class="fa fa-star  btnrating"></span>
                                <span data-attr="3" data-ques="4" id="rating-star-4-3" class="fa fa-star  btnrating"></span>
                                <span data-attr="4" data-ques="4" id="rating-star-4-4" class="fa fa-star  btnrating"></span>
                                <span data-attr="5" data-ques="4" id="rating-star-4-5" class="fa fa-star btnrating"></span>

                                <input type="hidden" name="ratingquestion4" class="ratingquestionval" id="ratingquestion4" value="0">
                            </div>
                            <div class="form-group">
                                <label>Question 5 <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                <br />
                                <span data-attr="1" data-ques="5" id="rating-star-5-1" class="fa fa-star  btnrating"></span>
                                <span data-attr="2" data-ques="5" id="rating-star-5-2" class="fa fa-star  btnrating"></span>
                                <span data-attr="3" data-ques="5" id="rating-star-5-3" class="fa fa-star  btnrating"></span>
                                <span data-attr="4" data-ques="5" id="rating-star-5-4" class="fa fa-star  btnrating"></span>
                                <span data-attr="5" data-ques="5" id="rating-star-5-5" class="fa fa-star btnrating"></span>

                                <input type="hidden" name="ratingquestion5" class="ratingquestionval" id="ratingquestion5" value="0">
                            </div>
                           
                            @csrf()
                            <div class="form-group">
                                <label>Feedback <span class="m-l-5 text-danger  errorlabelmy"> *</span></label>
                                <textarea name="description"
                                    class="form-control  description @error('description') is-invalid @enderror"></textarea>
                                <input type="hidden" name="studentid" class="studentid" value="">
                                <input type="hidden" name="teacherid" class="teacherid" value="">
                                <span class="text-danger">@error('detail') {{ $message }} @enderror</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js">
</script>

<script type="text/javascript" src="{{ asset('assets/widgets/datepicker/datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
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



    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    })


    $(document).on('click', '.btnsearchForm', function() {

        $('#student-datatable').DataTable().draw(true);
    })

    var oTable = $('#student-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
            data: function(d) {
                d.date = $('.joiningDate').val();
            }
        },

        columns: [

            {
                data: 'BillingStatus',
                name: 'BillingStatus',
                orderable: false,
                searchable: false
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
                data: 'contact_no',
                name: 'student.contact_no'
            },
            {
                data: 'CountryName',
                name: 'countries.CountryName'
            },
            {
                data: 'Feedback',
                name: 'Feedback',
                orderable: false,
                searchable: false,
            }, {
                data: 'joiningdate',
                name: 'joiningdate',
                orderable: false,
                searchable: false
            },
            {
                data: 'attendancecount',
                name: 'attendancecount',
                orderable: false,
                searchable: false
            },
            {
                data: 'totaldaycount',
                name: 'totaldaycount',
                orderable: false,
                searchable: false
            },


        ]
    });
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});

$(document).ready(function() {
    $('.select2').select2();


    $(document).on('click', '.btnfeedbackmodal', function() {

        let studentid = $(this).attr('data-id');
        let teacherid = $(this).attr('data-teacher-id');
        $('#feedBackform .studentid').val(studentid);
        $('#feedBackform .teacherid').val(teacherid);
        $('.btnrating').removeClass('checked');
        $('.ratingquestionval').val(0);
        $('#feedbackModal').modal('show');

    });




    $("#feedBackform").validate({
        rules: {
            description: {
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
                success: function(data) {
                    $('#feedBackform .studentid').val('');
                    $('#feedBackform .teacherid').val('');
                    $('#feedBackform .description').val('');
                    $('.btnrating').removeClass('checked');
        $('.ratingquestionval').val(0);
                    $('#student-datatable').DataTable().draw(true);
                    $('#feedbackModal').modal('hide');
                    swal("Feedback Save Successfully");
                },
                error: function(data) {
                    alert('Error')
                }
            });
        }
    });

    function changeStatus(formData) {

        console.log(formData)



        $.ajax({
            url: "{{ route('admin.student.billingstatus') }}",
            method: "POST",
            data: formData,
            success: function(res) {
                swal({
                    title: 'Status!',
                    text: 'Billing Status Change Successfully',
                    type: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1800
                });
            }
        })



    }

    function confirmStatus(info, callback) {


        swal.fire({
            title: "Are you sure?",
            text: "You Want Change status",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes !",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        }).then((result) => {
            if (result.value) {

                changeStatus(info);
                callback();
            }
        })



    }


    $(document).on('click', '.btnbillingStart', function() {
        var studentid = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var statustext = $(this).text();
        console.log('ss')
        let $this = $(this);

        var info = {
            status: status,
            studentid: studentid,
            _token: $('meta[name="csrf-token"]').attr('content')
        }

        confirmStatus(info, function() {
            $('#student-datatable').DataTable().draw(true);
            swal("Billing  Status change Successfully");
            $this.parents('.myclassDropBiiling').find('.btnstatustext').text(statustext);
        })

        console.log(status + '--' + studentid)
    })


    $(document).on('click',".btnrating" ,(function(e) {


        var selected_value = $(this).attr("data-attr");
        var question_value = $(this).attr("data-ques");

        console.log(selected_value,'---',question_value)

        var previous_value = $(`#ratingquestion${question_value}`).val();
        $(this).closest('.form-group').find('.btnrating').removeClass('checked')
        $(`#ratingquestion${question_value}`).val(selected_value);
        for (i = 1; i <= selected_value; ++i) {
            $(`#rating-star-${question_value}-${i}`).addClass('checked');

        }

        // for (ix = 1; ix <= previous_value; ++ix) {
        //     $(`#rating-star-${question_value}-${ix}`).toggleClass('checked');

        // }

    }));

});
</script>
@endpush