@extends('layouts.admin')

@section('title', 'Создать продукт')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Создать продукт'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Создать продукт</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('product.store') }}" method="POST">
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
                    <div class="form-group">
                        <label for="category_id">Категория</label>
                        <select class="form-control select2bs4 @error('category_id') is-invalid @enderror" 
                            name="category_id" style="width: 100%;" required>
                            <option>Выберите категория</option>
                            @foreach ($categories as $cat)
                                @if (old('category_id') == $cat->id)
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
                            name="author_id" style="width: 100%;" required>
                            <option>Выберите автор</option>
                            @foreach ($authors as $author)
                                @if (old('author_id') == $author->id)
                            <option value="{{ $author->id }}" selected>{{ $author->name }}</option>
                                @else
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
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
                            rows="4" cols="6" required>{{ old("description") }}</textarea>
                        @error('description')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" 
                            id="price" name="price" value="{{ old("price") }}" 
                            placeholder="Введите цена" required>
                        @error('price')
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