@extends('layouts.admin')

@section('title', 'Добавить книгу')

@section('content')

@include('layouts.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Добавить книгу'
])

@php
use App\Models\Admin\Book;
@endphp

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Добавить книгу</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.book.store', $product->id) }}" method="POST">
                @method("PATCH")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ $product->translateOrNew(\App::getLocale())->name }}"
                            placeholder="Введите название" required readonly>
                        @error('name')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>

                    {{-- ~~~~~~~~~~~~~~~~~~~ create field of book ~~~~~~~~~~~~~~~~~~~ --}}
                    @includeIf('admin.extra.book.create')

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('product.index') }}" class="btn btn-default">Назад</a>
                    <button type="submit" class="btn btn-info">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop
