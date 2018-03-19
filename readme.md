
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

## 步驟三 進入container
```
docker exec -it --user 1000 kiosk_container bash
```

## 步驟四 編輯.env
```
DB_CONNECTION=mongo
DB_HOST=xxxx
DB_PORT=xxxx
DB_DATABASE=xxx
DB_USERNAME=xxx
DB_PASSWORD=xxx
```

# API壓力測試

## 新增post_data.txt
```
token=1d7ed42da49d98a14ff3634d7cfaa15838d7307416f5f342bf22d42dfcc2f93c
```
## 指令
-n 請求數、 -c 同時連線數、 -T Content-type的header內容、-p form_data內容、Api的url
```
ab -n 10 -c 5 -T application/json -T application/x-www-form-urlencoded -p post_data.txt  http://localhost:81/api/setting/customer
```