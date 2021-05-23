@extends('layouts.admin')

@section('title', 'Изменить цвет')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('color.index'),
    'title' => 'Изменить цвет'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Изменить цвет</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('color.update', $model->id) }}" method="POST">
                @method("PATCH")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ $model->name }}" placeholder="Введите название" required>
                        @error('name')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="short">Короткое</label>
                        <input class="form-control @error('short') is-invalid @enderror"
                            id="short" name="short" placeholder="Введите короткое имя"
                            required value="{{ $model->short }}" />
                        @error('short')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="hex">Код</label>
                        <input class="form-control @error('hex') is-invalid @enderror"
                            id="hex" name="hex" placeholder="Введите код"
                            required value="{{ $model->hex }}" />
                        @error('hex')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror"
                            id="status" @if($model->isActive()) checked @endif name="status">
                        <label class="form-check-label" for="status">Активный</label>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Изменить</button>
                    <a href="{{ route('color.index') }}" class="btn btn-default">Назад</a>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop
