<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseStoreRequest;

class PurchaseController extends Controller
{
    /**
     * 商品購入画面を表示する
     */
    public function show($item_id)
    {
        // 該当商品を検索し、存在しない場合は404エラー
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        // 既に購入されているかチェック
        if ($item->is_sold) {
            return redirect()->route('item.detail', $item_id)
                ->with('error', 'この商品はすでに購入済みです。');
        }

        // ビューに商品とユーザー情報を渡す
        return view('purchase', compact('item', 'user'));
    }

    /**
     * 1. 「購入する」ボタンを押下すると購入が完了する
     * 4. 商品を購入した後の遷移先は商品一覧画面になっている
     */
    public function process(PurchaseStoreRequest $request, $item_id)
    {
        // Itemモデルを取得
        $item = Item::findOrFail($item_id);

        // 二重購入防止チェック
        if ($item->is_sold) {
            return redirect()->back()->with('error', 'この商品はすでに購入済みです。');
        }

        // トランザクションを開始し、購入処理を実行
        DB::transaction(function () use ($request, $item) {

            // Purchaseレコードを作成し、購入履歴を保存
            Purchase::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address, // 住所情報
            ]);

            // Itemモデルには 'is_sold' アクセサがあるため、別途フラグを立てる必要はない
        });

        // 4. 購入後の遷移先：商品一覧画面
        return redirect()->route('item.index')
            ->with('success', $item->name . 'の購入が完了しました。商品一覧にてSOLD表示をご確認ください。');
    }
}
