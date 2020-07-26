@extends('layouts.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список продукты')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Список продукты'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список продукты</h3>
                            <a href="{{ route('product.create') }}" 
                                class="btn btn-sm btn-primary float-right">Создать</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование</th>
                                        <th>Категория</th>
                                        <th>Автор</th>
                                        {{-- <th>Описание</th> --}}
                                        <th>Цена</th>
                                        <th>Активный</th>
                                        <th width="150px">Прикреплять</th>
                                        <th width="190px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->translateorNew(\App::getLocale())->name }}</td>
                                        <td>{{ $model->category->translateorNew(\App::getLocale())->name }}</td>
                                        <td>{{ $model->author->name }}</td>
                                        {{-- <td>{{ substr($model->translateorNew(\App::getLocale())->description, 1, 50) }}...</td> --}}
                                        <td>@money_format($model->price)</td>
                                        <td>{{ $model->activeLabel() }}</td>
                                        <td>
                                            <a href="{{ route('admin.relation.index', [$model->id, 'P']) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-paperclip"></i> Прикреплять 
                                                @if ($model->relations->count())
                                                <span class="badge bg-warning">{{ $model->relations->count() }}</span>
                                                @else
                                                <span class="badge bg-danger">{{ $model->relations->count() }}</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('product.edit', $model->id) }}" class="btn btn-app">
                                                <i class="fas fa-edit"></i> Изм.
                                            </a>
                                            <a href="{{ route('product.eform', $model->id) }}" class="btn btn-app">
                                                @if ($model->hasEbook())
                                                <span class="badge bg-teal">@money_format($model->eprice)</span>
                                                @else
                                                <span class="badge badge-danger">0</span>
                                                @endif
                                                <i class="fas fa-inbox"></i> ebook
                                            </a>
                                            <form action="{{ route('product.destroy', $model->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="{{ route('product.image', $model->id) }}" class="btn btn-app">
                                                @if ($model->hasImage())
                                                    <span class="badge bg-purple">1</span>
                                                @else
                                                    <span class="badge bg-danger">0</span>
                                                @endif
                                                    <i class="fas fa-image"></i> Изоб.
                                                </a>
                                                <button type="submit" class="btn btn-app">
                                                    <i class="fas fa-trash"></i> Удалить
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            {{ $models->links() }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</section>
@endsection

