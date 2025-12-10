<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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

        <main class="main mypage-main">
            <div class="profile-info-area">
                <div class="profile-image-wrapper">
                    <div class="profile-image"></div>
                </div>
                <div class="profile-details">
                    <p class="user-name">ユーザー名</p>
                    <a href="/profile/edit" class="profile-edit-button">プロフィールを編集</a>
                </div>
            </div>

            <div class="mypage-nav">
                <nav class="tab-nav">
                    <ul class="tab-list">
                        <li class="tab-item is-active"><a href="#items_sold">出品した商品</a></li>
                        <li class="tab-item"><a href="#items_purchased">購入した商品</a></li>
                    </ul>
                </nav>
            </div>

            <div id="items_sold" class="tab-content active">
                <div class="mypage-item-list-container">
                    <div class="mypage-item-list">
                        @php
                            $items = [
                                '腕時計', 'HDD', '玉ねぎ', '革靴', 'ノートPC',
                                'マイク', 'ショルダーバッグ', 'タンブラー', 'コーヒーミル', 'メイクアップセット'
                            ];
                        @endphp

                        @foreach ($items as $item)
                            <a href="/item" class="item-card">
                                <div class="item-card__image-wrapper">
                                    <img src="{{ asset('image/' . $item . '.jpg') }}" alt="{{ $item }}" class="item-card__image">
                                </div>
                                <p class="item-card__name">{{ $item }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="items_purchased" class="tab-content hidden">
                <div class="mypage-item-list-container">
                    <div class="mypage-item-list">
                        <p>購入した商品はありません。</p>
                    </div>
                </div>
            </div>

        </main>

        <footer class="footer">
        </footer>
    </div>

</body>
</html>