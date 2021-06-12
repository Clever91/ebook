@extends('layouts.admin.admin')

@section('title', 'Изменить книгу')

@section('content')

@include('layouts.admin.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Изменить книгу'
])

@php
use App\Models\Admin\Book;
@endphp

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Изменить книгу</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.book.update', $model->id) }}" method="POST">
                @method("PATCH")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ $model->product->translateOrNew(\App::getLocale())->name }}"
                            placeholder="Введите название" required readonly>
                        @error('name')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>

                    {{-- ~~~~~~~~~~~~~~~~~~~ edit field of book ~~~~~~~~~~~~~~~~~~~ --}}
                    @includeIf('admin.extra.book.edit', [ 'book' => $model ])

                    {{-- ~~~~~~~~~~~~~~~~~~~ create field of book detail ~~~~~~~~~~~~~~~~~~~ --}}
                    @if (!is_null($model->detail))
                        @includeIf('admin.extra.bookDetail.edit', [ 'detail' => $model->detail ])
                    @else
                        @includeIf('admin.extra.bookDetail.create')
                    @endif

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('admin.book.list') }}" class="btn btn-default">Назад</a>
                    <button type="submit" class="btn btn-info">Изменить</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop
