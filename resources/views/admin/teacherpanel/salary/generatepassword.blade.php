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
            <div class="col-6">

                {!! Form::open(array('route' => 'teacherpanel.salary.payroll.slip.password.generate.save','method'=>'POST')) !!}
                <!-- general form elements disabled -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">{{ $pageTitle }}  @include('admin.partials.flash')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        
                        <form role="form">
                           
                           
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- textarea -->
                                    <div class="form-group">
                                        <label>Old Password <span class="text-danger">@error('oldpassword') {{ $message }}
                                                @enderror</span></label>
                                        {!! Form::password('oldpassword', array('placeholder' => 'Old Password','class' =>
                                        'form-control '.$errors->first('password', 'is-invalid'))) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- textarea -->
                                    <div class="form-group">
                                        <label>New Password <span class="text-danger">@error('newpassword') {{ $message }}
                                                @enderror</span></label>
                                        {!! Form::password('newpassword', array('placeholder' => 'New Password','class' =>
                                        'form-control '.$errors->first('password', 'is-invalid'))) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- textarea -->
                                    <div class="form-group">
                                        <label>Confirm Password <span class="text-danger">@error('confirm-password')
                                                {{ $message }} @enderror</span></label>
                                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm
                                        Password','class' => 'form-control '.$errors->first('confirm-password',
                                        'is-invalid'))) !!}
                                    </div>
                                </div>

                            </div>

                           


                        </form>
                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.col -->
        </div>
            </div>
        </div>
    </div>

</div>

@endsection
@push('scripts')
<script>
 $(document).ready(function(){

 })
 </script>   
@endpush