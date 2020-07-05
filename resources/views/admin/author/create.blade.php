@extends('layouts.admin')

@section('title', 'Создать автор')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('author.index'),
    'title' => 'Создать автор'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Создать автор</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('author.store') }}" method="POST">
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
                        <label for="bio">Биография автора</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                            id="bio" name="bio" placeholder="Введите биография автора"
                            required>{{ old("bio") }}</textarea>
                        @error('bio')
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