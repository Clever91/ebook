@extends('layouts.admin.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список цветов')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.admin.breadcrumb', [
    'list' => route('color.index'),
    'title' => 'Список цветов'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список цветов</h3>
                            <a href="{{ route('color.create') }}"
                                class="btn btn-sm btn-primary float-right">Создать</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование</th>
                                        <th>Короткое</th>
                                        <th>Код</th>
                                        <th>Активный</th>
                                        <th width="190px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->name }}</td>
                                        <td>{{ $model->short }}</td>
                                        <td style="background-color: {{ $model->hex }}">{{ $model->hex }}</td>
                                        <td>{{ $model->activeLabel() }}</td>
                                        <td>
                                            <form action="{{ route('color.destroy', $model->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="{{ route('color.edit', $model->id) }}" class="btn btn-app">
                                                    <i class="fas fa-edit"></i> Изменить.
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

