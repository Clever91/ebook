@extends('layouts.admin')

@section('title', 'Изменить продукт')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Изменить продукт'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Изменить продукт</h3>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- /.card-header -->
            <div class="card-body">
                <!-- form start -->
                <form role="form" action="{{ route('product.eform.patch', $model->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @method("PATCH")
                    @csrf
                        <div class="form-group">
                            <label for="eprice">Электронная цена</label>
                            <input type="text" class="form-control @error('eprice') is-invalid @enderror"
                                id="eprice" name="eprice" value="{{ $model->ebookPrice() }}"
                                placeholder="Введите цена" required>
                            @error('eprice')
                                <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ebook">Электронная книга</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input"
                                        id="ebook" name="ebook">
                                    <label class="custom-file-label" for="ebook">
                                        @if ($model->ebook())
                                           {{ $model->ebook()->file->name }}
                                        @else
                                            Выберите файл
                                        @endif
                                    </label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Загрузить</span>
                                </div>
                            </div>
                            @error('ebook')
                                <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $('.custom-file-input').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
</script>

@stop
