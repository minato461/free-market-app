<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 | フリマアプリ</title>
    
    {{-- CSSの読み込み (public/css/style.css) --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    {{-- 全体を固定幅 (1512px) で中央に配置するためのコンテナ --}}
    <div class="page-container"> 
        
        {{-- 1. ヘッダー (幅 1512px / 高さ 80px) --}}
        <header class="header">
            <div class="header__inner">
                <h1 class="header__logo">
                    {{-- 画像を適切に配置してください --}}
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

        {{-- 2. メインナビゲーション (リスト: 幅 1512px / 高さ 47px / 上 127px) --}}
        <div class="main-nav">
            <nav class="tab-nav">
                <ul class="tab-list">
                    <li class="tab-item is-active"><a href="/">おすすめ</a></li>
                    <li class="tab-item"><a href="#">マイリスト</a></li>
                </ul>
            </nav>
        </div>

        {{-- 3. メインコンテンツ (商品一覧エリア) --}}
        <main class="main">
            {{-- 商品一覧 (グリッド) --}}
            <div class="item-list-container">
                <div class="item-list">
                    
                    {{-- 7つの商品カードを再現するためのループ --}}
                    @for ($i = 0; $i < 7; $i++)
                    <a href="/item" class="item-card">
                        <div class="item-card__image-wrapper">
                            {{-- 実際にはここに画像タグが入ります --}}
                            <div class="item-card__image-placeholder">商品画像</div>
                        </div>
                        <p class="item-card__name">商品名</p>
                    </a>
                    @endfor

                </div>
            </div>
        </main>

        {{-- 4. フッター (黒い領域) --}}
        <footer class="footer">
            {{-- フッターの内容は空欄のまま --}}
        </footer>
    </div>
    
</body>
</html>