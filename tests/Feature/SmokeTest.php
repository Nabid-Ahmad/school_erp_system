<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Renders every page of the application (public + admin) to catch view errors,
 * undefined-route links and permission breakage in one sweep.
 */
class SmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PermissionSeeder::class);

        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_public_pages_render(): void
    {
        $this->get('/')->assertOk();
        $this->get('/login')->assertOk();
        $this->get('/register')->assertNotFound();
        $this->get('/up')->assertOk();
    }

    public function test_admin_can_render_every_module_page(): void
    {
        $routes = [
            '/dashboard',
            '/search?q=',
            '/profile',
            '/users',
            '/users/create',
            '/settings',
            '/classes',
            '/classes/create',
            '/subjects',
            '/subjects/create',
            '/teachers',
            '/teachers/create',
            '/students',
            '/students/create',
            '/fees',
            '/fees/create',
            '/fee-structures',
            '/galleries',
            '/galleries/create',
            '/events',
            '/events/create',
            '/expenses',
            '/expenses/create',
            '/attendances',
            '/attendances/create',
            '/results',
            '/results/create',
            '/salaries',
            '/promotions',
        ];

        $this->actingAs($this->admin);

        foreach ($routes as $route) {
            $this->get($route)->assertOk('Failed to render '.$route);
        }
    }

    public function test_teacher_can_render_their_pages(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher);
        $this->get('/attendances/create')->assertOk();
        $this->get('/results/create')->assertOk();
        $this->get('/fees')->assertForbidden();
    }
}