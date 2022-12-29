@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div class="container">



        <div id="page-title">
            <h2>{{ $pageTitle }}
            </h2>
            <p>{{ $subTitle }}</p>
            
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
                                        <table data-link="{{ route('teacherpanel.student.classes.today.attendance.datatable') }}"
                                            id="todayclasses-datatable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>

                                                
                                                    <th>Student Name</th>
                                                    <th>Group</th>
                                                    <th>Attendance Day</th>
                                                    <th>Class time</th>
                                                    <th>Student Name</th>
                                                    <th>Attendance Date</th>
                                                    <th>Lesson Add</th>
                                                    


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


    <script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-fixedcolumns.js') }}"></script>



    <script type="text/javascript">
        /* Datatables responsive */

        $(document).ready(function() {

            var oTable = $('#todayclasses-datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                pageLength: 50,
                scrollY: "600px",
                scrollX: true,
                scrollCollapse: true,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                    [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
                ],
                ajax: {
                    url: $('#todayclasses-datatable').attr('data-link')
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
                        data: 'day_name',
                        name: 'studentattendance.day_name'
                    },
                    {
                        data: 'classtime',
                        name: 'studentattendance.attdendancetime',
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
                        data: 'attendancedate',
                        name: 'studentattendance.created_at'
                    },
                    {
                        data: 'isLesson',
                        name: 'isLesson',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('.dataTables_filter input').attr("placeholder", "Search...");





        });
    </script>
@endpush
