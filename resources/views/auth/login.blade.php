@extends('layouts.login')

@section('title', 'Login')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>Admin</b></a>
    </div>

    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Войдите, чтобы начать сеанс</p>
            <form action="{{ route('login') }}" method="post">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                        name="username" placeholder="Введите логин" value="{{ old('username') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('username')
                    <p>Ошибка: <code>{{ $message }}</code></p>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                        name="password" placeholder="Введите пароль">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <p>Ошибка: <code>{{ $message }}</code></p>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">
                                Запомни меня
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Войти в систему</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
      </div>
      <!-- /.login-card-body -->
    </div>
</div>
@endsection
