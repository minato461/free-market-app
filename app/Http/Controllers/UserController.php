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

        // 自分が作成した商品（Bladeで使う変数名: $listedItems）
        $listedItems = Item::where('user_id', $user->id)
            ->with('purchase')
            ->orderBy('created_at', 'desc')
            ->get();

        // 自分が購入した商品（Bladeで使う変数名: $purchasedItems）
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
        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:8',
            'address' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->save();

        $address = $user->personalAddress ?? new PersonalAddress(['user_id' => $user->id]);

        $address->postal_code = $request->input('postal_code');
        $address->address = $request->input('address');
        $address->building_name = $request->input('building_name');

        $user->personalAddress()->save($address);

        return redirect()->route('mypage.index')->with('success', 'プロフィール情報を更新しました。');
    }
}