@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<link href="{{ asset('assets/widgets/select2/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="container">
    <div id="page-title">
        <h2>{{ $pageTitle }} <a class="btn btn-primary" href="{{ route('admin.invoices.all') }}"> Back</a></h2>
        <p>{{ $subTitle }}</p>
        <!-- styles -->
        @include('admin.partials.themeswitcher')
        <!-- /.styles -->
    </div>
</div>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="bootstrap snippets bootdeys">
            <form action="{{ route('parentpanel.student.lesson.save_invoice') }}" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="invoice" id="invoice">
                            <div class="invoice-ribbon"><div class="ribbon-inner">PAID</div></div>
                                <div class="row">
                                    <div class="col-sm-6 top-left">
                                        Online Quran Course
                                    </div>
                                    <div class="col-sm-6 top-left">
                                        <h3 class="marginright">INVOICE-{{ $invoice_no }}</h3>
                                        <span class="marginright">{{ $invoice_create_date }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xs-4 from">
                                        <p class="lead marginbottom">From : Dynofy</p>
                                        <p>350 Rhode Island Street</p>
                                        <p>Suite 240, San Francisco</p>
                                        <p>California, 94103</p>
                                        <p>Phone: 415-767-3600</p>
                                        <p>Email: contact@dynofy.com</p>
                                    </div>
                                    <div class="col-xs-4 to" id="invoice_to">
                                        <p>{{ $invoice_data->getParent->name }}</p>
                                        <p>{{ $invoice_data->getParent->current_address }}</p>
                                        <p>{{ $invoice_data->getParent->contact_no }}</p>
                                        <p>{{ $invoice_data->getParent->resource_email }}</p>
                                    </div>
                                    <div class="col-xs-4 text-right payment-details">
                                        <p class="lead marginbottom payment-info">Payment details</p>
                                        <p>Date: {{ $invoice_create_date }}</p>
                                        <p>Account Name: {{ Auth::user()->name }}</p>
                                    </div>
                                </div>
                                <div class="row table-row">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width:5%">#</th>
                                                <th>Student Name</th>
                                                <th class="text-right">Package Name</th>
                                                <th class="text-right">Duration</th>
                                                <th class="text-right">Per Month</th>
                                                <th class="text-right">Discount %</th>
                                                <th class="text-right">Months</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="package_fatch">
                                            @if(!empty($invoice_data->getInvoiceItems))
                                                @php
                                                    $count = 1;
                                                    $total = 0;
                                                @endphp
                                                @foreach($invoice_data->getInvoiceItems as $items)
                                                    <tr id="row_id_560" class="package_fatch_rows">
                                                        <td class="text-center">{{ $count }}</td>
                                                        <td>
                                                            <span>{{ $items->getStudent->studentname }}</span>
                                                            <input type="hidden" name="student[1][student_id]" value="{{ $items->student_id }}">
                                                        </td>
                                                        <td>
                                                            <span>1 Days</span>
                                                            <input type="hidden" name="student[1][package_id]" value="{{ $items->package_id }}">
                                                        </td>
                                                        <td>
                                                            <span>{{ $items->duration }}</span>
                                                            <input type="hidden" name="student[1][duration]" value="{{ $items->duration }}">
                                                        </td>
                                                        <td>
                                                            <span>{{ $items->per_month_amount }}</span>
                                                            <input type="hidden" name="student[1][per_month_amount]" value="{{ $items->per_month_amount }}">
                                                        </td>
                                                        <td class="text-right">
                                                            <span>0</span>
                                                        </td>
                                                        <td class="text-right">
                                                            <span>1</span>
                                                        </td>
                                                        <td class="text-right amount_holder">
                                                            <span>
                                                                {{ $items->total }}
                                                                <?php
                                                                    $total+= $items->total;
                                                                ?>    
                                                            </span>
                                                            <input type="hidden" name="student[1][student_permonth_total]" value="{{ $items->total }}">
                                                        </td>
                                                    </tr>
                                                @php
                                                    $count++; 
                                                @endphp
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 margintop">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <select class='form-control'>
                                                    <option value="2Checkout">2Checkout</option>
                                                    <option value="Paypal">Paypal</option>
                                                    <option value="Stripe">Stripe</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <button class="btn btn-success btn-block" type="submit">Pay Now</button>
                                            </div>
                                        </div>
                                        <p class="lead marginbottom">THANK YOU!</p>
                                    </div>
                                    <div class="col-xs-6 text-right pull-right invoice-total">
                                        <p>Total : $<span class="invoice_sub_total">{{ $total }}</span></p>
                                        <hr />
                                        <input type="hidden" id="group_id" name="group_id" value="{{ $invoice_data->group_id }}" />
                                        <input type="hidden" name="total" value="{{ $total }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@include('admin.invoice.style')

@push('scripts')
<script src="{{ asset('assets/widgets/select2/select2.full.min.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
    integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
    crossorigin="anonymous"></script>
<script type="text/javascript">
/* Datatables responsive */

$(document).ready(function() {
    $('.select2').select2();
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
         startDate: new Date()

    });
});

function fatchParent(parent_id){
    $.ajax({
        url : "{{ route('admin.invoices.fatchParent') }}",
        type : "POST",
        data : {
            _token : "{{ csrf_token() }}",
            parent_id : parent_id
        },
        success : function(res){
            invoice_to(res.data.parent);
            $("#package_fatch").html('');
            var count = 1;
            $.each(res.data.parent.students, function(key, value){
                var packageText = "";
                var per_month = amount = 0;
                var regPackage = $.each(value.register_package, function(rkey, rvalue){
                    var param = {
                        "row_id" : rvalue.id,
                        "row_num" : count,
                        "student_id" : value.id,
                        "student_name" : value.full_name,
                        "package_name" : rvalue.get_package.days+" Days",
                        "package_id" : rvalue.get_package.id,
                        "duration" : rvalue.get_package.duration,
                        "per_month" : rvalue.get_package.amount,
                        "months" : 1,
                        "amount" : rvalue.get_package.amount,
                    };
                    package_fatch(param);
                    count++;
                    per_month+= rvalue.get_package.amount;
                });
            });
            subTotal();
            if(res.data.userBalance > 0){
                paidAmount(res.data.userBalance);
            }
            $("#group_id").val(parent_id);
        }
    })
}
function invoice_to(data){
    var html = [
        {"<>":"p","class":"lead marginbottom","html":"To : ${name}"},
        {"<>":"p","html":"${current_address}"},
        {"<>":"p","html":"Phone: ${contact_no}"},
        {"<>":"p","html":"Email: ${get_user.email}"}
    ];
    $("#invoice_to").html("").json2html(data, html);
}

function package_fatch(data){
    var html = [
        {"<>":"tr","id":"row_id_${row_id}","class":"package_fatch_rows","html":[
            {"<>":"td","class":"text-center","html":"${row_num}"},
            {"<>":"td","html":[
                {"<>":"span","html":"${student_name}"},
                {"<>":"input","type":"hidden","name":"student[${row_num}][student_id]","value":"${student_id}"},
            ]},
            {"<>":"td","html":[
                {"<>":"span","html":"${package_name}"},
                {"<>":"input","type":"hidden","name":"student[${row_num}][package_id]","value":"${package_id}"},
            ]},
            {"<>":"td","html":[
                {"<>":"span","html":"${duration}"},
                {"<>":"input","type":"hidden","name":"student[${row_num}][duration]","value":"${duration}"},
            ]},
            {"<>":"td","html":[
                {"<>":"span","html":"${per_month}"},
                {"<>":"input","type":"hidden","name":"student[${row_num}][per_month_amount]","value":"${per_month}"},
            ]},
            {"<>":"td","class":"text-right","html":[
                {"<>":"span","html":"0"},
            ]},
            {"<>":"td","class":"text-right","html":[
                {"<>":"span","html":"0"},
            ]},
            {"<>":"td","class":"text-right amount_holder","html":[
                {"<>":"span","html":"${amount}"},
                {"<>":"input","type":"hidden","name":"student[${row_num}][student_permonth_total]","value":"${amount}"},
            ]}
        ]}
    ];
    $("#package_fatch").json2html(data, html);
}

function subTotal(){
    var total = 0;
    $("#package_fatch tr").each(function(){
        total+= Number($(this).find(".amount_holder").html());
    });
    $(".invoice_sub_total").html(total);
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/json2html/1.2.0/json2html.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.json2html/1.2.0/jquery.json2html.min.js"></script>
@endpush

@endsection