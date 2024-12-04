<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel TMS')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Task message container (for success/error feedback) -->
    <div id="task-message" class="fixed top-0 left-1/2 transform -translate-x-1/2 p-4 text-white rounded-md hidden"></div>

    <!-- Main Content Section -->
    <div class="content">
        @yield('content')
    </div>
</body>
</html>