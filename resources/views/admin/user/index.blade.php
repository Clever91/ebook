@extends('adminlte::page')

@section('title', __('app.create_users'))

@section('content_header')
    <h1>{{ __('app.users') }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('app.all_users_list') }}</h3>
        <a href="{{ route('user.create') }}" class="btn btn-primary float-right">{{ __('app.create') }}</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <table id="users_datatable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Updated At</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($models as $model)
                <tr>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->username }}</td>
                    <td>{{ $model->role }}</td>
                    <td>{{ $model->updated_at }}</td>
                    <td>{{ $model->created_at }}</td>
                    <td>
                        @if(!$model->isAdmin())
                        <a href="{{ route('user.edit', $model->id) }}" class="btn btn-info btn-sm">Update</a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="{{ route('user.destroy', $model->id) }}" 
                            class="btn btn-danger btn-sm jquery-postback" data-method="delete">Delete</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total</th>
                    <th>{{ $models->count() }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@stop

@section('js')
<script>

var langUrl = '{{ config("translatable.dt-locales")[App::getLocale()] }}';

$(document).ready( function () {
    $('#users_datatable').DataTable({
        "language": {
            "url": langUrl,
        }
    });
});

</script>
@stop