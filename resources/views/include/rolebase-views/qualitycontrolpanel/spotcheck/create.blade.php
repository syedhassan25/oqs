@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">




    <div id="page-title">
        <h2>{{ $pageTitle }} <a class="btn btn-primary" href="{{ route('admin.agency.index') }}">Back</a></h2>
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

                        <form action="{{ route('admin.agency.store') }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- general form elements disabled -->
                            <div class="card card-warning">
                             
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Agency Name <span class="text-danger">@error('agencyname')
                                                            {{ $message }} @enderror</span></label>
                                                    <input type="text" value="{{old('agencyname')}}" name="agencyname"
                                                        placeholder="Agency Name"
                                                        class="form-control @error('agencyname') is-invalid  @enderror" />

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
                        </form>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@push('scripts')

@endpush