<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        $candidatesCount = \App\Models\Candidate::count();
        $recentMembers = \App\Models\User::role(['member', 'sponsor'])
            ->latest()
            ->take(5)
            ->get();
        $recentCandidates = \App\Models\Candidate::with('user')
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
                $query->whereIn('name', ['member', 'sponsor', 'admin']);
            })
            ->leftJoin('model_has_roles', function($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                     ->where('model_has_roles.model_type', '=', 'App\\Models\\User');
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*')
            ->orderByRaw("CASE 
                WHEN roles.name = 'admin' THEN 1
                WHEN roles.name = 'sponsor' THEN 2
                ELSE 3 
            END")
            ->latest('users.created_at')
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
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'nickname' => $validated['nickname'],
            'last_name' => $validated['nickname'], // Keep last_name for backward compatibility
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->roles()->sync($validated['roles']);

        return redirect()->route('admin.members.index')
            ->with('success', 'Miembro creado exitosamente');
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
            'nickname' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
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
            'nickname' => $validated['nickname'],
            'last_name' => $validated['nickname'], // Keep last_name for backward compatibility
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $user->roles()->sync($validated['roles']);

        return redirect()->route('admin.members.index')
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
        $candidates = \App\Models\Candidate::with('user')
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
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'biography' => 'nullable|string',
        ]);

        // First create a user account for the candidate
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['nickname'], // Using nickname as last_name for backward compatibility
            'nickname' => $validated['nickname'],
            'email' => $validated['email'],
            'password' => Hash::make(Str::random(12)), // Generate a random password
            'email_verified_at' => now(),
        ]);

        // Assign candidate role
        $candidateRole = Role::where('name', 'candidate')->first();
        $user->assignRole($candidateRole);

        // Create the candidate profile
        $candidate = \App\Models\Candidate::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['nickname'], // Using nickname as last_name for backward compatibility
            'nickname' => $validated['nickname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'biography' => $validated['biography'] ?? null,
            'status' => 'pending',
            'added_by' => auth()->id(),
            'application_date' => now(),
        ]);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate created successfully');
    }

    public function editCandidate(\App\Models\Candidate $candidate)
    {
        return view('admin.candidates.edit', compact('candidate'));
    }

    public function updateCandidate(Request $request, \App\Models\Candidate $candidate)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'nickname' => [
                'required',
                'string',
                'max:255',
                Rule::unique('candidates', 'nickname')->ignore($candidate->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('candidates', 'email')->ignore($candidate->id),
            ],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'biography' => 'nullable|string',
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        // Check if status is being changed to accepted
        $statusChanged = $candidate->status !== $validated['status'];
        $becomingAccepted = $statusChanged && $validated['status'] === 'accepted';
        
        // Prepare the update data
        $updateData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['nickname'],
            'nickname' => $validated['nickname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'biography' => $validated['biography'] ?? null,
            'status' => $validated['status'],
        ];
        
        // Update status_updated_at if status is changing
        if ($statusChanged) {
            $updateData['status_updated_at'] = now();
        }
        
        // Update the candidate
        $candidate->update($updateData);

        // If status is changing to accepted, handle the acceptance
        if ($becomingAccepted) {
            // If there's no user yet, create one through the observer
            if (!$candidate->user) {
                // This will trigger the CandidateObserver
                $candidate->refresh(); // Make sure we have the latest data
                event('eloquent.updated: ' . get_class($candidate), $candidate);
            }
            
            // Delete the candidate after a short delay to allow the observer to complete
            // This ensures the candidate is removed from the candidates list
            $candidate->delete();
            
            return redirect()->route('admin.members.index')
                ->with('success', '¡Recluta aceptado y convertido en miembro exitosamente!');
        }
        // Update associated user if it already exists
        elseif ($candidate->user) {
            $candidate->user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['nickname'],
                'nickname' => $validated['nickname'],
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Recluta actualizado exitosamente');
    }

    public function deleteCandidate(\App\Models\Candidate $candidate)
    {
        // Delete the associated user if it exists
        if ($candidate->user) {
            $candidate->user->delete();
        }
        
        // Delete the candidate
        $candidate->delete();
        
        return back()->with('success', 'Candidate deleted successfully');
    }
}
