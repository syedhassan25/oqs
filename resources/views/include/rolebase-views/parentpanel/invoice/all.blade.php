@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">
    <div id="page-title">
        <h2>{{ $pageTitle }} <a class="btn btn-primary" href="{{ route('admin.invoice.create') }}"> Create Invoice</a></h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
        @include('admin.partials.flash')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="lanaguagedatatable" data-link="{{route('parentpanel.student.lesson.datatable')}}" style="width:100% important" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice Date</th>
                                    <th>Parent Name</th>
                                    <th>Group No</th>
                                    <th>Invoice Amount</th>
                                    <th>Paid From Wallet</th>
                                    <th>Discount</th>
                                    <th>Remaining Amount</th>
                                    <th>Status</th>
                                    <th>Created From</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Data tables -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/widgets/datatable/datatable-responsive.js') }}"></script>
<script>
$(document).ready(function() {
    var oTable = $('#lanaguagedatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: $('#lanaguagedatatable').attr('data-link'),
            data : {
                parent_id : {{ $parent_id }},
            },
        },
        columns: [
            {
                data: 'date',
            },
            {
                data: 'get_parent.name',
            },
            {
                data: 'get_parent.groupno',
            },
            {
                data: 'invoice_amount',
            },
            {
                data: 'paid_from_user_balance',
            },
            {
                data: 'discount',
            },
            {
                data: 'remaing_amount',
            },
            {
                data: 'status',
            },
            {
                data: 'get_parent.name',
            },
            {
                data: 'created_type',
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    $('.dataTables_filter input').attr("placeholder", "Search...");
});
</script>
@endpush

@endsection