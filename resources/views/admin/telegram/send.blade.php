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
                                @else
                            <div class="callout callout-danger">
                                @endif
                                <h5>{{ $item["name"] }}</h5>
                                <p>{{ $item["caption"] }}</p>
                            </div>
                            @endforeach
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            {{--  --}}
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

{{-- <script>
    var page = "{{ $page }}";
    setTimeout(function() { 
        window.location = "{{ route('/telegram/{$id}/send') }} }}"
    }, 3000);
</script> --}}

@endsection

