@extends('adminlte::page')

@section('title', 'Error 500')

@section('content_header')
    <h1>500 Error Page</h1>
@stop

@section('content')

<div class="error-page">
    <h2 class="headline text-danger">500</h2>

    <div class="error-content">
        <h3>
            <i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.
        </h3>

        <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href="{{ route('dashboard') }}">return to dashboard</a> or try using the search form.
        </p>
    </div>
</div>
<!-- /.error-page -->

@stop