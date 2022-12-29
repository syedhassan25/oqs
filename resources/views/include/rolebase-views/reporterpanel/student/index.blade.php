@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
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


                            <div class="row">
                                    <div class="col-md-4">
                                        <input placeholder="Joining Date" data-date-format="mm/dd/yy"
                                            class="form-control bootstrap-datepicker joiningDate" name="" type="text"
                                            value="">
                                    </div>
                                      <div class="col-md-3">
                                        <select class="form-control" id="employeeDrp">
                                            <option value="">Select Teacher</option>
                                            @foreach($Employee as $val)
                                                <option value="{{$val->id}}">{{$val->employeename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                            <select name="academicStatus" class="form-control academicStatus select2"
                                             multiple="multiple" data-placeholder="Select a Status" data-dropdown-css-class="select2-purple">
                                            <option value="">Select Status</option>
                                             @foreach($academicStatusArr as $s)
                                             <?php 
                                                 $sel = "";
                                                 if($s->academic_status_val == $status){
                                                     $sel = "selected";
                                                 }
                                             
                                             ?>
                                              <option {{$sel}} value="{{$s->academic_status_val}}">{{$s->academic_status}}</option>
                                             @endforeach
                                    
                                            </select>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" value="" placeholder="Group No" id="txtserachgroup" class="form-control"  />
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />


                            <div class="table-responsive">
                                    <table data-link="{{route('reporter.student.studentdatatablenew')}}" id="student-datatable"
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                 <th>Group</th>
                                                
                                                 <th>Student Name</th>
                                                <th>Student Name</th>
                                                 <th>Teahcer</th>
                                               <th>Status</th>
                                                <th>Skype id 2</th>
                                               <th>joining Date</th>
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

</div>


<div class="modal fade" id="CommentStudentModal" tabindex="-1" role="dialog" aria-labelledby="SchduleModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="addMeetingSchduleModalLongTitle">Comments</h5>

            </div>
            <form id="formstudentComments" action="{{ route('reporter.student.new.comment.save') }}"
                method="POST" role="form">
                <div class="modal-body">


                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            
                              <div class="table-responsive">
                                            <table data-link="{{ route('reporter.student.new.comment.datatable') }}"
                                                id="student-new-comment-datatable"
                                                class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>

                                                        <th>Comment</th>
                                                        <th>Created By</th>
                                                        <th>Created At</th>
                                                        
                                                    </tr>
                                                </thead>



                                            </table>
                                        </div>
                           
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Comment<span class="m-l-5 text-danger  errorlabelmy">
                                        *</span></label>
                                <textarea name="comment"
                                    class="form-control comment @error('comment') is-invalid @enderror "></textarea>
                                    
                                <input type="hidden" name="id" value="" />

                                <span class="text-danger">@error('comment')
                                    {{ $message }}
                                    @enderror</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" id="saveCommentsNew" class="btn btn-primary btn-block">Save
                        Comments</button>
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

  $('.select2').select2();

    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    })


    $(document).on('click', '.btnsearchForm', function() {

        $('#student-datatable').DataTable().draw(true);
    })
    
    
     $(document).on('click','.btnstudentcommentmodal',function(){
        
        let studentid = $(this).attr('data-id');
        $('#CommentStudentModal  input[name="id"]').val(studentid);
        $('#student-new-comment-datatable').DataTable().draw(true);
        $('#CommentStudentModal').modal('show');
        
    });
    
    
    
     $('#formstudentComments').on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#saveCommentsNew').attr('disabled', 'disabled');
            },
            success: function(data) {
                if (data.error) {

                    $('#saveCommentsNew').attr('disabled', false);
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
                  
                   $('#student-new-comment-datatable').DataTable().draw(true);
                    $(`.form-control`).removeClass('is-invalid')
                    $('.errorlabelmy').html('');
                    $('#saveCommentsNew').attr('disabled', false);
                     swal("Good job!", data.success, data.alert);
                    $("#formstudentComments").get(0).reset();
                    // $('#CommentStudentModal').modal('hide');
                    $('#CommentStudentModal  input[name="id"]').val('')
                   
                    
                }
                $('#save').attr('disabled', false);

            }
        })
    });



 var oTable = $('#student-new-comment-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-new-comment-datatable').attr('data-link'),
            data: function(d) {
                d.id = $('#CommentStudentModal  input[name="id"]').val();
            }
        },

        columns: [
            {
                data: 'comment',
                name: 'comment'
            },
            {
                data: 'name',
                name: 'users.name'
            },
            {
                data: 'created_at',
                name: 'created_at'
            }
        ]
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
                data: 'employeename',
                name: 'employees.employeename',
                searchable: true,
                visible: true
            },
           
             {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {
                data: 'skypid_2',
                name: 'student.skypid_2'
            },
             {
                data: 'joining_date',
                name: 'student.joining_date'
            },
             {
                data: 'detail',
                name: 'detail',
                orderable: false,
                searchable: false
            }
        ]
    });
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});


</script>
@endpush