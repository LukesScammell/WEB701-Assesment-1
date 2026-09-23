<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::app')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $message = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'tokens' => 100,
        ]);

        $this->message = 'Registration successful! You have received 100 tokens.';

        $this->reset('name', 'email', 'password');
    }
};
?>

<div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
    <h1>Pixel Pals</h1>
    <h2>Create Account</h2>

    @if ($message)
        <p style="color: green;">{{ $message }}</p>
    @endif

    <form wire:submit="register">
        <div style="margin-bottom: 15px;">
            <label>Name</label><br>
            <input type="text" wire:model="name" style="width: 100%; padding: 8px;">

            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

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

        <button type="submit">Register</button>
    </form>
</div>