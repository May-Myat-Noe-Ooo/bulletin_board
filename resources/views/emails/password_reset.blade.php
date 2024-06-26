<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            line-height: 1;
            color: rgb(255, 255, 255);
            font-family: "IBM Plex Sans", sans-serif;
            font-size: 20px;
            font-weight: 400;
        }

        .button {
            display: inline-block;
            text-decoration: none;
            background-color: #008CBA;
            /* Blue background */
            color: white;
            /* White text */
            border: none;
            padding: 15px 32px;
            text-align: center;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
            /* Rounded corners */
        }

        .button:hover {
            background-color: #005f73;
            /* Darker blue on hover */
        }
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> --}}
</head>

<body>
    <p>Welcome to bulletin_board, {{ $user->name }}!</p>
    <p>Your username is {{ $user->name }}. Click the link below to reset your password:</p>
    <a href="{{ $resetLink }}" class="button">Reset Password</a>
    <p>Thanks for joining and have a great day.</p>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script> --}}
</body>

</html>
