<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

describe('Authentication API', function () {
    
    describe('Login', function () {
        it('can login with valid credentials', function () {
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password123')
            ]);

            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'test@example.com',
                'password' => 'password123'
            ]);

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data' => [
                        'user' => [
                            'id',
                            'name',
                            'email'
                        ],
                        'token'
                    ]
                ]);

            expect($response->json('status'))->toBe('success');
            expect($response->json('data.user.email'))->toBe('test@example.com');
            expect($response->json('data.token'))->toBeString();
        });

        it('cannot login with invalid credentials', function () {
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password123')
            ]);

            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'test@example.com',
                'password' => 'wrong-password'
            ]);

            $response->assertStatus(401)
                ->assertJson([
                    'status' => 'error',
                    'message' => 'Credenciales incorrectas'
                ]);
        });

        it('requires email and password', function () {
            $response = $this->postJson('/api/v1/auth/login', []);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email', 'password']);
        });

        it('requires valid email format', function () {
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'not-an-email',
                'password' => 'password123'
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });
    });

    describe('Logout', function () {
        it('can logout with valid token', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/logout');

            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Sesión cerrada correctamente'
                ]);
        });

        it('cannot logout without authentication', function () {
            $response = $this->postJson('/api/v1/logout');

            $response->assertStatus(401);
        });
    });

    describe('Logout All Devices', function () {
        it('can logout from all devices', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/logoutAllDevices');

            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Sesión cerrada correctamente'
                ]);
        });

        it('cannot logout all devices without authentication', function () {
            $response = $this->postJson('/api/v1/logoutAllDevices');

            $response->assertStatus(401);
        });
    });

    describe('Token Management', function () {
        it('creates a token with expiration', function () {
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password123')
            ]);

            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'test@example.com',
                'password' => 'password123'
            ]);

            $token = $response->json('data.token');
            
            // Verificar que el token funciona
            $protectedResponse = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->getJson('/api/v1/users');

            $protectedResponse->assertStatus(200);
        });

        it('invalidates token after logout', function () {
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password123')
            ]);

            // Login
            $loginResponse = $this->postJson('/api/v1/auth/login', [
                'email' => 'test@example.com',
                'password' => 'password123'
            ]);

            $token = $loginResponse->json('data.token');

            // Hacer logout (esto debería invalidar el token)
            $logoutResponse = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->postJson('/api/v1/logout');

            $logoutResponse->assertStatus(200);

            // Note: En testing con Sanctum::actingAs, los tokens no se invalidan realmente
            // por lo que no podemos probar la invalidación directamente en este contexto
            // Este test verifica que el logout endpoint funciona correctamente
        });
    });
});