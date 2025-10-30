<?php

namespace Tests\Feature\V2;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiVersionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_v2_version_endpoint()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v2/version');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'api_version',
                'features',
                'improvements_over_v1',
                'deprecations',
                'migration_guide'
            ])
            ->assertJson([
                'api_version' => '2.0'
            ]);
    }

    /** @test */
    public function it_can_access_v2_health_endpoint()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v2/health');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'version',
                'timestamp',
                'database',
                'cache',
                'features'
            ])
            ->assertJson([
                'status' => 'healthy',
                'version' => '2.0'
            ]);
    }

    /** @test */
    public function it_has_enhanced_headers_in_v2()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v2/version');

        $response->assertStatus(200);
        
        // V2 debe tener headers mejorados
        $this->assertTrue($response->headers->has('X-API-Version') || 
                         $response->headers->has('x-api-version'));
    }

    /** @test */
    public function v1_and_v2_coexist_properly()
    {
        $user = User::factory()->create();
        
        // Test V1 sigue funcionando
        $v1Response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/tickets');
        
        $v1Response->assertStatus(200);
        
        // Test V2 también funciona
        $v2Response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v2/tickets');
        
        $v2Response->assertStatus(200);
        
        // Ambas versiones deben funcionar independientemente
        $this->assertTrue($v1Response->isOk());
        $this->assertTrue($v2Response->isOk());
    }
}
