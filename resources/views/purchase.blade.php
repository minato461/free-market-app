<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品購入 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
</head>
<body>

    <div class="page-container">
        <header class="header">
            <div class="header__inner">
                <h1 class="header__logo">
                    <a href="{{ route('item.index') }}"><img src="{{ asset('storage/image/logo.svg') }}" alt="COACHTECH"></a>
                </h1>
                <div class="header__search">
                    <input type="text" placeholder="なにをお探しですか?" class="search__input">
                </div>
                <nav class="header__nav">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <form method="POST" action="/logout" id="logout-form">
                                @csrf
                                <button type="submit" class="logout__button nav__link">ログアウト</button>
                            </form>
                        </li>
                        <li class="nav__item"><a href="/mypage">マイページ</a></li>
                        <li class="nav__item"><a href="/sell" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main purchase-main">
            <h2 class="purchase-title">商品購入画面</h2>

            <form action="{{ route('purchase.process', $item->id) }}" method="POST" id="purchase-form">
                @csrf
                <div class="purchase-content-wrapper">
                    <div class="purchase-form-area">

                        <div class="item-info-box">
                            <div class="item-image-wrapper">
                                @if ($item->image_path)
                                    <img src="{{ asset('storage/image/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
                                @else
                                    商品画像なし
                                @endif
                            </div>
                            <div class="item-details">
                                <p class="item-name">{{ $item->name }}</p>
                                <p class="item-price">¥ {{ number_format($item->price) }}</p>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="setting-section">
                            <h3 class="setting-title">支払い方法</h3>
                            <div class="setting-content">
                                <select id="payment_method" name="payment_method" class="form-select">
                                    <option value="credit_card" {{ old('payment_method', 'credit_card') == 'credit_card' ? 'selected' : '' }}>カード払い</option>
                                    <option value="konbini" {{ old('payment_method') == 'konbini' ? 'selected' : '' }}>コンビニ払い</option>
                                </select>
                            </div>
                            @error('payment_method')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="divider"></div>

                        <div class="setting-section">
                            <h3 class="setting-title">配送先</h3>
                            <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="address-change-link">変更する</a>
                            <div class="setting-content address-details">
                                @php
                                    $hasShippingAddress = $address && !empty($address->postal_code) && !empty($address->address);
                                    $postalCode = $address->postal_code ?? ' XXX-XXXX';
                                    $fullAddress = ($address && $address->address)
                                        ? $address->address . ($address->building_name ? ' ' . $address->building_name : '')
                                        : '住所が設定されていません';

                                    $shippingAddressValue = $hasShippingAddress ? ($address->postal_code . $address->address) : '';
                                @endphp

                                <p>〒 {{ $postalCode }}</p>
                                <p>{{ $fullAddress }}</p>

                                <input type="hidden" name="shipping_address" value="{{ $shippingAddressValue }}">

                                @if (!$hasShippingAddress)
                                    <p class="error-message">※購入確定前に「変更する」から配送先を設定してください。</p>
                                @endif
                            </div>
                            @error('shipping_address')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="divider"></div>
                    </div>

                    <div class="order-summary-area">
                        <div class="order-summary-box">
                            <div class="summary-row">
                                <p class="summary-label">商品代金</p>
                                <p class="summary-value">¥ {{ number_format($item->price) }}</p>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row">
                                <p class="summary-label">支払い方法</p>
                                <p class="summary-value payment-display" id="payment-display">
                                    {{ old('payment_method', 'credit_card') == 'konbini' ? 'コンビニ払い' : 'カード払い' }}
                                </p>
                            </div>
                        </div>
                        <button type="submit" class="purchase-button" id="purchase-btn">購入する</button>
                    </div>
                </div>
            </form>
        </main>
        <footer class="footer"></footer>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentSelect = document.getElementById('payment_method');
            const paymentDisplay = document.getElementById('payment-display');

            paymentSelect.addEventListener('change', function() {
                const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
                paymentDisplay.textContent = selectedText;
            });
        });
    </script>
</body>
</html>