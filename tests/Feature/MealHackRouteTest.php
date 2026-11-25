<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

class MealHackRouteTest extends TestCase
{
    public function test_meal_hack_read_and_create_require_login(): void
    {
        foreach (['meal.index' => 'GET', 'meal.store' => 'POST'] as $name => $method) {
            $route = Route::getRoutes()->getByName($name);

            $this->assertNotNull($route);
            $this->assertContains($method, $route->methods());
            $this->assertContains('auth', $route->gatherMiddleware());
            $this->assertNotContains(RoleMiddleware::class . ':admin', $route->gatherMiddleware());
        }
    }

    public function test_meal_hack_management_routes_require_admin(): void
    {
        foreach (['meal.edit' => 'GET', 'meal.update' => 'PATCH', 'meal.destroy' => 'DELETE'] as $name => $method) {
            $route = Route::getRoutes()->getByName($name);

            $this->assertNotNull($route);
            $this->assertContains($method, $route->methods());
            $this->assertContains('auth', $route->gatherMiddleware());
            $this->assertContains(RoleMiddleware::class . ':admin', $route->gatherMiddleware());
        }
    }
}

