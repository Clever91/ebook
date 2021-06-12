@extends('layouts.auth.login')

@section('title', 'Ошибка')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-danger">500</h2>

        <div class="error-content">
            <h3>
                <i class="fas fa-exclamation-triangle text-danger"></i> К сожалению! Что-то пошло не так.
            </h3>
            <p>
            Мы будем работать над исправлением этого сразу.
            Вы можете вернуться <a href="{{ route('dashborad') }}">на панель инструментов</a>
            </p>
        </div>
    </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->

@endsection
