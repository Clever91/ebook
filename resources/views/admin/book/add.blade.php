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
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                            id="price" name="price" value="{{ old('price') }}"
                            placeholder="Введите цена" required>
                        @error('price')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    {{-- ~~~~~~~~~~~~~~~~~~~ Optional params ~~~~~~~~~~~~~~~~~~~ --}}
                    <div class="form-group">
                        <label for="leftover">Остатки</label>
                        <input type="text" class="form-control @error('leftover') is-invalid @enderror"
                            id="leftover" name="leftover"  value="{{ old('leftover') }}"
                            placeholder="Введите остаток">
                        @error('leftover')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cover">Обложка книги</label>
                        <select class="form-control select2bs4 @error('cover') is-invalid @enderror"
                            name="cover" style="width: 100%;" required>
                            @foreach (Book::coverTypes() as $cover => $val)
                            <option value="{{ $cover }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        @error('cover')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="letter">Письмо из книги</label>
                        <select class="form-control select2bs4 @error('letter') is-invalid @enderror"
                            name="letter" style="width: 100%;" required>
                            @foreach (Book::letterTypes() as $letter => $val)
                            <option value="{{ $letter }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        @error('letter')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="paper_size">Размер страницы</label>
                        <select class="form-control select2bs4 @error('paper_size') is-invalid @enderror"
                            name="paper_size" style="width: 100%;">
                            <option value="">Выберите размер страницы</option>
                            @foreach (Book::paperSizeTypes() as $val)
                            <option value="{{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        @error('paper_size')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="color">Цвет книги</label>
                        <select class="form-control select2bs4 @error('color') is-invalid @enderror"
                            name="color" style="width: 100%;">
                            <option value="">Выберите цвет</option>
                            @foreach (Book::colorTypes() as $color => $val)
                            <option value="{{ $color }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        @error('color')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    {{-- ~~~~~~~~~~~~~~~~~~~ Optional params ~~~~~~~~~~~~~~~~~~~ --}}
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
