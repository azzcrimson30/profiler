<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Dashboard Controller
 *
 * Handles the main dashboard view with statistics and overview data.
 */
class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('is_admin', true)->count(),
            'total_regular_users' => User::where('is_admin', false)->count(),
            'my_profiles' => $user->profiles()->count(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return view('dashboard', compact('stats'));
    }
}
