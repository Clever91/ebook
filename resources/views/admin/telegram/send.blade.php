@extends('layouts.admin')

@section('title', 'Список группы')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Список группы'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список группы</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @foreach ($result as $item)
                                @if ($item["success"])
                            <div class="callout callout-success">  
                                <h5>{{ $item["name"] }}</h5>
                                <p>{{ $item["caption"] }}</p>
                            </div>
                                @else
                            <div class="callout callout-danger">
                                <h5>{{ $item["name"] }}</h5>
                                <p>{{ $item["message"] }}</p>
                            </div>
                                @endif
                            @endforeach
                            @if (empty($result))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Успех</h5>
                                Сообщение успешно отправлено всей группе телеграмм
                            </div>
                            <br>
                            <a href="{{ route('product.index') }}" class="btn btn-primary">Перейти к списку товаров</a>
                            @endif
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            @if (!empty($result))
                            <form id="next" role="form" action="{{ route('admin.telegram.send', $product->id) }}" method="POST">
                                @method("POST")
                                @csrf
                                <input type="hidden" name="page" value="{{ $page + 1 }}">
                            </form>
                            @endif
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

<script>
    setTimeout(function() { 
        $("#next").submit();
    }, 1000);
</script>

@endsection

