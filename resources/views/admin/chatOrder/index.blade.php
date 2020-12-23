@extends('layouts.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список чат заказов')

@section('content')


<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('admin.chat.order.index'),
    'title' => 'Список чат заказов'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список чат заказов</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Клиент чата ID</th>
                                        <th>Телефон</th>
                                        <th>Сумма </th>
                                        <th>Доставка</th>
                                        <th>Тип доставки</th>
                                        <th>Способ оплаты</th>
                                        <th>Состояние</th>
                                        <th>Оплаченный заказ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->chat_id }}</td>
                                        <td>@money_format($model->amount)</td>
                                        <td>@money_format($model->delivery_price)</td>
                                        <td>{{ $model->deliveryLabel() }}</td>
                                        <td>{{ $model->paymentLabel() }}</td>
                                        <td>{{ $model->stateLabel() }}</td>
                                        <td>{{ $model->isPaidLabel() }}</td>
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

