<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class PurchaseController extends Controller
{

    public function process(Request $request, $item_id)
    {
        $item = Item::find($item_id);

        $request->validate([
            'payment_method' => 'required|string',
            'shipping_address' => 'required|string',
        ]);

        if (!$item || $item->user_id === Auth::id() || $item->isSold()) {
            return back()->withErrors(['error' => 'この商品は購入できません。'])->withInput();
        }

        try {
            Purchase::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'shipping_address' => $request->input('shipping_address'),
                'payment_method' => $request->input('payment_method'),
            ]);

            return redirect()->route('mypage.index')->with('success', '商品を購入しました。マイページで購入履歴をご確認ください。');

        } catch (\Exception $e) {
            \Log::error('購入処理エラー: ' . $e->getMessage());
            return back()->withErrors(['error' => '購入処理中にエラーが発生しました。もう一度お試しください。'])->withInput();
        }
    }
}