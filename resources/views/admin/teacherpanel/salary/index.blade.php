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
                           <div class="card-header">
        						
        					</div>
                            <div class="card-body">
                            
                                <table id="payrollitemsdatatable" data-link="{{route('teacherpanel.salary.detail.payroll.datatable')}}"
                                    style="width:100% important" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
        									<th>Start date</th>
        									<th>End  Date</th>
        									<th>Action</th>
                                        </tr>
                                    </thead>

                                </table>

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
<script type="text/javascript" src="{{ asset('assets/widgets/datepicker/datepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


	
	<script type="text/javascript">
		$(document).ready(function() {
    var oTable = $('#payrollitemsdatatable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthMenu: [
        [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
        [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
    ],
    ajax: {
        url: $('#payrollitemsdatatable').attr('data-link')
    },

    columns: [
        {
            data: 'employee_no',
            name: 'employees.employee_no'
        },
        {
            data: 'date_from',
            name: 'payroll.date_from'
        },
        {
            data: 'date_to',
            name: 'payroll.date_to'
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