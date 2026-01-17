<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\PersonalAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function showMypage()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // プロフィール画像や住所情報の取得
        $address = $user->personalAddress;

        // 自分が作成した商品
        $listedItems = Item::where('user_id', $user->id)
            ->with('purchase')
            ->orderBy('created_at', 'desc')
            ->get();

        // 自分が購入した商品
        $purchasedItems = Item::whereHas('purchase', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('purchase')->get();

        return view('mypage', compact('user', 'address', 'listedItems', 'purchasedItems'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $address = $user->personalAddress ?? new PersonalAddress();

        return view('profile', compact('user', 'address'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // ★ 判定ロジック: 既に住所レコードが存在するかを確認（更新前の状態を保持）
        // 住所レコードがない場合、または住所が未入力の場合は「初回設定」とみなす
        $isFirstTime = !$user->personalAddress()->exists() || empty($user->personalAddress->address);

        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:8',
            'address' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像のバリデーション
        ]);

        $user->name = $request->input('name');
        $user->save();

        $address = $user->personalAddress ?? new PersonalAddress(['user_id' => $user->id]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('image', 'public');
            $address->image_path = basename($path);
        }

        $address->postal_code = $request->input('postal_code');
        $address->address = $request->input('address');
        $address->building_name = $request->input('building_name');

        $user->personalAddress()->save($address);

        if ($isFirstTime) {
            // 初回設定時は商品一覧（おすすめ）へ遷移
            return redirect()->route('item.index')->with('success', 'プロフィールの初期設定が完了しました。');
        } else {
            // 2回目以降の更新はマイページへ遷移
            return redirect()->route('mypage.index')->with('success', 'プロフィール情報を更新しました。');
        }
    }
}