<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with user information and candidates list.
     */
    public function index()
    {
        $user = Auth::user();
        $candidates = Candidate::latest()->get();
        
        return view('dashboard', [
            'user' => $user,
            'candidates' => $candidates
        ]);
    }
}
