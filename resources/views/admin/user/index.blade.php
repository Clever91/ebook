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
                    <th>Username</th>
                    <th>Role</th>
                    <th>Updated At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>{{ $users->count() }}</th>
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