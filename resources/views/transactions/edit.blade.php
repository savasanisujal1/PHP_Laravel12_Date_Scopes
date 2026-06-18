@extends('layouts.app') 

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h4 class="mb-4">Edit Transaction</h4>
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $transaction->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ $transaction->amount }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="created_at" class="form-control" value="{{ $transaction->created_at ? $transaction->created_at->format('Y-m-d') : '' }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Transaction</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 