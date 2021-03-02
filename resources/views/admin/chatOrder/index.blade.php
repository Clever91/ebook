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
                                        <th>Состояние</th>
                                        <th>Тип доставки</th>
                                        <th>Способ оплаты</th>
                                        <th>Оплачен</th>
                                        <th>Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                    <tr>
                                        <td><a href="{{ route('admin.chat.order.detail', $model->id) }}">{{ $model->id }}</a></td>
                                        <td>{{ $model->chat_id }}</td>
                                        <td><a href="{{ route('admin.chat.order.detail', $model->id) }}">{{ $model->phone }}</a></td>
                                        <td>@money_format($model->amount)</td>
                                        <td>@money_format($model->delivery_price)</td>
                                        <td>{!! $model->stateHtml() !!}</td>
                                        <td>{{ $model->deliveryLabel() }}</td>
                                        <td>{{ $model->paymentLabel() }}</td>
                                        <td>{!! $model->isPaidHtml() !!}</td>
                                        <td>
                                            @if ($model->isNotDraf())
                                            <a href="{{ route('admin.chat.order.send', $model->id) }}" class="btn btn-app">
                                                <i class="fab fa-telegram"></i> Отправить
                                            </a>
                                            @endif
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

