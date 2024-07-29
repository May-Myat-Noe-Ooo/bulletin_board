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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('img/mtmLogo.png') }}" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        {!! file_get_contents(public_path('css/reset.css')) !!} {!! file_get_contents(public_path('css/style.css')) !!}
    </style>
</head>

<body>
    <!-- New header section -->
    <!-- <header class="bg-white py-2"> -->
    <header class="py-2">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}">
                <div class="d-flex align-items-center">
                    <img src="../img/mtmLogo.png" alt="Company Logo" height="70" class="d-inline-block align-middle">
                    <h1 class="ms-3 mb-0 align-middle">MTM Bulletinboard</h1>
                </div>
            </a>
            <div>
                <!-- Accessibility widget -->
                <div class="font-size-controls">
                    <button id="decreaseFont" class="btn btn-outline-dark">A-</button>
                    <button id="resetFont" class="btn btn-outline-dark">A</button>
                    <button id="increaseFont" class="btn btn-outline-dark">A+</button>

                    <button id="blueButton" class="btn btn-primary me-2">Blue</button>
                    <button id="blackButton" class="btn btn-dark me-2">Black</button>
                    <button id="whiteButton" class="btn btn-light me-2">White</button>
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
        </div>
        @include('layouts.navbar')
    </header>

    {{-- @include('layouts.navbar') --}}
    <form id="textToSpeechForm" action="/convert-text-to-speech" method="POST">
        @csrf
        <input type="hidden" id="text" name="text">
        <button type="submit" id="readAloudButton" class="btn btn-primary">🔊 Read Aloud</button>
    </form>

    @if (session('audioFileUrl'))
        <audio id="audioPlayer" controls autoplay>
            <source src="{{ session('audioFileUrl') }}" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <main class="container py-3">
        @yield('body')
        <!-- Add the Read Aloud button -->

    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //Read Aloud Section 
            const readAloudButton = document.getElementById('readAloudButton');
            const textInput = document.getElementById('text');

            document.addEventListener('selectionchange', function() {
                const selectedText = window.getSelection().toString().trim();
                if (selectedText) {
                    const selection = window.getSelection();
                    const range = selection.getRangeAt(0);
                    const rect = range.getBoundingClientRect();
                    readAloudButton.style.top = `${rect.bottom + window.scrollY}px`;
                    readAloudButton.style.left = `${rect.right + window.scrollX}px`;
                    readAloudButton.style.display = 'block';
                    textInput.value = selectedText;
                } else {
                    readAloudButton.style.display = 'none';
                }
            });

            readAloudButton.addEventListener('click', function() {
                if (!textInput.value) {
                    alert('Please select some text to read aloud.');
                    return;
                }
                document.getElementById('textToSpeechForm').submit();
            });

            const audioPlayer = document.getElementById('audioPlayer');
            if (audioPlayer) {
                audioPlayer.addEventListener('ended', function() {
                    audioPlayer.style.display = 'none';
                });
            }

            //Changing Font Size and Changing color count sectioon

            const body = document.body;
            const header = document.querySelector('header');
            const nav = document.querySelector('nav');
            const footer = document.querySelector('footer');
            const resizableElements = document.querySelectorAll('.resizable');

            const decreaseFontButton = document.getElementById('decreaseFont');
            const resetFontButton = document.getElementById('resetFont');
            const increaseFontButton = document.getElementById('increaseFont');
            const blueButton = document.getElementById('blueButton');
            const blackButton = document.getElementById('blackButton');
            const whiteButton = document.getElementById('whiteButton');

            let fontSize = parseInt(localStorage.getItem('fontSize')) || 16;

            // Function to set font size for all resizable elements
            function setFontSize(size) {
                body.style.fontSize = size + 'px';
                footer.style.fontSize = size + 'px';
                resizableElements.forEach(element => {
                    element.style.fontSize = size + 'px';
                });
                localStorage.setItem('fontSize', size); // Save the font size in local storage
            }

            // Apply the saved font size on page load
            setFontSize(fontSize);
            console.log(fontSize);
            // Apply the saved color scheme on page load
            const savedColorScheme = localStorage.getItem('colorScheme');
            if (savedColorScheme) {
                applyColorScheme(savedColorScheme);
            }

            // Decrease font size
            decreaseFontButton.addEventListener('click', function() {
                fontSize = Math.max(10, fontSize - 1); // Prevent font size from being too small
                setFontSize(fontSize);
            });

            // Reset font size
            resetFontButton.addEventListener('click', function() {
                fontSize = 16;
                setFontSize(fontSize);
            });

            // Increase font size
            increaseFontButton.addEventListener('click', function() {
                fontSize = Math.min(24, fontSize + 1); // Prevent font size from being too large
                setFontSize(fontSize);
            });

            // Function to apply color scheme
            function applyColorScheme(scheme) {
                switch (scheme) {
                    case 'blue':
                        body.style.backgroundColor = 'blue';
                        header.style.backgroundColor = 'blue';
                        nav.style.backgroundColor = '#0000AA';
                        footer.style.backgroundColor = '#0000AA';
                        body.style.color = 'yellow';
                        document.querySelectorAll('a').forEach(a => a.style.color = 'white');
                        document.getElementById('bcard').style.backgroundColor = 'blue';
                        document.getElementById('bcard').style.borderColor = 'white';
                        document.querySelectorAll('#post-list-inner-card').forEach(function(card) {
                            card.style.backgroundColor = '#0000AA';
                            card.style.color = '#ffffff';
                        });
                        document.querySelectorAll('.postlist .card-body').forEach(function(card) {
                            card.style.backgroundColor = '#0000AA';
                        });
                        document.querySelectorAll('.reset-nav a').forEach(function(card) {
                            card.style.backgroundColor = '#0000AA';
                        });
                        document.querySelectorAll('.post__text h2, h1').forEach(function(element) {
                            element.style.color = 'black';
                        });
                        break;
                    case 'black':
                        body.style.backgroundColor = 'black';
                        header.style.backgroundColor = 'black';
                        nav.style.backgroundColor = '#333333';
                        footer.style.backgroundColor = '#333333';
                        body.style.color = 'yellow';
                        footer.style.color = 'yellow';
                        document.querySelectorAll('a').forEach(a => a.style.color = 'white');
                        document.getElementById('bcard').style.backgroundColor = 'black';
                        document.querySelectorAll('.post__text h2, h1').forEach(function(element) {
                            element.style.color = 'yellow';
                        });
                        document.querySelectorAll('#post-list-inner-card').forEach(function(card) {
                            card.style.backgroundColor = '#333333';
                            card.style.color = '';
                        });
                        document.querySelectorAll('.postlist .card-body').forEach(function(card) {
                            card.style.backgroundColor = '#333333';
                        });
                        document.querySelectorAll('.reset-nav a').forEach(function(card) {
                            card.style.backgroundColor = '#333333';
                        });
                        document.querySelectorAll('.btn-outline-dark').forEach(function(button) {
                            button.classList.remove('btn-outline-dark');
                            button.classList.add('btn-outline-light');
                        });
                        document.getElementById('bcard').style.borderColor = 'white';
                        break;
                    case 'white':
                    default:
                        // Reset styles to defaults
                        body.style.backgroundColor = '';
                        header.style.backgroundColor = 'white';
                        nav.style.backgroundColor = '';
                        footer.style.backgroundColor = '';
                        body.style.color = '';
                        footer.style.color = '';
                        document.querySelectorAll('a').forEach(a => a.style.color = '');
                        document.getElementById('bcard').style.backgroundColor = '';
                        document.getElementById('bcard').style.borderColor = '';
                        document.querySelectorAll('#post-list-inner-card').forEach(function(card) {
                            card.style.backgroundColor = '';
                            card.style.color = '';
                        });
                        document.querySelectorAll('.postlist .card-body').forEach(function(card) {
                            card.style.backgroundColor = '';
                        });
                        document.querySelectorAll('.reset-nav a').forEach(function(card) {
                            card.style.backgroundColor = '';
                        });
                        document.querySelectorAll('.post__text h2, h1').forEach(function(element) {
                            element.style.color = '';
                        });
                        document.querySelectorAll('.btn-outline-light').forEach(function(button) {
                            button.classList.remove('btn-outline-light');
                            button.classList.add('btn-outline-dark');
                        });
                        break;
                }
                localStorage.setItem('colorScheme', scheme); // Save the color scheme in local storage
            }

            // Event listeners for color buttons
            blueButton.addEventListener('click', function() {
                applyColorScheme('blue');
            });
            blackButton.addEventListener('click', function() {
                applyColorScheme('black');
            });
            whiteButton.addEventListener('click', function() {
                applyColorScheme('white');
            });


            const dropdownItems = document.querySelectorAll('.dropdown-item');

            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
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
