@extends('layouts.admin')

@section('title', 'Изменить книгу')

@section('content')

@include('layouts.breadcrumb', [
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
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                            id="price" name="price" value="{{ $model->price }}"
                            placeholder="Введите цена" required>
                        @error('price')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    {{-- ~~~~~~~~~~~~~~~~~~~ Optional params ~~~~~~~~~~~~~~~~~~~ --}}
                    <div class="form-group">
                        <label for="leftover">Остатки</label>
                        <input type="text" class="form-control @error('leftover') is-invalid @enderror"
                            id="leftover" name="leftover" value="{{ $model->leftover }}"
                             placeholder="Введите остаток">
                        @error('leftover')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cover_type_id">Обложка книги</label>
                        <select class="form-control select2bs4 @error('cover_type_id') is-invalid @enderror"
                            name="cover_type_id" style="width: 100%;" required>
                            @foreach (Book::coverTypes() as $cover)
                                @if (!is_null($model->coverType) && $model->coverType->id == $cover->id)
                                <option value="{{ $cover->id }}" selected>{{ $cover->translateOrNew(\App::getLocale())->name }}</option>
                                @else
                                <option value="{{ $cover->id }}">{{ $cover->translateOrNew(\App::getLocale())->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('cover_type_id')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="letter">Надпись</label>
                        <select class="form-control select2bs4 @error('letter') is-invalid @enderror"
                            name="letter" style="width: 100%;">
                            <option value="">Выберите</option>
                            @foreach (Book::letterTypes() as $letter => $val)
                                @if ($model->letter == $letter)
                                <option value="{{ $letter }}" selected>{{ $val }}</option>
                                @else
                                <option value="{{ $letter }}">{{ $val }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('letter')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="paper_size">Размер страницы</label>
                        <input type="text" class="form-control @error('paper_size') is-invalid @enderror"
                            id="paper_size" name="paper_size"  value="{{ $model->paper_size }}"
                            placeholder="Введите размер">
                        @error('paper_size')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="color_id">Цвет книги</label>
                        <select class="form-control select2bs4 @error('color_id') is-invalid @enderror"
                            name="color_id" style="width: 100%;">
                            <option value="">Выберите цвет</option>
                            @foreach (Book::colorTypes() as $color)
                            @if ($model->color_id == $color->id)
                            <option value="{{ $color->id }}" selected>{{ $color->name }}</option>
                            @else
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('color_id')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    {{-- ~~~~~~~~~~~~~~~~~~~ Optional params ~~~~~~~~~~~~~~~~~~~ --}}
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
