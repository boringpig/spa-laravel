
Kiosk 泉州後台
===

# 環境需求
- php >= 7.0.0
- mongodb >= 3.4

# 環境版本
- Laravel 5.5
- MongoDB 3.6

# 環境部署

# 步驟ㄧ 遠端拉專案並做基本設定
```
git clone git@gitlab.program.com.tw:jeffery/kiosk_backend.git
cp .env.example .env
composer install
php artisan k:g
chmod -R 775 storage/
chmod -R 775 bootstrap/cache
```

## 步驟二 啟動docker
```
cd docker 
docker-compose up -d
```

## 步驟三 編輯.env
```
DB_CONNECTION=mongo
DB_HOST=xxxx
DB_PORT=xxxx
DB_DATABASE=xxx
DB_USERNAME=xxx
DB_PASSWORD=xxx
```
