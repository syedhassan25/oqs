@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <button class="btn btn-primary pull-right addLessonbtn">Send
                            reminder</button></h2>
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
                                    <table data-link="{{route('teacherpanel.reminder.datatable')}}"
                                        id="reminder-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Teminder Title</th>
                                                <th>Reminder Prupose</th>
                                                <th>Reminder Date</th>
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

<div id="reminderModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="formreminder" action="{{ route('teacherpanel.reminder.save') }}" method="POST" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send reminder</h4>
                </div>

                <div class="modal-body">
                  
                       <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>reminder title <span class="text-danger">@error('title')
                                        {{ $message }}
                                        @enderror</span></label>


  <input  name="id"  type="hidden" value="">

                                <input placeholder="reminder title"
                                    class="form-control reminderpurpose @error('title') is-invalid @enderror " name="title"
                                    type="text">


                            </div>
                        </div>

                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>reminder purpose <span class="text-danger">@error('purpose')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="purpose"
                                    class="form-control @error('purpose') is-invalid @enderror"></textarea>

                            </div>
                        </div>

                    </div>
                       <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>reminder date <span class="text-danger">@error('reminderdate')
                                        {{ $message }}
                                        @enderror</span></label>


 

                               <input placeholder="Joining Date" data-date-format="mm/dd/yy"
                                            class="form-control bootstrap-datepicker reminderdate" name="reminderdate" type="text"
                                            value="">

                            </div>
                        </div>

                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnsavelesson" class="btn btn-primary btn-block">Save</button>


                </div>

            </div>
        </form>
    </div>
</div>

</div>

@endsection
@push('scripts')

<!-- Data tables -->
<script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>
<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/widgets/datepicker/datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {
    
     $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
    })

    
    
     $(document).on('click', '.addLessonbtn', function(e) {

        e.preventDefault();


        $(`#formreminder input[name="id"]`).val('')
        $(`#formreminder input[name="reminderpurpose"]`).val('')
        $(`#formreminder textarea[name="reminderdetail"]`).val('')
        
        $('#reminderModal').modal('show');


    })

    $(document).on('click', '#btnsavelesson', function(e) {
        e.preventDefault();

        $('.text-danger').text('');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
        $('textarea').removeClass('is-invalid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
                type: "POST",
                url: $('#formreminder').attr('action'),
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#formreminder')[0])
            })
            .done(function(data) {
                console.log(data);
                if (data.error) {
                    $.each(data.error, function(key, value) {
                        var input = `#formreminder input[name="${key}"]`;
                        var inputtextarea = `#formreminder textarea[name="${key}"]`;
                        var inputselect = `#formreminder select[name="${key}"]`;
                        var inputselectid = `#formreminder select[id="${key}"]`;
                        // console.log(input)
                        $(input).parents('.form-group').find('.text-danger').text(value);
                        $(inputtextarea).parents('.form-group').find('.text-danger').text(
                            value);
                        $(inputselect).parents('.form-group').find('.text-danger').text(
                            value);
                        $(inputselectid).parents('.form-group').find('.text-danger').text(
                            value);
                        $(input).addClass('is-invalid');
                        $(inputtextarea).addClass('is-invalid');
                        $(inputselect).addClass('is-invalid');
                        $(inputselectid).addClass('is-invalid');
                    });
                }

                if (data.Success) {
                    swal({
                        title: "Good job!",
                        text: data.msg,
                        icon: "success",
                        button: "Close",
                    });
                    $('#formreminder')[0].reset();
                    $('#reminderModal').modal('hide');
                    $('#reminder-datatable').DataTable().draw(true);

                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });

    $(document).on('click', '.btneditreminder', function() {
        
        var id = $(this).attr('data-id');

        var route = '{{ route("teacherpanel.reminder.edit", ":id") }}';

        route = route.replace(':id', id);

        $.get(route, {}, function(res) {

        console.log(res)
            $(`#formreminder input[name="id"]`).val(res.id)
            $(`#formreminder input[name="reminderpurpose"]`).val(res.subject)
            $(`#formreminder textarea[name="reminderdetail"]`).val(res
                .Description)
         

            $('#reminderModal').modal('show');
        })


    })
    
    
    var oTable = $('#reminder-datatable').DataTable({
        processing: true,
        serverSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#reminder-datatable').attr('data-link'),
        },

        columns: [

        
            {
                data: 'title',
                name: 'title'
            },
            
           {
                data: 'purpose',
                name: 'purpose'
            },
             {
                data: 'reminderdate',
                name: 'reminderdate'
            },
            
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});
</script>
@endpush