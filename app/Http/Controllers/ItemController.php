<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Item::with('likes', 'purchase', 'brand', 'category')
            ->orderBy('created_at', 'desc');

        if ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        if (Auth::check()) {
            $userId = Auth::id();
            $query->where('user_id', '!=', $userId);
        }

        $items = $query->take(10)->get();

        return view('index', compact('items'));
    }

    public function mylist(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $keyword = $request->input('keyword');
        $userId = Auth::id();

        $likedItemIds = Like::where('user_id', $userId)->pluck('item_id');

        if ($likedItemIds->isEmpty()) {
            $query = Item::whereRaw('1 = 0');
        } else {
            $query = Item::with('purchase', 'brand', 'category')
                ->whereIn('id', $likedItemIds);
        }

        if ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        $items = $query->orderBy('created_at', 'desc')->get();

        return view('index', compact('items'));
    }

    public function show(Item $item)
    {
        $item->load([
            'likes',
            'brand',
            'category',
            'user',
            'comments.user'
        ]);

        $isLiked = Auth::check() ? $item->likes->contains('user_id', Auth::id()) : false;

        $likeCount = $item->likes->count();

        return view('item', compact('item', 'isLiked', 'likeCount'));
    }

    public function toggleLike(Request $request, Item $item)
    {
        $user = Auth::user();
        $userId = $user->id;
        $itemId = $item->id;

        DB::transaction(function () use ($userId, $itemId) {

            $like = Like::where('user_id', $userId)
                        ->where('item_id', $itemId)
                        ->first();

            if ($like) {
                Like::where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->delete();
            } else {
                Like::create([
                    'user_id' => $userId,
                    'item_id' => $itemId,
                ]);
            }
        });

        return redirect()->route('item.show', $item);
    }
}
