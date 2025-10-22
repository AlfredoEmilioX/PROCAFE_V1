<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','lowercase','email','max:255','unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    // ANTES (causa el error)
// public function register(): \Symfony\Component\HttpFoundation\Response

// DESPUÉS (sin tipo de retorno)
public function register()
{
    $this->validate([
        'name' => ['required','string','max:255'],
        'email' => ['required','string','lowercase','email','max:255','unique:users,email'],
        'password' => ['required','confirmed', \Illuminate\Validation\Rules\Password::min(8)],
    ]);

    $user = \App\Models\User::create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => \Illuminate\Support\Facades\Hash::make($this->password),
    ]);

    \Illuminate\Support\Facades\Auth::login($user, remember: true);

    // Livewire soporta redirecciones retornando Redirector propio
    return redirect()->intended(route('home'));
}


    public function render()
    {
        return view('livewire.pages.auth.register')
            ->title('Crear cuenta');
    }
}
