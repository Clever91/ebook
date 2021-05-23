<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Media Nashr | @yield('title')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Language icon --}}
    <link rel="stylesheet" href="{{ asset('plugins/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    {{-- fontawesome icons --}}
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery Cookie -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- Custom Cookie js --}}
    {{-- <script src="{{ asset('js/cookie.js') }}"></script> --}}

</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include('layouts.navbar')

        @include('layouts.leftsidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Page script -->
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // init datatable
            $('.datatables').DataTable({
                "paging": true,
                // "lengthChange": false,
                // "searching": false,
                "ordering": true,
                "info": true,
                // "autoWidth": false,
                "responsive": true,
                "language": {
                    "emptyTable": "В таблице нет данных",
                    "info": "Показаны записи с _START_ по _END_ из _TOTAL_",
                    "infoEmpty": "Показано от 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Показать записи _MENU_",
                    "loadingRecords": "Загрузка ...",
                    "processing": "Обработка ...",
                    "search": "Search:",
                    "zeroRecords": "Соответствующих записей не найдено",
                    "paginate": {
                        "first": "Первый",
                        "last": "Последний",
                        "next": "Далее",
                        "previous": "Предыдущий"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                },
            });

            // Set a cookie
            function setCookie(key, value) {
                $.cookie(key, value, { expires : 20, path: '/' }); // 20 day
            }

            // Read the cookie
            function getCookie(key) {
                return $.cookie(key);
            }

            // Remove the cookie
            function removeCookie(key) {
                $.removeCookie(key);
            }

            $(".btn-filter-tool").on("click", function(e) {
                e.preventDefault();
                openFilter = !openFilter;
                console.log(openFilter);
                if (openFilter) {
                    var coo = setCookie("hide_tool", 'true');
                    console.log(coo);
                } else {
                    removeCookie("hide_tool");
                }
            });

            var openFilter = true;
            function initFilterTool() {
                var hideTool = getCookie("hide_tool");
                console.log(hideTool);
                openFilter = true;
                if (hideTool)
                    openFilter = false;
                if (!openFilter)
                    $(".btn-hide-tool").click();
            }
            initFilterTool();
        })
    </script>

</body>
</html>
