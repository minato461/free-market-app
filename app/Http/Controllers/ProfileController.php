<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PersonalAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $address = $user->personalAddress ?? new PersonalAddress(['user_id' => $user->id]);

        return view('profile', [
            'user' => $user,
            'address' => $address,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'regex:/^\d{3}-?\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building_name' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user->name = $validatedData['name'];
        $user->save();

        $address = $user->personalAddress ?? new PersonalAddress(['user_id' => $user->id]);

        if ($request->hasFile('image_path')) {
            if ($address->image_path && $address->image_path !== 'default_profile.png') {
                Storage::disk('public')->delete('image/' . $address->image_path);
            }
            $path = $request->file('image_path')->store('image', 'public');
            $address->image_path = basename($path);
        }

        $address->postal_code = str_replace('-', '', $validatedData['postal_code'] ?? '');
        $address->address = $validatedData['address'];
        $address->building_name = $validatedData['building_name'] ?? null;

        $address->save();

        return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました。');
    }
}