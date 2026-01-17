<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::with('user')->findOrFail($item_id);
        $user = Auth::user();
        $sessionAddress = session("shipping_address_{$item_id}");

        if ($sessionAddress) {
            $address = (object)$sessionAddress;
        } else {
            $pa = $user->personalAddress;
            $address = (object)[
                'postal_code' => $pa->postal_code ?? '',
                'address' => $pa->address ?? '',
                'building_name' => $pa->building_name ?? '',
            ];
        }

        return view('purchase', compact('item', 'address'));
    }

    public function process(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $request->validate([
            'payment_method' => 'required|string',
            'shipping_address' => 'required|string',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentType = ($request->payment_method === 'konbini') ? 'konbini' : 'card';

            $session = Session::create([
                'payment_method_types' => [$paymentType],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('purchase.success', ['item_id' => $item->id]),
                'cancel_url' => route('purchase.show', ['item_id' => $item->id]),
                'payment_method_options' => [
                    'konbini' => [
                        'expires_after_days' => 3,
                    ],
                ],
            ]);

            return redirect($session->url, 303);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => '決済の開始に失敗しました: ' . $e->getMessage()]);
        }
    }

    public function success(Request $request, $item_id)
    {
        $user = Auth::user();

        $sessionAddress = session("shipping_address_{$item_id}");
        if ($sessionAddress) {
            $shippingAddress = ($sessionAddress['postal_code'] ?? '') . ' ' . ($sessionAddress['address'] ?? '') . ' ' . ($sessionAddress['building_name'] ?? '');
        } else {
            $pa = $user->personalAddress;
            $shippingAddress = ($pa->postal_code ?? '') . ' ' . ($pa->address ?? '') . ' ' . ($pa->building_name ?? '');
        }

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item_id,
            'payment_method' => 'stripe',
            'shipping_address' => $shippingAddress,
        ]);

        session()->forget("shipping_address_{$item_id}");

        return redirect()->route('item.index')->with('success', '購入が完了しました！');
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $currentAddress = session("shipping_address_{$item_id}") ?? [
            'postal_code' => $user->personalAddress->postal_code ?? '',
            'address' => $user->personalAddress->address ?? '',
            'building_name' => $user->personalAddress->building_name ?? '',
        ];

        $address = (object)$currentAddress;
        return view('address', compact('item', 'address'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        session(["shipping_address_{$item_id}" => $request->only(['postal_code', 'address', 'building_name'])]);

        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    }
}