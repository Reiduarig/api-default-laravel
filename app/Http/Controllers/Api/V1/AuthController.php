<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginRequest $request)
    {
        // Validar las credenciales del usuario
        $credentials = $request->only('email', 'password');

        if (! auth()->attempt([
            'email' => data_get($credentials, 'email'),
            'password' => data_get($credentials, 'password'),
        ])) 
        {
            return $this->error('Credenciales incorrectas', 401);
        }

        return $this->success(
            'Autenticado correctamente',
            [
                'token' => auth()->user()->createToken(
                    'API Token for ' . auth()->user()->email,
                    ['*'],
                    now()->addMonth())->plainTextToken,
            ]
        );
    }

    public function register()
    {
        return $this->success('register');
    }

    // Revocar el token de acceso actual
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(
            'Sesión cerrada correctamente',
        );
    }

    // Revocar todos los tokens de acceso del usuario, esto cerrará sesión en todos los dispositivos
    public function logoutAllDevices(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success(
            'Sesión cerrada en todos los dispositivos correctamente',
            []
        );
    } 
}
