<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoutesCheckTest extends TestCase
{
    /**
     * Test that all referenced routes exist
     */
    public function test_auth_routes_exist()
    {
        $requiredRoutes = [
            'login',
            'logout',
            'register',
            'password.request',
            'password.email',
            'password.reset',
            'password.update',
            'password.confirm',
            'verification.notice',
            'verification.verify',
            'verification.send',
            'home',
            'dashboard',
            'admin',
            'data-management'
        ];

        $definedRoutes = collect(Route::getRoutes())->map->getName()->filter()->unique()->toArray();

        foreach ($requiredRoutes as $route) {
            $this->assertContains($route, $definedRoutes, "Route '{$route}' is not defined!");
        }
    }

    /**
     * Test that no undefined frontend or backend routes are being used
     */
    public function test_no_generic_backend_routes()
    {
        $definedRoutes = collect(Route::getRoutes())->map->getName()->filter()->unique()->toArray();
        
        // These generic routes should NOT exist (they're in old templates that aren't used)
        $forbiddenPatterns = [
            'backend.dashboard',
            'frontend.posts.index',
            'frontend.categories.index',
            'frontend.tags.index',
            'frontend.comments.index'
        ];

        foreach ($forbiddenPatterns as $pattern) {
            $this->assertNotContains($pattern, $definedRoutes, 
                "Old route '{$pattern}' should not be defined in SPA system!");
        }
    }

    /**
     * Test that SPA redirects work
     */
    public function test_spa_redirects()
    {
        // Test unauthenticated redirect
        $response = $this->get('/');
        $this->assertThat(
            $response->status(),
            $this->logicalOr(
                $this->equalTo(302),
                $this->equalTo(307)
            ),
            'Home route should redirect'
        );

        // Test login page loads
        $response = $this->get('/login');
        $this->assertThat(
            $response->status(),
            $this->logicalOr(
                $this->equalTo(200),
                $this->equalTo(302),
                $this->equalTo(307)
            )
        );
    }

    /**
     * Test that language route exists
     */
    public function test_language_switch_route()
    {
        $definedRoutes = collect(Route::getRoutes())->map->getName()->filter()->unique()->toArray();
        $this->assertContains('language.switch', $definedRoutes, "Language switch route should be defined!");
    }
}
