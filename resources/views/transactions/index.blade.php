<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background: linear-gradient(120deg, #eef2ff, #f8fafc); transition: 0.3s; }
        .dark body { background: #121212; color: #fff; }
        .dark .glass-card { background: rgba(30,30,30,0.8); color: #fff; }
        .glass-card { background: rgba(255,255,255,0.7); backdrop-filter: blur(12px); border-radius: 16px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        .stat-card { border-radius: 16px; color: #fff; padding: 20px; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-6px); }
        .bg1 { background: linear-gradient(135deg,#667eea,#764ba2); }
        .bg2 { background: linear-gradient(135deg,#43cea2,#185a9d); }
        .bg3 { background: linear-gradient(135deg,#f7971e,#ffd200); color:#222; }
    </style>
</head>

<body>
<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <span class="navbar-brand fw-bold">💼 Transaction Dashboard</span>
        <div class="d-flex gap-2">
            <button @click="darkMode = !darkMode; localStorage.setItem('dark', darkMode)" class="btn btn-outline-light btn-sm">
                <i class="bi" :class="darkMode ? 'bi-sun' : 'bi-moon'"></i>
            </button>
            <a href="{{ route('transactions.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-circle"></i> Add</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="stat-card bg1"><h6>Today</h6><h2>{{ $today->count() }}</h2></div></div>
        <div class="col-md-4"><div class="stat-card bg2"><h6>Last Week</h6><h2>{{ $last_week->count() }}</h2></div></div>
        <div class="col-md-4"><div class="stat-card bg3"><h6>Last 10 Days</h6><h2>{{ $last_10_days->count() }}</h2></div></div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('transactions.index') }}" class="d-flex gap-2">
                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control rounded-pill" placeholder="Search...">
                <button class="btn btn-dark rounded-pill px-4">Search</button>
            </form>
        </div>
       <div class="col-md-6 text-end">
    <a href="{{ route('transactions.export') }}" class="btn btn-outline-primary rounded-pill">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
    
    <a href="{{ route('transactions.export.excel') }}" class="btn btn-outline-success rounded-pill">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>
</div>
    </div>

    <div class="glass-card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Title</th><th>Amount</th><th>Date</th><th>Action</th></tr></thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->title }}</td>
                        <td><span class="badge bg-primary">₹ {{ $transaction->amount }}</span></td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                              <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('transactions.delete', $transaction->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">No transactions found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $transactions->links('pagination::custom') }}
        </div>
    </div>
</div>

<script>
</script>
</body>
</html>