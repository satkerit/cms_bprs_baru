<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AuctionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auction\StoreAuctionRequest;
use App\Http\Requests\Admin\Auction\UpdateAuctionRequest;
use App\Models\Auction;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $query = Auction::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('auction_number', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('debtor_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('asset_type')) {
            $query->where('asset_type', $request->asset_type);
        }

        $auctions = $query->paginate(15)->withQueryString();

        $stats = [
            'total'             => Auction::count(),
            'registration_open' => Auction::where('status', AuctionStatus::RegistrationOpen->value)->count(),
            'sold'              => Auction::where('status', AuctionStatus::Sold->value)->count(),
            'draft'             => Auction::where('status', AuctionStatus::Draft->value)->count(),
        ];

        return view('admin.auctions.index', compact('auctions', 'stats'));
    }

    public function create()
    {
        $statuses   = AuctionStatus::cases();
        $assetTypes = ['tanah', 'rumah', 'ruko', 'apartemen', 'gedung', 'pabrik', 'kendaraan', 'mesin', 'lainnya'];

        return view('admin.auctions.create', compact('statuses', 'assetTypes'));
    }

    public function store(StoreAuctionRequest $request)
    {
        $data         = $request->validated();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);

        $data['is_featured'] = $request->boolean('is_featured');

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            $slug = $data['slug'];
            foreach ($request->file('images') as $image) {
                $result       = ImageService::upload($image, [
                    'dir'     => "auctions/{$slug}",
                    'formats' => ['webp', 'jpg'],
                    'sizes'   => [1280, 768, 480],
                ]);
                $imagePaths[] = $result['original'] ?? $result['path'] ?? $image->store("auctions/{$slug}", 'public');
            }
        }

        $data['images'] = $imagePaths;

        $auction = Auction::create($data);

        return redirect()->route('admin.auctions.index')
            ->with('success', "Lelang \"{$auction->title}\" berhasil ditambahkan.");
    }

    public function show(Auction $auction)
    {
        return view('admin.auctions.show', compact('auction'));
    }

    public function edit(Auction $auction)
    {
        $statuses   = AuctionStatus::cases();
        $assetTypes = ['tanah', 'rumah', 'ruko', 'apartemen', 'gedung', 'pabrik', 'kendaraan', 'mesin', 'lainnya'];

        return view('admin.auctions.edit', compact('auction', 'statuses', 'assetTypes'));
    }

    public function update(UpdateAuctionRequest $request, Auction $auction)
    {
        $data = $request->validated();

        $data['is_featured'] = $request->boolean('is_featured');

        // Handle new image uploads
        $existingImages = $auction->images ?? [];

        if ($request->hasFile('images')) {
            $slug = $auction->slug;
            foreach ($request->file('images') as $image) {
                $result           = ImageService::upload($image, [
                    'dir'         => "auctions/{$slug}",
                    'formats'     => ['webp', 'jpg'],
                    'sizes'       => [1280, 768, 480],
                ]);
                $existingImages[] = $result['original'] ?? $result['path'] ?? $image->store("auctions/{$slug}", 'public');
            }
        }

        // Handle deleted images
        $deletedImages = $request->input('deleted_images', []);
        // deleted_images bukan kolom DB — buang dari data agar tidak kena MassAssignment
        unset($data['deleted_images']);
        if (!empty($deletedImages)) {
            foreach ($deletedImages as $path) {
                Storage::disk('public')->delete($path);
            }
            $existingImages = array_values(array_filter($existingImages, fn($p) => !in_array($p, $deletedImages)));
        }

        $data['images'] = $existingImages;

        $auction->update($data);

        return redirect()->route('admin.auctions.show', $auction)
            ->with('success', "Lelang \"{$auction->title}\" berhasil diperbarui.");
    }

    public function destroy(Auction $auction)
    {
        // Hapus gambar dari storage
        if (!empty($auction->images)) {
            foreach ($auction->images as $path) {
                Storage::disk('public')->delete($path);
            }
            // Coba hapus folder jika kosong
            Storage::disk('public')->deleteDirectory("auctions/{$auction->slug}");
        }

        $title = $auction->title;
        $auction->delete();

        return redirect()->route('admin.auctions.index')
            ->with('success', "Lelang \"{$title}\" berhasil dihapus.");
    }

    public function updateStatus(Request $request, Auction $auction)
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', array_column(AuctionStatus::cases(), 'value'))],
        ]);

        $auction->update(['status' => $request->status]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status lelang berhasil diperbarui.',
                'status'  => $auction->status,
            ]);
        }

        return back()->with('success', 'Status lelang berhasil diperbarui.');
    }
}
