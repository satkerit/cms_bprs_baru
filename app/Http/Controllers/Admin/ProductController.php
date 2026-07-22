<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Brochure;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\AuthorizesAdminActions;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HandlesImageUpload, AuthorizesAdminActions;

    public function __construct(
        private readonly ProductService $productService,
    ) {}

    public function index(Request $request)
    {
        $this->authorizeView('products.view');

        $products = $this->productService->list(
            search: $request->input('search'),
            type: $request->input('type'),
        );

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->authorizeCreate('products.create');

        $brochures = Brochure::orderBy('original_name')->get();

        return view('admin.products.create', compact('brochures'));
    }

    public function show(Product $product)
    {
        $this->authorizeView('products.view');

        return view('admin.products.show', compact('product'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorizeCreate('products.create');

        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        // Handle image upload
        $imagePath = $this->handleImageUpload($request, 'image', 'products');

        // Handle brochure upload (takes precedence over library selection)
        $brochurePath = null;
        if ($request->hasFile('brochure')) {
            $brochurePath = $request->file('brochure')->store('products/brochures', 'public');
        }

        $result = $this->productService->create(
            data: $validated,
            imagePath: $imagePath,
            brochurePath: $brochurePath,
        );

        if ($result['success']) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
        }

        return back()->withInput()->with('error', 'Gagal menambahkan produk: ' . ($result['error'] ?? ''));
    }

    public function edit(Product $product)
    {
        $this->authorizeEdit('products.edit');

        $brochures = Brochure::orderBy('original_name')->get();

        return view('admin.products.edit', compact('product', 'brochures'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorizeEdit('products.edit');

        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        // Handle image upload (with old path for deletion)
        $imagePath = $this->handleImageUpload($request, 'image', 'products', $product->image);
        $imageChanged = $imagePath !== $product->image;

        // Handle brochure (file upload or library selection)
        $brochurePath = null;
        if ($request->hasFile('brochure')) {
            $brochurePath = $request->file('brochure')->store('products/brochures', 'public');
        }

        $result = $this->productService->update(
            product: $product,
            data: $validated,
            imagePath: $imageChanged ? $imagePath : null,
            brochurePath: $brochurePath,
        );

        if ($result['success']) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
        }

        return back()->withInput()->with('error', 'Gagal memperbarui produk: ' . ($result['error'] ?? ''));
    }

    public function destroy(Product $product)
    {
        $this->authorizeDelete('products.delete');

        $result = $this->productService->delete($product);

        if ($result['success']) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus produk. Silakan coba lagi.');
    }
}
