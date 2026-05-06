<!DOCTYPE html>
<html>

<head>
    <title>My University</title>

</head>

<body>

    <header>
        <h1>Salil University</h1>
    </header>

    <nav>

        <a href="{{ route('home') }}">
            {{ __('messages.home') }}
        </a>

        <a href="{{ route('about') }}">
            {{ __('messages.about') }}
        </a>

        |

        <a href="/lang/en">English</a>
        <a href="/lang/hi">Hindi</a>
        <a href="/lang/pa">Punjabi</a>
        <a href="/lang/fr">French</a>

    </nav>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        My University Footer
    </footer>

</body>

</html>