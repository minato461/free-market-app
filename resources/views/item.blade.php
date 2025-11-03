<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
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
                        @guest
                            <li class="nav__item"><a href="/login">ログイン</a></li>
                            <li class="nav__item"><a href="/login">マイページ</a></li>
                        @endguest

                        @auth
                            <li class="nav__item">
                                <form method="POST" action="/logout" id="logout-form">
                                    @csrf
                                    <button type="submit" class="logout__button nav__link">ログアウト</button>
                                </form>
                            </li>
                            <li class="nav__item"><a href="/mypage">マイページ</a></li>
                        @endauth
                        <li class="nav__item"><a href="/sell" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main item-main">
            <div class="item-detail-wrapper">
                <div class="item-image-area">
                    <div class="item-image-box">商品画像</div>
                </div>

                <div class="item-content-area">
                    <div class="item-info-top">
                        <h2 class="item-name">商品名がここに入る</h2>
                        <p class="brand-name">ブランド名</p>
                        <p class="item-price">¥47,000 <span>(税込)</span></p>
                        <div class="interaction-status">
                            <span class="favorite"><i class="star-icon">★</i> 3</span>
                            <span class="comment-count"><i class="comment-icon">💬</i> 1</span>
                        </div>
                        <a href="/purchase" class="purchase-button">購入手続きへ</a>
                    </div>
                    <div class="item-description-section">
                        <h3 class="section-title">商品説明</h3>
                        <p class="description-text">
                            カラー：グレー<br>
                            新品<br>
                            商品の状態は良好です。傷もありません。<br>
                            購入後、即発送いたします。
                        </p>
                    </div>

                    <div class="item-spec-section">
                        <h3 class="section-title">商品の情報</h3>
                        <div class="spec-row">
                            <p class="spec-label">カテゴリ</p>
                            <p class="spec-value tag-area">
                                <span class="spec-tag">洋服</span>
                                <span class="spec-tag">メンズ</span>
                            </p>
                        </div>
                        <div class="spec-row">
                            <p class="spec-label">商品の状態</p>
                            <p class="spec-value">良好</p>
                        </div>
                    </div>

                    <div class="comment-section">
                        <h3 class="section-title">コメント(1)</h3>

                        <div class="comment-list">
                            <div class="comment-item">
                                <div class="comment-user">
                                    <div class="user-icon"></div>
                                    <p class="user-name-text">admin</p>
                                </div>
                                <p class="comment-text">こちらにコメントが入ります。</p>
                            </div>
                        </div>

                        <div class="comment-form-area">
                            <h3 class="section-title">商品へのコメント</h3>
                            <form action="/comment" method="POST">
                                @csrf
                                <textarea name="comment" class="comment-textarea"></textarea>
                                <button type="submit" class="comment-submit-button">コメントを送信する</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer"></footer>
    </div>

</body>
</html>