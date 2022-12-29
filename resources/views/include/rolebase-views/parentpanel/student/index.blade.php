@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

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


                              <div class="table-responsive">
                                    <table data-link="{{route('parentpanel.student.datatable')}}"
                                        id="student-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Group</th>
                                                 <th>Status</th>
                                                <th width="20%">Days</th>
                                                <th width="10%">Language</th>
                                                <th>Country</th>
                                                <th>Duration</th>
                                                 <th>Detail</th>
                                                

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

@endsection
@push('scripts')

<!-- Data tables -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>

<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {
    var oTable = $('#student-datatable').DataTable({
        processing: true,
        serverSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#student-datatable').attr('data-link'),
        },

        columns: [

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
                data: 'class_status',
                name: 'class_status',
                orderable: false,
                searchable: false
            },
            
            {
                data: 'day',
                name: 'day',
                orderable: false,
                searchable: false
            },
            {
                data: 'languages',
                name: 'languages',
                orderable: false,
                searchable: false
            },

            {
                data: 'CountryName',
                name: 'countries.CountryName'
            },
            {
                data: 'duration',
                name: 'student.duration'
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