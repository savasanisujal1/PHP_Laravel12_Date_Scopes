<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Card hover */
        .card-hover {
            border-radius: 0.8rem;
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        /* Gradient Header */
        .card-header-gradient {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: #fff;
            border-top-left-radius: 0.8rem;
            border-top-right-radius: 0.8rem;
        }

        /* Footer */
        footer {
            background-color: #fff;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('transactions.index') }}">Laravel Transaction</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}"
                            href="{{ route('transactions.index') }}"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transactions.create') ? 'active' : '' }}"
                            href="{{ route('transactions.create') }}"><i class="bi bi-plus-circle me-1"></i> Add Transaction</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-hover shadow-sm">
                    <div class="card-header card-header-gradient">
                        <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Transaction</h4>
                    </div>
                    <div class="card-body bg-white p-4">

                        <!-- Validation Errors -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('transactions.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Transaction Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter transaction title" required>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount"
                                    placeholder="Enter amount" required>
                            </div>

                            <div class="mb-3">
                                <label for="created_at" class="form-label">Transaction Date</label>
                                <input type="date" class="form-control" id="created_at" name="created_at" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"><i
                                    class="bi bi-save me-2"></i>Save Transaction</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-secondary py-4 mt-auto shadow-sm">
        &copy; 2026 Laravel Date Scopes Demo. All rights reserved.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>