@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <a href="{{route('admin.teacher.create')}}" target="_blank"
                class="btn btn-primary pull-right px-2">Add New Teacher</a></h2>
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
    <table data-link="{{route('admin.teacher.datatable')}}" id="employee-datatable"
                        class="table table-bordered table-hover" >
                        <thead>
                            <tr>

                                <th>Teacher NAme</th>
                                <th>Email</th>
                                <th>Teacher Father NAme</th>
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
    var oTable = $('#employee-datatable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthMenu: [
        [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
        [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
    ],
    ajax: {
        url: $('#employee-datatable').attr('data-link')
    },

    columns: [  {
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
            data: 'age',
            name: 'employees.age'
        },
        {
            data: 'gender_type',
            name: 'gender_type',
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