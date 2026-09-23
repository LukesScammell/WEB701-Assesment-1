<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::app')] class extends Component
{
    public ?int $amount = null;
    public ?int $tokens = null;
    public string $message = '';

    public function mount(): void
    {
        $user = $this->getAuthenticatedUser();

        if (!$user) {
            return;
        }

        $this->tokens = $user->tokens;
    }

    public function transaction(): void
    {
        $this->message = '';

        $user = $this->getAuthenticatedUser();

        if (!$user) {
            return;
        }

        $validated = $this->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $amount = $validated['amount'];

        if ($amount > $user->tokens) {
            $this->message = 'Not enough tokens.';
            return;
        }

        $user->tokens -= $amount;
        $user->save();

        $this->tokens = $user->tokens;
        $this->message = 'Transaction successful! Remaining tokens: ' . $user->tokens;

        $this->reset('amount');
    }

    private function getAuthenticatedUser(): ?User
    {
        $token = session('jwt_token');

        if (!$token) {
            $this->message = 'Please login first.';
            return null;
        }

        try {
            $secret = config('services.jwt.secret');

            $decoded = JWT::decode($token, new Key($secret, 'HS256'));

            $user = User::find($decoded->sub);

            if (!$user) {
                $this->message = 'User not found.';
                return null;
            }

            return $user;
        } catch (\Exception $e) {
            $this->message = 'Invalid or expired login token.';
            return null;
        }
    }
};
?>

<div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
    <h1>Pixel Pals</h1>
    <h2>Token Transaction</h2>

    @if ($tokens !== null)
        <p><strong>Current Tokens:</strong> {{ $tokens }}</p>
    @endif

    @if ($message)
        <p>{{ $message }}</p>
    @endif

    @if ($tokens !== null)
        <form wire:submit="transaction">
            <div style="margin-bottom: 15px;">
                <label>Token Amount</label><br>
                <input type="number" wire:model="amount" min="1" style="width: 100%; padding: 8px;">

                @error('amount')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Submit Transaction</button>
        </form>
    @endif
</div>