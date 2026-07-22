<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\SecureSessionMiddleware;
use ReflectionClass;

class SecureSessionUserAgentTest extends TestCase
{
    /**
     * Test that minor browser version changes don't trigger false positives
     */
    public function test_minor_version_changes_should_not_trigger_hijacking()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        // Chrome minor version update
        $ua1 = 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36';
        $ua2 = 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.1 Mobile Safari/537.36';
        
        $hash1 = $method->invoke($middleware, $ua1);
        $hash2 = $method->invoke($middleware, $ua2);
        
        $this->assertEquals($hash1, $hash2, 'Minor version changes should produce the same hash');
    }

    /**
     * Test that whitespace differences don't trigger false positives
     */
    public function test_whitespace_differences_should_not_trigger_hijacking()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        $ua1 = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
        $ua2 = 'Mozilla/5.0  (Windows NT 10.0;  Win64; x64)  AppleWebKit/537.36  (KHTML, like Gecko)  Chrome/120.0.0.0  Safari/537.36';
        
        $hash1 = $method->invoke($middleware, $ua1);
        $hash2 = $method->invoke($middleware, $ua2);
        
        $this->assertEquals($hash1, $hash2, 'Whitespace differences should produce the same hash');
    }

    /**
     * Test that different browsers produce different hashes
     */
    public function test_different_browsers_should_produce_different_hashes()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        $chrome = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
        $firefox = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0';
        
        $chromeHash = $method->invoke($middleware, $chrome);
        $firefoxHash = $method->invoke($middleware, $firefox);
        
        $this->assertNotEquals($chromeHash, $firefoxHash, 'Different browsers should produce different hashes');
    }

    /**
     * Test that mobile vs desktop produces different hashes
     */
    public function test_mobile_vs_desktop_should_produce_different_hashes()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        $desktop = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
        $mobile = 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36';
        
        $desktopHash = $method->invoke($middleware, $desktop);
        $mobileHash = $method->invoke($middleware, $mobile);
        
        $this->assertNotEquals($desktopHash, $mobileHash, 'Mobile and desktop should produce different hashes');
    }

    /**
     * Test that same device produces consistent hashes
     */
    public function test_same_device_should_produce_consistent_hashes()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        // Simulate multiple requests from same mobile device
        $ua1 = 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36';
        $ua2 = 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36';
        
        $hash1 = $method->invoke($middleware, $ua1);
        $hash2 = $method->invoke($middleware, $ua2);
        
        $this->assertEquals($hash1, $hash2, 'Same User Agent should produce the same hash');
    }

    /**
     * Test null and empty user agents
     */
    public function test_null_and_empty_user_agents()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        $hashNull = $method->invoke($middleware, null);
        $hashEmpty = $method->invoke($middleware, '');
        
        $this->assertEquals('unknown', $hashNull);
        $this->assertEquals('unknown', $hashEmpty);
    }

    /**
     * Test that major browser changes ARE detected (legitimate security check)
     */
    public function test_major_browser_change_should_be_detected()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        $chrome = 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36';
        $firefox = 'Mozilla/5.0 (Android 15; Mobile; rv:120.0) Gecko/120.0 Firefox/120.0';
        
        $chromeHash = $method->invoke($middleware, $chrome);
        $firefoxHash = $method->invoke($middleware, $firefox);
        
        $this->assertNotEquals($chromeHash, $firefoxHash, 'Switching browsers should produce different hashes (legitimate security check)');
    }

    /**
     * Test different platforms with same browser
     */
    public function test_different_platforms_same_browser()
    {
        $middleware = new SecureSessionMiddleware();
        $reflection = new ReflectionClass($middleware);
        $method = $reflection->getMethod('getUaHash');
        $method->setAccessible(true);

        $windows = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
        $android = 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36';
        
        $windowsHash = $method->invoke($middleware, $windows);
        $androidHash = $method->invoke($middleware, $android);
        
        $this->assertNotEquals($windowsHash, $androidHash, 'Different platforms should produce different hashes');
    }
}
