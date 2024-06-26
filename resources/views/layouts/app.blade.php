<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulletin Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .required:after {
            content: " *";
            color: red;
            font-weight: 100;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Vertically center the content */
        }

        footer {
            width: 100%;
            background-color: #343a40;
            color: #ffffff;
            margin-top: 50px;
            padding: 20px 0;
        }

        a {
            display: inline-block;
            color: #0000FF;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
        }
.message-avatar img {
    display: inline-block;
    width: 51px;
    height: 48px;
    border-radius: 50%;
}
    </style>
</head>

<body>

    @include('layouts.navbar')

    <main class="container py-5">
        @yield('body')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
