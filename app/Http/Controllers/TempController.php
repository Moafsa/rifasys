<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempController extends Controller
{
    public function clearLogin()
    {
        // Limpar sessão e redirecionar para login limpo
        session()->flush();
        return redirect()->route('login')->with('success', 'Sessão limpa com sucesso!');
    }
}
