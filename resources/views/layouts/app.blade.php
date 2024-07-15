<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bulletin Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('img/mtmLogo.png') }}" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        {!! file_get_contents(public_path('css/style.css')) !!} 
    </style>
</head>

<body>
    <!-- New header section -->
    <header class="bg-white py-2">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}">
                <div class="d-flex align-items-center">
                    <img src="../img/mtmLogo.png" alt="Company Logo" height="70" class="d-inline-block align-middle">
                    <h1 class="ms-3 mb-0 align-middle">MTM Bulletinboard</h1>
                </div>
            </a>
            <div>
                @guest
                    <a href="{{ route('signup.form') }}" class="btn btn-outline-dark me-2">Sign Up</a>
                    <a href="{{ route('login.index') }}" class="btn btn-outline-dark">Log In</a>
                @endguest
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" id="languageDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ENG
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="#">English</a></li>
                            <li><a class="dropdown-item" href="#">日本語</a></li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
        @include('layouts.navbar')
    </header>

    {{--@include('layouts.navbar')--}}

    <main class="container py-3">
        @yield('body')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item');

            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            const dropdownItems = document.querySelectorAll('.dropdown-item');

        dropdownItems.forEach(item => {
            item.addEventListener('click', function () {
                // Remove active class from all dropdown items
                dropdownItems.forEach(i => i.classList.remove('active'));

                // Add active class to the clicked item
                this.classList.add('active');
            });
        });
        });
    </script>
</body>

</html>
