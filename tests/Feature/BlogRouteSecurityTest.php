<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class BlogRouteSecurityTest extends TestCase
{
    public function test_blog_engagement_mutations_are_rate_limited(): void
    {
        $likeRoute = Route::getRoutes()->getByName('blog.toggle-like');
        $commentRoute = Route::getRoutes()->getByName('blog.comment.store');

        $this->assertNotNull($likeRoute);
        $this->assertNotNull($commentRoute);
        $this->assertContains('throttle:20,1', $likeRoute->gatherMiddleware());
        $this->assertContains('throttle:5,1', $commentRoute->gatherMiddleware());
    }

    public function test_obsolete_get_view_pixel_route_is_removed(): void
    {
        $viewPixelRoute = collect(Route::getRoutes()->getRoutes())
            ->first(fn ($route) => str_contains($route->uri(), 'view-pixel'));

        $this->assertNull($viewPixelRoute);
    }
}
