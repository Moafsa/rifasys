<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form for requesting a password reset link.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.exists' => 'Não encontramos um usuário com este email.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        $passwordReset = PasswordReset::createForUser($user);
        
        // Send reset email
        $this->sendResetEmail($user, $passwordReset);

        return redirect()->route('password.check-email')->with('reset_email', $user->email);
    }

    /**
     * Send reset password email to user.
     */
    private function sendResetEmail(User $user, PasswordReset $passwordReset): void
    {
        $resetLink = route('password.confirm.show', [
            'token' => $passwordReset->token,
            'email' => $user->email
        ]);

        Mail::send('emails.reset-password-link', [
            'user' => $user,
            'passwordReset' => $passwordReset,
            'resetLink' => $resetLink
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Redefinir Senha - RAFE');
        });
    }
}
