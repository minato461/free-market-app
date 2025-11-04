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
                    <a href="/"><img src="{{ asset('image/logo.svg') }}" alt="COACHTECH"></a>
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

            <form class="address-form" action="/address" method="POST">
                @csrf
                <div class="form-group">
                    <label for="postcode" class="form-label">郵便番号</label>
                    <input type="text" id="postcode" name="postcode" class="form-input" value="既存の値が入力されている">
                </div>
                <div class="form-group">
                    <label for="address" class="form-label">住所</label>
                    <input type="text" id="address" name="address" class="form-input" value="既存の値が入力されている">
                </div>
                <div class="form-group">
                    <label for="building" class="form-label">建物名</label>
                    <input type="text" id="building" name="building" class="form-input" value="既存の値が入力されている">
                </div>
                <button type="submit" class="update-button">更新する</button>
            </form>
        </main>

        <footer class="footer"></footer>
    </div>

</body>
</html>