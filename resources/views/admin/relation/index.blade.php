@extends('layouts.admin')

@section('title', 'Присоединить группы')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('admin.relation.index', [$relation_id, $type]),
    'title' => 'Присоединить группы'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Присоединить группы</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.relation.store', [$relation_id, $type]) }}" method="POST">
                @method("POST")
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="groups">Группы</label>
                        <select class="form-control select2bs4 @error('groups') is-invalid @enderror" 
                            name="groups[]" style="width: 100%;" title="Выберите группы" 
                            multiple required>
                            @foreach ($groups as $group)
                                @if (in_array($group->id, $related))
                            <option value="{{ $group->id }}" selected>
                                {{ $group->translateOrNew(\App::getLocale())->name }}
                            </option>
                                @else
                            <option value="{{ $group->id }}">{{ $group->translateOrNew(\App::getLocale())->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('groups')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="order_no">Порядковый номер</label>
                        <input type="number" class="form-control @error('order_no') is-invalid @enderror" 
                            id="order_no" name="order_no" value="{{ old("order_no") }}" placeholder="Введите порядковый номер"
                            required>
                        @error('order_no')
                            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->
        
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Прикреплять</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->

@stop