@extends('layouts.login')

@section('title', 'Ошибка')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-danger"> 400</h2>

        <div class="error-content">
            <h3>
                <i class="fas fa-exclamation-triangle text-danger"></i> К сожалению, Вы не имеете доступа к этой странице.
            </h3>
            <p>
                У вас нет разрешения, спросите разрешение у администратора. 
                Вы можете вернуться <a href="{{ route('dashboard') }}">на панель инструментов</a> 
            </p>
        </div>
        <!-- /.error-content -->
      </div>
    <!-- /.error-page -->
</section>
@endsection
