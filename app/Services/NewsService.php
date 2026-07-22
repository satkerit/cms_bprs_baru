<?php

namespace App\Services;

use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\Facades\ResponseCache;

class NewsService
{
    private const MAX_GALLERY_IMAGES = 7;

    /**
     * Get paginated news list with filters.
     */
    public function list(?string $search = null, ?string $category = null, ?string $status = null, int $perPage = 10): mixed
    {
        /** @var Builder<News> $query */
        $query = News::query()->with('user');

        if ($search) {
            $query->where(function (Builder $q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($status === 'published') {
            $query->published();
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new news article.
     *
     * @param array<string, mixed> $data
     * @param array<int, string> $slideImagePaths
     * @return array{success: bool, news?: News, error?: string}
     */
    public function create(array $data, array $slideImagePaths = []): array
    {
        try {
            DB::beginTransaction();

            $news = News::create($data);

            if (!empty($slideImagePaths)) {
                $this->storeGalleryImages($news, $slideImagePaths);
            }

            DB::commit();
            $this->invalidateCache();

            return ['success' => true, 'news' => $news->fresh()];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('News creation failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Update an existing news article.
     *
     * @param array<string, mixed> $data
     * @param array<int, string> $slideImagePaths
     * @param array<int> $deleteImageIds
     * @return array{success: bool, news?: News, error?: string}
     */
    public function update(News $news, array $data, array $slideImagePaths = [], array $deleteImageIds = []): array
    {
        try {
            DB::beginTransaction();

            $news->update($data);

            if (!empty($slideImagePaths)) {
                $currentCount = $news->images()->count();
                if (($currentCount + count($slideImagePaths)) > self::MAX_GALLERY_IMAGES) {
                    throw new \Exception('Maksimal total ' . self::MAX_GALLERY_IMAGES . ' gambar galeri yang diizinkan');
                }

                foreach ($slideImagePaths as $path) {
                    $news->images()->create(['image_path' => $path]);
                }
            }

            if (!empty($deleteImageIds)) {
                $imagesToDelete = NewsImage::whereIn('id', $deleteImageIds)
                    ->where('news_id', $news->id)
                    ->get();

                foreach ($imagesToDelete as $img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }

            DB::commit();
            $this->invalidateCache();

            return ['success' => true, 'news' => $news->fresh()];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('News update failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete a news article and its associated images.
     */
    public function delete(News $news): array
    {
        try {
            DB::beginTransaction();

            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }

            foreach ($news->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $news->delete();

            DB::commit();
            $this->invalidateCache();

            return ['success' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('News deletion failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete a single gallery image.
     */
    public function deleteImage(NewsImage $newsImage): array
    {
        try {
            Storage::disk('public')->delete($newsImage->image_path);
            $newsImage->delete();
            return ['success' => true];
        } catch (\Exception $e) {
            Log::error('News image deletion failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Invalidate all news-related caches.
     */
    public function invalidateCache(): void
    {
        Cache::forget('news_home_3');
        ResponseCache::clear();
    }

    /**
     * Store multiple gallery image records.
     *
     * @param array<int, string> $paths
     */
    private function storeGalleryImages(News $news, array $paths): void
    {
        if (count($paths) > self::MAX_GALLERY_IMAGES) {
            throw new \Exception('Maksimal ' . self::MAX_GALLERY_IMAGES . ' gambar galeri yang diizinkan');
        }

        foreach ($paths as $path) {
            $news->images()->create(['image_path' => $path]);
        }
    }
}
