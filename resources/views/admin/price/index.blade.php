@extends('layouts.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Установить тип цены')

@section('content')


<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('admin.priceType.index'),
    'title' => 'Установить тип цены'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.price.setPrice', $priceType->id) }}" method="post">
                    @csrf
                    @method("POST")
                <div class="card">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                Установить тип цены
                            </h3>
                        </div>
                        <div class="card-body">
                            <h4>{{ $priceType->name }}</h4>
                            <div class="row">
                                <div class="col-5 col-sm-3">
                                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                        @php $index = 1; @endphp
                                        @foreach ($category as $cat_id => $cat_name)
                                        <a class="nav-link @if($index == 1) active @endif" data-toggle="pill" href="#cat_{{ $cat_id }}" role="tab"
                                            aria-controls="vert-tabs-profile" aria-selected="false">{{ $cat_name }}</a>
                                        @php $index++; @endphp
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-7 col-sm-9">
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        @php $index = 1; @endphp
                                        @foreach ($category as $cat_id => $cat_name)
                                        <div class="tab-pane text-left fade @if($index == 1) show active @endif" id="cat_{{ $cat_id }}" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">{{ $cat_name }}</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Название книги</th>
                                                                <th width="30%">Цена книги</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $lang = \App::getLocale(); @endphp
                                                            @foreach ($products[$cat_id] as $book_id => $book)
                                                            <tr>
                                                                <td>{{ $book_id }} <input type="hidden" name="books[]" value="{{ $book_id }}" /></td>
                                                                <td>{{ $book->getNameWithBtnLabel($lang) }}</td>
                                                                <td><input name="prices[]" type="text" class="form-control"
                                                                    value="@if(isset($prices[$book_id])){{ $prices[$book_id] }}@endif"
                                                                    placeholder="0" autocomplete="off" /></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @php $index++; @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            {{-- <button type="reset" class="btn btn-sm btn-default">Сбросить</button> --}}
                            <button type="submit" class="btn btn-sm btn-primary">Сохранить</button>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card -->
                </div>
                </form>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</section>
@endsection
