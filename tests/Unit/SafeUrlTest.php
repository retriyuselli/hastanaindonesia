<?php

namespace Tests\Unit;

use App\Support\SafeUrl;
use PHPUnit\Framework\TestCase;

class SafeUrlTest extends TestCase
{
    public function test_it_allows_http_urls_without_credentials(): void
    {
        $this->assertSame('https://example.com/path', SafeUrl::http(' https://example.com/path '));
        $this->assertSame('http://example.com', SafeUrl::http('http://example.com'));
    }

    public function test_it_rejects_unsafe_or_credentialed_urls(): void
    {
        $this->assertNull(SafeUrl::http('javascript:alert(1)'));
        $this->assertNull(SafeUrl::http('data:text/html,test'));
        $this->assertNull(SafeUrl::http('https://user:password@example.com'));
        $this->assertNull(SafeUrl::http('http://example.com', httpsOnly: true));
    }
}
