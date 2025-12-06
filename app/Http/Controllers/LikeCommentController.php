<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentStoreRequest;

class LikeCommentController extends Controller
{
    public function toggle(Item $item)
    {
        $userId = Auth::id();
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

    public function store(CommentStoreRequest $request, Item $item)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'content' => $request->comment,
        ]);

        return redirect()->route('item.show', $item)
            ->with('success', 'コメントを投稿しました。');
    }
}
