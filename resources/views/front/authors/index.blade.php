@extends('layouts.front.front')

@section('title', 'Authors')

@push('stylesheets')
    <!-- CSS Custom -->
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/cubeportfolio/css/cubeportfolio.min.css') }}">
@endpush

@section('content')

<!-- ====== MAIN CONTENT ===== -->
<main id="content">
    <div class="space-bottom-2 space-bottom-lg-3">
        <div class="pb-lg-1">
            @include('layouts.front.breadcrumb', [
                'title' => "Authors",
                'links' => [
                    [
                        'title' => "Home",
                        'url' => route("front.home"),
                        'end' => "Authors",
                    ]
                ]
            ])

            <div class="container">
                <div class="u-cubeportfolio mb-5 mb-lg-7">
                    <!-- Filter -->
                    <ul id="filterControls" class="d-flex justify-content-between list-inline cbp-l-filters-alignRight cbp-l-filters-alignRight__custom text-left pl-lg-8 pt-4 pt-lg-8 mb-5 mb-lg-8 overflow-auto">
                        <li class="list-inline-item bg-white text-secondary-gray-700 px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0 cbp-filter-item-active u-cubeportfolio__item" data-filter="*">All</li>
                        @foreach($alphabets as $alphabet)
                        <li class="list-inline-item bg-white text-secondary-gray-700 px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0 u-cubeportfolio__item" data-filter=".{{ $alphabet }}">{{ $alphabet }}</li>
                        @endforeach
                    </ul>
                    <!-- End Filter -->

                    <!-- Content -->
                    <div class="cbp"
                        data-layout="grid"
                        data-controls="#filterControls"
                        data-animation="quicksand"
                        data-x-gap="20"
                        data-y-gap="100"
                        data-media-queries='[
                        {"width": 1100, "cols": 5},
                        {"width": 800, "cols": 3},
                        {"width": 480, "cols": 1}
                        ]'>
                        @foreach ($models as $author)
                        <!-- Item -->
                        <div class="cbp-item @foreach($author->getFirstAlphabets() as $alphabet) {{ $alphabet }} @endforeach">
                            <a class="cbp-caption" href="../others/authors-single.html">
                                {{-- <img class="rounded-circle img-fluid mb-3" src="https://placehold.it/140x140" alt="Image Description"> --}}
                                <img class="rounded-circle img-fluid mb-3" src="{{ $author->getImageUrl('140x140') }}" alt="{{ $author->translateorNew($lang)->bio }}">
                                <div class="py-3 text-center">
                                    <h4 class="h6 text-dark">{{ $author->translateorNew($lang)->name }}</h4>
                                    <span class="font-size-2 text-secondary-gray-700">21,658 Published Books</span>
                                </div>
                            </a>
                        </div>
                        <!-- End Item -->
                        @endforeach
                    </div>
                    <!-- End Content -->
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-wide border-dark text-dark rounded-0 transition-3d-hover">Load More</button>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- ====== END MAIN CONTENT ===== -->

@endsection

@push('scripts')
{{-- JS Custom --}}
<script src="{{ asset('front/assets/vendor/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
<script src="{{ asset('front/assets/js/components/hs.cubeportfolio.js') }}"></script>
<script>
    $(document).on('ready', function () {

        // initialization of cubeportfolio
        $.HSCore.components.HSCubeportfolio.init('.cbp');

    });
</script>
@endpush
