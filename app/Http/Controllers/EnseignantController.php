<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = User::where('role', 'enseignant')->latest()->paginate(10);

        return view('enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        return view('enseignants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'enseignant',
        ]);

        return redirect()->route('enseignants.index')->with('success', 'Administrateur ajouté.');
    }

    public function edit(User $enseignant)
    {
        abort_unless($enseignant->role === 'enseignant', 404);

        return view('enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, User $enseignant)
    {
        abort_unless($enseignant->role === 'enseignant', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $enseignant->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
        ]);

        $enseignant->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $enseignant->password,
        ]);

        return redirect()->route('enseignants.index')->with('success', 'Administrateur modifié.');
    }

    public function destroy(User $enseignant)
    {
        abort_if(auth()->id() === $enseignant->id, 403, 'Vous ne pouvez pas supprimer votre compte courant.');
        $enseignant->delete();

        return redirect()->route('enseignants.index')->with('success', 'Administrateur supprimé.');
    }
}