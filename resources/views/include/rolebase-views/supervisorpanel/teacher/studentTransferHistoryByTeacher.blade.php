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
            
<div class="row">
    
                                    
                                      <div class="col-md-4">
                                        <select class="form-control js-example-basic-single" id="employeeDrp">
                                            <option value="">Select Teacher</option>
                                            @foreach($Employee as $val)
                                                <option value="{{$val->id}}">{{$val->employeename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                 
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btnsearchForm">Search</button>
                                    </div>
                                </div>
                                <br />

                <div class="row">
            <div class="col-12">
                <div class="card">
                  
                    <!-- /.card-header -->
                    <div class="card-body">

                     
    <div class="table-responsive">
                                                                <table id="teacherchangehistoryDatatable"
                                                                    data-link="{{route('admin.teacher.student.transfer.history.forms')}}"
                                                                    class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Old Teacher</th>
                                                                            <th>New Teacher</th>
                                                                            <th>Name</th> 
                                                                            <th>Group</th>
                                                                            <th>Day</th>
                                                                            <th>reason</th>
                                                                            <th>Description</th>
                                                                            <th>Date</th>
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
    var teacherchangehistoryDatatable = $('#teacherchangehistoryDatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
            [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
        ],
        ajax: {
            url: $('#teacherchangehistoryDatatable').attr('data-link'),
             data: function(d) {
                d.teacherid = $('#employeeDrp').val();
              
            }
            
        },

        columns: [{
                data: 'oldteachername',
                name: 'oldteacher.oldteachername',
                orderable: false,
                searchable: false
            },
            {
                data: 'newteachername',
                name: 'newteacher.newteachername',
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
                data: 'day',
                name: 'day',
                orderable: false,
                searchable: false
            },
            {
                data: 'reason',
                name: 'reason.reason',
            },
            {
                data: 'description',
                name: 'teacherchange.description',
            },
            {
                data: 'createt_at_new',
                name: 'teacherchange.created_at',
            }
        ]
    });
    
     $(document).on('click', '.btnsearchForm', function() {

         $('#teacherchangehistoryDatatable').DataTable().draw(true);
       
    })
    
});

$(document).ready(function() {
    $('.dataTables_filter input').attr("placeholder", "Search...");
});
</script>
@endpush