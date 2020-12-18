@extends('layouts.login')

@section('title', 'Success')

@section('content')

<div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0 text-success">Успешный платеж</h5>
      </div>
      <div class="card-body">
        <h6 class="card-title">Вы заплатили успешно</h6>

        <p class="card-text">Ваш заказ успешно создан</p>
        <a href="{{ $url }}" class="btn btn-primary">Перейти к боту</a>
      </div>
    </div>
</div>

@endsection
