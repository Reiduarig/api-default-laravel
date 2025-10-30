<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Services\API\V1\ApiResponseService;

/**
 * @group Autenticación
 * 
 * Endpoints para gestión de autenticación usando Laravel Sanctum.
 * Los endpoints de login y register no requieren autenticación.
 * Los endpoints de logout requieren autenticación Bearer token.
 */
class AuthController extends Controller
{
    /**
     * Iniciar sesión
     * 
     * Autentica un usuario con email y contraseña, devuelve un token Bearer para acceder a endpoints protegidos.
     * 
     * @unauthenticated
     * 
     * @bodyParam email string required Email del usuario. Example: admin@admin.com
     * @bodyParam password string required Contraseña del usuario. Example: password
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Inicio de sesión exitoso.",
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "name": "Admin User",
     *       "email": "admin@admin.com",
     *       "email_verified_at": null,
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T10:00:00.000000Z"
     *     },
     *     "token": "1|abcdef123456789..."
     *   }
     * }
     * 
     * @response 401 {
     *   "status": "error",
     *   "message": "Credenciales incorrectas"
     * }
     */
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

    /**
     * Registrar usuario
     * 
     * Crea una nueva cuenta de usuario en el sistema.
     * 
     * @unauthenticated
     * 
     * @bodyParam name string required Nombre completo del usuario. Example: Juan Pérez
     * @bodyParam email string required Email único del usuario. Example: juan@example.com
     * @bodyParam password string required Contraseña (mínimo 8 caracteres). Example: password123
     * @bodyParam password_confirmation string required Confirmación de contraseña. Example: password123
     * 
     * @response 201 {
     *   "status": "success",
     *   "message": "Registro exitoso.",
     *   "data": {
     *     "id": 2,
     *     "name": "Juan Pérez",
     *     "email": "juan@example.com",
     *     "email_verified_at": null,
     *     "created_at": "2025-10-30T11:00:00.000000Z",
     *     "updated_at": "2025-10-30T11:00:00.000000Z"
     *   }
     * }
     * 
     * @response 422 {
     *   "status": "error",
     *   "message": "Los datos proporcionados no son válidos.",
     *   "data": {
     *     "email": ["The email has already been taken."]
     *   }
     * }
     */
    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return ApiResponseService::success('Registro exitoso.', $user);
    }

    /**
     * Cerrar sesión
     * 
     * Revoca el token actual y cierra la sesión en este dispositivo específico.
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Sesión cerrada correctamente",
     *   "data": []
     * }
     */
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

    /**
     * Cerrar sesión en todos los dispositivos
     * 
     * Revoca TODOS los tokens del usuario, cerrando sesión en todos los dispositivos donde esté autenticado.
     * Útil para desconectar por seguridad o cambio de contraseña.
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Sesión cerrada correctamente",
     *   "data": []
     * }
     */
    public function logoutAllDevices(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponseService::success(
            [],
            'Sesión cerrada correctamente'
        );
    }

}
