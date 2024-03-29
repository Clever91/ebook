@extends('layouts.admin.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список книги')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.admin.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Список книги'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список книги</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование</th>
                                        <th>Оптовая цена</th>
                                        <th>Остатки</th>
                                        <th>Обложка книги</th>
                                        <th>Размер</th>
                                        <th>Надпись</th>
                                        <th>Цвет</th>
                                        <th>Активный</th>
                                        <th width="190px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($books as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->product->translateorNew(\App::getLocale())->name }}</td>
                                        <td>@money_format($model->price)</td>
                                        <td>{{ $model->leftover }}</td>
                                        <td>{{ $model->coverLabel() }}</td>
                                        <td>{{ $model->paperSize() }}</td>
                                        <td>{{ $model->letterLabel() }}</td>
                                        <td>{{ $model->colorLabel() }}</td>
                                        <td>{{ $model->activeLabel() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">События</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a href="{{ route('admin.book.add', $model->product->id) }}" class="dropdown-item">
                                                        <i class="fas fa-plus"></i> Добавить
                                                    </a>
                                                    <a href="{{ route('admin.book.edit', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-edit"></i> Изменить
                                                    </a>
                                                    <a href="{{ route('admin.book.image', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-image"></i> Изображение
                                                        @if ($model->hasImage())
                                                            <span class="badge bg-purple">Да</span>
                                                        @else
                                                            <span class="badge bg-danger">Нет</span>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.book.destroy', $model->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-trash"></i> Удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            {{ $books->links() }}
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

