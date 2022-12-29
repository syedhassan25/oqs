@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <button class="btn btn-primary pull-right addLessonbtn">Send
                            Suggestion</button></h2>
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
                                    <table data-link="{{route('teacherpanel.suggestion.datatable')}}"
                                        id="suggestion-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Suggestion Purpose</th>
                                                <th>Suggestion Description</th>
                                            
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

<div id="suggestionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="formsuggestion" action="{{ route('teacherpanel.suggestion.save') }}" method="POST" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send Suggestion</h4>
                </div>

                <div class="modal-body">
                  
                       <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>suggestion Purpose <span class="text-danger">@error('suggestionpurpose')
                                        {{ $message }}
                                        @enderror</span></label>


  <input  name="id"  type="hidden" value="">

                                <input placeholder="suggestion Purpose"
                                    class="form-control suggestionpurpose @error('suggestionpurpose') is-invalid @enderror " name="suggestionpurpose"
                                    type="text">


                            </div>
                        </div>

                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>suggestion Details <span class="text-danger">@error('suggestiondetail')
                                        {{ $message }}
                                        @enderror</span></label>

                                <textarea name="suggestiondetail"
                                    class="form-control @error('suggestiondetail') is-invalid @enderror"></textarea>

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


        $(`#formsuggestion input[name="id"]`).val('')
        $(`#formsuggestion input[name="suggestionpurpose"]`).val('')
        $(`#formsuggestion textarea[name="suggestiondetail"]`).val('')
        
        $('#suggestionModal').modal('show');


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
                url: $('#formsuggestion').attr('action'),
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData($('#formsuggestion')[0])
            })
            .done(function(data) {
                console.log(data);
                if (data.error) {
                    $.each(data.error, function(key, value) {
                        var input = `#formsuggestion input[name="${key}"]`;
                        var inputtextarea = `#formsuggestion textarea[name="${key}"]`;
                        var inputselect = `#formsuggestion select[name="${key}"]`;
                        var inputselectid = `#formsuggestion select[id="${key}"]`;
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
                    $('#formsuggestion')[0].reset();
                    $('#suggestionModal').modal('hide');
                    $('#suggestion-datatable').DataTable().draw(true);

                }
            })
            .fail(function(data) {
                console.log(data);

            });
    });

    $(document).on('click', '.btneditsuggestion', function() {
        
        var id = $(this).attr('data-id');

        var route = '{{ route("teacherpanel.suggestion.edit", ":id") }}';

        route = route.replace(':id', id);

        $.get(route, {}, function(res) {

        console.log(res)
            $(`#formsuggestion input[name="id"]`).val(res.id)
            $(`#formsuggestion input[name="suggestionpurpose"]`).val(res.subject)
            $(`#formsuggestion textarea[name="suggestiondetail"]`).val(res
                .Description)
         

            $('#suggestionModal').modal('show');
        })


    })
    
    
    var oTable = $('#suggestion-datatable').DataTable({
        processing: true,
        serverSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#suggestion-datatable').attr('data-link'),
        },

        columns: [

        
            {
                data: 'subject',
                name: 'subject'
            },
            
           {
                data: 'Description',
                name: 'Description'
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