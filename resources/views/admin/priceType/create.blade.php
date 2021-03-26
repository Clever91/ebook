@extends('layouts.admin')

@section('title', 'Создать тип цены')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('admin.priceType.index'),
    'title' => 'Создать тип цены'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Создать тип цены</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.priceType.store') }}" method="POST">
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
                        <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror"
                            id="status" name="status">
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
