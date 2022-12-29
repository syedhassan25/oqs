@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="container">


    <div id="page-title">
        <h2>Dashboard</h2>
        <p>{{$subTitle}}</p>
       
    </div>

    

</div>

@endsection
@push('scripts')


@endpush