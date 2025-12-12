# アプリケーション名

お問い合わせフォーム

## 環境構築
・docker-compose exec php bash
・composer install
・cp .env.example .env
・php artisan key:generate
・php artisan migrate
・php artisan db:seed

## 開発環境
・お問い合わせフォーム http://localhost/contacts
・管理者登録 http://localhost/register
・管理者ログイン http://localhost/login
・phpMyAdmin http://localhost:8080

## 使用技術
・PHP 8.2.11
・Laravel 8.83.8
・jQuery 3.7.1
・MySQL 8.0.26
・nginx 1.21.1

## ER図

<img width="491" height="391" alt="contact-form drawio" src="https://github.com/user-attachments/assets/6ad52ba9-38ac-4216-892a-a58f33e0e2fd" />
