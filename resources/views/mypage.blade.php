<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール | フリマアプリ</title>
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
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" class="logout__button nav__link">ログアウト</button>
                            </form>
                        </li>
                        <li class="nav__item"><a href="{{ route('mypage.index') }}">マイページ</a></li>
                        <li class="nav__item"><a href="/sell" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main mypage-main">
            <div class="profile-info-area">
                <div class="profile-image-wrapper">
                    <!-- PersonalAddressモデルを参照 -->
                    <img src="{{ asset('storage/image/' . ($address->image_path ?? 'default_profile.png')) }}"
                        alt="プロフィール画像"
                        class="profile-image"
                        onerror="this.onerror=null;this.src='{{ asset('storage/image/default_profile.png') }}';">
                </div>
                <div class="profile-details">
                    <p class="user-name">{{ $user->name ?? '名無しユーザー' }}</p>
                    <a href="{{ route('profile.edit') }}" class="profile-edit-button">プロフィールを編集</a>
                </div>
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mypage-nav">
                <nav class="tab-nav">
                    <ul class="tab-list">
                        <li class="tab-item is-active" data-tab-target="items_listed"><a href="javascript:void(0)">出品した商品</a></li>
                        <li class="tab-item" data-tab-target="items_purchased"><a href="javascript:void(0)">購入した商品</a></li>
                    </ul>
                </nav>
            </div>

            <!-- 出品した商品リスト（デフォルトで表示） -->
            <div id="items_listed" class="tab-content active">
                <div class="mypage-item-list-container">
                    <div class="mypage-item-list">
                        @forelse ($listedItems as $item)
                            <a href="{{ route('item.show', $item->id) }}" class="item-card">
                                <div class="item-card__image-wrapper">
                                    <img src="{{ asset('storage/image/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-card__image">

                                    @if ($item->isSold())
                                        <div class="sold-badge">SOLD</div>
                                    @endif
                                </div>
                                <p class="item-card__name">{{ $item->name }}</p>
                            </a>
                        @empty
                            <p class="empty-message">出品した商品はありません。</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div id="items_purchased" class="tab-content hidden">
                <div class="mypage-item-list-container">
                    <div class="mypage-item-list">
                        @forelse ($purchasedItems as $item)
                            <a href="{{ route('item.show', $item->id) }}" class="item-card">
                                <div class="item-card__image-wrapper">
                                    <img src="{{ asset('storage/image/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-card__image">
                                </div>
                                <p class="item-card__name">{{ $item->name }}</p>
                            </a>
                        @empty
                            <p class="empty-message">購入した商品はありません。</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </main>

        <footer class="footer">
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-item');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetId = tab.getAttribute('data-tab-target');

                    tabs.forEach(t => t.classList.remove('is-active'));
                    tab.classList.add('is-active');

                    contents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('active');
                    });

                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                        targetContent.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>