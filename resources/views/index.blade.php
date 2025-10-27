<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="page-container">
        <header class="header">
            <div class="header__inner">
                <h1 class="header__logo">
                    <a href="/"><img src="path/to/coachtech_logo.png" alt="COACHTECH"></a>
                </h1>
                <div class="header__search">
                    <input type="text" placeholder="なにをお探しですか?" class="search__input">
                </div>
                <nav class="header__nav">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="/login">ログイン</a></li>
                        <li class="nav__item"><a href="/mypage">マイページ</a></li>
                        <li class="nav__item"><a href="/sell" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="main-nav">
            <nav class="tab-nav">
                <ul class="tab-list">
                    <li class="tab-item is-active"><a href="/">おすすめ</a></li>
                    <li class="tab-item"><a href="#">マイリスト</a></li>
                </ul>
            </nav>
        </div>

        <main class="main">
            <div class="item-list-container">
                <div class="item-list">
                    <a href="/item" class="item-card">
                        <div class="item-card__image-wrapper">
                            <img src="{{ asset('images/腕時計.jpg') }}" alt="" class="item-card__image">
                        </div>
                        <p class="item-card__name">腕時計</p>
                    </a>

                </div>
            </div>
        </main>

        <footer class="footer">
        </footer>
    </div>

</body>
</html>