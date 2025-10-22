@php
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

new #[Layout('components.layouts.app')] class extends Component
{
    // ✅ Propiedades planas (no 'state')
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $phone = '';
    public string $address = '';
    public string $document_type = 'dni';
    public string $document_number = '';

    public function register()
    {
        $data = validator([
            'name'               => $this->name,
            'email'              => $this->email,
            'password'           => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'phone'              => $this->phone,
            'address'            => $this->address,
            'document_type'      => $this->document_type,
            'document_number'    => $this->document_number,
        ], [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:8','same:password_confirmation'],
            'password_confirmation' => ['required'],
            'phone' => ['nullable','string','max:20'],
            'address' => ['nullable','string'],
            'document_type' => ['nullable','in:dni,ruc'],
            'document_number' => ['nullable','string','max:20'],
        ])->validate();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?: null,
            'address' => $data['address'] ?: null,
            'role' => 'customer',
        ]);

        Auth::login($user, remember: true);
        return redirect()->intended('/');
    }
};
@endphp

<div class="row g-4 align-items-stretch">
  {{-- Imagen izquierda (solo ≥ lg) --}}
  <div class="col-lg-7 d-none d-lg-block">
    <div class="ratio ratio-4x3 rounded-4 overflow-hidden bg-light">
      <img src="{{ asset('images/cafe_register.jpg') }}" alt="Autenticación PROCAFES" class="w-100 h-100 object-fit-cover">
    </div>
  </div>

  {{-- Formulario --}}
  <div class="col-12 col-lg-5">
    <div class="card shadow-sm h-100 rounded-4 border-0">
      <div class="card-body p-4 p-lg-5">
        <h2 class="h4 mb-1">Crea tu cuenta</h2>
        <p class="text-muted mb-4">Únete a PROCAFES</p>

        {{-- IMPORTANTE: prevent + model.live para autocompletado --}}
        <form wire:submit.prevent="register" novalidate>
          <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input id="name" type="text" wire:model.live="name"
                   class="form-control @error('name') is-invalid @enderror"
                   required autofocus placeholder="Tu nombre y apellidos">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" type="email" wire:model.live="email"
                   class="form-control @error('email') is-invalid @enderror"
                   required autocomplete="email" placeholder="tucorreo@dominio.com">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input id="phone" type="text" wire:model.live="phone"
                   class="form-control @error('phone') is-invalid @enderror"
                   placeholder="9XXXXXXXX">
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea id="address" rows="2" wire:model.live="address"
                      class="form-control @error('address') is-invalid @enderror"
                      placeholder="Calle, número, referencia"></textarea>
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-sm-5">
              <label for="document_type" class="form-label">Documento</label>
              <select id="document_type" class="form-select" wire:model.live="document_type">
                <option value="dni">DNI</option>
                <option value="ruc">RUC</option>
              </select>
            </div>
            <div class="col-sm-7">
              <label for="document_number" class="form-label">N° Documento</label>
              <input id="document_number" type="text" wire:model.live="document_number"
                     class="form-control @error('document_number') is-invalid @enderror"
                     placeholder="DNI: 8 dígitos / RUC: 11 dígitos">
              @error('document_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" wire:model.live="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password" placeholder="••••••••">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" wire:model.live="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   required autocomplete="new-password" placeholder="••••••••">
            @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-procafes-dark btn-lg" wire:loading.attr="disabled">
              Crear cuenta
            </button>
          </div>
        </form>

        <div class="text-center my-3"><span class="text-muted">o</span></div>
        <a href="{{ route('auth.google.redirect') }}"
           class="btn btn-light border w-100 d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-google"></i> Registrarme con Google
        </a>

        <p class="text-center mt-3 mb-0">
          ¿Ya tienes cuenta?
          <a href="{{ route('login') }}" class="link-procafes text-decoration-none">Inicia sesión</a>
        </p>
      </div>
    </div>
  </div>
</div>
