<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulletin Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        nav {
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
            background-color:#f08632;
        }

        .required:after {
            content: " *";
            color: red;
            font-weight: 100;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #ffffff;
        }

        .postlist .card-body {
            background-color: #f8f9fa;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Vertically center the content */
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

        .card .icon-wrapper {
            visibility: hidden;
        }

        .card:hover .icon-wrapper {
            visibility: visible;
        }

        .card-body .dropdown {
    position: absolute;
    top: 10px;
    right: 10px;
}

.card-body .dropdown .dropdown-menu {
    min-width: 0;
}

.card-body .dropdown .dropdown-menu .dropdown-item {
    display: flex;
    align-items: center;
}

.card-body .dropdown .dropdown-menu .dropdown-item i {
    margin-right: 8px;
}
.postlist .card {
    transition: transform 0.2s;
}

.postlist .card:hover {
    transform: scale(1.05);
}
.userlist .card {
    transition: transform 0.2s;
}

.userlist .card:hover {
    transform: scale(1.05);
}

.userlist .card img {
    object-fit: cover;
}

.userlist .dropdown-menu {
    right: 0;
    left: auto;
}

.userlist .modal .modal-body p {
    margin-bottom: 10px;
}

.userlist .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.userlist .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}
/*---------------------
  Post
-----------------------*/

.post__text h2 {
  font-size: 50px;
  color: #000000;
  font-weight: 700;
  font-style: italic;
  font-family: "Playfair Display", serif;
}

.post__links {
  text-align: right;
  padding-top: 15px;
}
.post__links a {
  font-size: 16px;
  color: #111111;
  margin-right: 26px;
  display: inline-block;
  position: relative;
}
.post__links a:after {
  position: absolute;
  right: -16px;
  top: 0;
  content: "|";
  color: #888888;
}
.post__links span {
  font-size: 16px;
  color: #888888;
  display: inline-block;
}

    </style>
</head>

<body>

    @include('layouts.navbar')

    <main class="container py-3">
        @yield('body')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
