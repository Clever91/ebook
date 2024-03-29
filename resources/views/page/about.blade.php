@extends('layouts.front.front')

@section('title', 'About Us')

@section('content')

<!-- ====== MAIN CONTENT ===== -->
<main id="content">
    <div class="mb-5 space-bottom-lg-3">
        <div class="py-3 py-lg-7">
            <h6 class="font-weight-medium font-size-7 text-center my-1">About Us</h6>
        </div>
        <img class="img-fluid" src="{{ asset('front/images/about.jpg') }}" alt="Image-Description">
        {{-- <img class="img-fluid" src="{{ asset('front/assets/img/1800x500/img1.jpg') }}" alt="Image-Description"> --}}
        <div class="container">
            <div class="mb-lg-8">
                <div class="col-lg-9 mx-auto">
                    <div class="bg-white mt-n10 mt-md-n13 pt-5 pt-lg-7 px-3 px-md-5 pl-xl-10 pr-xl-4">
                        <div class="mb-4 mb-lg-7 ml-xl-4">
                            <h6 class="font-weight medium font-size-10 mb-4 mb-lg-7">Welcome to Book Market 24</h6>
                            <p class="font-weight-medium font-italic">“ Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model search for eolved over sometimes by accident, sometimes on purpose ”</p>
                        </div>
                        <div class="mb-4 pb-xl-1 ml-xl-4">
                            <h6 class="font-weight-medium font-size-4 mb-4">What we really do?</h6>
                            <p class="font-size-2">Mauris tempus erat laoreet turpis lobortis, eu tincidunt erat fermentum. Aliquam non tincidunt urna. Integer tincidunt nec nisl vitae ullamcorper. Proin sed ultrices erat. Praesent varius ultrices massa at faucibus. Aenean dignissim, orci sed faucibus pharetra, dui mi dignissim tortor, sit amet condimentum mi ligula sit amet augue. Pellentesque vitae eros eget enim mollis placerat. Aliquam non tincidunt urna. Integer tincidunt nec nisl vitae ullamcorper. Proin sed ultrices erat. Praesent varius ultrices massa at faucibus. Aenean dignissim, orci sed faucibus pharetra, dui mi dignissim tortor, sit amet condimentum mi ligula sit amet augue. Pellentesque vitae eros eget enim mollis placerat.</p>
                        </div>
                        <div class="ml-xl-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-medium font-size-4">Our Vision</h6>
                                    <p class="font-size-2">Pellentesque sodales augue eget ultricies ultricies. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur sagittis ultrices condimentum.</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="font-weight-medium font-size-4">Our Vision</h6>
                                    <p class="font-size-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit metus mauris, tristique quis sapien eu, rutrum vulputate enim.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-5 mb-lg-7">
                <div class="d-md-flex align-items-center justify-content-between px-xl-10">
                    <div class="text-center mb-3 mb-md-0">
                        <div class="font-size-12 font-weight-medium ml-lg-2">45M</div>
                        <span class="font-size-4">Active Readers</span>
                    </div>
                    <div class="text-center mb-3 mb-md-0">
                        <div class="font-size-12 font-weight-medium ml-2">+6k</div>
                        <span class="font-size-4">Total Pages</span>
                    </div>
                    <div class="text-center mb-3 mb-md-0">
                        <div class="font-size-12 font-weight-medium ">30.6M</div>
                        <span class="font-size-4">Buyers Activie</span>
                    </div>
                    <div class="text-center mb-0">
                        <div class="font-size-12 font-weight-medium ml-2">283</div>
                        <span class="font-size-4">Cup Of Coffe</span>
                    </div>
                </div>
            </div>
            <div class="mb-5 mb-lg-10">
                <h6 class="font-weight-medium font-size-7 mb-5 mb-lg-6">Why We</h6>
                <ul class="list-unstyled my-0 list-features row d-md-flex">
                    <li class="list-feature mb-5 mb-lg-0 col-md-6 col-lg-3">
                        <div class="media flex-column align-items-center align-items-md-start pr-xl-3">
                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3">
                                <i class="glyph-icon flaticon-delivery"></i>
                            </div>
                            <div class="media-body text-center text-md-left">
                                <h4 class="feature__title font-size-3 text-dark">Free Delivery</h4>
                                <p class="feature__subtitle m-0 text-dark">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu.</p>
                            </div>
                        </div>
                    </li>
                    <li class="list-feature  mb-5 mb-lg-0 col-md-6 col-lg-3">
                        <div class="media flex-column align-items-center align-items-md-start pr-xl-3">
                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3">
                                <i class="glyph-icon flaticon-credit"></i>
                            </div>
                            <div class="media-body text-center text-md-left">
                                <h4 class="feature__title font-size-3 text-dark">Secure Payment</h4>
                                <p class="feature__subtitle m-0 text-dark">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu.</p>
                            </div>
                        </div>
                    </li>
                    <li class="list-feature  mb-5 mb-md-0 col-md-6 col-lg-3">
                        <div class="media flex-column align-items-center align-items-md-start pr-xl-3">
                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3">
                                <i class="glyph-icon flaticon-warranty"></i>
                            </div>
                            <div class="media-body text-center text-md-left">
                                <h4 class="feature__title font-size-3 text-dark">Money Back Guarantee</h4>
                                <p class="feature__subtitle m-0 text-dark">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu.</p>
                            </div>
                        </div>
                    </li>
                    <li class="list-feature  mb-5 mb-md-0 col-md-6 col-lg-3">
                        <div class="media flex-column align-items-center align-items-md-start pr-xl-3">
                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3">
                                <i class="glyph-icon flaticon-help"></i>
                            </div>
                            <div class="media-body text-center text-md-left">
                                <h4 class="feature__title font-size-3 text-dark">24/7 Support</h4>
                                <p class="feature__subtitle m-0 text-dark">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu.</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="mb-10 pb-md-6 pb-lg-10">
                <h6 class="font-weight-medium font-size-7 mb-5">Our Team</h6>
                <div class="js-slick-carousel u-slick" data-pagi-classes="text-center u-slick__pagination mt-md-8 mt-4 position-absolute right-0 left-0"
                    data-slides-show="5"
                    data-responsive='[{
                        "breakpoint": 992,
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
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://demo2.madrasthemes.com/bookworm-html/redesigned-octo-fiesta/assets/img/329x330/img2.png" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Anna Baranov</h6>
                                <span class="font-size-2 text-secondary-gray-700">Client Care</span>
                            </div>
                        </div>
                    </div>
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border border-left-0 pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://placehold.it/180x320" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Thomas Snow</h6>
                                <span class="font-size-2 text-secondary-gray-700">CEO/Founder</span>
                            </div>
                        </div>
                    </div>
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border border-left-0 pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://placehold.it/180x320" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Andre Kowalsy</h6>
                                <span class="font-size-2 text-secondary-gray-700">Support Boss</span>
                            </div>
                        </div>
                    </div>
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border border-left-0 pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://placehold.it/180x320" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Pamela Doe</h6>
                                <span class="font-size-2 text-secondary-gray-700">Delivery Driver</span>
                            </div>
                        </div>
                    </div>
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border border-left-0 pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://placehold.it/180x320" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Susan McCain</h6>
                                <span class="font-size-2 text-secondary-gray-700">Packaging Girl</span>
                            </div>
                        </div>
                    </div>
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border border-left-0 pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://placehold.it/180x320" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Andre Kowalsy</h6>
                                <span class="font-size-2 text-secondary-gray-700">Support Boss</span>
                            </div>
                        </div>
                    </div>
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border border-left-0 pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://placehold.it/180x320" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Pamela Doe</h6>
                                <span class="font-size-2 text-secondary-gray-700">Delivery Driver</span>
                            </div>
                        </div>
                    </div>
                    <div class="product__inner overflow-hidden">
                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                            <div class="woocommerce-loop-product__thumbnail border border-left-0 pt-5 mb-3">
                                <a href="#" class="d-block"><img src="https://placehold.it/180x320" class="img-fluid mx-auto d-block attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description"></a>
                            </div>

                            <div class="woocommerce-loop-product__body product__body">
                                <h6 class="font-weight-regular mb-1">Thomas Snow</h6>
                                <span class="font-size-2 text-secondary-gray-700">CEO/Founder</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h6 class="font-weight-medium font-size-7 mb-4 mb-lg-9">Company Partners</h6>
                <div class="d-lg-flex align-items-center justify-content-between">
                    <div class="text-center mb-5 mb-lg-0">
                        <img class="img-fluid" src="https://demo2.madrasthemes.com/bookworm-html/redesigned-octo-fiesta/assets/img/150x32/img1.png" alt="Image-Description">
                    </div>
                    <div class="text-center mb-5 mb-lg-0">
                        <img class="img-fluid" src="http://placehold.it/150x32" alt="Image-Description">
                    </div>
                    <div class="text-center mb-5 mb-lg-0">
                        <img class="img-fluid" src="http://placehold.it/150x32" alt="Image-Description">
                    </div>
                    <div class="text-center mb-5 mb-lg-0">
                        <img class="img-fluid" src="http://placehold.it/150x32" alt="Image-Description">
                    </div>
                    <div class="text-center mb-5 mb-lg-0">
                        <img class="img-fluid" src="http://placehold.it/150x32" alt="Image-Description">
                    </div>
                    <div class="text-center mb-5 mb-lg-0">
                        <img class="img-fluid" src="http://placehold.it/150x32" alt="Image-Description">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- ====== END MAIN CONTENT ===== -->

@endsection
