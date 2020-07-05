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
                <form role="form" action="{{ route('product.image.patch', $model->id) }}" 
                    method="POST" enctype="multipart/form-data">
                    @method("PATCH")
                    @csrf
                        @if ($model->hasImage())
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Исходное изображение:</strong>                        
                                <br/>
                                <img src="{{ $model->image->getOrginalImage() }}" width="300px" />
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="image">Изображение книги</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image">
                                    <label class="custom-file-label" for="image">
                                        @if ($model->hasImage()) 
                                           {{ $model->image->name }}
                                        @else
                                            Выберите файл
                                        @endif
                                    </label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Загрузить</span>
                                </div>
                            </div>
                            @error('image')
                                <p>Error: <code>{{ $message }}</code></p>
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