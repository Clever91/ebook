@extends('adminlte::master')

@section('adminlte_css_pre')
    {{-- <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
@stop

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', 'login-page')

@section('body')
    
    <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>

    <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-analytics.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-firestore.js"></script>

    <script src="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.css" />

    <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyBCK4OJ96yNhSCrs8QjveUb3qjunbGOhpU",
        authDomain: "ebook-27f01.firebaseapp.com",
        databaseURL: "https://ebook-27f01.firebaseio.com",
        projectId: "ebook-27f01",
        storageBucket: "ebook-27f01.appspot.com",
        messagingSenderId: "396964778551",
        appId: "1:396964778551:web:24ff3488f28efc3a8a65b2",
        measurementId: "G-XYTRGQ9995"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
        
        // Initialize the FirebaseUI Widget using Firebase.
        var ui = new firebaseui.auth.AuthUI(firebase.auth());

        var uiConfig = {
            callbacks: {
                signInSuccessWithAuthResult: function(authResult, redirectUrl) {
                // User successfully signed in.
                // Return type determines whether we continue the redirect automatically
                // or whether we leave that to developer to handle.
                return true;
                },
                uiShown: function() {
                // The widget is rendered.
                // Hide the loader.
                document.getElementById('loader').style.display = 'none';
                }
            },
            // Will use popup for IDP Providers sign-in flow instead of the default, redirect.
            signInFlow: 'popup',
            signInSuccessUrl: '/home',
            signInOptions: [
                // Leave the lines as is for the providers you want to offer your users.
                firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                firebase.auth.FacebookAuthProvider.PROVIDER_ID,
                firebase.auth.TwitterAuthProvider.PROVIDER_ID,
                firebase.auth.GithubAuthProvider.PROVIDER_ID,
                firebase.auth.EmailAuthProvider.PROVIDER_ID,
                firebase.auth.PhoneAuthProvider.PROVIDER_ID
            ],
            provider: firebase.auth.EmailAuthProvider.PROVIDER_ID,
            signInMethod: firebase.auth.EmailAuthProvider.EMAIL_LINK_SIGN_IN_METHOD,
            // Terms of service url.
            tosUrl: '/',
            // Privacy policy url.
            privacyPolicyUrl: '/'
        };

        // The start method will wait until the DOM is loaded.
        ui.start('#firebaseui-auth-container', uiConfig);


    </script>

    <!-- The surrounding HTML is left untouched by FirebaseUI.
        Your app may use that space for branding, controls and other customizations.-->
    <h1>Welcome to My Awesome App</h1>
    <div id="firebaseui-auth-container"></div>
    <div id="loader">Loading...</div>

@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop

@section('js')

@stop