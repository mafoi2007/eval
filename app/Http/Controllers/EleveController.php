<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EleveController extends Controller
{
    
    public function index()
    {
        $eleves = Eleve::with(['user', 'classe'])->latest()->paginate(10);
        return view('eleves.index', compact('eleves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $classes = Classe::orderBy('nom')->get();
        return view('eleves.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'classe_id' => ['required', 'exists:classes,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'eleve',
        ]);

        Eleve::create([
            'user_id' => $user->id,
            'classe_id' => $validated['classe_id'],
        ]);

        return redirect()->route('eleves.index')->with('success', 'Élève ajouté avec succès.');

    }

    /**
     * Display the specified resource.
     */
   /* public function show(string $id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(string $id)*/
    public function edit(Eleve $eleve)
    {
        //
        $classes = Classe::orderBy('nom')->get();
        $eleve->load('user');

        return view('eleves.edit', compact('eleve', 'classes'));

    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(Request $request, string $id)*/
     public function update(Request $request, Eleve $eleve)
    {
        //
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $eleve->user_id],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'classe_id' => ['required', 'exists:classes,id'],
        ]);

        $eleve->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $eleve->user->password,
        ]);

        $eleve->update(['classe_id' => $validated['classe_id']]);

        return redirect()->route('eleves.index')->with('success', 'Élève modifié avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     */
    /*public function destroy(string $id)*/
    public function destroy(Eleve $eleve)
    {
        //
        $eleve->user()->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé.');
    }
}
