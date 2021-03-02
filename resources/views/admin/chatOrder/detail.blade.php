@extends('layouts.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Детали заказа')

@section('content')

@php
    use App\Helpers\Common\GlobalFunc;
@endphp

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('admin.chat.order.index'),
    'title' => 'Детали заказа #' . $model->id
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Детали заказа</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                        <i class="fas fa-globe"></i> {{ env('APP_NAME') }}
                                        <small class="float-right">Создано: {{ date('d/m/Y', strtotime($model->created_at)) }}</small>
                                        </h4>
                                    </div>
                                <!-- /.col -->
                                </div>
                                @php
                                    $chatUser = $model->chatUser();
                                @endphp
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Клиента:
                                        <address>
                                        <strong>{{ $chatUser->getFullName() }}</strong><br>
                                        Телефон: <a href="tel: +{{ $model->phone }}">+{{ $model->phone }}</a><br>
                                        Электронная почта: client@client.com
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Тип доставки: <strong>{{ $model->deliveryLabel() }}</strong><br>
                                        Способ оплаты: <strong>{{ $model->paymentLabel() }}</strong><br>
                                        Место заказа: <strong>{{ $model->getLatLng() }}</strong><br>
                                        Оплачено: <strong>{!! $model->isPaidHtml() !!}</strong><br>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        {{-- <b>Invoice #007612</b><br> --}}
                                        <b>ID заказа:</b> {{ $model->id }}<br>
                                        <b>Обновлено:</b> {{ date('d/m/Y', strtotime($model->updated_at)) }}<br>
                                        <b>Создано:</b> {{ date('d/m/Y', strtotime($model->created_at)) }}<br>
                                    </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <br>

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Книга</th>
                                                    <th>Количество</th>
                                                    <th>Цена</th>
                                                    <th>Сумма</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($model->details as $index => $detail)
                                                @php
                                                $product_name = $detail->product->name;
                                                $amount = $detail->price * $detail->quantity;
                                                if (!is_null($detail->book))
                                                    $product_name .= " (" .$detail->book->getBtnLabel() .")";
                                                @endphp
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $product_name }}</td>
                                                    <td>{{ $detail->quantity }} шт</td>
                                                    <td>{{ GlobalFunc::moneyFormat($detail->price) }}</td>
                                                    <td>{{ GlobalFunc::moneyFormat($amount) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <hr>

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">
                                        <p class="lead">Способы оплаты:</p>
                                        <img src="{{ asset('/dist/img/credit/visa.png') }}" alt="Visa">
                                        <img src="{{ asset('/dist/img/credit/mastercard.png') }}" alt="Mastercard">
                                        <img src="{{ asset('/dist/img/credit/american-express.png') }}" alt="American Express">
                                        <img src="{{ asset('/dist/img/credit/paypal2.png') }}" alt="Paypal">

                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                                        plugg
                                        dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">
                                        <p class="lead">Общий</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Сумма:</th>
                                                    <td>{{ GlobalFunc::moneyFormat($model->amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Доставка</th>
                                                    <td>{{ GlobalFunc::moneyFormat($model->delivery_price) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Итого:</th>
                                                    <td>{{ GlobalFunc::moneyFormat($model->amountWithDelivery()) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div class="col-12">
                                        <a href="{{ route('admin.chat.order.detail', $model->id) }}?print=true" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                        Payment
                                        </button>
                                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Generate PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.invoice -->
                        </div>
                        <!-- /.card-body -->
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

@if ($isPrint)
<script>
    window.addEventListener("load", window.print());
</script>
@endif
