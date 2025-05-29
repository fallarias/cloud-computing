<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>

    {{-- Bootstrap CDN (optional but helpful for styling) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Add any custom CSS --}}
    @yield('styles')
</head>
<body>

    {{-- Main Content --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Optional footer --}}
    <footer class="bg-light text-center py-3 mt-4">
        &copy; {{ date('Y') }} Staff Management System. All rights reserved.
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Extra JS if needed --}}
    @yield('scripts')
</body>
</html>
