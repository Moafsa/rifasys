<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
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
        // $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'phone' => ['required', 'string', 'max:20'],
            'document' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo Gmail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.regex' => 'Apenas contas Gmail são permitidas (@gmail.com).',
            'email.unique' => 'Este Gmail já está cadastrado. Use outro endereço ou faça login.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'document.required' => 'O campo CPF é obrigatório.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'terms.required' => 'Você deve aceitar os termos de uso.',
            'terms.accepted' => 'Você deve aceitar os termos de uso.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'document' => $data['document'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            // Validação inicial
            $this->validator($request->all())->validate();

            // Verificação adicional se é Gmail
            $email = $request->input('email');
            
            if (!str_ends_with(strtolower($email), '@gmail.com')) {
                return back()->withErrors([
                    'email' => 'Apenas contas Gmail são permitidas. Use um endereço @gmail.com',
                ])->onlyInput('email', 'name', 'phone', 'document');
            }

            // Verificação se o Gmail já existe
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                return back()->withErrors([
                    'email' => 'Este Gmail já está cadastrado. Use outro endereço ou faça login.',
                ])->onlyInput('name', 'phone', 'document');
            }

            // Verificação se o CPF já existe (permitir até 3 cadastros)
            $document = $request->input('document');
            $documentCount = User::where('document', $document)->count();
            if ($documentCount >= 3) {
                return back()->withErrors([
                    'document' => 'Este CPF já possui 3 cadastros. Máximo permitido.',
                ])->onlyInput('name', 'email', 'phone');
            }

            $user = $this->create($request->all());

            // Create email verification
            $verification = EmailVerification::createForUser($user);
            
            // Send verification email
            $this->sendVerificationEmail($user, $verification);

            // Fazer login para poder acessar a página de verificação
            Auth::login($user);

            return redirect()->route('verification.method')->with('success', 'Cadastro realizado com sucesso! Escolha como deseja verificar sua conta.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to be handled by Laravel
            throw $e;
        } catch (\Exception $e) {
            // Handle other exceptions (like database constraint violations)
            return back()->withErrors([
                'email' => 'Erro ao criar conta. Verifique se os dados estão corretos e tente novamente.',
            ])->onlyInput('name', 'phone', 'document')->with('error', 
                'Ação não permitida. Consulte nossos <a href="' . route('terms') . '" class="underline text-blue-600 hover:text-blue-800">Termos de Uso</a> para mais informações.'
            );
        }
    }

    /**
     * Send verification email to user.
     */
    private function sendVerificationEmail(User $user, EmailVerification $verification): void
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
