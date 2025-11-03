<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品出品 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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

        <main class="main sell-main">
            <h2 class="sell-title">商品の出品</h2>

            <form class="sell-form" action="/sell" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="sell-section image-section">
                    <p class="section-title">商品画像</p>
                    <div class="image-upload-box">
                        <label for="item_image_upload" class="image-select-button">画像を選択する</label>
                        <input type="file" id="item_image_upload" name="item_image" style="display: none;">
                    </div>
                </div>

                <div class="sell-divider"></div>

                <div class="sell-section details-section">
                    <p class="section-title">商品の詳細</p>

                    <div class="form-group category-group">
                        <label class="form-label">カテゴリ</label>
                        <div class="category-tags">
                            <span class="category-tag is-selected">ファッション</span>
                            <span class="category-tag">家電</span>
                            <span class="category-tag">インテリア</span>
                            <span class="category-tag">レディース</span>
                            <span class="category-tag">メンズ</span>
                            <span class="category-tag">コスメ</span>
                            <span class="category-tag">本</span>
                            <span class="category-tag">ゲーム</span>
                            <span class="category-tag">スポーツ</span>
                            <span class="category-tag">キッチン</span>
                            <span class="category-tag">ハンドメイド</span>
                            <span class="category-tag">アクセサリー</span>
                            <span class="category-tag">おもちゃ</span>
                            <span class="category-tag">ベビー・キッズ</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="condition" class="form-label">商品の状態</label>
                        <select id="condition" name="condition" class="form-select">
                            <option value="">選択してください</option>
                            <option value="good">良好</option>
                            <option value="no_scratch">目立った傷や汚れなし</option>
                            <option value="some_scratch">やや傷や汚れあり</option>
                            <option value="bad">状態が悪い</option>
                        </select>
                    </div>
                </div>

                <div class="sell-divider"></div>

                <div class="sell-section name-description-section">
                    <p class="section-title">商品名と説明</p>
                    <div class="form-group">
                        <label for="name" class="form-label">商品名</label>
                        <input type="text" id="name" name="name" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="brand" class="form-label">ブランド名</label>
                        <input type="text" id="brand" name="brand" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">商品の説明</label>
                        <textarea id="description" name="description" class="form-textarea"></textarea>
                    </div>
                </div>

                <div class="sell-divider"></div>

                <div class="sell-section price-section">
                    <p class="section-title">販売価格</p>
                    <div class="form-group price-group">
                        <input type="text" id="price" name="price" class="form-input price-input" placeholder="¥">
                    </div>
                </div>

                <div class="sell-divider"></div>

                <button type="submit" class="sell-button">出品する</button>
            </form>
        </main>

        <footer class="footer"></footer>
    </div>

</body>
</html>