@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('user.index'),
    'title' => 'Изменить пользователь '
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Изменить пользователь </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('user.update', $model->id) }}" method="POST">
                @method("PATCH")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                            id="name" name="name" value="{{ $model->name }}">
                        @error('name')
                            <p>Ошибка: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Имя пользователя</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                            id="username" name="username" value="{{ $model->username }}">
                        @error('username')
                            <p>Ошибка: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" value="" 
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <p>Ошибка: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Роль</label>
                        <select class="custom-select @error('role') is-invalid @enderror" name="role">
                            @foreach ($model->roles() as $key => $value)
                                @if ($model->role == $key)
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                            <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')
                            <p>Ошибка: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('active') is-invalid @enderror" 
                            id="active" {{ $model->isActive() ? 'checked' : '' }} name="active">
                        <label class="form-check-label" for="active">Активный</label>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" class="btn btn-default">Отмена</button>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </div>
            </form>
        </div>
    </div>
</section>

@stop