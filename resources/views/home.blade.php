@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('dashboard'),
    'title' => 'Главная'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            You are logged in!  {{ App::getLocale() }} / {{ session('locale') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
