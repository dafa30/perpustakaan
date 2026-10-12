<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Pintar</title>
    <link href="{{ asset('library/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center" style="background-color: #f8f9fa;">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Dafa Adi Raharjo. All rights reserved.</p>
    </footer>

    <script src="{{ asset('library/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
