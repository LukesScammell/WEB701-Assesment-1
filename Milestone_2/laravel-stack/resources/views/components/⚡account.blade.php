<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::app')] class extends Component
{
    public ?string $name = null;
    public ?string $email = null;
    public ?int $tokens = null;
    public string $message = '';

    public function mount(): void
    {
        $token = session('jwt_token');

        if (!$token) {
            $this->message = 'Please login first.';
            return;
        }

        try {
            $secret = config('services.jwt.secret');

            $decoded = JWT::decode($token, new Key($secret, 'HS256'));

            $user = User::find($decoded->sub);

            if (!$user) {
                $this->message = 'User not found.';
                return;
            }

            $this->name = $user->name;
            $this->email = $user->email;
            $this->tokens = $user->tokens;
        } catch (\Exception $e) {
            $this->message = 'Invalid or expired login token.';
        }
    }
};
?>

<div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
    <h1>Pixel Pals</h1>
    <h2>My Account</h2>

    @if ($message)
        <p>{{ $message }}</p>
    @else
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Tokens:</strong> {{ $tokens }}</p>
    @endif
</div>