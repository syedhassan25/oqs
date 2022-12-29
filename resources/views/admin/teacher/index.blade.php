@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="container">



        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $subTitle }} <a href="{{ route('admin.teacher.create') }}" target="_blank"
                            class="btn btn-primary pull-right px-2">Add New Teacher</a></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ $pageTitle }}</a></li>
                            <li class="breadcrumb-item active">{{ $subTitle }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="example-box-wrapper">

                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" id="employeeDrp">
                                <option value="">Select All Teacher</option>
                                <option selected value="1">Active</option>
                                <option value="2">Deactive</option>
                            </select>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">


                                    <div class="table-responsive">
                                        <table data-link="{{ route('admin.teacher.datatable') }}" id="employee-datatable"
                                            class="table table-bordered table-hover">
                                            <thead>
                                                <tr>

                                                    <th>Teacher NAme</th>
                                                    <th>Email</th>
                                                    <th>Teacher Father NAme</th>
                                                    <th>AnyDesk</th>
                                                    <th>Age</th>
                                                    <th>Gender</th>
                                                    <th>contact_no</th>
                                                    <th>contact_no_2</th>
                                                    <th>whatsapp</th>
                                                    <th>personal_skype</th>
                                                    <th>identity_card_no</th>
                                                    <th>City</th>
                                                    <th>Country</th>
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
        </section>


        <div class="modal fade" id="ComplainTeacherModal" tabindex="-1" role="dialog" aria-labelledby="SchduleModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Complain About Teacher</h5>

                    </div>
                    <form id="formteachercomplain" action="{{ route('admin.teacher.about.complain.save') }}" method="POST"
                        role="form">
                        <div class="modal-body">


                            @csrf
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="table-responsive">
                                        <table data-link="{{ route('admin.teacher.about.complain.datatable') }}"
                                            id="teacher-about-complain-datatable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>

                                                    <th>Complain</th>
                                                    <th>Created At</th>
                                                    <th>Created By</th>

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
                                        <label>Complain<span class="m-l-5 text-danger  errorlabelmy">
                                                *</span></label>
                                        <textarea name="complain" class="form-control complain @error('complain') is-invalid @enderror "></textarea>

                                        <input type="hidden" name="id" value="" />

                                        <span class="text-danger">
                                            @error('complain')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" id="savecomplain" class="btn btn-primary btn-block">Save
                                </button>
                        </div>
                    </form>
                </div>
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
    <script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>

    <script type="text/javascript">
        $(document).on('click', '.view_employee', function() {

            var $id = $(this).attr('data-id');

            var url = '{{ route('admin.teacher.view.detail.allowance', ':id') }}';
            url = url.replace(':id', $id);
            uni_modal("Employee Details", url, "modal-lg")

        });

        $('#formteachercomplain').on('submit', function(event) {
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
                    $('#savecomplain').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.error) {

                        $('#savecomplain').attr('disabled', false);
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

                        $('#teacher-about-complain-datatable').DataTable().draw(true);
                        $(`.form-control`).removeClass('is-invalid')
                        $('.errorlabelmy').html('');
                        $('#saveCommentsNew').attr('disabled', false);
                        swal("Good job!", data.success, data.alert);
                        $("#formteachercomplain").get(0).reset();
                        // $('#CommentStudentModal').modal('hide');
                        $('#ComplainTeacherModal  input[name="id"]').val('')


                    }
                    $('#savecomplain').attr('disabled', false);

                }
            })
        });

        $(document).on('click', '.btnteachercomplainmodal', function() {

            let teacherid = $(this).attr('data-id');
            $('#ComplainTeacherModal  input[name="id"]').val(teacherid);
            $('#teacher-about-complain-datatable').DataTable().draw(true);
            $('#ComplainTeacherModal').modal('show');

        });
        var oTable = $('#teacher-about-complain-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
            ],
            ajax: {
                url: $('#teacher-about-complain-datatable').attr('data-link'),
                data: function(d) {
                    d.id = $('#ComplainTeacherModal  input[name="id"]').val();
                }
            },

            columns: [{
                    data: 'comment',
                    name: 'comment',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'creatorname',
                    name: 'creatorname',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        /* Datatables responsive */

        $(document).ready(function() {


            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                $temp.remove();
                toastr.success('Copy Successfully')
            }

            $(document).on('click', '.CopyAnydesckClass', function() {
                copyToClipboard($(this));
            });

            $(document).on('change', '#employeeDrp', function() {
                $('#employee-datatable').DataTable().draw(true);
            });


            var oTable = $('#employee-datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                ],
                ajax: {
                    url: $('#employee-datatable').attr('data-link'),
                    data: function(d) {
                        d.status = $("#employeeDrp").val();
                    }
                },

                columns: [{
                        data: 'employeename',
                        name: 'employees.employeename'
                    },
                    {
                        data: 'email',
                        name: 'users.email'
                    },
                    {
                        data: 'employeefathername',
                        name: 'employees.employeefathername'
                    },
                    {
                        data: 'anyDeskcolumn',
                        name: 'anyDeskcolumn',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'age',
                        name: 'employees.age'
                    },
                    {
                        data: 'gendertxt',
                        name: 'gendertxt',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'contact_no',
                        name: 'employees.contact_no'
                    },
                    {
                        data: 'contact_no_2',
                        name: 'employees.contact_no_2'
                    },
                    {
                        data: 'whatsapp',
                        name: 'employees.whatsapp'
                    },
                    {
                        data: 'personal_skype',
                        name: 'employees.personal_skype'
                    },
                    {
                        data: 'identity_card_no',
                        name: 'employees.identity_card_no'
                    },
                    {
                        data: 'CityName',
                        name: 'cities.CityName'
                    },
                    {
                        data: 'CountryName',
                        name: 'countries.CountryName'
                    },
                    {
                        data: 'action',
                        name: 'action',
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
