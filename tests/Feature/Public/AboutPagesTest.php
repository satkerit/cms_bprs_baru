<?php

namespace Tests\Feature\Public;

use Tests\TestCase;

class AboutPagesTest extends TestCase
{
    /**
     * Test company page returns 200 status code.
     * Requirements: 2.2
     */
    public function test_company_page_returns_successful_response(): void
    {
        $response = $this->withoutSecurityMiddleware()->get('/tentang-kami/perusahaan');

        $response->assertStatus(200);
    }

    /**
     * Test the combined Manajemen page returns 200 status code.
     * Requirements: 2.2
     */
    public function test_manajemen_page_returns_successful_response(): void
    {
        $response = $this->withoutSecurityMiddleware()->get('/tentang-kami/manajemen');

        $response->assertStatus(200);
    }

    /**
     * Old Dewan Komisaris URL redirects (301) to the combined Manajemen page.
     */
    public function test_old_komisaris_url_redirects_to_manajemen(): void
    {
        $response = $this->withoutSecurityMiddleware()->get('/tentang-kami/dewan-komisaris');

        $response->assertStatus(301);
        $this->assertStringEndsWith('/tentang-kami/manajemen', $response->headers->get('Location'));
    }

    /**
     * Old Dewan Direksi URL redirects (301) to the combined Manajemen page.
     */
    public function test_old_direksi_url_redirects_to_manajemen(): void
    {
        $response = $this->withoutSecurityMiddleware()->get('/tentang-kami/dewan-direksi');

        $response->assertStatus(301);
        $this->assertStringEndsWith('/tentang-kami/manajemen', $response->headers->get('Location'));
    }

    /**
     * Old Dewan Pengawas Syariah URL redirects (301) to the combined Manajemen page.
     */
    public function test_old_pengawas_syariah_url_redirects_to_manajemen(): void
    {
        $response = $this->withoutSecurityMiddleware()->get('/tentang-kami/pengawas-syariah');

        $response->assertStatus(301);
        $this->assertStringEndsWith('/tentang-kami/manajemen', $response->headers->get('Location'));
    }

    /**
     * Test struktur page returns 200 status code.
     * Requirements: 2.2
     */
    public function test_struktur_page_returns_successful_response(): void
    {
        $response = $this->withoutSecurityMiddleware()->get('/tentang-kami/struktur-organisasi');

        $response->assertStatus(200);
    }

    /**
     * Test offices page returns 200 status code.
     * Requirements: 2.2
     */
    public function test_offices_page_returns_successful_response(): void
    {
        $response = $this->withoutSecurityMiddleware()->get('/tentang-kami/kantor-cabang');

        $response->assertStatus(200);
    }
}
