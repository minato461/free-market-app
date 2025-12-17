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

        $listedItems = Item::where('user_id', $user->id)
                        ->with('purchase')
                        ->get();

        $purchasedItems = Purchase::where('user_id', $user->id)
                                ->with('item')
                                ->get()
                                ->pluck('item');

        $address = $user->personalAddress ?? new PersonalAddress();

        return view('mypage', compact('user', 'listedItems', 'purchasedItems', 'address'));
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