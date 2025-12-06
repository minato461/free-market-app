<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->name }} | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                        @guest
                            <li class="nav__item"><a href="/login" class="nav__link">ログイン</a></li>
                            <li class="nav__item"><a href="/register" class="nav__link">会員登録</a></li>
                        @endguest

                        @auth
                            <li class="nav__item">
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="logout__button nav__link">ログアウト</button>
                                </form>
                            </li>
                            <li class="nav__item"><a href="/mypage" class="nav__link">マイページ</a></li>
                        @endauth
                        <li class="nav__item"><a href="/sell" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main item-main">
            <div class="item-detail-wrapper">
                <div class="item-image-area">
                    <div class="item-image-box">
                        <img src="{{ asset('storage/image/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
                    </div>
                </div>

                <div class="item-content-area">
                    <div class="item-info-top">
                        <h2 class="item-name">{{ $item->name }}</h2>

                        <p class="brand-name">
                            @if ($item->brand)
                                {{ $item->brand->name }}
                            @else
                                
                            @endif
                        </p>

                        <p class="item-price">
                            ¥{{ number_format($item->price) }} <span>(税込)</span>
                        </p>

                        <div class="interaction-status">
                            <div class="flex items-center space-x-2">
                                @auth
                                <form method="POST" action="{{ route('like.toggle', $item) }}" class="inline-block like-form">
                                    @csrf

                                    <button type="submit" class="favorite-button transition duration-150 ease-in-out focus:outline-none">
                                        <span class="favorite-icon text-2xl">
                                            <i class="{{ $isLiked ? 'fas fa-heart text-red-500' : 'far fa-heart text-gray-500 hover:text-red-400' }}"></i>
                                        </span>
                                    </button>
                                </form>
                                @endauth

                                @guest
                                <div class="text-2xl text-gray-400 cursor-not-allowed" title="いいねするにはログインが必要です">
                                    <i class="far fa-heart"></i>
                                </div>
                                @endguest

                                <span class="like-count text-lg font-bold">{{ $likeCount }}</span>
                            </div>

                            <span class="comment-count-display">
                                <i class="far fa-comment-alt"></i>
                                {{ $item->comments->count() }}
                            </span>
                        </div>

                        @if (!$item->purchase && (!Auth::check() || Auth::id() !== $item->user_id))
                            <a href="{{ route('purchase.show', ['item_id' => $item->id]) }}" class="purchase-button">購入手続きへ</a>
                        @elseif ($item->purchase)
                            <button class="purchase-button sold-out" disabled>SOLD OUT</button>
                        @elseif (Auth::check() && Auth::id() === $item->user_id)
                            <button class="purchase-button my-item" disabled>出品中の商品です</button>
                        @endif

                    </div>

                    <div class="item-description-section">
                        <h3 class="section-title">商品説明</h3>
                        <p class="description-text">
                            {{ nl2br(e($item->description)) }}
                        </p>
                    </div>

                    <div class="item-spec-section">
                        <h3 class="section-title">商品の情報</h3>

                        <div class="spec-row">
                            <p class="spec-label">カテゴリ</p>
                            <p class="spec-value tag-area">
                                {{-- $item->categoryはリレーション先のコレクション --}}
                                @foreach ($item->category as $category)
                                    <span class="spec-tag">{{ $category->name }}</span>
                                @endforeach
                            </p>
                        </div>

                        <div class="spec-row">
                            <p class="spec-label">商品の状態</p>
                            <p class="spec-value">{{ $item->condition }}</p>
                        </div>
                    </div>

                    <div class="comment-section">
                        <h3 class="section-title">コメント({{ $item->comments->count() }})</h3>

                        <div class="comment-list">
                            @foreach ($item->comments as $comment)
                                <div class="comment-item">
                                    <div class="comment-user">
                                        <div class="user-icon">{{ mb_substr($comment->user->name, 0, 1) }}</div>
                                        <p class="user-name-text">{{ $comment->user->name }}</p>
                                    </div>
                                    <p class="comment-text">{{ $comment->content }}</p>
                                    @if (Auth::check() && (Auth::id() === $comment->user_id || Auth::id() === $item->user_id))
                                        <form action="/comment/{{ $comment->id }}" method="POST" class="comment-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-button">削除</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="comment-form-area">
                            <h3 class="section-title">商品へのコメント</h3>
                            @auth
                                <form action="{{ route('comment.store', $item) }}" method="POST">
                                    @csrf

                                    <textarea
                                        name="comment"
                                        class="comment-textarea @error('comment') border-red-500 @enderror"
                                        placeholder="コメントを入力してください"
                                    >{{ old('comment') }}</textarea>

                                    @error('comment')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror

                                    <button type="submit" class="comment-submit-button">コメントを送信する</button>
                                </form>
                            @else
                                <p class="comment-login-message">コメントするには<a href="/login">ログイン</a>が必要です。</p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer"></footer>
    </div>

</body>
</html>