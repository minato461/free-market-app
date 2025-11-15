<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="page-container">
        <header class="header">
            <div class="header__inner">
                <h1 class="header__logo">
                    <a href="/"><img src="{{ asset('image/logo.svg') }}" alt="COACHTECH"></a>
                </h1>
            </div>
        </header>

        <main class="main login-main">
            <div class="login-container">
                <h2 class="login-title">ログイン</h2>

                <form class="login-form" action="/login" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}">
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">パスワード</label>
                        <input type="password" id="password" name="password" class="form-input">
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="login-button">ログインする</button>
                </form>

                <div class="register-link-area">
                    <a href="/register" class="register-link">会員登録はこちら</a>
                </div>
            </div>
        </main>

        <footer class="footer"></footer>
    </div>

</body>
</html>