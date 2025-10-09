<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'customer')->latest()->paginate(10);
        return view('admin.users.users-index', compact('users'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403, 'No puedes editar un administrador.');
        }

        return view('admin.users.users-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only('name','email','phone','address'));

        return redirect()->route('admin.users.index')->with('ok', 'Cliente actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'customer') {
            return back()->with('error', 'No puedes eliminar administradores.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('ok', 'Cliente eliminado correctamente.');
    }
}
