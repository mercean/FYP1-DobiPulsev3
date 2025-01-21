<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirects user to the correct dashboard based on their role
     */
    public function redirectDashboard()
    {
        $user = Auth::user();
        
        // Check the user's role and redirect them accordingly
        if ($user->account_type === 'regular') {
            return redirect()->route('regular.dashboard'); // Redirect to regular dashboard
        } elseif ($user->account_type === 'bulk') {
            return redirect()->route('bulk.dashboard'); // Redirect to bulk dashboard
        } elseif ($user->account_type === 'admin') {
            return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
        }
        
        // If user doesn't have a role or is not recognized, send them to the home page
        return redirect('/');
    }

    /**
     * Regular User Dashboard
     */
    public function regularDashboard()
    {
        return view('dashboard.regular'); // Show regular user's dashboard
    }

    /**
     * Bulk User Dashboard
     */
    public function bulkDashboard()
    {
        return view('dashboard.bulk'); // Show bulk user's dashboard
    }

    /**
     * Admin User Dashboard
     */
    public function adminDashboard()
    {
        return view('admin_dashboard'); // Show admin's dashboard
    }
}
