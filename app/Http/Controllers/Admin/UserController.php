<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display listing of users.
     */
    public function index(Request $request)
    {
        $query = User::withCount(['bids', 'wonAuctions']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details.
     */
    public function show($id)
    {
        $user = User::withCount(['bids', 'wonAuctions', 'auctionItems'])
            ->findOrFail($id);

        $recentBids = $user->bids()
            ->with('auctionItem')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.users.show', compact('user', 'recentBids'));
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:admin,user'],
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Role pengguna berhasil diperbarui!');
    }

    /**
     * Delete user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
