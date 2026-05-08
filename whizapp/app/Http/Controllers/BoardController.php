<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    /**
     * Display all boards for the authenticated user.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $boards = $user->boards()->latest()->get();
        return view('dashboard', compact('boards'));
    }

    /**
     * Store a newly created board.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $slug = Str::slug($request->name) . '-' . Str::random(5);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->boards()->create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified board.
     */
    public function show(Board $board)
    {
        if ($board->user_id !== Auth::id()) {
            abort(403);
        }

        $board->load('wishlistItems');
        $items = $board->wishlistItems;

        return view('board', compact('board', 'items'));
    }

    /**
     * Search boards for the authenticated user.
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:100',
        ]);

        $query = $request->input('query');
        $boards = Board::where('user_id', Auth::id())
            ->where('name', 'LIKE', "%{$query}%")
            ->get();

        return view('dashboard', compact('boards', 'query'));
    }

    /**
     * Generate a share link for the board.
     */
    public function generateShareLink(Board $board)
    {
        if ($board->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$board->share_token) {
            $board->share_token = \Illuminate\Support\Str::random(16);
            $board->is_public   = true;
            $board->save();
        }

        if (request()->expectsJson()) {
            return response()->json([
                'share_url' => url('/shared/' . $board->share_token)
            ]);
        }

        return back()->with('share_url',
            url('/shared/' . $board->share_token));
    }

    /**
     * View a shared board.
     */
    public function viewShared(string $token)
    {
        $board = Board::where('share_token', $token)
            ->where('is_public', true)
            ->first();

        if (!$board) {
            abort(404);
        }

        $board->load('wishlistItems');
        $items = $board->wishlistItems;
        $readOnly = true;

        return view('board', compact('board', 'items', 'readOnly'));
    }

    /**
     * Delete the specified board.
     */
    public function destroy(Board $board)
    {
        if ($board->user_id !== Auth::id()) {
            abort(403);
        }

        $board->delete();

        return redirect()->route('dashboard');
    }
}
