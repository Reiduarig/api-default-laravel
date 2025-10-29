<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Services\API\V1\ApiResponseService;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    

    public function login(LoginRequest $request)
    {
        // Validar las credenciales del usuario
        $credentials = $request->only('email', 'password');

        if (! auth()->attempt([
            'email' => data_get($credentials, 'email'),
            'password' => data_get($credentials, 'password'),
        ])) {
            return ApiResponseService::error(
                'Credenciales incorrectas',
                401
            );
        }
       
        $token = auth()
            ->user()
            ->createToken(
                data_get($credentials, 'email'),
                ['*'],
                now()->addMonth()
            )->plainTextToken;
        
        return ApiResponseService::success(
            [
                'user' => auth()->user(),
                'token' => $token
            ],
            'Inicio de sesión exitoso.'
        );
    }

    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return ApiResponseService::success('Registro exitoso.', $user);
    }

    // Revocar el token de acceso actual
    public function logout(Request $request)
    {
        $user = $request->user();
        $token = $user->currentAccessToken();
        
        // En testing, el token puede ser TransientToken que no tiene delete()
        if ($token && method_exists($token, 'delete')) {
            $token->delete();
        }

        return ApiResponseService::success(
            [],
            'Sesión cerrada correctamente'
        );
    }

    // Revocar todos los tokens de acceso del usuario, esto cerrará sesión en todos los dispositivos
    public function logoutAllDevices(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponseService::success(
            [],
            'Sesión cerrada correctamente'
        );
    }

}
