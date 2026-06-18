<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { background-color: #f8f9fa; transition: background 0.3s, color 0.3s; }
        .dark body { background-color: #121212; color: #fff; }
        .dark .card { background-color: #1e1e1e; color: #fff; border: 1px solid #333; }
        .dark .form-control { background-color: #2d2d2d; border-color: #444; color: #fff; }
        .card-hover { border-radius: 0.8rem; transition: all 0.3s ease; }
        .card-header-gradient { background: linear-gradient(135deg, #4e54c8, #8f94fb); color: #fff; border-top-left-radius: 0.8rem; border-top-right-radius: 0.8rem; }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('transactions.index') }}">Laravel Transaction</a>
            <div class="d-flex">
                <button @click="darkMode = !darkMode; localStorage.setItem('dark', darkMode)" class="btn btn-sm btn-outline-light">
                    <i class="bi" :class="darkMode ? 'bi-sun-fill' : 'bi-moon-fill'"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-hover shadow-sm">
                    <div class="card-header card-header-gradient">
                        <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Transaction</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('transactions.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Transaction Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter title" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" name="amount" placeholder="Enter amount" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" class="form-control" name="created_at" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save me-2"></i>Save Transaction
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>