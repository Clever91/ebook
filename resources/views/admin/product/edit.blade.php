@extends('layouts.admin.admin')

@section('title', 'Изменить продукт')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.admin.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Изменить продукт'
])

@php
use App\Models\Admin\Book;

$book = $model->book();
$detail = $book->detail;
@endphp

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Изменить продукт</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('product.update', $model->id) }}" method="POST">
                @method("PATCH")
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ $model->translateOrNew(\App::getLocale())->name }}" placeholder="Введите название" required>
                        @error('name')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Категория</label>
                        <select class="form-control select2bs4 @error('category_id') is-invalid @enderror"
                            name="category_id" style="width: 100%;" required>
                            <option>Выберите категория</option>
                            @foreach ($categories as $cat)
                                @if ($model->category_id == $cat->id)
                            <option value="{{ $cat->id }}" selected>
                                {{ $cat->translateOrNew(\App::getLocale())->name }}
                            </option>
                                @else
                            <option value="{{ $cat->id }}">{{ $cat->translateOrNew(\App::getLocale())->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('category_id')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="author_id">Автор</label>
                        <select class="form-control select2bs4 @error('author_id') is-invalid @enderror"
                            name="author_id" style="width: 100%;">
                            <option value="">Выберите автор</option>
                            @foreach ($authors as $author)
                                @if ($model->author_id == $author->id)
                            <option value="{{ $author->id }}" selected>{{ $author->translateorNew(\App::getLocale())->name }}</option>
                                @else
                            <option value="{{ $author->id }}">{{ $author->translateorNew(\App::getLocale())->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('author_id')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Описания</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" placeholder="Введите название"
                            rows="4" cols="6" maxlength="1020" required>{{ $model->translateOrNew(\App::getLocale())->description }}</textarea>
                        @error('description')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>

                    {{-- ~~~~~~~~~~~~~~~~~~~ edit field of book ~~~~~~~~~~~~~~~~~~~ --}}
                    @includeIf('admin.extra.book.edit', [ 'book' => $book ])

                    {{-- ~~~~~~~~~~~~~~~~~~~ status of product ~~~~~~~~~~~~~~~~~~~ --}}
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror"
                            id="status" @if ($model->isActive()) checked @endif name="status">
                        <label class="form-check-label" for="status">Активный</label>
                    </div>
                    <hr>

                    {{-- ~~~~~~~~~~~~~~~~~~~ create field of book detail ~~~~~~~~~~~~~~~~~~~ --}}
                    @if (!is_null($detail))
                        @includeIf('admin.extra.bookDetail.edit', [ 'detail' => $detail ])
                    @else
                        @includeIf('admin.extra.bookDetail.create')
                    @endif
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('product.index') }}" class="btn btn-default">Назад</a>
                    <button type="submit" class="btn btn-info">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop
