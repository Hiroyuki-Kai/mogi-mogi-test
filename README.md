# アプリケーション名

**mogimogi（モギモギページ）**

---

# 環境構築

本アプリケーションは Docker を使用した開発環境を前提としています。

## 1. リポジトリをクローン

```bash
git clone git@github.com:Hiroyuki-Kai/mogi-mogi-test.git
cd mogi-mogi-test
```

## 2. Docker起動

```bash
docker-compose up -d --build
```

## 3. Composerインストール

```bash
docker-compose exec php bash
composer install
```

## 4. .env作成

```bash
docker-compose exec php cp .env.example .env
```

**作成した.env の DB 設定の以下の項目を修正**<br>
**※ .env はホスト側（VSCodeなど）で編集してください**

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

## 5. アプリケーションキー生成

```bash
docker-compose exec php php artisan key:generate
```

## 6. マイグレーション

```bash
docker-compose exec php php artisan migrate
```

## 7. シーディング

```bash
docker-compose exec php php artisan db:seed
```

## 8. シンボリックリンク作成

```bash
docker-compose exec php php artisan storage:link
```

## 9. パーミッション設定（初回起動時）

Laravel がログ・キャッシュを書き込めるように権限を設定します。

```bash
docker-compose exec php bash -lc "chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache"
```

---
# 使用技術（実行環境）

-   PHP 8.4.10
-   Laravel 8.83.29
-   MySQL 8.0.26
-   Docker
-   HTML / CSS

---

# 機能一覧

### 商品管理

* 商品一覧表示
* 商品登録
* 商品詳細・編集
* 商品削除

### 検索機能

* 商品名検索
* 価格並び替え
* ページネーション

---

# ER図

ER図は下記画像を参照してください。

![ER図](./mogimogi_er.png)

---

# URL一覧（ローカル環境）

| 機能         | URL                                   |
| ---------- | ------------------------------------- |
| 商品一覧       | http://localhost/products             |
| 商品登録       | http://localhost/products/register    |
| 商品詳細       | http://localhost/products/detail/{id} |
| phpMyAdmin | http://localhost:8080                 |

---

# 補足

※ 初期状態では画像ファイルは存在しません。
商品登録時に以下の画像を「storage/app/public/images/」配下にアップロードすることで表示されます。<br>
[ダミーデータ画像ファイル](./fruits-img.zip)
