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