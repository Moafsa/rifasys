<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Temporarily disable middleware for testing
        // $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validação rigorosa do Gmail
        $credentials = $request->validate([
            'email' => [
                'required', 
                'email', 
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                'exists:users,email'
            ],
            'password' => ['required'],
        ], [
            'email.required' => 'O campo Gmail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.regex' => 'Apenas contas Gmail são permitidas (@gmail.com).',
            'email.exists' => 'Este Gmail não está cadastrado em nossa plataforma.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        // Verificação adicional de existência do usuário
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'Este Gmail não está cadastrado. Verifique o endereço ou faça um cadastro.',
            ])->onlyInput('email');
        }

        // Verificação se é realmente Gmail
        if (!str_ends_with(strtolower($credentials['email']), '@gmail.com')) {
            return back()->withErrors([
                'email' => 'Apenas contas Gmail são permitidas. Use um endereço @gmail.com',
            ])->onlyInput('email');
        }

        // Check if email is verified before attempting login
        if (!$user->hasVerifiedEmail()) {
            // Create and send new verification email
            $verification = EmailVerification::createForUser($user);
            $this->sendVerificationEmail($user, $verification);
            
            // Fazer login primeiro para poder acessar a página de verificação
            Auth::login($user);
            
            return redirect()->route('verification.method')
                ->with('error', 'Você precisa verificar sua conta antes de continuar. Escolha como deseja receber o código de verificação.');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // FORÇAR verificação após login
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.method')
                    ->with('error', 'Você precisa verificar sua conta antes de continuar. Escolha como deseja receber o código de verificação.');
            }
            
            return redirect()->route('home')->with('success', 'Login realizado com sucesso! Bem-vindo de volta!');
        }

        return back()->withErrors([
            'email' => 'Gmail ou senha incorretos. Verifique suas credenciais.',
        ])->onlyInput('email')->with('warning', 
            'Credenciais inválidas. Consulte nossos <a href="' . route('terms') . '" class="underline text-blue-600 hover:text-blue-800">Termos de Uso</a> se precisar de ajuda.'
        );
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('home')->with('success', 'Logout realizado com sucesso! Volte sempre!');
        } catch (\Exception $e) {
            // Em caso de erro, apenas redireciona
            return redirect()->route('home');
        }
    }

    /**
     * Send verification email to user.
     */
    private function sendVerificationEmail($user, EmailVerification $verification): void
    {
        $verificationLink = route('verification.confirm.show', [
            'token' => $verification->token,
            'email' => $user->email
        ]);

        Mail::send('emails.verify-email-link', [
            'user' => $user,
            'verificationLink' => $verificationLink
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verificar Email - RAFE');
        });
    }
}
