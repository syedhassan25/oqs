@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <button class="btn btn-primary pull-right addLessonbtn">Send
                            Complain</button></h2>
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
                                    <table data-link="{{route('teacherpanel.complain.datatable')}}"
                                        id="complain-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Complain Purpose</th>
                                                <th>Complain Description</th>
                                                <th>Reciever</th>
                                                <th>Created at</th>
                                                
                                                

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

<div id="ComplainModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="formcomplain" action="{{ route('teacherpanel.complain.save') }}" method="POST" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send Complain</h4>
                </div>

                <div class="modal-body">
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Complain  Reciever<span class="text-danger">@error('complainreciever')
                                        {{ $message }}
                                        @enderror</span></label>

                                <select name="complainreciever"
                                    class="form-control @error('complainreciever') is-invalid @enderror">
                                    <option value="">Select Complain Reciever</option>
                                    <option value="1">Section Incharge</option>
                                    <option value="2">Team</option>

                                </select>


                            </div>
                        </div>

                    </div>
                       <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Complain Purpose <span class="text-danger">@error('complainpurpose')
                                        {{ $message }}
                                        @enderror</span></label>


  <input  name="id"  type="hidden" value="">

                                <input placeholder="Complain Purpose"
                                    class="form-control complainpurpose @error('complainpurpose') is-invalid @enderror " name="complainpurpose"
                                    type="text">


                            </div>
                        </div>

                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Complain Details <span class="text-danger">@error('complaindetail')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="complaindetail"
                                    class="form-control @error('complaindetail') is-invalid @enderror"></textarea>

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

<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {
    
    
     $(document).on('click', '.addLessonbtn', function(e) {

        e.preventDefault();


        $(`#formcomplain input[name="id"]`).val('')
        $(`#formcomplain input[name="complainpurpose"]`).val('')
        $(`#formcomplain textarea[name="complaindetail"]`).val('')
        $(`#formcomplain select[name="complainreciever"]`).val('');
        $('#ComplainModal').modal('show');


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
                url: $('#formcomplain').attr('action'),
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#formcomplain')[0])
            })
            .done(function(data) {
                console.log(data);
                if (data.error) {
                    $.each(data.error, function(key, value) {
                        var input = `#formcomplain input[name="${key}"]`;
                        var inputtextarea = `#formcomplain textarea[name="${key}"]`;
                        var inputselect = `#formcomplain select[name="${key}"]`;
                        var inputselectid = `#formcomplain select[id="${key}"]`;
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
                    $('#formcomplain')[0].reset();
                    $('#ComplainModal').modal('hide');
                    $('#complain-datatable').DataTable().draw(true);

                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });

    $(document).on('click', '.btneditcomplain', function() {
        
        var id = $(this).attr('data-id');

        var route = '{{ route("teacherpanel.complain.edit", ":id") }}';

        route = route.replace(':id', id);

        $.get(route, {}, function(res) {

        console.log(res)
            $(`#formcomplain input[name="id"]`).val(res.id)
            $(`#formcomplain input[name="complainpurpose"]`).val(res.complain)
            $(`#formcomplain textarea[name="complaindetail"]`).val(res
                .Description)
            $(`#formcomplain select[name="complainreciever"]`).val(res.reciver_type);

            $('#ComplainModal').modal('show');
        })


    })
    
    
    var oTable = $('#complain-datatable').DataTable({
        processing: true,
        serverSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#complain-datatable').attr('data-link'),
        },

        columns: [

        
            {
                data: 'complain',
                name: 'complain'
            },
            
           {
                data: 'Description',
                name: 'Description'
            },
            
            {
                data: 'reciever',
                name: 'reciever',
                orderable: false,
                searchable: false
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