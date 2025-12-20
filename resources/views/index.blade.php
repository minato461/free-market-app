<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="page-container">
        <header class="header">
            <div class="header__inner">
                <h1 class="header__logo">
                    <a href="{{ route('item.index') }}"><img src="{{ asset('storage/image/logo.svg') }}" alt="COACHTECH"></a>
                </h1>
                <form action="{{ request()->routeIs('item.mylist') ? route('item.mylist') : route('item.index') }}" method="GET" class="header__search">
                    <input type="text" name="keyword" placeholder="なにをお探しですか?" class="search__input" value="{{ request('keyword') }}">
                    <button type="submit" style="display: none;"></button>
                </form>
                <nav class="header__nav">
                    <ul class="nav__list">
                        @guest
                            <li class="nav__item">
                                <a href="{{ route('login') }}" class="nav__link">ログイン</a>
                            </li>
                            <li class="nav__item">
                                <a href="{{ route('register') }}" class="nav__link">会員登録</a>
                            </li>
                        @endguest

                        @auth
                            <li class="nav__item">
                                <a href="/mypage" class="nav__link">マイページ</a>
                            </li>
                            <li class="nav__item">
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="logout__button nav__link">ログアウト</button>
                                </form>
                            </li>
                        @endauth

                        <li class="nav__item"><a href="/sell" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="main-nav">
            <nav class="tab-nav">
                <ul class="tab-list">
                    <li class="tab-item @if(request()->routeIs('item.index')) is-active @endif">
                        <a href="{{ route('item.index') }}">おすすめ</a>
                    </li>
                    <li class="tab-item @if(request()->routeIs('item.mylist')) is-active @endif">
                        @auth
                            <a href="{{ route('item.mylist') }}">マイリスト</a>
                        @else
                            <span class="nav-disabled">マイリスト</span>
                        @endauth
                    </li>
                </ul>
            </nav>
        </div>

        <main class="main">
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            <div class="item-list-container">
                <div class="item-list">
                    @foreach ($items as $item)
                        <a href="/item/{{ $item->id }}" class="item-card">
                            <div class="item-card__image-wrapper">
                                <img src="{{ asset('storage/image/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-card__image">
                                @if ($item->isSold())
                                    <div class="item-card__sold-badge">Sold</div>
                                @endif
                            </div>

                            <div class="item-card__info">
                                <span class="item-card__name">{{ $item->name }}</span>
                                <span class="item-card__like-count">
                                    <i class="fas fa-heart"></i>
                                    {{ $item->likes->count() }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </main>

        <footer class="footer">
        </footer>
    </div>

</body>
</html>