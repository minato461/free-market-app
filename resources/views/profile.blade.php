<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール設定 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
                        <li class="nav__item"><a href="{{ route('item.create') }}" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main profile-main">
            <h2 class="profile-title">プロフィール設定</h2>

            <form class="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="profile-image-upload">
                    <div class="profile-image-wrapper">
                        <div class="profile-image" id="image_preview">
                            @if($address->image_path)
                                <img src="{{ asset('storage/image/' . $address->image_path) }}" alt="プロフィール画像" id="preview_img">
                            @endif
                        </div>
                    </div>
                    <label for="image_upload" class="image-select-button">画像を選択する</label>
                    {{-- nameはコントローラーのバリデーションに合わせて image_path --}}
                    <input type="file" id="image_upload" name="image_path" style="display: none;" accept="image/*">
                    @error('image_path') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">ユーザー名</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}">
                    @error('name') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="postal_code" class="form-label">郵便番号</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-input" value="{{ old('postal_code', $address->postal_code) }}">
                    @error('postal_code') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">住所</label>
                    <input type="text" id="address" name="address" class="form-input" value="{{ old('address', $address->address) }}">
                    @error('address') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="building_name" class="form-label">建物名</label>
                    <input type="text" id="building_name" name="building_name" class="form-input" value="{{ old('building_name', $address->building_name) }}">
                    @error('building_name') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="update-button">更新する</button>
            </form>
        </main>

        <footer class="footer"></footer>
    </div>

    <script>
        document.getElementById('image_upload').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            const preview = document.getElementById('image_preview');

            reader.onload = function (event) {
                preview.innerHTML = `<img src="${event.target.result}" alt="プレビュー" id="preview_img">`;
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>