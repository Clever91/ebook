@extends('layouts.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список категорий')

@section('content')


<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('category.index'),
    'title' => 'Список категорий'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список категорий</h3>
                            <a href="{{ route('category.create') }}"
                                class="btn btn-sm btn-primary float-right">Создать</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatables">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование</th>
                                        <th>Порядковый номер</th>
                                        <th>Активный</th>
                                        <th width="150px">Прикреплять</th>
                                        <th width="280px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->translateorNew(\App::getLocale())->name }}</td>
                                        <td>{{ $model->order_no }}</td>
                                        <td>{{ $model->activeLabel() }}</td>
                                        <td>
                                            <a href="{{ route('admin.relation.index', [$model->id, 'C']) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-paperclip"></i> Доб. группу
                                                @if ($model->relations->count())
                                                <span class="badge bg-warning">{{ $model->relations->count() }}</span>
                                                @else
                                                <span class="badge bg-danger">{{ $model->relations->count() }}</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('category.destroy', $model->id) }}" method="POST">
                                                <a href="{{ route('category.edit', $model->id) }}" class="btn btn-app">
                                                    <i class="fas fa-edit"></i> Изменить.
                                                </a>
                                                @method('DELETE')
                                                @csrf
                                                <a href="{{ route('category.image', $model->id) }}" class="btn btn-app">
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

                        {{-- <div class="card-footer">
                            {{ $models->links() }}
                        </div> --}}
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

