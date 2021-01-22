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
                                        <td>@money_format($model->bookPrice())</td>
                                        <td>{{ $model->activeLabel() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Действия</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a href="{{ route('product.edit', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-edit"></i> Изменить
                                                    </a>
                                                    <a href="{{ route('product.eform', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-eye"></i> Электронная книга (
                                                        @if ($model->ebook())
                                                        <span class="badge bg-teal">@money_format($model->ebookPrice())</span>
                                                        @else
                                                        <span class="badge badge-danger">0</span>
                                                        @endif
                                                        )
                                                    </a>
                                                    <a href="{{ route('product.image', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-image"></i> Изображение
                                                        @if ($model->hasImage())
                                                            <span class="badge bg-purple">Да</span>
                                                        @else
                                                            <span class="badge bg-danger">Нет</span>
                                                        @endif
                                                    </a>
                                                    <a href="{{ route('admin.relation.index', [$model->id, 'P']) }}" class="dropdown-item">
                                                        <i class="fas fa-paperclip"></i> Доб. группу
                                                        @if ($model->relations->count())
                                                        <span class="badge bg-warning">{{ $model->relations->count() }}</span>
                                                        @else
                                                        <span class="badge bg-danger">{{ $model->relations->count() }}</span>
                                                        @endif
                                                    </a>
                                                    <a href="{{ route('admin.telegram.index', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-bullhorn"></i> Отправить
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('product.destroy', $model->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-trash"></i> Удалить
                                                        </button>
                                                    </form>
                                                    {{-- <a class="dropdown-item" href="#">Separated link</a> --}}
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

