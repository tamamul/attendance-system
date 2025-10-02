<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin', User::class);

        $users = User::when($request->role, function($query) use ($request) {
                $query->where('role', $request->role);
            })
            ->when($request->search, function($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('email', 'like', '%'.$request->search.'%')
                      ->orWhere('nip', 'like', '%'.$request->search.'%');
            })
            ->orderBy('name')
            ->paginate(10);

        return response()->json($users);
    }

    public function show(User $user)
    {
        $this->authorize('admin', User::class);

        return response()->json($user);
    }

    public function getGuruList()
    {
        $this->authorize('admin', User::class);

        $gurus = User::where('role', 'guru')
            ->select('id', 'name', 'nip', 'email')
            ->orderBy('name')
            ->get();

        return response()->json($gurus);
    }
}