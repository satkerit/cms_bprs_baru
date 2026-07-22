<?php

namespace Tests\Unit\Helpers;

use App\Helpers\HtmlSanitizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class HtmlSanitizerTest extends TestCase
{
    #[Test]
    public function clean_removes_script_tags(): void
    {
        $input = '<p>Hello</p><script>alert("xss")</script>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<p>Hello</p>', $result);
        $this->assertStringNotContainsString('<script>', $result);
    }

    #[Test]
    public function clean_removes_event_handlers(): void
    {
        $input = '<img src="x" onerror="alert(1)">';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('onerror', $result);
    }

    #[Test]
    public function clean_removes_javascript_uris(): void
    {
        $input = '<a href="javascript:alert(1)">Click</a>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('javascript:', $result);
    }

    #[Test]
    public function clean_removes_vbscript_uris(): void
    {
        $input = '<a href="vbscript:msgbox(1)">Click</a>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('vbscript:', $result);
    }

    #[Test]
    public function clean_removes_data_uris_in_dangerous_contexts(): void
    {
        $input = '<iframe src="data:text/html,<script>alert(1)</script>"></iframe>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('data:', $result);
        $this->assertStringNotContainsString('<iframe', $result);
    }

    #[Test]
    public function clean_preserves_safe_html_tags(): void
    {
        $input = '<p><strong>Bold</strong> and <em>italic</em></p>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<p>', $result);
        $this->assertStringContainsString('<strong>Bold</strong>', $result);
        $this->assertStringContainsString('<em>italic</em>', $result);
    }

    #[Test]
    public function clean_allows_headings(): void
    {
        $input = '<h1>Title</h1><h2>Subtitle</h2><h3>Section</h3>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<h1>Title</h1>', $result);
        $this->assertStringContainsString('<h2>Subtitle</h2>', $result);
    }

    #[Test]
    public function clean_allows_lists(): void
    {
        $input = '<ul><li>Item 1</li><li>Item 2</li></ul><ol><li>First</li></ol>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<ul>', $result);
        $this->assertStringContainsString('<ol>', $result);
        $this->assertStringContainsString('<li>Item 1</li>', $result);
    }

    #[Test]
    public function clean_allows_tables(): void
    {
        $input = '<table><tr><td>Cell</td></tr></table>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<table>', $result);
        $this->assertStringContainsString('<td>Cell</td>', $result);
    }

    #[Test]
    public function clean_removes_unknown_tags(): void
    {
        $input = '<p>Safe</p><marquee>Bad</marquee><blink>Worse</blink>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<p>Safe</p>', $result);
        $this->assertStringNotContainsString('<marquee', $result);
        $this->assertStringNotContainsString('<blink', $result);
    }

    #[Test]
    public function clean_sanitizes_external_links(): void
    {
        $input = '<a href="https://external.com">Link</a>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('rel="noopener noreferrer"', $result);
        $this->assertStringContainsString('target="_blank"', $result);
    }

    #[Test]
    public function clean_removes_css_expressions(): void
    {
        $input = '<div style="color:expression(alert(1))">Test</div>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('expression', $result);
    }

    #[Test]
    public function clean_removes_embed_and_object(): void
    {
        $input = '<embed src="evil.swf"><object data="evil.swf"></object>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('<embed', $result);
        $this->assertStringNotContainsString('<object', $result);
    }

    #[Test]
    public function clean_removes_form_input_and_button(): void
    {
        $input = '<form action="evil.com"><input name="x"><button>Submit</button></form>';
        $result = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('<form', $result);
        $this->assertStringNotContainsString('<input', $result);
        $this->assertStringNotContainsString('<button', $result);
    }

    #[Test]
    public function clean_does_not_break_on_null_input(): void
    {
        $this->assertEquals('', HtmlSanitizer::clean(null));
    }

    #[Test]
    public function clean_handles_empty_string(): void
    {
        $this->assertEquals('', HtmlSanitizer::clean(''));
    }

    #[Test]
    public function sanitize_is_alias_for_clean(): void
    {
        $input = '<script>alert(1)</script><p>Safe</p>';
        $clean = HtmlSanitizer::clean($input);
        $sanitize = HtmlSanitizer::sanitize($input);

        $this->assertEquals($clean, $sanitize);
    }

    #[Test]
    #[DataProvider('xssPayloadsProvider')]
    public function clean_blocks_common_xss_payloads(string $payload, string $description): void
    {
        $result = HtmlSanitizer::clean($payload);

        $this->assertStringNotContainsString('<script', $result, "Failed for: {$description}");
        $this->assertStringNotContainsString('onerror', $result, "Failed for: {$description}");
        $this->assertStringNotContainsString('onload', $result, "Failed for: {$description}");
        $this->assertStringNotContainsString('javascript:', $result, "Failed for: {$description}");
    }

    public static function xssPayloadsProvider(): array
    {
        return [
            ['<script>alert(1)</script>', 'Basic script tag'],
            ['<script src="http://evil.com/xss.js"></script>', 'External script'],
            ['<img src=x onerror=alert(1)>', 'Img onerror'],
            ['<body onload=alert(1)>', 'Body onload'],
            ['<svg onload=alert(1)>', 'SVG onload'],
            ['<a href="javascript:alert(1)">link</a>', 'Javascript URI'],
            ['<img src="javascript:alert(1)">', 'Img javascript URI'],
            ['<iframe src="javascript:alert(1)"></iframe>', 'Iframe javascript'],
            ["<a href=\"javascript:alert('XSS')\">link</a>", 'Javascript URI with quotes'],
            ['<div style="background:url(javascript:alert(1))">', 'CSS javascript URL'],
        ];
    }
}
