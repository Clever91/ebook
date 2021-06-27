<div class="page-header border-bottom mb-8">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-center py-4">
            <h1 class="page-title font-size-3 font-weight-medium m-0 text-lh-lg">{{ $title }}</h1>
            <nav class="woocommerce-breadcrumb font-size-2">
                {{-- <a href="{{ route('front.home') }}" class="h-primary">Home</a>
                <span class="breadcrumb-separator mx-1"><i class="fas fa-angle-right"></i></span> --}}
                @foreach ($links as $link)
                <a href="{{ $link['url'] }}" class="h-primary">{{ $link['title'] }}</a>
                <span class="breadcrumb-separator mx-1"><i class="fas fa-angle-right"></i></span>{{ $link['end'] }}
                @endforeach
            </nav>
        </div>
    </div>
</div>
