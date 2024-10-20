<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        $totalTransactions = Transaction::count();
        $totalPending = Transaction::where('status', 'pending')->count();
        $totalFailed = Transaction::where('status', 'failed')->count();
        $totalSuccess = Transaction::where('status', 'success')->count();
        $latestTransactions = Transaction::orderBy('created_at', 'desc')->paginate(10);

        return view('backend.dashboard.index', compact('totalTransactions', 'totalPending', 'totalFailed', 'totalSuccess', 'latestTransactions'));
    }
}
