<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Asegúrate de tener esta línea
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
