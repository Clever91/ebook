@extends('layouts.admin')

@section('title', 'Создать цвет')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('color.index'),
    'title' => 'Создать цвет'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Создать цвет</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('color.store') }}" method="POST">
                @method("POST")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old("name") }}" placeholder="Введите название" required>
                        @error('name')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="short">Короткое</label>
                        <input class="form-control @error('short') is-invalid @enderror"
                            id="short" name="short" placeholder="Введите короткое имя"
                            required value="{{ old("short") }}" />
                        @error('short')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="hex">Код</label>
                        <input class="form-control @error('hex') is-invalid @enderror"
                            id="hex" name="hex" placeholder="Введите код"
                            required value="{{ old("hex") }}" />
                        @error('hex')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror"
                            id="status" checked name="status">
                        <label class="form-check-label" for="status">Активный</label>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop
