<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Item::with(['likes', 'purchase', 'brand', 'category'])
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
            $items = collect();
        } else {
            $query = Item::with(['purchase', 'brand', 'category'])
                ->whereIn('id', $likedItemIds);

            if ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            }
            $items = $query->orderBy('created_at', 'desc')->get();
        }

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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $itemId = $item->id;

        DB::transaction(function () use ($userId, $itemId) {
            $like = Like::where('user_id', $userId)
                        ->where('item_id', $itemId)
                        ->first();

            if ($like) {
                $like->delete();
            } else {
                Like::create([
                    'user_id' => $userId,
                    'item_id' => $itemId,
                ]);
            }
        });

        return redirect()->back();
    }

    public function create()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'item_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'condition' => 'required|string',
            'price' => 'required|integer|min:300',
            'brand_name' => 'nullable|string|max:255',
        ], [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'item_image.required' => '商品画像を選択してください',
            'category_ids.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は数値で入力してください',
            'price.min' => '販売価格は300円以上で入力してください',
        ]);

        $image = $request->file('item_image');
        $path = $image->store('image', 'public');

        DB::transaction(function () use ($request, $path) {
            $item = Item::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'brand_name' => $request->brand_name,
                'price' => $request->price,
                'description' => $request->description,
                'image_path' => basename($path),
                'condition' => $request->condition,
            ]);

            $item->category()->sync($request->category_ids);
        });

        return redirect()->route('mypage.index')->with('success', '商品を出品しました');
    }
}
