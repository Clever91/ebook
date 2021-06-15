<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Book Market 24 | @yield('title')</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/animate.css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/slick-carousel/slick/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">

    <!-- CSS Bookworm Template -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/theme.css') }}">
</head>
<body>

    <!--===== HEADER CONTENT ====-->
    @include('layouts.front.header')

    <!-- Account Sidebar Navigation - Desktop -->
    @include('layouts.front.sidebar-account')
    <!-- End Account Sidebar Navigation - Desktop -->

    <!-- Cart Sidebar Navigation -->
    @include('layouts.front.sidebar-cart')
    <!-- End Cart Sidebar Navigation -->

    <!-- Categories Sidebar Navigation -->
    @include('layouts.front.sidebar-cats')
    <!-- End Categories Sidebar Navigation -->
    <!--===== END HEADER CONTENT =====-->

    <!--===== MAIN CONTENT ======-->
    @yield('content')
    <!--====== END MAIN CONTENT =====-->

    <!-- ========== FOOTER ========== -->
    @include('layouts.front.footer')
    <!-- ========== END FOOTER ========== -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('front/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/multilevel-sliding-mobile-menu/dist/jquery.zeynep.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/slick-carousel/slick/slick.min.js') }}"></script>


    <!-- JS HS Components -->
    <script src="{{ asset('front/assets/js/hs.core.js') }}"></script>
    <script src="{{ asset('front/assets/js/components/hs.unfold.js') }}"></script>
    <script src="{{ asset('front/assets/js/components/hs.malihu-scrollbar.js') }}"></script>
    <script src="{{ asset('front/assets/js/components/hs.slick-carousel.js') }}"></script>
    <script src="{{ asset('front/assets/js/components/hs.show-animation.js') }}"></script>
    <script src="{{ asset('front/assets/js/components/hs.selectpicker.js') }}"></script>

    <!-- JS Bookworm -->
    <!-- <script src="../../assets/js/bookworm.js"></script> -->
    <!-- JS Vue3 -->
    {{-- <script src="https://unpkg.com/vue@next"></script> --}}

    <script>
        $(document).on('ready', function () {
            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));

            // initialization of malihu scrollbar
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

            // initialization of slick carousel
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

            // initialization of show animations
            $.HSCore.components.HSShowAnimation.init('.js-animation-link');

            // init zeynepjs
            var zeynep = $('.zeynep').zeynep({
                onClosed: function () {
                    // enable main wrapper element clicks on any its children element
                    $("body main").attr("style", "");

                    console.log('the side menu is closed.');
                },
                onOpened: function () {
                    // disable main wrapper element clicks on any its children element
                    $("body main").attr("style", "pointer-events: none;");

                    console.log('the side menu is opened.');
                }
            });

            // handle zeynep overlay click
            $(".zeynep-overlay").click(function () {
                zeynep.close();
            });

            // open side menu if the button is clicked
            $(".cat-menu").click(function () {
                if ($("html").hasClass("zeynep-opened")) {
                    zeynep.close();
                } else {
                    zeynep.open();
                }
            });
        });
    </script>
</body>
</html>
