<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\EmailVerification;

class TestEmailController extends Controller
{
    public function testEmail(Request $request)
    {
        // Get first user or create a test one
        $user = User::first();
        
        if (!$user) {
            return response()->json(['error' => 'No users found'], 404);
        }

        // Create verification
        $verification = EmailVerification::createForUser($user);
        
        try {
            // Send email
            Mail::send('emails.verify-email', [
                'user' => $user,
                'verification' => $verification,
                'verificationCode' => $verification->token
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Teste - Código de Verificação - RAFE');
            });

            return response()->json([
                'success' => true,
                'message' => 'Email enviado com sucesso!',
                'user' => $user->email,
                'code' => $verification->token
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Falha ao enviar email: ' . $e->getMessage()
            ], 500);
        }
    }
}

