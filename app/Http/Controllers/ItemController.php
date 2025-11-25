<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Item::with('likes', 'purchase')
            ->orderBy('created_at', 'desc');

        if ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        if (Auth::check()) {
            $userId = Auth::id();
            $query->where('user_id', '!=', $userId);
        }

        $items = $query->get();

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
            $query = Item::with('purchase')
                ->whereIn('id', $likedItemIds);
        }

        if ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        $items = $query->orderBy('created_at', 'desc')->get();

        return view('index', compact('items'));
    }
}
