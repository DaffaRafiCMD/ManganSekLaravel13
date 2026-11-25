<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TempatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MinumanJajanTest extends TestCase
{
    public function test_minuman_and_jajan_have_correct_category_routes(): void
    {
        foreach (['minuman', 'jajan'] as $kategori) {
            $url = route('kategori', ['kategori' => $kategori], false);
            $this->assertSame('/kategori/' . $kategori, $url);
            $matched = Route::getRoutes()->match(Request::create($url, 'GET'));
            $this->assertSame(TempatController::class . '@index', $matched->getActionName());
            $this->assertSame($kategori, $matched->parameter('kategori'));
            $this->assertContains('auth', $matched->gatherMiddleware());
        }
    }

    public function test_admin_create_form_preserves_drink_and_snack_categories(): void
    {
        foreach (['minuman', 'jajan'] as $kategori) {
            $request = Request::create('/menu/create', 'GET', ['kategori' => $kategori]);
            $view = app(MenuController::class)->create($request);
            $this->assertSame('menu.form', $view->name());
            $this->assertSame($kategori, $view->getData()['tempat']->kategori);
        }
    }
}
