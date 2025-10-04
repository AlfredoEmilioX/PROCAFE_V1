<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public array $state = [
        'email' => '',
        'password' => '',
        'remember' => false,
    ];

    public function mount()
    {
        if (Auth::check()) {
            // Si ya está logueado, sácalo del /login
            return redirect()->to($this->destinationPath(Auth::user()->role));
        }
    }

    public function login()
    {
        $this->validate([
            'state.email' => ['required', 'email'],
            'state.password' => ['required', 'string'],
        ]);

        $remember = (bool) ($this->state['remember'] ?? false);

        if (! Auth::attempt([
            'email' => $this->state['email'],
            'password' => $this->state['password'],
        ], $remember)) {
            throw ValidationException::withMessages([
                'state.email' => __('auth.failed'),
            ]);
        }

        // Regenerar ID de sesión para fijar la cookie
        session()->regenerate();

        // Redirección RELATIVA dentro del mismo host
        return redirect()->intended($this->destinationPath(Auth::user()->role));
    }

    private function destinationPath(?string $role): string
    {
        return $role === 'admin' ? '/dashboard' : '/mis-productos';
    }

    public function render()
    {
        return view('livewire.pages.auth.login')
            ->layout('components.layouts.app');
    }
}
