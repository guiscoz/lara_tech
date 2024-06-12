<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\HomeController;
use Illuminate\View\View;
use Mockery;

class HomeControllerTest extends TestCase
{
    public function testHomeReturnsWelcomeView()
    {
        $controller = new HomeController();
        $response = $controller->home();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('welcome', $response->name());
    }
}
