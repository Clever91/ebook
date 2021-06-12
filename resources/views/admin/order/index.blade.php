@extends('layouts.admin.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список заказы')

@section('content')


<!-- Content Header (Page header) -->
@include('layouts.admin.breadcrumb', [
    'list' => route('admin.order.index'),
    'title' => 'Список заказы'
])

@php
    use App\Models\Admin\Order;
@endphp

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список заказы</h3>
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
                                        <th width="120px">Статус</th>
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
                                            <a class="btn btn-sm btn-app btn-event-delivery">
                                                <i class="fas fa-truck"></i> Delivery
                                            </a>
                                            <a class="btn btn-sm btn-app btn-event-cancel">
                                                <i class="far fa-window-close"></i> Cancel
                                            </a>
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

<script src="">
    $(".btn-event-delivery").on("click", function (event) {
        event.preventDefault();
        alert("ok");
    });
</script>

