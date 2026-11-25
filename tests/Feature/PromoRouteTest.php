<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\PromoController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PromoRouteTest extends TestCase
{
    public function test_promo_category_filter_uses_public_index_route(): void
    {
        foreach (['makanan', 'minuman', 'jajan'] as $kategori) {
            $url = route('promo.index', ['kategori' => $kategori], false);
            $request = Request::create($url, 'GET');
            $matched = Route::getRoutes()->match($request);
            $this->assertSame(PromoController::class . '@index', $matched->getActionName());
            $this->assertSame($kategori, $request->query('kategori'));
            $this->assertNotContains('auth', $matched->gatherMiddleware());
        }
    }

    public function test_promo_write_routes_require_admin(): void
    {
        foreach (['promo.create' => 'GET', 'promo.store' => 'POST', 'promo.edit' => 'GET',
                  'promo.update' => 'PATCH', 'promo.destroy' => 'DELETE'] as $name => $method) {
            $route = Route::getRoutes()->getByName($name);
            $this->assertNotNull($route);
            $this->assertContains($method, $route->methods());
            $this->assertContains('auth', $route->gatherMiddleware());
            $this->assertContains(RoleMiddleware::class . ':admin', $route->gatherMiddleware());
        }
    }
}
