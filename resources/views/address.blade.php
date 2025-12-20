<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送付先住所変更 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
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

        <main class="main address-main">
            <h2 class="address-title">住所の変更</h2>

            <form class="address-form" action="{{ route('address.update', ['item_id' => $item->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="postal_code">郵便番号</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-input" value="{{ old('postal_code', $address->postal_code ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="address">住所</label>
                    <input type="text" id="address" name="address" class="form-input" value="{{ old('address', $address->address ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="building_name">建物名</label>
                    <input type="text" id="building_name" name="building_name" class="form-input" value="{{ old('building_name', $address->building_name ?? '') }}">
                </div>
                <button type="submit" class="update-button">更新する</button>
            </form>
        </main>

        <footer class="footer"></footer>
    </div>

</body>
</html>