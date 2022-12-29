@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/print/print.min.css') }}">
    <style>
        #tableEarnings {
            border-collapse: collapse;
        }

        #tableEarnings td {
            padding: 0px;
        }

        #tableclassess {
            border-collapse: collapse;
        }

        #tableclassess td {
            padding: 0px;
        }

        #tableDeductions {
            border-collapse: collapse;
        }

        #tableDeductions td {
            padding: 0px;
        }

        #tablesClassesbonus {
            border-collapse: collapse;
        }

        #tablesClassesbonus td {
            padding: 0px;
        }


        @media print {
            #tableEarnings {
                border-collapse: collapse;
            }

            #tableEarnings td {
                padding: 0px;
            }

            #tableclassess {
                border-collapse: collapse;
            }

            #tableclassess td {
                padding: 0px;
            }

            #tableDeductions {
                border-collapse: collapse;
            }

            #tableDeductions td {
                padding: 0px;
            }

            #tablesClassesbonus {
                border-collapse: collapse;
            }

            #tablesClassesbonus td {
                padding: 0px;
            }
        }



        @media print {
            .highlited {
                color: red;
                background-color: red;
            }
        }

        select {
            width: 150px;
            height: 30px;
            border: 1px solid #999;
            font-size: 18px;
            color: #1c87c9;
            background-color: #eee;
            border-radius: 5px;
            box-shadow: 4px 4px #ccc;
        }
    </style>

    <div class="container">



        <div class="row" style="display:block">
            <div class="col-md-4"><input  type="password" class="form-control slipPassword"
                    placeholder="Enter Valid Password to view Salary Slip" name="slipPassword" /></div>
            <div class="col-md-1">
                <button id="btnslippass" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('teacherpanel.salary.payroll.slip.password.generate') }}"
                    class="btn btn-primary">Reset Password</a>
            </div>
            <div class="col-md-5">
                <h3><strong>Please Contact To Support Department For Getting Salary Slip Password</strong>
            </div>
        </div>
        <br />

        <div style="display:none" class="slipContainer">
            <div id="page-title">
                <h2>{{ $pageTitle }}

                    <select id="payrollselectdate" class="">
                        @foreach ($allpayrolldata as $paydata)
                            <option {{ $paydata->id == request()->route('id') ? 'selected' : '' }}
                                value="{{ $paydata->id }}">
                                {{ date('F Y', strtotime($paydata->payrollparent->date_from)) }}</option>
                        @endforeach
                    </select>

                    <Button data-id="{{ request()->route('id') }}"
                        class="btn btn-primary pull-right px-2 btnstudentcommentmodal">Add Concern About Salary</Button>
                    <!--<button-->
                    <!--        class="btn btn-success btn-sm  col-md-2 float-right" type="button" id="print_btn"><span-->
                    <!--            class="fa fa-print"></span> Print</button>-->
                </h2>
                <p>{{ $subTitle }}</p>
                <!-- styles -->
                @include('admin.partials.themeswitcher')
                <!-- /.styles -->
            </div>

            <div class="panel">
                <div class="panel-body" id="paySlipRec" data-passid="{{ $teacherdata->salarypass }}">

                    <div class="example-box-wrapper">
                        @include('admin.partials.flash')


                        <?php
                        $totalclassess = 0;
                        $totalamountstudent = 0;
                        $deductamountstudent = 0;
                        $netamountstudent = 0;
                        $studentLessonDeductAmount = 0;
                        $dedcutGoodwokrbonus = 0;
                        if ($ClasseBonusdata) {
                            $dedcutGoodwokrbonus = $ClasseBonusdata->goodWorkBonus - $goodWorkAmounttotal;
                        }
                        
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="payslip-title">Payslip for the month of
                                            {{ date('M-Y', strtotime($payroll->created_at)) }}</h4>
                                        <div class="row">
                                            <div class="col-sm-6 m-b-20"><img
                                                    src="{{ url('assets/image-resources/logo-admin.png') }}"
                                                    class="inv-logo" alt="">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="highlited">Sispn PVT</li>
                                                    <li>Gulshan-e-iqbal</li>
                                                    <li>Karachi,Pakistan</li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-6 m-b-20">
                                                <div class="invoice-details" style="float: right">
                                                    <h3 class="text-uppercase">Payslip #{{ $slipdata->slipInvoice }}</h3>
                                                    <ul class="list-unstyled">
                                                        <li>Salary Month:
                                                            <span>{{ date('M-Y', strtotime($payroll->date_to)) }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 m-b-20">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <h5 class="mb-0">
                                                            <strong>{{ $employees->employeename }}</strong>
                                                        </h5>
                                                    </li>
                                                    <li><span>{{ $employees->role_type }}</span></li>
                                                    <li>Employee ID: {{ $employees->employee_no }}</li>
                                                    <li>Joining Date:
                                                        {{ date('d-M-Y', strtotime($employees->created_at)) }}</li>
                                                </ul>
                                            </div>
                                            @if (count($totalClassesdata) > 0)
                                                <div class="col-sm-9 classesemonthtable">

                                                    <table class="table table-bordered" id="tablesClassesbonus">
                                                        <tbody>
                                                            <tr>
                                                                <td>Monthly CLasses</td>
                                                                @foreach ($classes_bonus as $data)
                                                                    <td>{{ $data->weeklyClasses }}</td>
                                                                @endforeach

                                                            </tr>
                                                            <tr>
                                                                <td>Classes Bonus</td>
                                                                @foreach ($classes_bonus as $data)
                                                                    <td>{{ $data->classesBonus }}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>Good Work Bonus</td>
                                                                @foreach ($classes_bonus as $data)
                                                                    <td>{{ $data->goodWorkBonus }}</td>
                                                                @endforeach
                                                            </tr>


                                                        </tbody>
                                                    </table>

                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 m-b-20">
                                               
                                            </div>
                                             @if(count($totaldaysEarn) > 0)
                                             <div class="col-sm-9 classesemonthtable">
                                            
                                                 <table class="table table-bordered" id="tablesClassesbonus" >
                                                                    <tbody>
                                                                      <tr>
                                                                        <td>Week Days</td>
                                                                        <td>{{$totaldaysEarn['weekday']}}</td>
                                                                         
                                                                       
                                                                      </tr>
                                                                     <tr>
                                                                        <td>Weekend Days</td>
                                                                        <td>{{$totaldaysEarn['weekend']}}</td>
                                                                    </tr>
        
                                                                    <tr>
                                                                        <td>Sum</td>
                                                                        <td>{{$totaldaysEarn['weekday']+$totaldaysEarn['weekend']}}</td>
                                                                    </tr>
                                                                   
                                                                    
                                                                   
                                                                  </tbody>
                                                                </table>
                                            
                                            </div>
                                             @endif
                                        </div>



                                        @if (count($totalClassesdata) > 0)
                                            <!-- <div class="row">-->
                                            <!--    <div class="col-sm-12">-->

                                            <!--<table id="tablebonusses" style="font-size:10px !important;text-align:center !important">-->
                                            <!--    <tbody>-->
                                            <!--        <tr>-->
                                            <!--            <td>-->
                                            <!--                <table>-->
                                            <!--                    <tbody>-->
                                            <!--                        <tr>-->
                                            <!--                            <td>Weekly CLasses</td>-->
                                            <!--                        </tr>-->
                                            <!--                        <tr>-->
                                            <!--                            <td>Classes</td>-->
                                            <!--                        </tr>-->
                                            <!--                        <tr>-->
                                            <!--                            <td>Good Work Bonus</td>-->
                                            <!--                        </tr>-->


                                            <!--                    </tbody>-->
                                            <!--                    </table>-->
                                            <!--            </td>-->
                                            <!--             @foreach ($classes_bonus as $data)
    -->
                                            <!--             <td>-->
                                            <!--                <table>-->
                                            <!--                    <tbody>-->
                                            <!--                            <tr>-->
                                            <!--                               <td>{{ $data->weeklyClasses }}</td>-->
                                            <!--                            </tr>-->
                                            <!--                            <tr>-->
                                            <!--                                <td>{{ $data->classesBonus }}</td>-->
                                            <!--                            </tr>-->
                                            <!--                            <tr>-->
                                            <!--                                <td>{{ $data->goodWorkBonus }}</td>-->
                                            <!--                            </tr>-->
                                            <!--                             </tbody>-->
                                            <!--                    </table>-->
                                            <!--            </td>-->
                                            <!--
    @endforeach-->

                                            <!--        </tr>    -->

                                            <!--</table>         -->

                                            <!--                       <table class="table table-bordered" id="tablesClassesbonus" >-->
                                            <!--                            <tbody>-->
                                            <!--                              <tr>-->
                                            <!--                                <td>Monthly CLasses</td>-->
                                            <!--                                  @foreach ($classes_bonus as $data)
    -->
                                            <!--                                     <td>{{ $data->weeklyClasses }}</td>-->
                                            <!--
    @endforeach-->

                                            <!--                              </tr>-->
                                            <!--                             <tr>-->
                                            <!--                                <td>Classes</td>-->
                                            <!--                                 @foreach ($classes_bonus as $data)
    -->
                                            <!--                                     <td>{{ $data->classesBonus }}</td>-->
                                            <!--
    @endforeach-->
                                            <!--                            </tr>-->
                                            <!--                            <tr>-->
                                            <!--                                <td>Good Work Bonus</td>-->
                                            <!--                                 @foreach ($classes_bonus as $data)
    -->
                                            <!--                                     <td>{{ $data->goodWorkBonus }}</td>-->
                                            <!--
    @endforeach-->
                                            <!--                            </tr>-->


                                            <!--                          </tbody>-->
                                            <!--                        </table>-->

                                            <!--    </div>-->
                                            <!--</div>    -->

                                            <div class="row classesemonthtable">

                                                <div class="col-sm-12">
                                                    <div>
                                                        <h4 class="m-b-10"><strong>Classes</strong></h4>
                                                        <table class="table table-bordered" id="tableclassess">
                                                            <thead>

                                                                <tr>
                                                                    <td>Studentname</td>
                                                                    <td>Days</td>
                                                                    <td>Duration</td>
                                                                    <td>Total Classes</td>
                                                                    <td>Total Attend Classes</td>
                                                                    <td>Start Date</td>
                                                                    <td>End Date</td>
                                                                    <td>Lesson Add</td>
                                                                    <td>Total Amount</td>
                                                                    <td>Deduct Amount</td>
                                                                    <td>Net Amount</td>
                                                                </tr>

                                                            </thead>
                                                            <tbody>


                                                                @foreach ($totalClassesdata as $data)
                                                                    <tr>
                                                                        <td>{{ $data['studentname'] }}</td>
                                                                        <td><?php $day_array = explode(',', $data['teacherdays_name']);
                                                                        echo count($day_array); ?></td>
                                                                        <td>{{ $data['duration'] }}</td>
                                                                        <td>{{ $data['totalAttendance'] }}</td>
                                                                        <td>{{ $data['totalAttendClass'] }}</td>
                                                                        <td>{{ date('d-m-Y', strtotime($data['firstattendancedate'])) }}
                                                                        </td>
                                                                        <td>{{ date('d-m-Y', strtotime($data['lastattendancedate'])) }}
                                                                        </td>
                                                                        <td>{{ $data['studentLessonAdd'] }}</td>
                                                                        <td>{{ $data['totalamountstudent'] }}</td>
                                                                        <td>{{ $data['deductamountstudent'] }}</td>
                                                                        <td>{{ $data['netamountstudent'] }}</td>

                                                                        <?php
                                                                        
                                                                        $totalamountstudent += $data['totalamountstudent'];
                                                                        
                                                                        $deductamountstudent += $data['deductamountstudent'];
                                                                        
                                                                        $netamountstudent += $data['netamountstudent'];
                                                                        
                                                                        $totalclassess += $data['totalAttendance'];
                                                                        
                                                                        $studentLessonDeductAmount += isset($data['studentLessonDeductAmount']) ? $data['studentLessonDeductAmount'] : 0;
                                                                        
                                                                        ?>
                                                                    </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td colspan="2"><strong>Total Classess</strong> <span
                                                                            class="float-right"><strong>{{ $totalclassess }}</strong></span>
                                                                    </td>
                                                                    <td colspan="2"><strong>Total Amount</strong> <span
                                                                            class="float-right"><strong>Rs .
                                                                                {{ $totalamountstudent }}</strong></span>
                                                                    </td>
                                                                    <td colspan="3"><strong>Total Deduction</strong> <span
                                                                            class="float-right"><strong>Rs .
                                                                                {{ $deductamountstudent }}</strong></span>
                                                                    </td>
                                                                    <td colspan="4"><strong>Total Net Amount</strong> <span
                                                                            class="float-right"><strong>Rs .
                                                                                {{ $netamountstudent }}</strong></span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div>
                                                    <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                                    <table class="table table-bordered" id="tableEarnings">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Basic Salary</strong> <span
                                                                        class="float-right">Rs
                                                                        {{ $employees->salary + $totalamountstudent }}</span>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                            
                                                            $earning = $employees->salary;
                                                            
                                                            ?>
                                                            @foreach ($allowancedata as $data)
                                                                <?php $earning += $data['amount']; ?>
                                                                <tr>
                                                                    <td><strong>{{ $data['allowance'] }}</strong> <span
                                                                            class="float-right">Rs.{{ $data['amount'] }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                            @if ($ClasseBonusdata)
                                                                <?php
                                                                
                                                                $earning += $ClasseBonusdata->classesBonus;
                                                                $earning += $ClasseBonusdata->goodWorkBonus;
                                                                
                                                                ?>
                                                                <tr>
                                                                    <td><strong>Classess Bonus</strong> <span
                                                                            class="float-right">Rs.{{ $ClasseBonusdata->classesBonus }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Good Work Bonus</strong> <span
                                                                            class="float-right">Rs.{{ $ClasseBonusdata->goodWorkBonus }}
                                                                            / {{ $goodWorkAmounttotal }}</span></td>
                                                                </tr>
                                                            @endif
                                                            @if ($extraAllowance)
                                                                @foreach ($extraAllowance as $key => $data)
                                                                    <?php $earning += $data; ?>
                                                                    <tr>
                                                                        <td><strong>{{ $key }}</strong> <span
                                                                                class="float-right">Rs.{{ $data }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif

                                                            @if ($slipdata->refamount && $slipdata->refamount != 0)
                                                                <?php $totalamountstudent += (int) $slipdata->refamount; ?>

                                                                <tr>
                                                                    <td><strong>Total Referral</strong> <span
                                                                            class="float-right amountRight"><strong>Rs .
                                                                                {{ $slipdata->refamount }}</strong></span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td><strong>Total Earnings</strong> <span
                                                                        class="float-right"><strong>Rs .
                                                                            {{ $earning + $totalamountstudent }}</strong></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div>
                                                    <h4 class="m-b-10"><strong>Deductions</strong></h4>
                                                    <table class="table table-bordered tableslip" id="tableDeductions">
                                                        <tbody>
                                                            @foreach ($deductiondata as $data)
                                                                <?php $earning += $data['amount']; ?>
                                                                <tr>
                                                                    <td><strong>{{ $data['deduction'] }}</strong> <span
                                                                            class="float-right">Rs.{{ $data['amount'] }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            @if ($deductamountstudent > 0)
                                                                <tr>
                                                                    <td><strong>Total Class Deduction</strong> <span
                                                                            class="float-right">Rs.{{ $deductamountstudent - $studentLessonDeductAmount }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            <tr>
                                                                <td><strong>Total Lesson Deduction</strong> <span
                                                                        class="float-right">Rs.{{ $studentLessonDeductAmount }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Late Attendance Deduction(affect on good work
                                                                        bonus)</strong> <span class="float-right">Rs.
                                                                        {{ ($ClasseBonusdata ? $ClasseBonusdata->goodWorkBonus : 0) - $goodWorkAmounttotal }}</span>
                                                                </td>
                                                            </tr>
                                                            <?php $extradeductionamount = 0; ?>
                                                            @if ($extradeduction)
                                                                @foreach ($extradeduction as $key => $data)
                                                                    <?php
                                                                    
                                                                    $earning += $data;
                                                                    $extradeductionamount += $data;
                                                                    
                                                                    ?>
                                                                    <tr>
                                                                        <td><strong>{{ $key }}</strong> <span
                                                                                class="float-right">Rs.{{ $data }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif

                                                            <?php $laoncreditamount = 0; ?>
                                                            @if ($creditarray)
                                                                @foreach ($creditarray as $key => $data)
                                                                    <?php
                                                                    
                                                                    $laoncreditamount += $data[0]->partial_amount;
                                                                    
                                                                    ?>
                                                                    <tr>
                                                                        <td><strong>{{ $data[0]->type }}</strong> <span
                                                                                class="float-right amountRight">Rs.{{ $data[0]->partial_amount }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif



                                                            <tr>
                                                                <td><strong>Total Deduction</strong> <span
                                                                        class="float-right"><strong>Rs .
                                                                            {{ $slipdata->deduction_amount + $extradeductionamount + $deductamountstudent + $dedcutGoodwokrbonus + $laoncreditamount }}</strong></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <p><strong>Net Salary: Rs {{ $slipdata->net }}</strong>
                                                    ({{ ucwords($salaryInwords) }})</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="CommentStudentModal" tabindex="-1" role="dialog" aria-labelledby="SchduleModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">Comments</h5>

                </div>
                <form id="formstudentComments" action="{{ route('teacherpanel.concern.add.payroll') }}" method="POST"
                    role="form">
                    <div class="modal-body">


                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="table-responsive">
                                    <table
                                        data-link="{{ route('teacherpanel.concern.payroll.datatable', request()->route('id')) }}"
                                        id="student-new-comment-datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>

                                                <th>Comment</th>
                                                <th>Created By</th>
                                                <th>Created At</th>

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
                                    <label>Comment<span class="m-l-5 text-danger  errorlabelmy">
                                            *</span></label>
                                    <textarea name="comment" class="form-control comment @error('comment') is-invalid @enderror "></textarea>

                                    <input type="hidden" name="id" value="{{ request()->route('id') }}" />

                                    <span class="text-danger">
                                        @error('comment')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="saveCommentsNew" class="btn btn-primary btn-block">Save
                            Comments</button>
                    </div>
                </form>
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

    <script type="text/javascript" src="{{ asset('assets/print/print.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="{{ asset('assets/widgets/sweetalert/sweetalert.min.js') }}" defer></script>

    <script>
        $(document).on('click', '.btnstudentcommentmodal', function() {

            $('#student-new-comment-datatable').DataTable().draw(true);
            $('#CommentStudentModal').modal('show');

        });

        $(document).on('click', '#btnslippass', function() {
            let pass = $('.slipPassword').val();
            let camppass = $('#paySlipRec').attr('data-passid');
            $this = $(this);

            if (pass) {

                var route = '{{ route('teacherpanel.salary.payroll.slip.password.generate.validate') }}';


                $.post(route, {
                    pass: pass,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(res) {
                    if (res.success == true) {
                        $('.slipContainer').show("slow");
                        $this.parents('.row').hide("slow");
                    }
                    else {
                        swal("Poof! Invalid Password!", {
                            icon: "error",
                        });
                    }
                })
            } else {
                swal("Poof! Please Enter Password!", {
                    icon: "error",
                });
            }

        })

        var oTable = $('#student-new-comment-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000],
                [10, 25, 50, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000]
            ],
            ajax: {
                url: $('#student-new-comment-datatable').attr('data-link'),
                data: function(d) {
                    d.id = "{{ request()->route('id') }}";
                }
            },

            columns: [{
                    data: 'comment',
                    name: 'comment'
                },
                {
                    data: 'name',
                    name: 'users.name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });

        $('#formstudentComments').on('submit', function(event) {
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
                    $('#saveCommentsNew').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.error) {

                        $('#saveCommentsNew').attr('disabled', false);
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

                        $('#student-new-comment-datatable').DataTable().draw(true);
                        $(`.form-control`).removeClass('is-invalid')
                        $('.errorlabelmy').html('');
                        $('#saveCommentsNew').attr('disabled', false);
                        swal("Good job!", data.success, data.alert);
                        $("#formstudentComments").get(0).reset();
                        // $('#CommentStudentModal').modal('hide');
                        $('#CommentStudentModal  input[name="id"]').val('')


                    }
                    $('#save').attr('disabled', false);

                }
            })
        });








        // function printDocument(documentId) {
        //     var doc = document.getElementById(documentId);

        //     //Wait until PDF is ready to print    
        //     if (typeof doc.print === 'undefined') {    
        //         setTimeout(function(){printDocument(documentId);}, 1000);
        //     } else {
        //         doc.print();
        //     }
        // }



        function demoFromHTML() {
            var pdf = new jsPDF('p', 'pt', 'letter');
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('#paySlipRec')[0];

            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#bypassme': function(element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
                source, // HTML string or DOM elem ref.
                margins.left, // x coord
                margins.top, { // y coord
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': specialElementHandlers
                },

                function(dispose) {
                    // dispose: object with X, Y of the last line add to the PDF 
                    //          this allow the insertion of new lines after html
                    pdf.save('Test.pdf');
                }, margins);
        }

        function print() {
            printJS({
                printable: 'paySlipRec',
                type: 'html',
                targetStyles: ['*']
            })
        }

        function printDiv() {
            var divToPrint = document.getElementById('paySlipRec');
            var popupWin = window.open('', '_blank', 'width=1100,height=400');
            popupWin.document.open();
            document.title = "{{ $employees->employeename }}";
            popupWin.document.write('<html><head><title>Salary Slip</title>');
            popupWin.document.write(
                '<link rel="stylesheet" href="{{ asset('assets/slip.css') }}" type="text/css" media="print" />');
            popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();


            //   var mywindow = window.open('', 'new div', 'height=400,width=600');
            //   mywindow.document.write('<html><head><title></title>');
            //   mywindow.document.write('<link rel="stylesheet" href="{{ asset('assets/slip.css') }}" type="text/css" />');
            //   mywindow.document.write('</head><body >');
            //   mywindow.document.write(divToPrint);
            //   mywindow.document.write('</body></html>');
            //   mywindow.document.close();
            //   mywindow.focus();
            //   setTimeout(function(){mywindow.print();},1000);
            //   mywindow.close();



            //   var contents = $("#paySlipRec").html();
            //     var frame1 = $('<iframe />');
            //     frame1[0].name = "frame1";
            //     frame1.css({ "position": "absolute", "top": "-1000000px" });
            //     $("body").append(frame1);
            //     var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
            //     frameDoc.document.open();
            //     //Create a new HTML document.
            //     frameDoc.document.write('<html><head><title>DIV Contents</title>');
            //     frameDoc.document.write('</head><body>');
            //     //Append the external CSS file.
            //     frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
            //     //Append the DIV contents.
            //     frameDoc.document.write(contents);
            //     frameDoc.document.write('</body></html>');
            //     frameDoc.document.close();
            //     setTimeout(function () {
            //         window.frames["frame1"].focus();
            //         window.frames["frame1"].print();
            //         frame1.remove();
            //     }, 500);


            //   return true;

        }

        // document.getElementById('printButton').addEventListener ("click", print)


        $(document).on('click', '#print_btn', function() {

            console.log('#sssss');
            //   printDocument('paySlipRec');
            // print()

            // demoFromHTML();
            printDiv();


        });


        $(document).on('change', '#payrollselectdate', function() {

            let id = $(this).val();
            console.log(id)
            var route = '{{ route('teacherpanel.salary.detail.payroll.slip', ':id') }}';
            route = route.replace(':id', id);
            window.location.href = route;

        })
    </script>
@endpush
