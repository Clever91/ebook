@extends('layouts.admin')

@section('title', 'Отправить продукт')

@section('content')

<!-- summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('product.index'),
    'title' => 'Отправить продукт'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Отправить продукт</h3>
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
            <div class="card-body pad">
                <!-- form start -->
                <form role="form" action="{{ route('admin.telegram.send', $model->id) }}" method="POST">
                    @method("POST")
                    @csrf
                        <div class="form-group">
                            <label for="image">Пришлю изображение</label>
                            @if ($model->hasImage())
                            <div class="row">
                                <img class="img-fluid" src="{{ $model->image->getOrginalImage() }}" 
                                    width="300px" alt="{{ $model->translateOrNew(\App::getLocale())->name }}" />
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="caption">Текст изображения здесь</label>
                            <textarea id="caption" class="form-control" rows="4" maxlength="1024"
                                spellcheck="false" name="caption" required></textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <textarea class="textarea" placeholder="Place some text here"
                                        style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                            <p class="text-sm mb-0">
                            Editor <a href="https://github.com/summernote/summernote">Documentation and license
                            information.</a>
                            </p>
                        </div> --}}
                    <!-- /.card-body -->
            
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Отправить в телеграмму</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
        // Summernote
        // $('.textarea').summernote()
    })
</script>

@stop