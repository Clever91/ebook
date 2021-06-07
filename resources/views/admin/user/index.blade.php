@extends('layouts.admin')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('title', 'Список пользователей')

@section('content')

<!-- Content Header (Page header) -->
@include('layouts.breadcrumb', [
    'list' => route('user.index'),
    'title' => 'Список пользователей'
])

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список пользователей</h3>
                            <a href="{{ route('user.create') }}"
                                class="btn btn-sm btn-primary float-right">Создать</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Имя</th>
                                        <th>Имя пользователя</th>
                                        <th>Роль</th>
                                        <th>Активный</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->name }}</td>
                                        <td>{{ $model->username }}</td>
                                        <td>{{ $model->activeLabel() }}</td>
                                        <td>{{ $model->roleLabel() }}</td>
                                        <td>
                                            <a href="{{ route('user.edit', $model->id) }}"
                                            class="btn btn-sm btn-info">Изменить</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            {{ $models->links() }}
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
@endsection

<!-- page script -->

<!-- DataTables -->
{{-- <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script> --}}

{{-- <script type="text/javascript">
    // your inline script
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script> --}}
