@extends('layouts.admin')

@section('title', 'Настройка')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('admin.settings'),
    'title' => 'Настройка'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Настройка</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (Session::has('status'))
                            <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                {{ Session::has('status') }}
                            </div>
                        @endif

                        <form method="post" action="{{ route('admin.settings.store') }}" class="form-horizontal" role="form">
                            {!! csrf_field() !!}

                            @if(count(config('setting', [])) )

                                @foreach(config('setting') as $section => $fields)
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="{{ Arr::get($fields, 'icon', 'fas fa-question') }}"></i> {{ $fields['title'] }}
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <p>{{ $fields['desc'] }}</p>
                                            @foreach($fields['elements'] as $field)
                                                @includeIf('admin.setting.fields.' . $field['type'] )
                                            @endforeach
                                        </div>
                                        {{-- <div class="card-footer"></div> --}}
                                    </div>
                                    <!-- end panel for {{ $fields['title'] }} -->
                                @endforeach

                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn-primary btn">
                                        Сохранить настройки
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer"></div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</section>
@endsection

