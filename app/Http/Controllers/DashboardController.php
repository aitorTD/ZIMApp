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
        
        // Get paginated candidates (10 per page)
        $candidates = Candidate::latest()->paginate(10);
        
        // Get statistics
        $totalCandidates = Candidate::count();
        $pendingCandidates = Candidate::where('status', 'pending')->count();
        $acceptedCandidates = Candidate::where('status', 'accepted')->count();
        $rejectedCandidates = Candidate::where('status', 'rejected')->count();
        
        return view('dashboard', [
            'user' => $user,
            'candidates' => $candidates,
            'totalCandidates' => $totalCandidates,
            'pendingCandidates' => $pendingCandidates,
            'acceptedCandidates' => $acceptedCandidates,
            'rejectedCandidates' => $rejectedCandidates
        ]);
    }
}
