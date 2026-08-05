<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\Seo\SeoMeta;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        SeoMeta::setTitle('Berita & Artikel')
            ->setDescription('Berita terbaru dan artikel informatif seputar perbankan syariah dari BPRS Bangka Belitung.');

        // Build a cache key from current query params (page/search/category)
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $category = $request->input('category', '');
        $cacheKey = 'news_index_' . md5("{$page}|{$search}|{$category}");

        $news = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($request) {
            $query = News::query()
                ->select(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category'])
                ->where('is_published', true)
                ->where('published_at', '<=', now());

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('excerpt', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            return $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();
        });

        // Categories are already cached via CacheService
        $categories = app(\App\Services\CacheService::class)->getNewsCategories();

        return view('frontend.pages.news.index', compact('news', 'categories'));
    }

    public function show(string $slug)
    {
        $news = Cache::remember(config('cache-keys.news_detail') . $slug, now()->addHours(6), function () use ($slug) {
            return News::with('images')
                ->where('slug', $slug)
                ->where('is_published', true)
                ->firstOrFail();
        });

        // SEO Implementation
        SeoMeta::setTitle($news->title)
            ->setDescription($news->meta_description ?? $news->excerpt)
            ->setKeywords($news->tags ?? [])
            ->setImage($news->featured_image ? asset('storage/' . $news->featured_image) : null)
            ->setType('article')
            ->setPublishedTime($news->published_at)
            ->setModifiedTime($news->updated_at)
            ->addSchema([
                '@context' => 'https://schema.org',
                '@type' => 'NewsArticle',
                'headline' => $news->title,
                'image' => [
                    $news->featured_image ? asset('storage/' . $news->featured_image) : asset('images/default-news.jpg')
                ],
                'datePublished' => $news->published_at->toIso8601String(),
                'dateModified' => $news->updated_at->toIso8601String(),
                'author' => [
                    '@type' => 'Person',
                    'name' => $news->author ?? 'Admin BPRS Babel'
                ]
            ])
            ->addSchema([
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Berita & Artikel', 'item' => route('news.index')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $news->title, 'item' => route('news.show', $news->slug)],
                ]
            ]);

        // Cache related news — invalidated when news is saved/deleted (see News model booted)
        $relatedNews = collect();
        if ($news->category) {
            $cacheKey = config('cache-keys.news_detail') . 'related_' . md5($news->category . '_' . $news->id);
            $relatedNews = Cache::remember($cacheKey, now()->addHours(6), function () use ($news) {
                return News::select(['id', 'title', 'slug', 'featured_image', 'published_at'])
                    ->where('is_published', true)
                    ->where('id', '!=', $news->id)
                    ->where('category', $news->category)
                    ->latest('published_at')
                    ->take(3)
                    ->get();
            });
        }

        return view('frontend.pages.news.show', compact('news', 'relatedNews'));
    }
}
