@echo off
echo ========================================
echo CDrive InfinityFree Deployment Paketi
echo ========================================
echo.

REM Deployment klasorunu temizle
if exist "infinityfree_deploy" rmdir /s /q infinityfree_deploy
mkdir infinityfree_deploy
mkdir infinityfree_deploy\htdocs
mkdir infinityfree_deploy\root

echo [1/5] Composer bagimliliklari yukleniyor...
call composer install --optimize-autoloader --no-dev

echo [2/5] Onbellekler olusturuluyor...
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear

echo [3/5] Production .env hazirlaniyor...
copy /Y .env.production infinityfree_deploy\root\.env

echo [4/5] Dosyalar kopyalaniyor...

REM htdocs klasorune (public klasoru)
xcopy /E /I /Y public\* infinityfree_deploy\htdocs\

REM Root klasorune (Laravel dosyalari)
xcopy /E /I /Y app infinityfree_deploy\root\app
xcopy /E /I /Y bootstrap infinityfree_deploy\root\bootstrap
xcopy /E /I /Y config infinityfree_deploy\root\config
xcopy /E /I /Y database infinityfree_deploy\root\database
xcopy /E /I /Y resources infinityfree_deploy\root\resources
xcopy /E /I /Y routes infinityfree_deploy\root\routes
xcopy /E /I /Y storage infinityfree_deploy\root\storage
xcopy /E /I /Y vendor infinityfree_deploy\root\vendor

copy /Y artisan infinityfree_deploy\root\artisan
copy /Y composer.json infinityfree_deploy\root\composer.json
copy /Y composer.lock infinityfree_deploy\root\composer.lock

REM SQL dosyasini kopyala
copy /Y create_database.sql infinityfree_deploy\create_database.sql

echo [5/5] InfinityFree icin ozel dosyalar hazirlaniyor...

REM htdocs/index.php - InfinityFree icin duzeltilmis
(
echo ^<?php
echo.
echo use Illuminate\Contracts\Http\Kernel;
echo use Illuminate\Http\Request;
echo.
echo define^('LARAVEL_START', microtime^(true^)^);
echo.
echo if ^(file_exists^($maintenance = __DIR__.'/../storage/framework/maintenance.php'^)^) {
echo     require $maintenance;
echo }
echo.
echo require __DIR__.'/../vendor/autoload.php';
echo.
echo $app = require_once __DIR__.'/../bootstrap/app.php';
echo.
echo $kernel = $app-^>make^(Kernel::class^);
echo.
echo $response = $kernel-^>handle^(
echo     $request = Request::capture^(^)
echo ^)-^>send^(^);
echo.
echo $kernel-^>terminate^($request, $response^);
) > infinityfree_deploy\htdocs\index.php

REM htdocs/.htaccess
(
echo ^<IfModule mod_rewrite.c^>
echo     ^<IfModule mod_negotiation.c^>
echo         Options -MultiViews -Indexes
echo     ^</IfModule^>
echo.
echo     RewriteEngine On
echo.
echo     # Handle Authorization Header
echo     RewriteCond %%{HTTP:Authorization} .
echo     RewriteRule .* - [E=HTTP_AUTHORIZATION:%%{HTTP:Authorization}]
echo.
echo     # Redirect Trailing Slashes
echo     RewriteCond %%{REQUEST_FILENAME} !-d
echo     RewriteCond %%{REQUEST_URI} ^(.+^)/$
echo     RewriteRule ^^^ %%1 [L,R=301]
echo.
echo     # Send Requests To Front Controller
echo     RewriteCond %%{REQUEST_FILENAME} !-d
echo     RewriteCond %%{REQUEST_FILENAME} !-f
echo     RewriteRule ^^^ index.php [L]
echo ^</IfModule^>
echo.
echo Options -Indexes
) > infinityfree_deploy\htdocs\.htaccess

REM Kurulum talimatlarini olustur
(
echo ========================================
echo CDrive InfinityFree Kurulum Talimatlari
echo ========================================
echo.
echo 1. VERITABANI KURULUMU
echo    - InfinityFree Control Panel'e giris yapin
echo    - phpMyAdmin'i acin
echo    - if0_37354591_db_notest veritabanini secin
echo    - Import sekmesine tiklayin
echo    - create_database.sql dosyasini yukleyin
echo.
echo 2. FTP BAGLANTISI
echo    Host: ftpupload.net
echo    Username: if0_37354591
echo    Port: 21
echo.
echo 3. DOSYA YUKLEME
echo    A^) htdocs/ klasorundeki TUM dosyalari FTP'de htdocs/ icine yukleyin
echo    B^) root/ klasorundeki TUM dosyalari FTP'de / ^(root^) icine yukleyin
echo.
echo 4. KLASOR YAPISI
echo    / ^(root^)
echo    ├── app/
echo    ├── bootstrap/
echo    ├── config/
echo    ├── database/
echo    ├── resources/
echo    ├── routes/
echo    ├── storage/
echo    ├── vendor/
echo    ├── .env
echo    └── artisan
echo.
echo    htdocs/
echo    ├── index.php
echo    ├── .htaccess
echo    └── css/
echo.
echo 5. KLASOR IZINLERI ^(FileZilla'da sag tik -^> File permissions^)
echo    - storage/ -^> 755 ^(Recursive^)
echo    - bootstrap/cache/ -^> 755 ^(Recursive^)
echo.
echo 6. TEST
echo    - https://crty.gt.tc/ adresine gidin
echo    - Giris: admin@cdrive.com / admin123
echo.
echo ========================================
echo Veritabani Bilgileri
echo ========================================
echo Host: sql211.infinityfree.com
echo Database: if0_37354591_db_notest
echo Username: if0_37354591
echo Password: eNNrqyMlb4L
echo.
echo ========================================
) > infinityfree_deploy\KURULUM_TALIMATLARI.txt

echo.
echo ========================================
echo Paket hazirlandi!
echo ========================================
echo.
echo Simdi yapmaniz gerekenler:
echo 1. infinityfree_deploy klasorunu ZIP'leyin
echo 2. ZIP'i acin
echo 3. KURULUM_TALIMATLARI.txt dosyasini okuyun
echo 4. Dosyalari FTP ile yukleyin
echo.
echo ZIP olusturmak icin:
echo - infinityfree_deploy klasorune sag tiklayin
echo - "Send to" -^> "Compressed (zipped) folder" secin
echo.
pause
