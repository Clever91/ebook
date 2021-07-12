@extends('layouts.front.front')

@section('title', 'Authors')

@push('stylesheets')
    <!-- CSS Custom -->
    <link rel="stylesheet" href="{{ asset('front/assets/vendor/fancybox/jquery.fancybox.css') }}">
@endpush

@section('content')

<!-- ====== MAIN CONTENT ====== -->
@include('layouts.front.breadcrumb', [
    'title' => $product->translateorNew($lang)->name,
    'links' => [
        [
            'title' => "Home",
            'url' => route("front.home"),
        ],
        [
            'title' => "Shop",
            'url' => route("front.home"),
            'end' => $product->translateorNew($lang)->name,
        ]
    ]
])

<div class="site-content" id="content">
    <div class="container">
        <div class="row  space-top-2">
            <div id="primary" class="content-area">
                <main id="main" class="site-main ">
                    <div class="product">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
                                    <figure class="woocommerce-product-gallery__wrapper mb-0">
                                        <div class="js-slick-carousel u-slick"
                                        data-pagi-classes="text-center u-slick__pagination my-4">
                                            <div class="js-slide">
                                                <img src="{{ $product->getImageUrl('300x452') }}" alt="Image Description" class="mx-auto img-fluid">
                                            </div>
                                            <div class="js-slide">
                                                <img src="{{ $product->getImageUrl('300x452') }}" alt="Image Description" class="mx-auto img-fluid">
                                            </div>
                                            <div class="js-slide">
                                                <img src="{{ $product->getImageUrl('300x452') }}" alt="Image Description" class="mx-auto img-fluid">
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="col-lg-7 pl-lg-0 summary entry-summary">
                                    <div class="px-lg-4 px-xl-6">
                                        <h1 class="product_title entry-title font-size-7 mb-3">{{ $product->translateorNew($lang)->name }}</h1>
                                        <div class="font-size-2 mb-4">
                                            <span class="text-yellow-darker">
                                                <span class="fas fa-star"></span>
                                                <span class="fas fa-star"></span>
                                                <span class="fas fa-star"></span>
                                                <span class="fas fa-star"></span>
                                                <span class="fas fa-star"></span>
                                            </span>
                                            <span class="ml-3">(3,714)</span>
                                            <span class="ml-3 font-weight-medium">By (author)</span>
                                            <span class="ml-2 text-gray-600">{{ $product->authorName() }}</span>
                                        </div>

                                        <div class="woocommerce-product-details__short-description font-size-2 mb-4">
                                            <p class="">{{ $product->translateorNew($lang)->description }}</p>
                                        </div>

                                        <p class="price font-size-22 font-weight-medium mb-4">
                                            <span class="woocommerce-Price-amount amount">
                                                <span class="woocommerce-Price-currencySymbol">$</span>29.95
                                            </span> –
                                            <span class="woocommerce-Price-amount amount">
                                                <span class="woocommerce-Price-currencySymbol">$</span>59.95
                                            </span>
                                        </p>

                                        <div class="mb-4">
                                            <label class="form-label font-size-2 font-weight-medium mb-3">Book Format</label>
                                            <!-- Select -->
                                            <select class="js-select selectpicker dropdown-select w-100 position-relative"
                                                data-style=" border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2"
                                                data-show-subtext="true"
                                                data-dropdown-align-right="true">
                                                @foreach ($product->booksBySort() as $index => $book)
                                                    @if ($index == 0)
                                                <option value="{{ $book->id }}" data-subtext="{{ $book->price }}" selected>{{ $book->getBtnLabel($lang) }}</option>
                                                    @else
                                                <option value="{{ $book->id }}" data-subtext="{{ $book->price }}">{{ $book->getBtnLabel($lang) }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <!-- End Select -->
                                        </div>

                                        <form class="cart d-md-flex align-items-center" method="post" enctype="multipart/form-data">
                                            <div class="quantity mb-4 mb-md-0 d-flex align-items-center">
                                                <!-- Quantity -->
                                                <div class="border px-3 width-120">
                                                    <div class="js-quantity">
                                                        <div class="d-flex align-items-center">
                                                            <label class="screen-reader-text sr-only">Quantity</label>
                                                            <a class="js-minus text-dark" href="javascript:;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10px" height="1px">
                                                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M-0.000,-0.000 L10.000,-0.000 L10.000,1.000 L-0.000,1.000 L-0.000,-0.000 Z" />
                                                                </svg>
                                                            </a>
                                                            <input type="number" class="input-text qty text js-result form-control text-center border-0" step="1" min="1" max="100" name="quantity" value="1" title="Qty">
                                                            <a class="js-plus text-dark" href="javascript:;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10px" height="10px">
                                                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M10.000,5.000 L6.000,5.000 L6.000,10.000 L5.000,10.000 L5.000,5.000 L-0.000,5.000 L-0.000,4.000 L5.000,4.000 L5.000,-0.000 L6.000,-0.000 L6.000,4.000 L10.000,4.000 L10.000,5.000 Z" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Quantity -->
                                            </div>

                                            <button type="submit" name="add-to-cart" value="7145" class="btn btn-dark border-0 rounded-0 p-3 btn-block ml-md-4 single_add_to_cart_button button alt">Add to cart</button>

                                        </form>
                                    </div>
                                    <div class="px-lg-4 px-xl-7 py-5 d-flex align-items-center">
                                        <ul class="list-unstyled nav">
                                            <li class="mr-6 mb-4 mb-md-0">
                                                <a href="#" class="h-primary"><i class="flaticon-heart mr-2"></i> Add to Wishlist</a>
                                            </li>
                                            <li class="mr-6">
                                                <a href="#" class="h-primary"><i class="flaticon-share mr-2"></i> Share</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features Section -->
                        <div class="woocommerce-tabs wc-tabs-wrapper mb-10 row">
                            <!-- Nav Classic -->
                            <ul class="col-lg-4 col-xl-3 pt-9 border-top d-lg-block tabs wc-tabs nav justify-content-lg-center flex-nowrap flex-lg-wrap overflow-auto overflow-lg-visble" id="pills-tab" role="tablist">
                                <li class="flex-shrink-0 flex-lg-shrink-1 nav-item mb-3">
                                    <a class="py-1 d-inline-block nav-link font-weight-medium active" id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab" aria-controls="pills-one-example1" aria-selected="true">
                                        Description
                                    </a>
                                </li>
                                <li class="flex-shrink-0 flex-lg-shrink-1 nav-item mb-3">
                                    <a class="py-1 d-inline-block nav-link font-weight-medium" id="pills-two-example1-tab" data-toggle="pill" href="#pills-two-example1" role="tab" aria-controls="pills-two-example1" aria-selected="false">
                                        Product Details
                                    </a>
                                </li>
                                <li class="flex-shrink-0 flex-lg-shrink-1 nav-item mb-3">
                                    <a class="py-1 d-inline-block nav-link font-weight-medium" id="pills-three-example1-tab" data-toggle="pill" href="#pills-three-example1" role="tab" aria-controls="pills-three-example1" aria-selected="false">
                                        Videos
                                    </a>
                                </li>
                                <li class="flex-shrink-0 flex-lg-shrink-1 nav-item mb-3">
                                    <a class="py-1 d-inline-block nav-link font-weight-medium" id="pills-four-example1-tab" data-toggle="pill" href="#pills-four-example1" role="tab" aria-controls="pills-four-example1" aria-selected="false">
                                        Reviews (0)
                                    </a>
                                </li>
                            </ul>
                            <!-- End Nav Classic -->

                            <!-- Tab Content -->
                            <div class="tab-content col-lg-8 col-xl-9 border-top" id="pills-tabContent">
                                <div class="woocommerce-Tabs-panel panel entry-content wc-tab tab-pane fade border-left pl-4 pt-4 pl-lg-6 pt-lg-6 pl-xl-9 pt-xl-9 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab">
                                    <!-- Mockup Block -->
                                    {{ $product->translateorNew($lang)->description }}
                                    <!-- End Mockup Block -->
                                </div>
                                <div class="woocommerce-Tabs-panel panel entry-content wc-tab tab-pane fade border-left pl-4 pt-4 pl-lg-6 pt-lg-6 pl-xl-9 pt-xl-9" id="pills-two-example1" role="tabpanel" aria-labelledby="pills-two-example1-tab">
                                    <!-- Mockup Block -->
                                    @foreach ($product->booksBySort() as $index => $book)
                                        @php
                                            $class = "hide";
                                            if ($index == 0) {
                                                $class = "show";
                                            } else {
                                                continue;
                                            }
                                        @endphp
                                    <div class="table-responsive mb-4 {{ $class }}">
                                        <table class="table table-hover table-borderless">
                                            <tbody>
                                                @if (!is_null($book->detail))
                                                <tr>
                                                    <th class="px-4 px-xl-5">Format: </th>
                                                    <td class="">Paperback | {{ $book->detail->page_count }} pages</td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 px-xl-5">Dimensions</th>
                                                    <td>{{ $book->paperSize() }} | {{ $book->detail->weight }}g</td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 px-xl-5">Publication date: </th>
                                                    <td>{{ $book->detail->year }} year</td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 px-xl-5">Publisher:</th>
                                                    <td>{{ $book->detail->publisher }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 px-xl-5">Imprint:</th>
                                                    <td>Corsair</td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 px-xl-5">Publication City/Country:</th>
                                                    <td>London, United Kingdom</td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 px-xl-5">Language:</th>
                                                    <td>English</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                    <!-- End Mockup Block -->
                                </div>
                                <div class="woocommerce-Tabs-panel panel entry-content wc-tab tab-pane fade border-left pl-4 pt-4 pl-lg-6 pt-lg-6 pl-xl-9 pt-xl-9" id="pills-three-example1" role="tabpanel" aria-labelledby="pills-three-example1-tab">
                                    <!-- Mockup Block -->
                                    <div class="d-flex mb-8 justify-content-center">
                                        <a href="javascript:;" class="product__video js-fancybox d-block p-4 border position-relative max-width-234"
                                            data-src="//www.youtube.com/watch?v=u-0Z0iVBxUY?autoplay=0"
                                            data-speed="700">
                                            <span class="position-absolute-center text-dark font-size-10"><i class="flaticon-multimedia"></i></span>
                                            <div class="hover-area">
                                                <img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto mb-3" alt="image-description">
                                                <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-dark">Where The Crawdads Sing Overview</h2>
                                                <div class="font-size-2 text-gray-700">Solomon</div>
                                            </div>
                                            <span class="text-white bg-dark px-3 py-1 position-absolute bottom-0 right-0">1:45</span>
                                        </a>
                                        <a href="javascript:;" class="product__video js-fancybox d-block p-4 border position-relative max-width-234"
                                            data-src="www.youtube.com/watch?v=F7yO1tYCYxQ?autoplay=0"
                                            data-speed="700">
                                            <span class="position-absolute-center text-dark font-size-10"><i class="flaticon-multimedia"></i></span>
                                            <div class="hover-area">
                                                <img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto mb-3" alt="image-description">
                                                <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-dark">Where The Crawdads Sing Overview</h2>
                                                <div class="font-size-2 text-gray-700">Solomon</div>
                                            </div>
                                            <span class="text-white bg-dark px-3 py-1 position-absolute bottom-0 right-0">2:21</span>
                                        </a>
                                    </div>
                                    <!-- End Mockup Block -->
                                </div>
                                <div class="woocommerce-Tabs-panel panel entry-content wc-tab tab-pane fade border-left pl-4 pt-4 pl-lg-6 pt-lg-6 pl-xl-9 pt-xl-9" id="pills-four-example1" role="tabpanel" aria-labelledby="pills-four-example1-tab">
                                    <!-- Mockup Block -->
                                    <h4 class="font-size-3">Customer Reviews </h4>
                                    <div class="mb-8">
                                        <div class="mb-6">
                                            <div class="d-flex  align-items-center mb-4">
                                                <span class="font-size-15 font-weight-bold">4.6</span>
                                                <div class="ml-3 h6 mb-0">
                                                    <span class="font-weight-normal">3,714 reviews</span>
                                                    <div class="text-yellow-darker">
                                                        <small class="fas fa-star"></small>
                                                        <small class="fas fa-star"></small>
                                                        <small class="fas fa-star"></small>
                                                        <small class="fas fa-star"></small>
                                                        <small class="far fa-star"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-xl-flex">
                                                <button type="button" class="d-block btn btn-outline-dark rounded-0 px-5 mb-3 mb-xl-0">See all reviews</button>
                                                <button type="button" class="d-block btn btn-dark ml-xl-3 rounded-0 px-5">Write a review</button>
                                            </div>
                                        </div>
                                        <div class="">
                                            <!-- Ratings -->
                                            <ul class="list-unstyled">
                                                <li class="py-2">
                                                    <a class="row align-items-center mx-gutters-2 font-size-2" href="javascript:;">
                                                        <div class="col-auto">
                                                            <span class="text-dark">5 stars</span>
                                                        </div>
                                                        <div class="col px-0">
                                                            <div class="progress bg-white-100" style="height: 7px;">
                                                                <div class="progress-bar bg-yellow-darker" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <span class="text-secondary">205</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="py-2">
                                                    <a class="row align-items-center mx-gutters-2 font-size-2" href="javascript:;">
                                                        <div class="col-auto">
                                                            <span class="text-dark">4 stars</span>
                                                        </div>
                                                        <div class="col px-0">
                                                            <div class="progress bg-white-100" style="height: 7px;">
                                                                <div class="progress-bar bg-yellow-darker" role="progressbar" style="width: 53%;" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <span class="text-secondary">55</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="py-2">
                                                    <a class="row align-items-center mx-gutters-2 font-size-2" href="javascript:;">
                                                        <div class="col-auto">
                                                            <span class="text-dark">3 stars</span>
                                                        </div>
                                                        <div class="col px-0">
                                                            <div class="progress bg-white-100" style="height: 7px;">
                                                                <div class="progress-bar bg-yellow-darker" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <span class="text-secondary">23</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="py-2">
                                                    <a class="row align-items-center mx-gutters-2 font-size-2" href="javascript:;">
                                                        <div class="col-auto">
                                                            <span class="text-dark">2 stars</span>
                                                        </div>
                                                        <div class="col px-0">
                                                            <div class="progress bg-white-100" style="height: 7px;">
                                                                <div class="progress-bar bg-yellow-darker" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <span class="text-secondary">0</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="py-2">
                                                    <a class="row align-items-center mx-gutters-2 font-size-2" href="javascript:;">
                                                        <div class="col-auto">
                                                            <span class="text-dark">1 stars</span>
                                                        </div>
                                                        <div class="col px-0">
                                                            <div class="progress bg-white-100" style="height: 7px;">
                                                                <div class="progress-bar bg-yellow-darker" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <span class="text-secondary">4</span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- End Ratings -->
                                        </div>
                                    </div>

                                    <h4 class="font-size-3 mb-8">1-5 of 44 reviews</h4>

                                    <ul class="list-unstyled mb-8">
                                        <li class="mb-4 pb-5 border-bottom">
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="mb-0">Amazing Story! You will LOVE it</h6>
                                                <div class="text-yellow-darker ml-3">
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="far fa-star"></small>
                                                </div>
                                            </div>
                                            <p class="mb-4 text-lh-md">Such an incredibly complex story! I had to buy it because there was a waiting list of 30+ at the local library for this book. Thrilled that I made the purchase</p>
                                            <div class="text-gray-600 mb-4">Staci, February 22, 2020 </div>
                                            <ul class="nav">
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-like-1"></i>
                                                        <span class="ml-2">90</span>
                                                    </a>
                                                </li>
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-dislike"></i>
                                                        <span class="ml-2">10</span>
                                                    </a>
                                                </li>
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-flag"></i>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li class="mb-4 pb-5 border-bottom">
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="mb-0">Get the best seller at a great price.</h6>
                                                <div class="text-yellow-darker ml-3">
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="far fa-star"></small>
                                                </div>
                                            </div>
                                            <p class="mb-4 text-lh-md">Awesome book, great price, fast delivery. Thanks so much.</p>
                                            <div class="text-gray-600 mb-4">Staci, February 22, 2020 </div>
                                            <ul class="nav">
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-like-1"></i>
                                                        <span class="ml-2">90</span>
                                                    </a>
                                                </li>
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-dislike"></i>
                                                        <span class="ml-2">10</span>
                                                    </a>
                                                </li>
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-flag"></i>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li class="mb-4 pb-5 border-bottom">
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="mb-0">I read this book short...</h6>
                                                <div class="text-yellow-darker ml-3">
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="far fa-star"></small>
                                                </div>
                                            </div>
                                            <p class="mb-4 text-lh-md">I read this book shortly after I got it and didn't just put it on my TBR shelf mainly because I saw it on Reese Witherspoon's bookclub September read. It was one of the best books I've read this year, and reminded me some of Kristen Hannah's The Great Alone. </p>
                                            <div class="text-gray-600 mb-4">Staci, February 22, 2020 </div>
                                            <ul class="nav">
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-like-1"></i>
                                                        <span class="ml-2">90</span>
                                                    </a>
                                                </li>
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-dislike"></i>
                                                        <span class="ml-2">10</span>
                                                    </a>
                                                </li>
                                                <li class="mr-7">
                                                    <a href="#" class="text-gray-600 d-flex align-items-center">
                                                        <i class="text-dark font-size-5 flaticon-flag"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>

                                    <h4 class="font-size-3 mb-4">Write a Review</h4>
                                    <div class="d-flex align-items-center mb-6">
                                        <h6 class="mb-0">Select a rating(required)</h6>
                                        <div class="text-yellow-darker ml-3 font-size-4">
                                            <small class="far fa-star"></small>
                                            <small class="far fa-star"></small>
                                            <small class="far fa-star"></small>
                                            <small class="far fa-star"></small>
                                            <small class="far fa-star"></small>
                                        </div>
                                    </div>
                                    <div class="js-form-message form-group mb-4">
                                        <label for="descriptionTextarea" class="form-label text-dark h6 mb-3">Details please! Your review helps other shoppers.</label>
                                        <textarea class="form-control rounded-0 p-4" rows="7" id="descriptionTextarea" placeholder="What did you like or dislike? What should other shoppers know before buying?" required data-msg="Please enter your message." data-error-class="u-has-error" data-success-class="u-has-success"></textarea>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label for="inputCompanyName" class="form-label text-dark h6 mb-3">Add a title</label>
                                        <input type="text" class="form-control rounded-0 px-4" name="companyName" id="inputCompanyName" placeholder="3000 characters remaining" aria-label="3000 characters remaining">
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-dark btn-wide rounded-0 transition-3d-hover">Submit Review</button>
                                    </div>
                                    <!-- End Mockup Block -->
                                </div>
                            </div>
                            <!-- End Tab Content -->
                        </div>
                        <!-- End Features Section -->

                    </div>
                </main>
            </div>
            <div id="secondary" class="sidebar widget-area order-1" role="complementary">
                <div id="widgetAccordion">
                    <div class="widget p-4d875 border mb-5">
                        <div class="mb-5">
                            <div class="media d-md-flex">
                                <a class="d-block" href="#">
                                    <img class="img-fluid" src="https://placehold.it/60x92" alt="Image-Description">
                                </a>
                                <div class="media-body ml-3 pl-1">
                                    <h6 class="font-size-2 text-lh-md font-weight-normal">
                                        <a href="#">Lessons Learned from  15 Years as CEO...</a>
                                    </h6>
                                    <span class="font-weight-medium">$37</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <div class="media d-md-flex">
                                <a class="d-block" href="#">
                                    <img class="img-fluid" src="https://placehold.it/60x92" alt="Image-Description">
                                </a>
                                <div class="media-body ml-3 pl-1">
                                    <h6 class="font-size-2 text-lh-md font-weight-normal">
                                        <a href="#">Love, Livestock, and Big Life Lessons...</a>
                                    </h6>
                                    <span class="font-weight-medium">$21</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media d-md-flex">
                                <a class="d-block" href="#">
                                    <img class="img-fluid" src="https://placehold.it/60x92" alt="Image-Description">
                                </a>
                                <div class="media-body ml-3 pl-1">
                                    <h6 class="font-size-2 text-lh-md font-weight-normal">
                                        <a href="#">Sleeper Cells, Ghost Stories, and Hunt...</a>
                                    </h6>
                                    <span class="font-weight-medium">$182</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="widget border mb-5">
                        <!-- Features Section -->
                        <div class="site-features">
                            <ul class="list-unstyled my-0 list-features">
                                <li class="list-feature p-4d875">
                                    <div class="media d-md-block d-xl-flex text-center text-xl-left">
                                        <div class="feature__icon font-size-10 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                            <i class="glyph-icon flaticon-delivery"></i>
                                        </div>
                                        <div class="media-body ml-xl-4">
                                            <h4 class="feature__title h6 mb-1 text-dark">Free Delivery</h4>
                                            <p class="feature__subtitle m-0 text-dark">Orders over $100</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-feature p-4d875 border-top">
                                    <div class="media  d-md-block d-xl-flex text-center text-xl-left">
                                        <div class="feature__icon font-size-10 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                            <i class="glyph-icon flaticon-credit"></i>
                                        </div>
                                        <div class="media-body ml-xl-4">
                                            <h4 class="feature__title h6 mb-1 text-dark">Secure Payment</h4>
                                            <p class="feature__subtitle m-0 text-dark">100% Secure Payment</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-feature p-4d875 border-top">
                                    <div class="media  d-md-block d-xl-flex text-center text-xl-left">
                                        <div class="feature__icon font-size-10 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                            <i class="glyph-icon flaticon-warranty"></i>
                                        </div>
                                        <div class="media-body ml-xl-4">
                                            <h4 class="feature__title h6 mb-1 text-dark">Money Back Guarantee</h4>
                                            <p class="feature__subtitle m-0 text-dark">Within 30 Days</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-feature p-4d875 border-top">
                                    <div class="media d-md-block d-xl-flex text-center text-xl-left">
                                        <div class="feature__icon font-size-10 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                            <i class="glyph-icon flaticon-help"></i>
                                        </div>
                                        <div class="media-body ml-xl-4">
                                            <h4 class="feature__title h6 mb-1 text-dark">24/7 Support</h4>
                                            <p class="feature__subtitle m-0 text-dark">Within 1 Business Day</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- End Features Section -->
                    </div> --}}
                </div>
            </div>
        </div>
        <section class="space-bottom-3">
            <div class="container">
                <header class="mb-5 d-md-flex justify-content-between align-items-center">
                    <h2 class="font-size-7 mb-3 mb-md-0">Customers Also Considered</h2>
                </header>

                 <div class="js-slick-carousel products no-gutters border-top border-left border-right"
                        data-arrows-classes="u-slick__arrow u-slick__arrow-centered--y"
                        data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n10"
                        data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n10"
                        data-slides-show="5"
                        data-responsive='[{
                           "breakpoint": 1500,
                           "settings": {
                             "slidesToShow": 4
                           }
                        },{
                           "breakpoint": 1199,
                           "settings": {
                             "slidesToShow": 3
                           }
                        }, {
                           "breakpoint": 992,
                           "settings": {
                             "slidesToShow": 2
                           }
                        }, {
                           "breakpoint": 554,
                           "settings": {
                             "slidesToShow": 2
                           }
                        }]'>
                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Paperback</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">Think Like a Monk: Train Your Mind for Peace and Purpose Everyday</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Jay Shetty</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Kindle Edition</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">The Overdue Life of Amy Byler</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Kelly Harms</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Paperback</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">All You Can Ever Know: A Memoir</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Jay Shetty</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Kindle Edition</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">The Last Sister (Columbia River Book 1)</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Kelly Harms</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Paperback</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">Think Like a Monk: Train Your Mind for Peace and Purpose Everyday</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Jay Shetty</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Kindle Edition</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">The Overdue Life of Amy Byler</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Kelly Harms</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Paperback</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">All You Can Ever Know: A Memoir</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Jay Shetty</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product">
                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                    <div class="woocommerce-loop-product__thumbnail">
                                        <a href="../shop/single-product-v7.html" class="d-block"><img src="https://placehold.it/120x180" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="../shop/single-product-v7.html">Kindle Edition</a></div>
                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="../shop/single-product-v7.html">The Last Sister (Columbia River Book 1)</a></h2>
                                        <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Kelly Harms</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>29</span>
                                        </div>
                                    </div>
                                    <div class="product__hover d-flex align-items-center">
                                        <a href="../shop/single-product-v7.html" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                            <span class="product__add-to-cart">ADD TO CART</span>
                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-switch"></i>
                                        </a>
                                        <a href="../shop/single-product-v7.html" class="h-p-bg btn btn-outline-primary border-0">
                                            <i class="flaticon-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- ====== END MAIN CONTENT ====== -->

@endsection

@push('scripts')
{{-- JS Custom --}}
<script src="{{ asset('front/assets/vendor/appear.js') }}"></script>
<script src="{{ asset('front/assets/vendor/fancybox/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('front/assets/vendor/hs-megamenu/src/hs.megamenu.js') }}"></script>

<script src="{{ asset('front/assets/js/components/hs.fancybox.js') }}"></script>
<script src="{{ asset('front/assets/js/components/hs.onscroll-animation.js') }}"></script>
<script src="{{ asset('front/assets/js/components/hs.quantity-counter.js') }}"></script>
<script src="{{ asset('front/assets/js/components/hs.scroll-nav.js') }}"></script>
<script>
    $(document).on('ready', function () {
        // initialization of select picker
        $.HSCore.components.HSSelectPicker.init('.js-select');

        // initialization of popups
        $.HSCore.components.HSFancyBox.init('.js-fancybox');

        // initialization of quantity counter
        $.HSCore.components.HSQantityCounter.init('.js-quantity');

        // initialization of HSScrollNav component
        $.HSCore.components.HSScrollNav.init($('.js-scroll-nav'), {
          duration: 700
        });
    });
</script>
@endpush
