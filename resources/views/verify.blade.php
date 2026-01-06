<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証誘導画面 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
</head>
<body>
    <div class="page-container">
        <header class="header">
            <div class="header__inner">
                <h1 class="header__logo">
                    <a href="{{ route('item.index') }}"><img src="{{ asset('storage/image/logo.svg') }}" alt="COACHTECH"></a>
                </h1>
            </div>
        </header>

        <main class="verify-container">
            <h2 class="verify-title">
                登録していただいたメールアドレスに認証メールを送付しました。<br>
                メール認証を完了してください。
            </h2>

            <div class="verify-link-container">
                <a href="http://localhost:8025" target="_blank" class="verify-button">
                    認証はこちらから
                </a>
            </div>

            {{-- 認証メールの再送フォーム --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="resend-button">
                    認証メールを再送する
                </button>
            </form>
        </main>
    </div>

</body>
</html>