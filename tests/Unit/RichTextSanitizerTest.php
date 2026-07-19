<?php

namespace Tests\Unit;

use App\Support\RichTextSanitizer;
use PHPUnit\Framework\TestCase;

class RichTextSanitizerTest extends TestCase
{
    public function test_it_keeps_safe_rich_text_and_removes_executable_content(): void
    {
        $html = <<<'HTML'
            <p onclick="alert(1)">Konten <strong>aman</strong>.</p>
            <script>alert('xss')</script>
            <a href="javascript:alert(1)">Tautan berbahaya</a>
            <a href="https://hastanaindonesia.com">Tautan aman</a>
            HTML;

        $sanitized = (new RichTextSanitizer)->sanitize($html);

        $this->assertStringContainsString('<p>Konten <strong>aman</strong>.</p>', $sanitized);
        $this->assertStringNotContainsString('onclick', $sanitized);
        $this->assertStringNotContainsString('<script', $sanitized);
        $this->assertStringNotContainsString('javascript:', $sanitized);
        $this->assertStringContainsString('href="https://hastanaindonesia.com"', $sanitized);
        $this->assertStringContainsString('rel="noopener noreferrer"', $sanitized);
    }
}
