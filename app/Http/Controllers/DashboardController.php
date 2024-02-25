<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $transactions = Transaction::all();
        $transactionsPerDay = [
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0
        ];
    
        foreach ($transactions as $transaction) {
            $dayOfWeek = date('l', strtotime($transaction->created_at));
            $transactionsPerDay[$dayOfWeek]++;
        }
    
        $transactionCounts = array_values($transactionsPerDay);

        $incomeThisMonth = Transaction::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');
    
        return view('pages.index', [
            'title' => 'Dashboard',
            'users' => User::all(),
            'products' => Product::all(),
            'transactions' => $transactions,
            'transactionCounts' => $transactionCounts,
            'incomeThisMonth' => $incomeThisMonth
        ]);
    }
}
