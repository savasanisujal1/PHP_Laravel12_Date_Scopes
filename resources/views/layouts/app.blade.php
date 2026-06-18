<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Laravel System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root { --bg-color: #f8f9fa; --text-color: #212529; --card-bg: #ffffff; }
        .dark { --bg-color: #121212; --text-color: #f8f9fa; --card-bg: #1e1e1e; }
        body { background-color: var(--bg-color); color: var(--text-color); transition: 0.3s; }
        .card { background-color: var(--card-bg); color: var(--text-color); border: none; }
        .navbar { background-color: var(--card-bg) !important; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Laravel System</a>
            <div class="d-flex align-items-center">
                <button @click="darkMode = !darkMode; localStorage.setItem('dark', darkMode)" class="btn btn-sm btn-outline-secondary">
                    <i class="bi" :class="darkMode ? 'bi-sun-fill' : 'bi-moon-fill'"></i>
                </button>
            </div>
        </div>
    </nav>
    <main class="container py-4">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>