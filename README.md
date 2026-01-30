# 🛒 フリマアプリクローン開発 (free-market-app)

## 💻 環境構築手順

## 1. 必須ツールの確認とインストール

以下がインストールされていることを確認してください。

- Docker
- Docker Compose
- Git

※ PHP / MySQL / Composer は Docker コンテナ内で利用します。


## 2. リポジトリのクローンと移動
```bash
git clone git@github.com:minato461/free-market-app.git
cd free-market-app
```

## 3. 環境変数の設定
```bash
cp .env.example .env
```

```.env``` ファイル内に以下の項目が設定されていることを確認してください。

### DB接続情報
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=free_market_db
DB_USERNAME=free_market_user
DB_PASSWORD=password
```

### メール設定(Mailhog)
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@test.com"
```

### Stripe決済設定
Stripeのダッシュボードから取得したテスト用キーを設定してください。

```
STRIPE_PUBLIC=pk_test_...
STRIPE_SECRET=sk_test_...
```

## 4. Dockerコンテナの起動
```bash
docker compose up -d
```

## 5. アプリケーションの初期化

### Appコンテナに入る
```bash
docker compose exec app bash
```

### 依存パッケージのインストール
```bash
composer install
```

### アプリケーションキーの生成
```bash
php artisan key:generate
```

### データベースの構築とシーディング（ダミーデータの投入）
```bash
php artisan migrate:fresh --seed
```

### 画像表示用のシンボリックリンク作成
```bash
php artisan storage:link
```

### テストの実行方法
本プロジェクトでは PHPUnit を使用して自動テストを行っています。

### 事前準備
テスト用のデータベース（SQLite推奨）を準備します。
`.env.testing` を作成し、以下を設定してください。

```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

その後、SQLite のデータベースファイルを作成します。

```bash
touch database/database.sqlite
php artisan migrate --env=testing

```

### テストの全件実行
```bash
php artisan test
```

## 🛠️ 使用技術 (Technology Stack)

| 区分 | 技術名 | バージョン (目安) | 備考 |
| :--- | :--- | :--- | :--- |
| **バックエンド** | PHP | 8.x 以上 | |
| **フレームワーク** | Laravel | 11.x | MVCモデルを採用 |
| **データベース** | MySQL | 8.0 以上 | 本番環境を想定 |
| **フロントエンド** | HTML / CSS | - | Bladeテンプレートを使用 |
| **バージョン管理** | Git / GitHub | - | |
| **依存性管理** | Composer | 2.x | |

## ER図
![フリマアプリ ER図](模擬案件_フリマアプリ.png)

## ストレージ構成
本プロジェクトのストレージ構成は、「環境構築」と「ソースコードの管理」が一体となった構想になっております。
商品画像は ```storage/app/public/image``` に保存されます。ブラウザからアクセスするために ```public/storage``` へのシンボリックリンクが必要です。

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
- Mailhog :：http://localhost:8025/