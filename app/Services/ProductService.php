<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\Facades\ResponseCache;

class ProductService
{
    /**
     * Get paginated product list with filters.
     */
    public function list(?string $search = null, ?string $type = null, int $perPage = 15): mixed
    {
        /** @var Builder<Product> $query */
        $query = Product::orderBy('order_position')->orderBy('name');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($type) {
            $query->where('type', $type);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new product.
     *
     * @param array<string, mixed> $data
     * @return array{success: bool, product?: Product, error?: string}
     */
    public function create(array $data, ?string $imagePath = null, ?string $brochurePath = null): array
    {
        try {
            $data = $this->sanitizeArrays($data);

            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            if ($brochurePath) {
                $data['brochure'] = $brochurePath;
                $data['brochure_id'] = null;
            }

            $product = Product::create($data);

            $this->invalidateCache();

            return ['success' => true, 'product' => $product];
        } catch (\Exception $e) {
            Log::error('Product creation failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Update an existing product.
     *
     * @param array<string, mixed> $data
     * @return array{success: bool, product?: Product, error?: string}
     */
    public function update(Product $product, array $data, ?string $imagePath = null, ?string $brochurePath = null): array
    {
        try {
            $data = $this->sanitizeArrays($data);

            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            if ($brochurePath) {
                if ($product->getAttribute('brochure')) {
                    Storage::disk('public')->delete($product->getAttribute('brochure'));
                }
                $data['brochure'] = $brochurePath;
                $data['brochure_id'] = null;
            } elseif (isset($data['brochure_id']) && !empty($data['brochure_id'])) {
                if ($product->getAttribute('brochure')) {
                    Storage::disk('public')->delete($product->getAttribute('brochure'));
                }
                $data['brochure'] = null;
            }

            $product->update($data);

            $this->invalidateCache();

            return ['success' => true, 'product' => $product->fresh()];
        } catch (\Exception $e) {
            Log::error('Product update failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete a product and its associated files.
     */
    public function delete(Product $product): array
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            if ($product->getAttribute('brochure')) {
                Storage::disk('public')->delete($product->getAttribute('brochure'));
            }

            $product->delete();

            $this->invalidateCache();

            return ['success' => true];
        } catch (\Exception $e) {
            Log::error('Product deletion failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => 'Gagal menghapus produk. Silakan coba lagi.'];
        }
    }

    /**
     * Filter empty values from array fields.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function sanitizeArrays(array $data): array
    {
        foreach (['features', 'benefits', 'requirements'] as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $data[$field] = array_values(
                    array_filter($data[$field], fn($v) => is_string($v) && !empty(trim($v)))
                );
            }
        }

        if (empty($data['description'])) {
            $data['description'] = $data['short_description'] ?? 'Deskripsi produk';
        }

        return $data;
    }

    /**
     * Invalidate product-related caches.
     */
    public function invalidateCache(): void
    {
        Cache::forget('products_home_6');
        Cache::forget('products_simpanan_syariah');
        Cache::forget('products_pembiayaan_syariah');
        Cache::forget('products_deposito_syariah');
        ResponseCache::clear();
    }
}
