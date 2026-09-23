<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::app')] class extends Component
{
    public string $email = '';
    public string $password = '';
    public string $message = '';

    public function login(): void
    {
        $this->message = '';

        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            $this->message = 'Invalid email or password.';
            return;
        }

        $secret = config('services.jwt.secret');

        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        $token = JWT::encode($payload, $secret, 'HS256');

        session(['jwt_token' => $token]);

        $this->message = 'Login successful! JWT created.';
        $this->reset('password');
    }
};
?>

<div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
    <h1>Pixel Pals</h1>
    <h2>Login</h2>

    @if ($message)
        <p>{{ $message }}</p>
    @endif

    <form wire:submit="login">
        <div style="margin-bottom: 15px;">
            <label>Email</label><br>
            <input type="email" wire:model="email" style="width: 100%; padding: 8px;">

            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Password</label><br>
            <input type="password" wire:model="password" style="width: 100%; padding: 8px;">

            @error('password')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Login</button>
    </form>
</div>