@extends('layouts.admin.admin')

@section('title', 'Изменить группа')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.admin.breadcrumb', [
    'list' => route('group.index'),
    'title' => 'Изменить группа'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Изменить группа</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('group.update', $model->id) }}" method="POST">
                @method("PATCH")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ $model->translateorNew(\App::getLocale())->name }}" placeholder="Введите название" required>
                        @error('name')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="order_no">Порядковый номер</label>
                        <input type="number" class="form-control @error('order_no') is-invalid @enderror"
                            id="order_no" name="order_no" value="{{ $model->order_no }}" placeholder="Введите порядковый номер"
                            required>
                        @error('order_no')
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
                    <a href="{{ route('group.index') }}" class="btn btn-default">Назад</a>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop
