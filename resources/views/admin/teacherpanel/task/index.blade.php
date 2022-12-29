@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} </h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>

    <div class="panel">
        <div class="panel-body">

            <div class="example-box-wrapper">
                @include('admin.partials.flash')
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                             <div class="table-responsive">
                                    <table id="taskdatatable" data-link="{{route('teacherpanel.task.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>

                                           <th>Assigned By</th>
                                            <th>Subject</th>
                                            <th>Subject</th>
                                            <th>Task For</th>
                                            <th>Student</th>
                                            <th>Group</th>
                                            <th>Description</th>
                                            <th>Comment</th>
                                            <th>Completion date</th>
                                            <th>Completion Time</th>
                                             <th>Status</th>
                                          

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
<script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>
<script>
$(document).ready(function() {
    var oTable = $('#taskdatatable').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#taskdatatable').attr('data-link')
        },

        columns: [
             {
                data: 'name',
                name: 'users.name'
            },
             {
                data: 'subjectlink',
                name: 'subjectlink',
                orderable: false,
                searchable: false
            },
            {
                data: 'taskName',
                name: 'taskName', searchable: true, visible: false 
            }
            ,
            {
                data: 'tasktype',
                name: 'tasktype',
                orderable: false,
                searchable: false
            },
            
             { data: 'studentname', name: 'student.studentname', searchable: true, visible: false },
             { data: 'group', name: 'student.group', searchable: true, visible: false },
          
            {
                data: 'taskDescription',
                name: 'taskDescription'
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false
            }
            ,
              {
                data: 'taskCompleteddate',
                name: 'taskCompleteddate'
            },
              {
                data: 'taskCompletedtime',
                name: 'taskCompletedtime'
            },
             {
                data: 'status',
                name: 'status',
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