<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for resetting the password (Step 1 - Verify Code).
     */
    public function showResetForm(Request $request): View
    {
        return view('auth.reset-password-step1');
    }

    /**
     * Show confirmation page for password reset link.
     */
    public function showConfirm(Request $request): View
    {
        $token = $request->get('token');
        $email = $request->get('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user || !$token) {
            return redirect()->route('home')->with('error', 'Link de redefinição inválido.');
        }

        return view('auth.confirm-password-reset', compact('user', 'token'));
    }

    /**
     * Confirm password reset with link.
     */
    public function confirmReset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'action' => 'required|in:confirm,deny'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        $passwordReset = PasswordReset::where('user_id', $user->id)
            ->where('token', $request->token)
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->first();

        if (!$passwordReset) {
            return redirect()->route('home')->with('error', 'Link de redefinição inválido ou expirado.');
        }

        if ($request->action === 'confirm') {
            // Store verified data in session for step 2
            session([
                'reset_email' => $request->email,
                'reset_token' => $request->token,
                'reset_verified' => true
            ]);

            return redirect()->route('password.reset-step2')
                ->with('success', 'Confirmação realizada! Agora defina sua nova senha.');
        } else {
            // Denied - mark as used and redirect
            $passwordReset->markAsUsed();
            return redirect()->route('home')->with('info', 'Redefinição cancelada. Você pode solicitar novamente mais tarde.');
        }
    }

    /**
     * Verify the reset code (Step 1) - legacy method.
     */
    public function verifyCode(Request $request): RedirectResponse
    {
        return redirect()->route('home')->with('error', 'Método de verificação não suportado. Use o link enviado por email.');
    }

    /**
     * Show the password reset form (Step 2 - New Password).
     */
    public function showResetStep2(Request $request): View
    {
        // Check if user is coming from step 1
        if (!session('reset_verified')) {
            return redirect()->route('password.reset')
                ->with('error', 'Acesso negado. Você deve confirmar o link primeiro.');
        }

        return view('auth.reset-password-step2');
    }

    /**
     * Reset the user's password (Step 2).
     */
    public function reset(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Verify session data
        if (!session('reset_verified') || !session('reset_email') || !session('reset_token')) {
            return redirect()->route('password.reset')
                ->with('error', 'Sessão expirada. Solicite um novo link de redefinição.');
        }

        // Verify the token again for security
        $passwordReset = PasswordReset::where('token', session('reset_token'))
            ->where('email', session('reset_email'))
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->first();

        if (!$passwordReset) {
            session()->forget(['reset_email', 'reset_token', 'reset_verified']);
            return redirect()->route('password.reset')
                ->with('error', '❌ Link expirado. Solicite um novo link de redefinição.');
        }

        // Update password
        $passwordReset->user->update([
            'password' => Hash::make($request->password)
        ]);

        // Mark token as used
        $passwordReset->markAsUsed();

        // Clear session
        session()->forget(['reset_email', 'reset_token', 'reset_verified']);

        return redirect()->route('login')
            ->with('success', '🎉 Senha redefinida com sucesso! Faça login com sua nova senha.');
    }
}