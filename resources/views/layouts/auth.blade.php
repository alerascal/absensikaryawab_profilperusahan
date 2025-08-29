<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendPro - Sistem Absensi Premium</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/auth/style.css') }}">
</head>
<body>
    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <!-- Main Content -->
    <main class="content">
        @yield('content')
    </main>

    <!-- Custom JS -->
    <script src="{{ asset('assets/auth/main.js') }}"></script>
</body>
</html>
