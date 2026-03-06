<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Transactions Dashboard</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Cards */
        .card-hover {
            transition: all 0.3s ease;
            border-radius: 0.8rem;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        /* Gradient Cards */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: #fff;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: #fff;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f7971e, #ffd200);
            color: #212529;
        }

        /* Table */
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        table thead {
            background-color: #e9ecef;
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
            <a class="navbar-brand fw-bold" href="{{ route('transactions.index') }}">Laravel Dashboard</a>
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

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card card-hover bg-gradient-primary p-3 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-title">Transactions Today</h6>
                            <h2 class="fw-bold">{{ $today->count() }}</h2>
                            <small>Total records created today</small>
                        </div>
                        <i class="bi bi-calendar-day fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover bg-gradient-success p-3 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-title">Transactions Last Week</h6>
                            <h2 class="fw-bold">{{ $last_week->count() }}</h2>
                            <small>Records in past 7 days</small>
                        </div>
                        <i class="bi bi-calendar-week fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover bg-gradient-warning p-3 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-title">Transactions Last 10 Days</h6>
                            <h2 class="fw-bold">{{ $last_10_days->count() }}</h2>
                            <small>Records in the last 10 days</small>
                        </div>
                        <i class="bi bi-calendar3 fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Tables -->
        <div class="mb-5">
            <h4 class="mb-3">Transactions Today</h4>
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($today as $transaction)
                        <tr>
                            <td>{{ $transaction->title }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $transaction->amount }}</span>
                            </td>
                            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-5">
            <h4 class="mb-3">Transactions Last Week</h4>
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($last_week as $transaction)
                        <tr>
                            <td>{{ $transaction->title }}</td>
                            <td>
                                <span class="badge bg-success">{{ $transaction->amount }}</span>
                            </td>
                            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-5">
            <h4 class="mb-3">Transactions Last 10 Days</h4>
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($last_10_days as $transaction)
                        <tr>
                            <td>{{ $transaction->title }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $transaction->amount }}</span>
                            </td>
                            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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