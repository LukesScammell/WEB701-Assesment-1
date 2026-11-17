<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DonationController extends Controller
{
    // Display the donation page
    public function create()
    {
        return view('donations');
    }

    // Validate and process a token donation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => [
                'required',
                'integer',
                Rule::in([25, 50, 100, 150, 250, 500]),
            ],
        ]);

        $amount = (int) $validated['amount'];

        DB::transaction(function () use ($request, $amount) {

            // Lock the account while updating its balance
            $user = User::whereKey($request->user()->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Prevent donations exceeding the available balance
            if ($user->token_balance < $amount) {
                throw ValidationException::withMessages([
                    'amount' => 'You do not have enough Pixel Tokens for this donation.',
                ]);
            }

            // Deduct tokens from the user's account
            $user->token_balance -= $amount;
            $user->save();

            // Save the donation transaction
            Donation::create([
                'user_id' => $user->id,
                'donor_name' => $user->name,
                'donor_email' => $user->email,
                'amount' => $amount,
                'status' => 'completed',
            ]);
        });

        return redirect()
            ->route('donations')
            ->with('success', "Thank you! You donated {$amount} Pixel Tokens.");
    }
}
