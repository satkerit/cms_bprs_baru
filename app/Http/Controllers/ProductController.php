<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\News;
use App\Models\Auction;
use Illuminate\Support\Str;
use App\Services\CacheService;
use App\Services\Seo\SeoMeta;

class ProductController extends Controller
{
    public function simpananSyariah()
    {
        SeoMeta::setTitle('Simpanan Syariah')
            ->setDescription('Produk simpanan dengan prinsip syariah yang amanah dan menguntungkan.');

        return view('frontend.pages.products.index', [
            'products' => app(CacheService::class)->getProductsByType('simpanan_syariah'),
            'categories' => collect(), // Empty collection — filter not needed for type-specific page
            'title' => 'Simpanan Syariah',
            'subtitle' => 'Kelola dana Anda dengan aman dan berkah melalui produk simpanan berbasis prinsip syariah yang amanah, transparan, dan menguntungkan.',
        ]);
    }

    public function pembiayaanSyariah()
    {
        SeoMeta::setTitle('Pembiayaan Syariah')
            ->setDescription('Solusi pembiayaan syariah untuk kebutuhan pribadi, usaha, dan investasi Anda.');

        return view('frontend.pages.products.index', [
            'products' => app(CacheService::class)->getProductsByType('pembiayaan_syariah'),
            'categories' => collect(), // Empty collection — filter not needed for type-specific page
            'title' => 'Pembiayaan Syariah',
            'subtitle' => 'Wujudkan impian Anda dengan solusi pembiayaan berbasis syariah yang adil, transparan, dan bebas riba untuk kebutuhan pribadi maupun usaha.',
        ]);
    }

    public function depositoSyariah()
    {
        SeoMeta::setTitle('Deposito Syariah')
            ->setDescription('Investasi berjangka dengan bagi hasil kompetitif sesuai prinsip syariah.');

        return view('frontend.pages.products.index', [
            'products' => app(CacheService::class)->getProductsByType('deposito_syariah'),
            'categories' => collect(), // Empty collection — filter not needed for type-specific page
            'title' => 'Deposito Syariah',
            'subtitle' => 'Investasikan dana Anda dengan bagi hasil kompetitif melalui deposito berjangka berbasis akad syariah yang aman, terpercaya, dan dijamin LPS.',
        ]);
    }

    public function kasKeliling()
    {
        SeoMeta::setTitle('Jadwal Kas Keliling')
            ->setDescription('Cek jadwal dan lokasi layanan Kas Keliling BPRS Bangka Belitung terdekat.');

        $schedulesByDate = app(CacheService::class)->getKasKelilingSchedules();

        return view('frontend.pages.products.kas-keliling', [
            'schedules' => $schedulesByDate->flatten(1), // Flatten grouped collection for the view
            'product' => Product::where('type', 'kas_keliling')
                ->where('is_active', true)
                ->first(),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // SEO Implementation
        SeoMeta::setTitle($product->name)
            ->setDescription($product->short_description ?? Str::limit(strip_tags($product->description), 160))
            ->setImage($product->getImageUrl())
            ->setType('product')
            ->setModifiedTime($product->updated_at)
            ->addSchema([
                '@context' => 'https://schema.org',
                '@type' => 'FinancialProduct',
                'name' => $product->name,
                'description' => $product->short_description,
                'image' => $product->getImageUrl(),
                'provider' => [
                    '@type' => 'Organization',
                    'name' => config('app.name'),
                    'url' => url('/')
                ]
            ]);

        return view('frontend.pages.products.show', compact('product'));
    }
}
