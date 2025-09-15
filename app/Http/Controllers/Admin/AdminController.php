<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $membersCount = \App\Models\User::role(['member', 'sponsor'])->count();
        $candidatesCount = \App\Models\User::role('candidate')->count();
        $recentMembers = \App\Models\User::role(['member', 'sponsor'])
            ->latest()
            ->take(5)
            ->get();
        $recentCandidates = \App\Models\User::role('candidate')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('membersCount', 'candidatesCount', 'recentMembers', 'recentCandidates'));
    }

    // Members Management
    public function members()
    {
        $members = User::with('roles')
            ->whereHas('roles', function($query) {
                $query->whereIn('name', ['member', 'sponsor']);
            })
            ->latest()
            ->paginate(15);

        return view('admin.members.index', compact('members'));
    }

    public function createMember()
    {
        $member = new User();
        $roles = Role::whereIn('name', ['member', 'sponsor'])->get();
        return view('admin.members.create', compact('member', 'roles'));
    }

    public function storeMember(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->roles()->sync($validated['roles']);

        return redirect()->route('admin.members')
            ->with('success', 'Member created successfully');
    }

    public function editMember(User $user)
    {
        $roles = Role::whereIn('name', ['member', 'sponsor'])->get();
        return view('admin.members.edit', compact('user', 'roles'));
    }

    public function updateMember(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $user->roles()->sync($validated['roles']);

        return redirect()->route('admin.members')
            ->with('success', 'Member updated successfully');
    }

    public function deleteMember(User $user)
    {
        $user->delete();
        return back()->with('success', 'Member deleted successfully');
    }

    // Candidates Management
    public function candidates()
    {
        $candidates = User::with('roles')
            ->whereHas('roles', function($query) {
                $query->where('name', 'candidate');
            })
            ->latest()
            ->paginate(15);

        return view('admin.candidates.index', compact('candidates'));
    }

    public function createCandidate()
    {
        return view('admin.candidates.create');
    }

    public function storeCandidate(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $candidateRole = Role::where('name', 'candidate')->first();
        $user->roles()->attach($candidateRole);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate created successfully');
    }

    public function editCandidate(User $user)
    {
        return view('admin.candidates.edit', compact('user'));
    }

    public function updateCandidate(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate updated successfully');
    }

    public function deleteCandidate(User $user)
    {
        $user->delete();
        return back()->with('success', 'Candidate deleted successfully');
    }
}
