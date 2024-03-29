<aside id="sidebarContent" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler">
    <div class="u-sidebar__scroller">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">
                <!-- Toggle Button -->
                <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                    <button type="button" class="close ml-auto"
                        aria-controls="sidebarContent"
                        aria-haspopup="true"
                        aria-expanded="false"
                        data-unfold-event="click"
                        data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebarContent"
                        data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInRight"
                        data-unfold-animation-out="fadeOutRight"
                        data-unfold-duration="500">
                        <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                    </button>
                </div>
                <!-- End Toggle Button -->

                <!-- Content -->
                <div class="js-scrollbar u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">
                        <form class="">
                            <!-- Login -->
                            <div id="login" data-target-group="idForm">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-user mr-3 font-size-5"></i>Account</h2>
                                </header>
                                <!-- End Title -->

                                <div class="p-4 p-md-6">
                                    <!-- Form Group -->
                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel" class="form-label" for="signinEmail">Username or email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel" required>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinPasswordLabel" class="form-label" for="signinPassword">Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="signinPassword" placeholder="" aria-label="" aria-describedby="signinPasswordLabel" required>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <div class="d-flex justify-content-between mb-5 align-items-center">
                                        <!-- Checkbox -->
                                        <div class="js-form-message">
                                            <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" required>
                                                <label class="custom-control-label" for="termsCheckbox">
                                                    <span class="font-size-2 text-secondary-gray-700">
                                                        Remember me
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- End Checkbox -->

                                        <a class="js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium" href="javascript:;"
                                        data-target="#forgotPassword"
                                        data-link-group="idForm"
                                        data-animation-in="fadeIn">Forgot Password?</a>
                                    </div>

                                    <div class="mb-4d75">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Sign In</button>
                                    </div>

                                    <div class="mb-2">
                                        <a href="javascript:;" class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
                                        data-target="#signup"
                                        data-link-group="idForm"
                                        data-animation-in="fadeIn">Create Account</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Signup -->
                            <div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-resume mr-3 font-size-5"></i>Create Account</h2>
                                </header>
                                <!-- End Title -->

                                <div class="p-4 p-md-6">
                                    <!-- Form Group -->
                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel1" class="form-label" for="signinEmail1">Email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail1" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel1" required>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinPasswordLabel1" class="form-label" for="signinPassword1">Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="signinPassword1" placeholder="" aria-label="" aria-describedby="signinPasswordLabel1" required>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signupConfirmPasswordLabel" class="form-label" for="signupConfirmPassword">Confirm Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4" name="confirmPassword" id="signupConfirmPassword" placeholder="" aria-label="" aria-describedby="signupConfirmPasswordLabel" required>
                                        </div>
                                    </div>
                                    <!-- End Input -->

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Create Account</button>
                                    </div>

                                    <div class="text-center mb-4">
                                        <span class="small text-muted">Already have an account?</span>
                                        <a class="js-animation-link small" href="javascript:;"
                                            data-target="#login"
                                            data-link-group="idForm"
                                            data-animation-in="fadeIn">Login
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Signup -->

                            <!-- Forgot Password -->
                            <div id="forgotPassword" style="display: none; opacity: 0;" data-target-group="idForm">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-question mr-3 font-size-5"></i>Forgot Password?</h2>
                                </header>
                                <!-- End Title -->

                                <div class="p-4 p-md-6">
                                    <!-- Form Group -->
                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel3" class="form-label" for="signinEmail3">Email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail3" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel3" required>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Recover Password</button>
                                    </div>

                                    <div class="text-center mb-4">
                                        <span class="small text-muted">Remember your password?</span>
                                        <a class="js-animation-link small" href="javascript:;"
                                            data-target="#login"
                                            data-link-group="idForm"
                                            data-animation-in="fadeIn">Login
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Forgot Password -->
                        </form>
                    </div>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </div>
</aside>
