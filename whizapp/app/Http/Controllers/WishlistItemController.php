<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\WishlistItem;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WishlistItemController extends Controller
{
    /**
     * Store a newly created wishlist item.
     */
    public function store(Request $request, Board $board)
    {
        if ($board->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'price' => 'nullable|numeric',
            'image_url' => 'nullable|url',
            'item_url' => 'required|url',
            'source' => 'nullable|string',
        ]);

        $board->wishlistItems()->create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'image_url' => $request->input('image_url'),
            'item_url' => $request->input('item_url'),
            'source' => $request->input('source'),
        ]);

        return back();
    }

    /**
     * Delete the specified wishlist item.
     */
    public function destroy(WishlistItem $item)
    {
        if ($item->board->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return back();
    }

    /**
     * Prefetch metadata from a URL.
     */
    public function prefetch(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ])->timeout(5)->get($request->url);

            if (!$response->successful()) {
                return response()->json(['error' => 'Could not fetch URL'], 422);
            }

            $html = $response->body();

            // Parse HTML
            $dom = new DOMDocument();
            @$dom->loadHTML($html);

            $xpath = new DOMXPath($dom);

            // Extract title
            $titleNode = $xpath->query('//meta[@property="og:title"]/@content')->item(0);
            $title = $titleNode ? $titleNode->value : null;

            // Extract image
            $imageNode = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
            $imageUrl = $imageNode ? $imageNode->value : null;

            // Extract price
            $priceNode = $xpath->query('//meta[@property="product:price:amount"]/@content')->item(0);
            if (!$priceNode) {
                $priceNode = $xpath->query('//meta[@property="og:price:amount"]/@content')->item(0);
            }
            $price = $priceNode ? $priceNode->value : null;

            // Extract source (domain name)
            $source = parse_url($request->url, PHP_URL_HOST);

            return response()->json([
                'title' => $title,
                'image_url' => $imageUrl,
                'price' => $price,
                'source' => $source,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch URL'], 422);
        }
    }
}
