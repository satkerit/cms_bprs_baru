<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\StoreNewsRequest;
use App\Http\Requests\Admin\News\UpdateNewsRequest;
use App\Models\News;
use App\Models\NewsImage;
use App\Services\NewsService;
use App\Traits\AuthorizesAdminActions;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use HandlesImageUpload, AuthorizesAdminActions;

    public function __construct(
        private readonly NewsService $newsService,
    ) {}

    public function index(Request $request)
    {
        $this->authorizeView('news.view');

        $news = $this->newsService->list(
            search: $request->input('search'),
            category: $request->input('category'),
            status: $request->input('status'),
        );

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $this->authorizeCreate('news.create');
        return view('admin.news.create');
    }

    public function store(StoreNewsRequest $request)
    {
        $this->authorizeCreate('news.create');

        $data = $request->validated();
        // slide_images diproses terpisah sebagai galeri & tidak boleh mass-assign ke model
        unset($data['slide_images']);
        $data['is_published'] = $request->boolean('is_published');
        $data['author'] = auth()->user()->name;
        $data['author_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->storeOptimizedImage($request->file('featured_image'), 'news');
        }

        $slidePaths = [];
        if ($request->hasFile('slide_images')) {
            foreach ($request->file('slide_images') as $image) {
                $slidePaths[] = $this->storeOptimizedImage($image, 'news/gallery');
            }
        }

        $result = $this->newsService->create($data, $slidePaths);

        if ($result['success']) {
            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
        }

        return back()->with('error', 'Gagal menambahkan berita: ' . ($result['error'] ?? ''))->withInput();
    }

    public function edit(News $news)
    {
        $this->authorizeEdit('news.edit');
        $news->load('images');
        return view('admin.news.edit', compact('news'));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $this->authorizeEdit('news.edit');

        $data = $request->validated();
        // slide_images diproses terpisah sebagai galeri & tidak boleh mass-assign ke model
        unset($data['slide_images']);
        $data['is_published'] = $request->boolean('is_published');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($news->featured_image);
            }
            $data['featured_image'] = $this->storeOptimizedImage($request->file('featured_image'), 'news');
        }

        // Handle gallery image uploads
        $slidePaths = [];
        if ($request->hasFile('slide_images')) {
            foreach ($request->file('slide_images') as $image) {
                $slidePaths[] = $this->storeOptimizedImage($image, 'news/gallery');
            }
        }

        $result = $this->newsService->update(
            news: $news,
            data: $data,
            slideImagePaths: $slidePaths,
            deleteImageIds: $request->input('delete_images', []),
        );

        if ($result['success']) {
            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
        }

        return back()->with('error', 'Gagal memperbarui berita: ' . ($result['error'] ?? ''))->withInput();
    }

    public function destroy(News $news)
    {
        $this->authorizeDelete('news.delete');

        $result = $this->newsService->delete($news);

        if ($result['success']) {
            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus berita: ' . ($result['error'] ?? ''));
    }

    public function deleteImage(NewsImage $newsImage)
    {
        $this->authorizeEdit('news.edit');

        $result = $this->newsService->deleteImage($newsImage);

        if (request()->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return back()->with('success', 'Foto slide berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus gambar: ' . ($result['error'] ?? ''));
    }
}
