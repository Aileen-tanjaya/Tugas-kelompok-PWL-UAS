<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;

class AdminSubscriptionReportController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'plan'])
            ->latest()
            ->paginate(10);

        $totalRevenue = Subscription::where('status', 'paid')->sum('amount');

        $totalPaid = Subscription::where('status', 'paid')->count();

        $totalPending = Subscription::where('status', 'pending')->count();

        $totalUsers = User::count();

        return view('admin.subscription-report', compact(
            'subscriptions',
            'totalRevenue',
            'totalPaid',
            'totalPending',
            'totalUsers'
        ));
    }
}