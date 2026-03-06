# PHP_Laravel12_Date_Scopes

## Introduction

PHP_Laravel12_Date_Scopes is a demo Laravel 12 application built to showcase how to filter Eloquent models by various date ranges using the Laravel Date Scopes package. This project demonstrates practical usage of date-based query scopes like:

- ofToday() – transactions created today

- ofLastWeek() – transactions in the past 7 days

- ofLastDays(n) – transactions in the last n days

- monthToDate() – transactions from the start of the month until today

This helps developers quickly retrieve date-specific data without writing complex query logic manually.

---

## Project Overview

This project implements a simple transaction management dashboard with the following features:

#### 1) Transaction Dashboard

- Displays transactions filtered by today, last week, and last 10 days.

- Includes summary cards and tables for each date range.

- Shows a success message when a new transaction is added.

#### 2) Add Transaction

- Provides a form to add a new transaction with title, amount, and date.

- Validates input before saving to the database.

- Redirects back to the dashboard with a confirmation message.

#### 3) Database & Seeder

- transactions table created via migration.

- Seeder populates demo transactions for testing date scopes.

- Laravel Date Scopes Integration

#### 4) Demonstrates the use of pre-built date query scopes.

- Enables filtering of transactions for today, last week, last N days, month-to-date, and more.

#### 5) Frontend

- Responsive dashboard built with Bootstrap 5.

- Uses gradient cards, tables, and icons for visual clarity.

- Navbar with links to dashboard and add transaction page.

- Success messages and validation errors styled for usability.

---

## Project Setup

## Step 1: Installation

Open terminal and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_Date_Scopes "12.*"
``

Move into project:

```bash
cd PHP_Laravel12_Date_Scopes
```

---

## Step 2: Update .env

Update .env with DB credentials:

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_date_scopes
DB_USERNAME=root
DB_PASSWORD=
```

Run Migration Command:

```bash
php artisan migrate
```

---

## Step 3: Install the Date Scopes Package

Install package:

```bash
composer require laracraft-tech/laravel-date-scopes
```

Publish config (optional, to customize inclusive/exclusive ranges):

```bash
php artisan vendor:publish --tag="date-scopes-config"
```

---

## Step 4: Create a Model and Migration

We’ll use a Transaction model to demonstrate scopes:

```bash
php artisan make:model Transaction -m
```
### Migration Table

Open database/migrations/..._create_transactions_table.php and update:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
```

Run migration:

```bash
php artisan migrate
```

This creates migration table in database.

### Model

Open: app/Models/Transaction.php

```php
<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaracraftTech\LaravelDateScopes\DateScopes;

class Transaction extends Model
{
    use HasFactory, DateScopes;

    protected $fillable = ['title', 'amount'];
}
```

The DateScopes trait adds many query scopes like:

- ofToday()

- ofLastWeek()

- monthToDate()

- ofLastYear()

… and more for other ranges (hours, days, months, years, centuries).

---

## Step 5: Seed Some Demo Data

Create Seeder

```bash
php artisan make:seeder TransactionSeeder
```

Edit database/seeders/TransactionSeeder.php:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::truncate();

        // Transactions from today
        Transaction::create(['title' => 'Today A', 'amount' => 100]);
        Transaction::create(['title' => 'Today B', 'amount' => 200]);

        // Yesterday
        Transaction::create([
            'title' => 'Yesterday',
            'amount' => 150,
            'created_at' => Carbon::yesterday()
        ]);

        // 10 days ago
        Transaction::create([
            'title' => '10 Days Ago',
            'amount' => 500,
            'created_at' => Carbon::now()->subDays(10)
        ]);
    }
}
```

Run seeder:

```bash
php artisan db:seed --class=TransactionSeeder
```
---

## Step 6: Create Controller

```bash
php artisan make:controller TransactionController
```

Edit: app/Http/Controllers/TransactionController.php

```php
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
{
    $today = Transaction::ofToday()->get();
    $last_week = Transaction::ofLastWeek()->get();
    $last_10_days = Transaction::ofLastDays(10)->get();

    return view('transactions.index', compact('today', 'last_week', 'last_10_days'));
}

public function create()
{
    return view('transactions.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'created_at' => 'required|date',
    ]);

    Transaction::create([
        'title' => $request->title,
        'amount' => $request->amount,
        'created_at' => $request->created_at,
    ]);

    return redirect()->route('transactions.index')->with('success', 'Transaction added successfully!');
}
}
```

---

## Step 7: Create Blade Files For Transactions

### Create.blade.php

File: resources/views/transactions/create.blade.php

```html
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
```

### index.blade.php

File: resources/views/transactions/index.blade.php

```html
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
```

---

## Step 8: Add Route

Open routes/web.php:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
```

---

## Step 9: Run Development Serve

```bash
php artisan serve
```

Open your browser and visit:

```bash
http://127.0.0.1:8000/
```
You can see Dashboard 

```bash
http://127.0.0.1:8000/create
```
You can now add transactions

---

## Output

<img width="1919" height="1028" alt="Screenshot 2026-03-06 172004" src="https://github.com/user-attachments/assets/208f5e81-b472-481b-a992-b738b129ee5d" />

<img width="1900" height="1030" alt="Screenshot 2026-03-06 172021" src="https://github.com/user-attachments/assets/6fccae25-5ad8-4985-9e41-974cfeeebdb5" />

<img width="1898" height="1028" alt="Screenshot 2026-03-06 172052" src="https://github.com/user-attachments/assets/2d5d21da-735d-4cbe-983e-cbadc10468ae" />

---

## Project Structure

```
PHP_Laravel12_Date_Scopes/
├── app/
│   └── Models/
│       └── Transaction.php                  <-- Transaction model
├── app/Http/Controllers/
│   └── TransactionController.php           <-- Controller for CRUD
├── database/
│   ├── migrations/
│   │   └── 2026_03_06_000000_create_transactions_table.php  <-- Migration for transactions
│   └── seeders/
│       └── TransactionSeeder.php           <-- Optional seeder for sample data
├── resources/
│   └── views/
│       └── transactions/
│           ├── index.blade.php             <-- Dashboard page
│           └── create.blade.php            <-- Add Transaction form
├── routes/
│   └── web.php                              <-- Define routes
├── .env                                     <-- Environment file (DB credentials, app config)
├── composer.json
└── README.md                                <-- Project instructions & setup
```

---

Your PHP_Laravel12_Date_Scopes Project is now ready!




