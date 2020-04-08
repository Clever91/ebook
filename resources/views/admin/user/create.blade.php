@extends('adminlte::page')

@section('title', __('app.create_user'))

@section('content_header')
    <h1>{{ __('app.create_user') }}</h1>
@stop

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('app.create_user') }}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="{{ route('user.store') }}" method="POST">
        @method("POST")
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">{{ __('app.name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                    id="name" name="name" value="{{ old("name") }}" placeholder="{{ __('app.enter_name') }}">
                @error('name')
                    <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                @enderror
            </div>
            <div class="form-group">
                <label for="username">{{ __('app.username') }}</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" 
                    id="username" name="username" value="{{ old("username") }}" placeholder="{{ __('app.enter_username') }}">
                @error('username')
                    <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">{{ __('app.password') }}</label>
                <input type="password" name="password" id="password" value="" 
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('app.role') }}</label>
                <select class="custom-select @error('role') is-invalid @enderror" name="role">
                    @foreach ($user->roles() as $key => $value)
                        @if (old('role') == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                    <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
                @error('role')
                    <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
                @enderror
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input @error('active') is-invalid @enderror" 
                    id="active" checked name="active">
                <label class="form-check-label" for="active">{{ __('app.active_user') }}</label>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
        </div>
    </form>
</div>

@stop

@section('js')
<script>

$(document).ready( function () {
    $('#users_datatable').DataTable();
});

</script>
@stop