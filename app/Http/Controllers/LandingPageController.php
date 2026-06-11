<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Landing Page Controller
 *
 * Handles the main landing page view.
 * Uses explicit view rendering with type-safe return values.
 */
class LandingPageController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): View
    {
        return view('landing');
    }
}