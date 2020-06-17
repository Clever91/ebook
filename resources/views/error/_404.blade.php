@extends('layouts.admin')

@section('title', 'Ошибка')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('dashboard'),
    'title' => 'Главная'
])

<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
            <h3>
                <i class="fas fa-exclamation-triangle text-warning"></i> К сожалению! Страница не найдена.
            </h3>
            <p>
                Мы не смогли найти страницу, которую вы искали. 
                Вы можете вернуться <a href="{{ route('dashboard') }}">на панель инструментов</a> 
            </p>
        </div>
        <!-- /.error-content -->
      </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->

@endsection
