<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(120deg, #eef2ff, #f8fafc);
            font-family: 'Segoe UI', sans-serif;
        }

        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .stat-card {
            border-radius: 16px;
            color: #fff;
            padding: 20px;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-6px);
        }

        .bg1 { background: linear-gradient(135deg,#667eea,#764ba2); }
        .bg2 { background: linear-gradient(135deg,#43cea2,#185a9d); }
        .bg3 { background: linear-gradient(135deg,#f7971e,#ffd200); color:#222; }

        .search-box {
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid #ddd;
        }

        .btn-modern {
            border-radius: 50px;
            padding: 10px 20px;
        }

        .badge {
            border-radius: 50px;
            padding: 6px 12px;
        }

        .table thead {
            border-bottom: 2px solid #eee;
        }

        .table tbody tr:hover {
            background: #f1f5f9;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <span class="navbar-brand fw-bold">💼 Transaction Dashboard</span>
        <a href="{{ route('transactions.create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-circle"></i> Add
        </a>
    </div>
</nav>

<div class="container my-5">

    <!-- ALERT -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- STATS -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card bg1">
                <h6>Today</h6>
                <h2>{{ $today->count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card bg2">
                <h6>Last Week</h6>
                <h2>{{ $last_week->count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card bg3">
                <h6>Last 10 Days</h6>
                <h2>{{ $last_10_days->count() }}</h2>
            </div>
        </div>
    </div>

    <!-- SEARCH -->
    <form method="GET" action="{{ route('transactions.index') }}" class="mb-4">
        <div class="d-flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   class="form-control search-box"
                   placeholder="🔍 Search transactions...">

            <button class="btn btn-dark btn-modern">Search</button>
        </div>
    </form>

    <!-- TABLE -->
    <div class="glass-card p-3">

        <h5 class="mb-3">All Transactions</h5>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->title }}</td>
                        <td>
                            <span class="badge bg-primary">
                                ₹ {{ $transaction->amount }}
                            </span>
                        </td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>
                            <form action="{{ route('transactions.delete', $transaction->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this transaction?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            No transactions found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $transactions->links('pagination::custom') }}
        </div>

    </div>

</div>

<footer class="text-center py-3 text-muted">
    © 2026 Laravel Project
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>