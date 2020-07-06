@extends('layouts.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список электронная книга')

@section('content')


<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('admin.ebook.index'),
    'title' => 'Список электронная книга'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список электронная книга</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Клиент</th>
                                        <th>Общая</th>
                                        <th>Общая со скидкой</th>
                                        <th>Скидка</th>
                                        <th>Статус</th>
                                        <th>Создано на</th>
                                        <th width="120px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->customer->displayName() }}</td>
                                        <td>{{ $model->total }}</td>
                                        <td>{{ $model->subtotal }}</td>
                                        <td>{{ $model->discount }}</td>
                                        <td>{!! $model->stateHTML() !!}</td>
                                        <td>{{ $model->created_at }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-info">Change</a>
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

