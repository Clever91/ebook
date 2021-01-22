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
                                                <button type="button" class="btn btn-default">События</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a href="{{ route('product.edit', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-edit"></i> Изменить
                                                    </a>
                                                    <a href="{{ route('product.eform', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-eye"></i> Электронная книга
                                                        ( <span class="badge @if ($model->ebook()) bg-teal @else badge-danger @endif">
                                                            @money_format($model->ebookPrice())
                                                        </span> )
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
                                                        <i class="fas fa-users"></i> Доб. группу
                                                        <span class="badge @if ($model->relations->count()) bg-warning @else bg-danger @endif">
                                                            {{ $model->relations->count() }}
                                                        </span>
                                                    </a>
                                                    <a href="{{ route('admin.book.index', $model->id) }}" class="dropdown-item">
                                                        <i class="fas fa-book"></i> Список книг
                                                        <span class="badge @if ($model->books()->count()) bg-info  @else bg-danger @endif ">
                                                            {{ $model->books()->count() }}
                                                        </span>
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

