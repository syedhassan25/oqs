@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <a href="{{route('admin.parent.create')}}" target="_blank" class="btn btn-primary pull-right px-2">Add Parent</a></h2>
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
    <table data-link="{{route('admin.parent.datatable')}}" id="parent-datatable"
                        class="table table-bordered table-hover" >
                        <thead>
                            <tr>

                                <th>Name</th>
                                <th>Father NAme</th>
                                <th>Group No</th>
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
    var oTable = $('#parent-datatable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthMenu: [
        [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
        [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
    ],
    ajax: {
        url: $('#parent-datatable').attr('data-link')
    },

    columns: [  {
            data: 'name',
            name: 'parents.name'
        },
        {
            data: 'fathername',
            name: 'parents.fathername'
        },
        {
            data: 'groupno',
            name: 'parents.groupno'
        },
        {
            data: 'contact_no',
            name: 'parents.contact_no'
        },
        {
            data: 'contact_no_2',
            name: 'parents.contact_no_2'
        },
        {
            data: 'whatsapp',
            name: 'parents.whatsapp'
        },
        {
            data: 'personal_skype',
            name: 'parents.personal_skype'
        },
        {
            data: 'identity_card_no',
            name: 'parents.identity_card_no'
        },
        {
            data: 'citycol',
            name: 'cicitycolty',
            orderable: false,
            searchable: false
        },
        {
            data: 'countrycol',
            name: 'countrycol',
            orderable: false,
            searchable: false
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