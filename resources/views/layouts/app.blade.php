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
        /* Styles for navigation */
        nav {
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
            background-color:#f08632;
        }
        .nav-item {
            height: 50px;
        }

        .nav-item:hover{
            background-color: #000000;
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
        .userlist .card-body {
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
    .post-title-link {
    color: #fd7e14;
    border-bottom: 1px solid #fd7e14;
}
}
/* Styles for user list */

.userlist .card {
    transition: transform 0.2s;
}

.userlist .card:hover {
    transform: scale(1.05);
    .user-name-link {
        color: #111111;
        border-bottom: 1px solid #111111;
}
.card-body {
            background-color: #f08632;
            color:#ffffff;
        }
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

.userlist {
    .card-body {
    position: relative;
    padding-top: 100%; /* Adjust as needed */
}

.background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 31%; /* 30% of the card-body height */
    overflow: hidden;
}

.background-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-img {
    position: absolute;
    top: 45%; /* Center vertically */
    left: 50%; /* Center horizontally */
    transform: translate(-50%, -50%); /* Adjust to center exactly */
    width: 200px;
    height: 200px;
    border: 5px solid #ddd; /* Optional: border to make the profile image stand out */
}

.card-body h5,
.card-body p {
    position: relative;
    z-index: 1; /* Ensure text is above the background image */
    margin-top: 3%; /* Adjust as needed to position below the profile image */
}

}
.user-name-link {
    color: #111111;
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
/* Default styles for the Like button */
.btn-like {
    color: #111111;
    border: 1px solid #111111;
    background-color: #ffffff;
    transition: all 0.3s ease;
}

.btn-like:hover {
    color: #ffffff;
    border: 1px solid #fd7e14;
    background-color: #fd7e14;
}

/* Styles for the three dots dropdown menu */
.custom-dot {
    color: #000000;
}

/*  Style for post title*/
.post-title-link {
    color: #111111;
}


/* Styles for Pagination link */
.pagination > li > a,
.pagination > li > span{
    z-index: 3;
    color: #111111;
    background-color:#f8f9fa ;
    border-color: #ddd;
}
.pagination > li > a:focus,
.pagination > li > a:hover,
.pagination > li > span:focus,
.pagination > li > span:hover,
.active>.page-link {
    z-index: 3;
    color: #f8f9fa;
    background-color: #111111;
    border-color: #ddd;
}

/* Style for edit profile */
.save-btn:hover,
.search-btn:hover,
.update-btn:hover,
.login-btn:hover,
.create-btn:hover,
.confirm-btn:hover,
.edit-btn:hover,
.reset-btn:hover,
.upload-btn:hover,
.register-btn:hover{
    color: #ffffff;
    border: 1px solid #fd7e14;
    background-color: #fd7e14;
}
.change-pw-link {
    font-size: 16px;
    color: #fd7e14;
    font-weight: 600;
}
.change-pw-link:hover {
    color: #f08632;
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
