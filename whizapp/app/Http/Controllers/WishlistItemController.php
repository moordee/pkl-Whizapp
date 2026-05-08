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

        $validated = $request->validate([
            'item_url'  => 'nullable|string|max:2048',
            'title'     => 'nullable|string|max:255',
            'item_type' => 'nullable|string|max:100',
            'price'     => 'nullable|numeric',
            'image_url' => 'nullable|string|max:2048',
            'source'    => 'nullable|string|max:100',
            'notes'     => 'nullable|string',
        ]);

        $source = !empty($validated['source'])
            ? $validated['source']
            : ($validated['item_url']
                ? preg_replace(
                    '/^www\./',
                    '',
                    parse_url($validated['item_url'], PHP_URL_HOST) ?? ''
                  )
                : null);

        WishlistItem::create([
            'board_id'  => $board->id,
            'item_url'  => $validated['item_url'] ?? null,
            'title'     => !empty($validated['title'])
                           ? $validated['title']
                           : (!empty($source)
                               ? 'Item from ' . $source
                               : 'Untitled Item'),
            'item_type' => $validated['item_type'] ?? null,
            'price'     => $validated['price'] ?? 0,
            'image_url' => $validated['image_url'] ?? null,
            'source'    => $source ?: null,
            'notes'     => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Item added successfully.');
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
        $request->validate(['url' => 'required|url']);

        $url = $request->input('url');

        try {
            $apiUrl = 'https://api.microlink.io?' . http_build_query([
                'url'     => $url,
                'meta'    => 'true',
                'iframe'  => 'false',
            ]);

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json',
            ])->timeout(10)->get($apiUrl);

            if (!$response->successful()) {
                return response()->json(
                    ['error' => 'Could not fetch URL'], 422
                );
            }

            $data = $response->json();

            if (($data['status'] ?? '') !== 'success') {
                return response()->json(
                    ['error' => 'Microlink could not parse this URL'], 422
                );
            }

            $result   = $data['data'] ?? [];
            $title    = $result['title'] ?? null;
            $image    = $result['image']['url']
                     ?? $result['logo']['url']
                     ?? null;
            $price    = $result['price'] ?? null;
            $source   = parse_url($url, PHP_URL_HOST);
            $source   = preg_replace('/^www\./', '', $source ?? '');

            return response()->json([
                'title'     => $title ? trim($title) : null,
                'image_url' => $image ? trim($image) : null,
                'price'     => $price ? trim($price) : null,
                'source'    => $source,
            ]);

        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Could not fetch URL'], 422
            );
        }
    }
}
