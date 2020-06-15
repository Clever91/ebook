@extends('layouts.admin')

@section('title', 'Создать категорию')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('category.index'),
    'title' => 'Создать категорию'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Создать категорию</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('category.store') }}" method="POST">
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
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('is_default') is-invalid @enderror" 
                            id="is_default" checked name="is_default">
                        <label class="form-check-label" for="is_default">По умолчанию</label>
                    </div>
                    <div class="form-group">
                        <label for="order_no">Порядковый номер</label>
                        <input type="number" class="form-control @error('order_no') is-invalid @enderror" 
                            id="order_no" name="order_no" value="{{ old("order_no") }}" placeholder="Введите порядковый номер"
                            required>
                        @error('order_no')
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