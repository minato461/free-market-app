<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

    <div class="page-container">
        <header class="header">
            <div class="header__inner register-logo-only">
                <h1 class="header__logo">
                    <a><img src="{{ asset('image/logo.svg') }}" alt="COACHTECH"></a>
                </h1>
            </div>
        </header>

        <main class="main register-main">
            <div class="register-container">
                <h2 class="register-title">会員登録</h2>
                <form class="register-form" action="/register" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">ユーザー名</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">パスワード</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">確認用パスワード</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                    </div>
                    <button type="submit" class="register-button">
                        登録する
                    </button>
                </form>

                <div class="login-link-area">
                    <a href="/login" class="login-link">
                        ログインはこちら
                    </a>
                </div>
            </div>
        </main>
        <footer class="footer">
        </footer>
    </div>

</body>
</html>