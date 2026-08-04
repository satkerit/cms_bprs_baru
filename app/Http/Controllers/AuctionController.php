<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $query = Auction::published();

        // Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('asset_type')) {
            $query->where('asset_type', $request->asset_type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('debtor_name', 'like', "%{$search}%");
            });
        }

        $auctions = $query->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        $featuredAuctions = Auction::published()->featured()->limit(3)->get();
        $stats            = Auction::getCachedStats();

        return view('frontend.pages.auctions.index', compact('auctions', 'featuredAuctions', 'stats'));
    }

    public function show(string $slug)
    {
        $auction = Auction::where('slug', $slug)->published()->firstOrFail();
        $auction->increment('view_count');

        $related = Auction::published()
            ->where('id', '!=', $auction->id)
            ->where('asset_type', $auction->asset_type)
            ->limit(3)
            ->get();

        return view('frontend.pages.auctions.show', compact('auction', 'related'));
    }
}
