@extends('layouts.admin')

@section('title', 'Изменить тип обложка')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('coverType.index'),
    'title' => 'Изменить тип обложка'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Изменить тип обложка</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('coverType.update', $model->id) }}" method="POST">
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
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror"
                            id="status" @if($model->isActive()) checked @endif name="status">
                        <label class="form-check-label" for="status">Активный</label>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Изменить</button>
                    <a href="{{ route('coverType.index') }}" class="btn btn-default">Назад</a>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop
