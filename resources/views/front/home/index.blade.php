@extends('layouts.front.front')

@section('title', Lang::get("front.home"))

@section('content')

<!--===== MAIN CONTENT ======-->
<div class="space-bottom-2 space-bottom-lg-3">
    <div class="container space-top-1">
        <ul class="nav justify-content-between flex-nowrap overflow-auto">
            <li class="nav-item flex-shrink-0">
                <a class="nav-link font-weight-medium" href="../shop/v7.html">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-chili-light height-100 width-100 rounded-circle">
                                <figure class="d-flex justify-content-center mb-0 text-chili">
                                    <i class="glyph-icon flaticon-like font-size-12 text-lh-2"></i>
                                </figure>
                            </div>
                        </div>
                        <span class="tabtext font-size-3 font-weight-medium text-dark">Romance</span>
                    </div>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link font-weight-medium" href="../shop/v7.html">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-carolina-light height-100 width-100 rounded-circle">
                                <figure class="d-flex justify-content-center mb-0 text-carolina">
                                    <i class="glyph-icon flaticon-doctor font-size-12 text-lh-2"></i>
                                </figure>
                            </div>
                        </div>
                        <span class="tabtext font-size-3 font-weight-medium text-dark">Health</span>
                    </div>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link font-weight-medium" href="../shop/v7.html">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-punch-light height-100 width-100 rounded-circle">
                                <figure class="d-flex justify-content-center mb-0 text-punch">
                                    <i class="glyph-icon flaticon-resume font-size-12 text-lh-2"></i>
                                </figure>
                            </div>
                        </div>
                        <span class="tabtext font-size-3 font-weight-medium text-dark">Biography</span>
                    </div>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link font-weight-medium" href="../shop/v7.html">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-tangerine-light height-100 width-100 rounded-circle">
                                <figure class="d-flex justify-content-center mb-0 text-tangerine">
                                    <i class="glyph-icon flaticon-jogging font-size-12 text-lh-2"></i>
                                </figure>
                            </div>
                        </div>
                        <span class="tabtext font-size-3 font-weight-medium text-dark">Sports</span>
                    </div>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link font-weight-medium" href="../shop/v7.html">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-chili-light height-100 width-100 rounded-circle">
                                <figure class="d-flex justify-content-center mb-0 text-chili">
                                    <i class="glyph-icon flaticon-baby-boy font-size-12 text-lh-2"></i>
                                </figure>
                            </div>
                        </div>
                        <span class="tabtext font-size-3 font-weight-medium text-dark">Children</span>
                    </div>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link font-weight-medium" href="{{ route('front.category.products', 2) }}">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-indigo-light height-100 width-100 rounded-circle">
                                <figure class="d-flex justify-content-center mb-0 text-primary-indigo">
                                    <i class="glyph-icon flaticon-gallery font-size-12 text-lh-2"></i>
                                </figure>
                            </div>
                        </div>
                        <span class="tabtext font-size-3 font-weight-medium text-dark">Arts & Photography</span>
                    </div>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link font-weight-medium" href="../shop/v7.html">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-tangerine-light height-100 width-100 rounded-circle">
                                <figure class="d-flex justify-content-center mb-0 text-tangerine">
                                    <i class="glyph-icon flaticon-cook font-size-12 text-lh-2"></i>
                                </figure>
                            </div>
                        </div>
                        <span class="tabtext font-size-3 font-weight-medium text-dark">Food & Drink</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<section class="space-bottom-2 space-bottom-lg-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="bg-gray-200 rounded-md py-4 py-lg-7 px-5 pl-lg-7 pr-lg-6 pb-lg-6 space-bottom-xl-2 mb-5">
                    <div class="pb-xl-3 mb-xl-1">
                        <div class="ml-xl-1">
                            <div class="mb-2">
                                <span class="font-weight-medium h6 text-gray-400">BEST SELLER</span>
                            </div>
                            <h6 class="font-weight-bold font-size-7">Books</h6>
                            <a href="../shop/v7.html" class="link-black-100 text-dark font-weight-medium">
                                <span class="product__add-to-cart d-inline-block">Shop Now</span>
                            </a>
                            <div class="d-flex justify-content-end">
                                <img src="https://demo2.madrasthemes.com/bookworm-html/redesigned-octo-fiesta/assets/img/350x312/img1.png" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-primary p-3 mb-5 mb-lg-0 rounded-md">
                    <div class="m-1">
                        <div class="position-relative">
                            <div class="border__1 rounded-md">
                                <div class="py-5 space-lg-2">
                                    <div class="text-center mb-lg-1 py-lg-4 py-xl-2">
                                        <h6 class="font-weight-bold text-white mb-3">GET FREE NEXTDAY DELIVERY</h6>
                                        <div class="text-lh-sm mb-3">
                                            <div class="font-size-7 text-white font-weight-bold">On orders of $35 </div>
                                            <span class="font-size-7 text-white font-weight-bold">or more.</span>
                                        </div>
                                        <div class="">
                                            <a href="../shop/v7.html" class="text-white h-border-bottom-white h6 font-weight-medium" tabindex="0">Start Shopping</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none d-md-block position-absolute bottom-n14 left-30">
                                <i class="flaticon-delivery font-size-17 text-red-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative mb-5">
                    <div class="bg-gray-200 height-md-350 pt-5 pt-lg-6 pl-5 pl-lg-7  rounded-md">
                        <h2 class="font-size-7 mt-lg-1 text-lh-md">
                            <span class="hero__title-line-1 font-weight-bold d-block">New Books</span>
                            <span class="hero__title-line-2 font-weight-normal d-block">Available</span>
                        </h2>
                        <a href="../shop/v7.html" class="link-black-100 text-dark font-weight-medium">
                            <span class="product__add-to-cart d-inline-block">Shop Now</span>
                        </a>
                        <div class="d-flex justify-content-end d-md-block position-md-absolute bottom-md-30 right-md-30">
                            <img src="https://demo2.madrasthemes.com/bookworm-html/redesigned-octo-fiesta/assets/img/442x234/img1.png" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                        </div>
                    </div>
                </div>
                <div class="position-relative">
                    <div class="bg-gray-200 height-md-470 pt-4 pl-5 pl-lg-7 pt-lg-7 rounded-md">
                        <div class="ml-lg-1">
                            <div class="space-bottom-1 space-bottom-md-6">
                                <div class="mb-2">
                                    <span class="font-weight-medium h6 text-gray-400">DEAL OF THE WEEK</span>
                                </div>
                                <h6 class="font-weight-bold font-size-7">Made For You</h6>
                                <a href="../shop/v7.html" class="link-black-100 text-dark font-weight-medium">
                                    <span class="product__add-to-cart d-inline-block">Shop Book</span>
                                </a>
                            </div>
                            <div class="d-flex justify-content-end d-md-block position-md-absolute bottom-md-65 right-0">
                                <img src="https://demo2.madrasthemes.com/bookworm-html/redesigned-octo-fiesta/assets/img/400x296/img1.png" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                            </div>
                            <div class="d-flex align-items-stretch pb-1">
                                <div class="py-2d75 text-primary-home-v3 mr-5">
                                    <span class="font-weight-medium font-size-3">114</span>
                                    <span class="font-size-2">Days</span>
                                </div>
                                <div class="py-2d75 text-primary-home-v3 mr-5">
                                    <span class="font-weight-medium font-size-3">03</span>
                                    <span class="font-size-2">Hours</span>
                                </div>
                                <div class="py-2d75 text-primary-home-v3 mr-5">
                                    <span class="font-weight-medium font-size-3">60</span>
                                    <span class="font-size-2">Mins</span>
                                </div>
                                <div class="py-2d75 text-primary-home-v3">
                                    <span class="font-weight-medium font-size-3">25</span>
                                    <span class="font-size-2">Secs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="space-bottom-2">
    <div class="container">
        <header class="border-bottom mb-8d75 pb-4d75 d-md-flex justify-content-between align-items-center">
            <h2 class="font-size-7 mb-3 mb-md-0">New Arrival Books</h2>
            <ul class="nav justify-content-md-center nav-gray-700 flex-nowrap flex-md-wrap overflow-auto overflow-md-visible" id="featuredBooks" role="tablist">
                <li class="nav-item mx-5 mb-1 flex-shrink-0 flex-md-shrink-1">
                    <a class="nav-link px-0 active" id="featured-tab" data-toggle="tab" href="#featured" role="tab" aria-controls="featured" aria-selected="true">Featured</a>
                </li>
                <li class="nav-item mx-5 mb-1 flex-shrink-0 flex-md-shrink-1">
                    <a class="nav-link px-0" id="onsale-tab" data-toggle="tab" href="#onsale" role="tab" aria-controls="onsale" aria-selected="false">On Sale</a>
                </li>
                <li class="nav-item mx-5 mb-1 flex-shrink-0 flex-md-shrink-1">
                    <a class="nav-link px-0" id="mostviewed-tab" data-toggle="tab" href="#mostviewed" role="tab" aria-controls="mostviewed" aria-selected="false">Most Viewed</a>
                </li>
            </ul>
        </header>
        <div class="tab-content u-slick__tab" id="featuredBooksContent">
            <div class="tab-pane fade show active" id="featured" role="tabpanel" aria-labelledby="featured-tab">
                <div class="js-slick-carousel products list-unstyled no-gutters my-0"
                    data-pagi-classes="d-md-none text-center u-slick__pagination u-slick__pagination mt-5 mb-0"
                    data-arrows-classes="d-none d-md-block u-slick__arrow u-slick__arrow-centered--y rounded-circle"
                    data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-xl-n10"
                    data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-xl-n10"
                    data-slides-show="5"
                    data-responsive='[{
                       "breakpoint": 1500,
                       "settings": {
                         "slidesToShow": 4
                       }
                    }, {
                       "breakpoint": 992,
                       "settings": {
                         "slidesToShow": 3
                       }
                    }, {
                       "breakpoint": 554,
                       "settings": {
                         "slidesToShow": 2
                       }
                    }]'>
                    @foreach ($featured as $product)
                    <div class="product product__no-border border-right">
                        <div class="product__inner overflow-hidden px-3 px-md-4d875">
                            <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                <div class="woocommerce-loop-product__thumbnail">
                                    <a href="{{ route('front.product.single', $product->id) }}" class="d-block">
                                        {{-- <img src="http://placehold.it/120x180" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" --}}
                                        <img src="{{ $product->getImageUrl('120x180') }}" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"
                                            alt="image-description"></a>
                                </div>
                                <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                    <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="{{ route('front.product.single', $product->id) }}">Paperback</a></div>
                                    <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark">
                                        <a href="{{ route('front.product.single', $product->id) }}">{{ $product->translateorNew($lang)->name }}</a></h2>
                                    <div class="font-size-2  mb-1 text-truncate">
                                        <a href="../others/authors-single.html" class="text-gray-700">{{ $product->authorName() }}</a>
                                    </div>
                                    <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol"></span>@money_format($product->bookPrice()) {{ $currency }}</span>
                                    </div>
                                    <!-- <div class="product__rating d-flex align-items-center font-size-2">
                                        <div class="text-warning mr-2">
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star"></small>
                                            <small class="far fa-star"></small>
                                        </div>
                                        <div class="">(3,714)</div>
                                    </div> -->
                                </div>
                                <div class="product__hover d-flex align-items-center">
                                    <a href="{{ route('front.product.single', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                        <span class="product__add-to-cart">ADD TO CART</span>
                                        <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                    </a>
                                    <a href="{{ route('front.product.single', $product->id) }}" class="mr-1 h-p-bg btn btn-outline-primary-green border-0">
                                        <i class="flaticon-switch"></i>
                                    </a>
                                    <a href="{{ route('front.product.single', $product->id) }}" class="h-p-bg btn btn-outline-primary-green border-0">
                                        <i class="flaticon-heart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="onsale" role="tabpanel" aria-labelledby="onsale-tab">
                <div class="js-slick-carousel products list-unstyled no-gutters my-0"
                    data-pagi-classes="d-md-none text-center u-slick__pagination u-slick__pagination mt-5 mb-0"
                    data-arrows-classes="d-none d-md-block u-slick__arrow u-slick__arrow-centered--y rounded-circle"
                    data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-xl-n10"
                    data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-xl-n10"
                    data-slides-show="5"
                    data-responsive='[{
                       "breakpoint": 1500,
                       "settings": {
                         "slidesToShow": 4
                       }
                    }, {
                       "breakpoint": 992,
                       "settings": {
                         "slidesToShow": 3
                       }
                    }, {
                       "breakpoint": 554,
                       "settings": {
                         "slidesToShow": 2
                       }
                    }]'>
                    @foreach ($onSale as $product)
                    <div class="product product__no-border border-right">
                        <div class="product__inner overflow-hidden px-3 px-md-4d875">
                            <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                <div class="woocommerce-loop-product__thumbnail">
                                    <a href="{{ route('front.product.single', $product->id) }}" class="d-block">
                                        {{-- <img src="http://placehold.it/120x180" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" --}}
                                        <img src="{{ $product->getImageUrl('120x180') }}" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"
                                            alt="image-description"></a>
                                </div>
                                <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                    <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="{{ route('front.product.single', $product->id) }}">Paperback</a></div>
                                    <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark">
                                        <a href="{{ route('front.product.single', $product->id) }}">{{ $product->translateorNew($lang)->name }}</a></h2>
                                    <div class="font-size-2  mb-1 text-truncate">
                                        <a href="../others/authors-single.html" class="text-gray-700">{{ $product->authorName() }}</a>
                                    </div>
                                    <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol"></span>@money_format($product->bookPrice()) {{ $currency }}</span>
                                    </div>
                                    <!-- <div class="product__rating d-flex align-items-center font-size-2">
                                        <div class="text-warning mr-2">
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star"></small>
                                            <small class="far fa-star"></small>
                                        </div>
                                        <div class="">(3,714)</div>
                                    </div> -->
                                </div>
                                <div class="product__hover d-flex align-items-center">
                                    <a href="{{ route('front.product.single', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                        <span class="product__add-to-cart">ADD TO CART</span>
                                        <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                    </a>
                                    <a href="{{ route('front.product.single', $product->id) }}" class="mr-1 h-p-bg btn btn-outline-primary-green border-0">
                                        <i class="flaticon-switch"></i>
                                    </a>
                                    <a href="{{ route('front.product.single', $product->id) }}" class="h-p-bg btn btn-outline-primary-green border-0">
                                        <i class="flaticon-heart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="mostviewed" role="tabpanel" aria-labelledby="mostviewed-tab">
                <div class="js-slick-carousel products list-unstyled no-gutters my-0"
                    data-pagi-classes="d-md-none text-center u-slick__pagination u-slick__pagination mt-5 mb-0"
                    data-arrows-classes="d-none d-md-block u-slick__arrow u-slick__arrow-centered--y rounded-circle"
                    data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-xl-n10"
                    data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-xl-n10"
                    data-slides-show="5"
                    data-responsive='[{
                       "breakpoint": 1500,
                       "settings": {
                         "slidesToShow": 4
                       }
                    }, {
                       "breakpoint": 992,
                       "settings": {
                         "slidesToShow": 3
                       }
                    }, {
                       "breakpoint": 554,
                       "settings": {
                         "slidesToShow": 2
                       }
                    }]'>
                    @foreach ($mostVieved as $product)
                    <div class="product product__no-border border-right">
                        <div class="product__inner overflow-hidden px-3 px-md-4d875">
                            <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                <div class="woocommerce-loop-product__thumbnail">
                                    <a href="{{ route('front.product.single', $product->id) }}" class="d-block">
                                        {{-- <img src="http://placehold.it/120x180" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" --}}
                                        <img src="{{ $product->getImageUrl('120x180') }}" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"
                                            alt="image-description"></a>
                                </div>
                                <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                    <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="{{ route('front.product.single', $product->id) }}">Paperback</a></div>
                                    <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark">
                                        <a href="{{ route('front.product.single', $product->id) }}">{{ $product->translateorNew($lang)->name }}</a></h2>
                                    <div class="font-size-2  mb-1 text-truncate">
                                        <a href="../others/authors-single.html" class="text-gray-700">{{ $product->authorName() }}</a>
                                    </div>
                                    <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol"></span>@money_format($product->bookPrice()) {{ $currency }}</span>
                                    </div>
                                    <!-- <div class="product__rating d-flex align-items-center font-size-2">
                                        <div class="text-warning mr-2">
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star"></small>
                                            <small class="far fa-star"></small>
                                        </div>
                                        <div class="">(3,714)</div>
                                    </div> -->
                                </div>
                                <div class="product__hover d-flex align-items-center">
                                    <a href="{{ route('front.product.single', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                        <span class="product__add-to-cart">ADD TO CART</span>
                                        <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                    </a>
                                    <a href="{{ route('front.product.single', $product->id) }}" class="mr-1 h-p-bg btn btn-outline-primary-green border-0">
                                        <i class="flaticon-switch"></i>
                                    </a>
                                    <a href="{{ route('front.product.single', $product->id) }}" class="h-p-bg btn btn-outline-primary-green border-0">
                                        <i class="flaticon-heart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<section class="space-bottom-3">
    <div class="space-1">
        <div class="container">
            <header class="border-bottom mb-8d75 pb-4">
                <h2 class="font-size-7 mb-0">Deals of the week</h2>
            </header>
            <div class="js-slick-carousel u-slick products bg-white"
                data-pagi-classes="text-center u-slick__pagination u-slick__pagination mt-6 mb-0 position-absolute right-0 left-0"
                data-slides-show="2"
                data-responsive='[{
                   "breakpoint": 1199,
                   "settings": {
                     "slidesToShow": 1
                   }
                }, {
                   "breakpoint": 768,
                   "settings": {
                     "slidesToShow": 1
                   }
                }, {
                   "breakpoint": 554,
                   "settings": {
                     "slidesToShow": 1
                   }
                }]'>
                @foreach ($dealsOfWeek as $product)
                <div class="product product__card product__card-v2 border-right">
                    <div class="media d-block d-md-flex px-4 px-md-6 px-xl-8d75">
                        <div class="woocommerce-loop-product__thumbnail mb-4 mb-md-0">
                            <a href="{{ route('front.product.single', $product->id) }}" class="d-block"
                                tabindex="0">
                                <img src="{{ $product->getImageUrl('200x327') }}"
                                    class="attachment-shop_catalog size-shop_catalog wp-post-image d-block mx-auto"
                                    alt="image-description"></a>
                        </div>
                        <div class="woocommerce-loop-product__body media-body ml-md-5d25">
                            <div class="mb-3">
                                <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate">
                                    <a href="{{ route('front.product.single', $product->id) }}" tabindex="0">Kindle Edition</a>
                                </div>
                                <h2 class="woocommerce-loop-product__title font-size-3 text-lh-md mb-2 text-height-2 crop-text-2 h-dark">
                                    <a href="{{ route('front.product.single', $product->id) }}" tabindex="0">{{ $product->translateorNew($lang)->name }}</a>
                                </h2>
                                <div class="font-size-2 text-gray-700 mb-1 text-truncate">
                                    <a href="../others/authors-single.html" class="text-gray-700" tabindex="0">{{ $product->authorName() }}</a>
                                </div>
                                <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                    <ins class="text-decoration-none mr-2">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol"></span>@money_format($product->bookPrice()) {{ $currency }}</span>
                                    </ins>
                                    <del class="font-size-1 font-weight-regular text-gray-700">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol"></span>@money_format($product->bookPrice()) {{ $currency }}</span</del>
                                </div>
                            </div>
                            <div class="countdown-timer mb-5">
                                <h5 class="countdown-timer__title font-size-3 mb-3">Hurry Up! <span class="font-weight-regular">Offer ends in:</span></h5>
                                <div class="d-flex align-items-stretch justify-content-between">
                                    <div class="py-2d75">
                                        <span class="font-weight-medium font-size-3">114</span>
                                        <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Days</span>
                                    </div>
                                    <div class="border-left pr-3 pr-md-0">&nbsp;</div>
                                    <div class="py-2d75">
                                        <span class="font-weight-medium font-size-3">03</span>
                                        <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Hours</span>
                                    </div>
                                    <div class="border-left pr-3 pr-md-0">&nbsp;</div>
                                    <div class="py-2d75">
                                        <span class="font-weight-medium font-size-3">60</span>
                                        <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Mins</span>
                                    </div>
                                    <div class="border-left pr-3 pr-md-0">&nbsp;</div>
                                    <div class="py-2d75">
                                        <span class="font-weight-medium font-size-3">25</span>
                                        <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Secs</span>
                                    </div>
                                </div>
                            </div>
                            <div class="deal-progress">
                                <div class="d-flex justify-content-between font-size-2 mb-2d75">
                                    <span>Already Sold: 14</span>
                                    <span>Available: 3</span>
                                </div>
                                <div class="progress">
                                    <div class="bg-dark progress-bar" role="progressbar" style="width:82%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="17"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section class="space-bottom-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 col-lg-4 col-xl-3 mb-4 mb-md-0">
                <div class="bg-img-hero min-height-440 rounded" style="background-image: url(http://placehold.it/300x440);">
                    <div class="p-5">
                        <h4 class="font-size-22">Romance</h4>
                        <p>Lorem ipsum dolor consectetu eiusmo tempor ametsum.</p>
                        <a href="#" class="text-dark font-weight-medium text-uppercase stretched-link">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class="mx-lg-8 mx-wd-4">
                    <div class="js-slick-carousel products no-gutters"
                        data-pagi-classes="d-lg-none text-center u-slick__pagination u-slick__pagination mt-5 mb-0"
                        data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow-centered--y rounded-circle"
                        data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n8 ml-wd-n4"
                        data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n8 mr-wd-n4"
                        data-slides-show="4"
                        data-responsive='[{
                           "breakpoint": 1500,
                           "settings": {
                             "slidesToShow": 3
                           }
                        }, {
                           "breakpoint": 1199,
                           "settings": {
                             "slidesToShow": 2
                           }
                        }, {
                           "breakpoint": 554,
                           "settings": {
                             "slidesToShow": 2
                           }
                        }]'>
                        @foreach ($productsByTag as $product)
                        <div class="product product__no-border border-right">
                            <div class="product__inner overflow-hidden px-3 px-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="{{ route('front.product.single', $product->id) }}" class="d-block"><img src="http://placehold.it/120x180" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="{{ route('front.product.single', $product->id) }}">Paperback</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark">
                                            <a href="{{ route('front.product.single', $product->id) }}">{{ $product->translateorNew($lang)->name }}</a>
                                        </h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="others/authors-single.html" class="text-gray-700">{{ $product->authorName() }}</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount">@money_format($product->bookPrice()) {{ $currency }}</span>
                                        </div>
                                        <!-- <div class="product__rating d-flex align-items-center font-size-2">
                                            <div class="text-warning mr-2">
                                                <small class="fas fa-star"></small>
                                                <small class="fas fa-star"></small>
                                                <small class="fas fa-star"></small>
                                                <small class="far fa-star"></small>
                                                <small class="far fa-star"></small>
                                            </div>
                                            <div class="">(3,714)</div>
                                        </div> -->
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="{{ route('front.product.single', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-auto" data-toggle="tooltip" data-placement="right" title="ADD TO CART">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="{{ route('front.product.single', $product->id) }}" class="mr-1 h-p-bg btn btn-outline-primary-green border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="{{ route('front.product.single', $product->id) }}" class="h-p-bg btn btn-outline-primary-green border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="space-bottom-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 col-lg-4 col-xl-3 mb-4 mb-md-0">
                <div class="bg-img-hero min-height-440 rounded" style="background-image: url(http://placehold.it/300x440);">
                    <div class="p-5">
                        <h4 class="font-size-22">Health</h4>
                        <p>Lorem ipsum dolor consectetu eiusmo tempor ametsum.</p>
                        <a href="#" class="text-dark font-weight-medium text-uppercase stretched-link">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class="mx-lg-8 mx-wd-4">
                    <div class="js-slick-carousel products no-gutters"
                        data-pagi-classes="d-lg-none text-center u-slick__pagination u-slick__pagination mt-5 mb-0"
                        data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow-centered--y rounded-circle"
                        data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n8 ml-wd-n4"
                        data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n8 mr-wd-n4"
                        data-slides-show="4"
                        data-responsive='[{
                           "breakpoint": 1500,
                           "settings": {
                             "slidesToShow": 3
                           }
                        }, {
                           "breakpoint": 1199,
                           "settings": {
                             "slidesToShow": 2
                           }
                        }, {
                           "breakpoint": 554,
                           "settings": {
                             "slidesToShow": 2
                           }
                        }]'>
                        @foreach ($productsByTag as $product)
                        <div class="product product__no-border border-right">
                            <div class="product__inner overflow-hidden px-3 px-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="{{ route('front.product.single', $product->id) }}" class="d-block"><img src="http://placehold.it/120x180" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="{{ route('front.product.single', $product->id) }}">Paperback</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark">
                                            <a href="{{ route('front.product.single', $product->id) }}">{{ $product->translateorNew($lang)->name }}</a>
                                        </h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="others/authors-single.html" class="text-gray-700">{{ $product->authorName() }}</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount">@money_format($product->bookPrice()) {{ $currency }}</span>
                                        </div>
                                        <!-- <div class="product__rating d-flex align-items-center font-size-2">
                                            <div class="text-warning mr-2">
                                                <small class="fas fa-star"></small>
                                                <small class="fas fa-star"></small>
                                                <small class="fas fa-star"></small>
                                                <small class="far fa-star"></small>
                                                <small class="far fa-star"></small>
                                            </div>
                                            <div class="">(3,714)</div>
                                        </div> -->
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="{{ route('front.product.single', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-auto" data-toggle="tooltip" data-placement="right" title="ADD TO CART">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="{{ route('front.product.single', $product->id) }}" class="mr-1 h-p-bg btn btn-outline-primary-green border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="{{ route('front.product.single', $product->id) }}" class="h-p-bg btn btn-outline-primary-green border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <div class="banner space-bottom-2 space-bottom-lg-3">
    <div class="container">
        <div class="bg-dark pl-xl-10 px-6 py-5 pt-lg-8 pb-lg-7s rounded-md">
            <div class="media d-block d-lg-flex">
                <div class="media-body align-self-center mb-4 mb-lg-0">
                    <p class="banner__pretitle text-uppercase text-gray-400 font-weight-bold">Available Once a Year</p>
                    <h2 class="banner__title font-size-10 font-weight-bold text-white mb-4">Get 50% off on orders over $139</h2>
                    <a href="../shop/v7.html" class="banner_btn btn btn-wide btn-primary text-white">Explore Books</a>
                </div>
                <img src="http://placehold.it/400x200" class="img-fluid" alt="image-description">
            </div>
        </div>
    </div>
</div> --}}

<section class="space-bottom-3">
    <div class="container">
        <header class="border-bottom mb-8d75 pb-4d75">
            <h2 class="font-size-7 mb-0">Most Popular Books</h2>
        </header>
        <div class="js-slick-carousel products list-unstyled no-gutters my-0"
            data-pagi-classes="d-lg-none text-center u-slick__pagination u-slick__pagination mt-5 mb-0"
            data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow-centered--y rounded-circle"
            data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-xl-n10"
            data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-xl-n10"
            data-slides-show="5"
            data-responsive='[{
               "breakpoint": 1500,
               "settings": {
                 "slidesToShow": 4
               }
            }, {
               "breakpoint": 992,
               "settings": {
                 "slidesToShow": 3
               }
            }, {
               "breakpoint": 554,
               "settings": {
                 "slidesToShow": 2
               }
            }]'>
            @foreach ($biographiesBook as $product)
            <div class="product product__no-border border-right">
                <div class="product__inner overflow-hidden px-3 px-md-4d875">
                    <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                        <div class="woocommerce-loop-product__thumbnail">
                            <a href="{{ route('front.product.single', $product->id) }}" class="d-block"><img src="http://placehold.it/120x180" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                        </div>
                        <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                            <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="{{ route('front.product.single', $product->id) }}">Paperback</a></div>
                            <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark">
                                <a href="{{ route('front.product.single', $product->id) }}">{{ $product->translateorNew($lang)->name }}</a>
                            </h2>
                            <div class="font-size-2  mb-1 text-truncate">
                                <a href="../others/authors-single.html" class="text-gray-700">{{ $product->authorName() }}</a>
                            </div>
                            <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                <span class="woocommerce-Price-amount amount">@money_format($product->bookPrice()) {{ $currency }}</span>
                            </div>
                            <!-- <div class="product__rating d-flex align-items-center font-size-2">
                                <div class="text-warning mr-2">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="far fa-star"></small>
                                    <small class="far fa-star"></small>
                                </div>
                                <div class="">(3,714)</div>
                            </div> -->
                        </div>
                        <div class="product__hover d-flex align-items-center">
                            <a href="{{ route('front.product.single', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                <span class="product__add-to-cart">ADD TO CART</span>
                                <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                            </a>
                            <a href="{{ route('front.product.single', $product->id) }}" class="mr-1 h-p-bg btn btn-outline-primary-green border-0">
                                <i class="flaticon-switch"></i>
                            </a>
                            <a href="{{ route('front.product.single', $product->id) }}" class="h-p-bg btn btn-outline-primary-green border-0">
                                <i class="flaticon-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="space-bottom-3">
    <div class="container">
        <header class="border-bottom d-md-flex justify-content-between align-items-center mb-8 pb-4d75">
            <h2 class="font-size-7 mb-3 mb-md-0">Biographies Book</h2>
            <a href="../shop/v2.html" class="h-primary d-block">View All <i class="glyph-icon flaticon-next"></i></a>
        </header>
        <div class="js-slick-carousel u-slick products"
            data-pagi-classes="text-center u-slick__pagination mt-8"
            data-slides-show="3"
            data-responsive='[{
               "breakpoint": 1199,
               "settings": {
                 "slidesToShow": 2
               }
            }, {
               "breakpoint": 768,
               "settings": {
                 "slidesToShow": 1
               }
            }, {
               "breakpoint": 554,
               "settings": {
                 "slidesToShow": 1
               }
            }]'>
            @foreach ($biographiesBook as $product)
            <div class="product product__card product__card-v2 border-right">
                <div class="media p-3 p-md-4d875">
                    <a href="{{ route('front.product.single', $product->id) }}" class="d-block" tabindex="0"><img src="http://placehold.it/120x183" alt="image-description"></a>
                    <div class="media-body ml-4d875">
                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="{{ route('front.product.single', $product->id) }}" tabindex="0">Hard Cover</a></div>
                        <h2 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark">
                            <a href="{{ route('front.product.single', $product->id) }}" tabindex="0">{{ $product->translateorNew($lang)->name }}</a>
                        </h2>
                        <div class="font-size-2 mb-1 text-truncate">
                            <a href="../others/authors-single.html" class="text-gray-700" tabindex="0">{{ $product->authorName() }}</a>
                        </div>
                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                            <span class="woocommerce-Price-amount amount">@money_format($product->bookPrice()) {{ $currency }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<div class="site-features border-top space-1d625">
    <div class="container">
        <ul class="list-unstyled my-0 list-features d-flex align-items-center justify-content-xl-between overflow-auto overflow-xl-visible">
            <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                <div class="media">
                    <div class="feature__icon font-size-14 text-primary text-lh-xs">
                        <i class="glyph-icon flaticon-delivery"></i>
                    </div>
                    <div class="media-body ml-4">
                        <h4 class="feature__title font-size-3">Free Delivery</h4>
                        <p class="feature__subtitle m-0">Orders over $100</p>
                    </div>
                </div>
            </li>
            <li class="flex-shrink-0 flex-xl-shrink-1 separator mx-4 mx-xl-0 border-left h-fixed-80" aria-hidden="true" role="presentation"></li>
            <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                <div class="media">
                    <div class="feature__icon font-size-14 text-primary text-lh-xs">
                        <i class="glyph-icon flaticon-credit"></i>
                    </div>
                    <div class="media-body ml-4">
                        <h4 class="feature__title font-size-3">Secure Payment</h4>
                        <p class="feature__subtitle m-0">100% Secure Payment</p>
                    </div>
                </div>
            </li>
            <li class="flex-shrink-0 flex-xl-shrink-1 separator mx-4 mx-xl-0 border-left h-fixed-80" aria-hidden="true" role="presentation"></li>
            <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                <div class="media">
                    <div class="feature__icon font-size-14 text-primary text-lh-xs">
                        <i class="glyph-icon flaticon-warranty"></i>
                    </div>
                    <div class="media-body ml-4">
                        <h4 class="feature__title font-size-3">Money Back Guarantee</h4>
                        <p class="feature__subtitle m-0">Within 30 Days</p>
                    </div>
                </div>
            </li>
            <li class="flex-shrink-0 flex-xl-shrink-1 separator mx-4 mx-xl-0 border-left h-fixed-80" aria-hidden="true" role="presentation"></li>
            <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                <div class="media">
                    <div class="feature__icon font-size-14 text-primary text-lh-xs">
                        <i class="glyph-icon flaticon-help"></i>
                    </div>
                    <div class="media-body ml-4">
                        <h4 class="feature__title font-size-3">24/7 Support</h4>
                        <p class="feature__subtitle m-0">Within 1 Business Day</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<!--====== END MAIN CONTENT =====-->

@endsection
