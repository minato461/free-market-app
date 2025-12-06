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

            <div class="purchase-content-wrapper">
                <div class="purchase-form-area">
                    <div class="item-info-box">
                        <div class="item-image-wrapper">商品画像</div>
                        <div class="item-details">
                            <p class="item-name">商品名</p>
                            <p class="item-price">¥ 47,000</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="setting-section">
                        <h3 class="setting-title">支払い方法</h3>
                        <div class="setting-content">
                            <select id="payment_method" name="payment_method" class="form-select">
                                <option value="">選択してください</option>
                                <option value="convenience">コンビニ払い</option>
                                <option value="card">カード払い</option>
                            </select>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="setting-section">
                        <h3 class="setting-title">配送先</h3>
                        <a href="/address/edit" class="address-change-link">変更する</a>
                        <div class="setting-content address-details">
                            <p>〒 XXX-YYYY</p>
                            <p>ここには住所と建物が入ります</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                </div>
                <div class="order-summary-area">
                    <div class="order-summary-box">
                        <div class="summary-row">
                            <p class="summary-label">商品代金</p>
                            <p class="summary-value">¥ 47,000</p>
                        </div>

                        <div class="summary-row">
                            <p class="summary-label">支払い方法</p>
                            <p class="summary-value">コンビニ払い</p>
                        </div>

                        <button type="submit" class="purchase-button">購入する</button>

                    </div>
                </div>

            </div>
        </main>

        <footer class="footer"></footer>
    </div>

</body>
</html>