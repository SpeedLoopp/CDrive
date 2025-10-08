@echo off
REM CDrive InfinityFree Deployment Script (Windows)

echo ========================================
echo CDrive InfinityFree Deployment Hazirligi
echo ========================================
echo.

REM 1. Composer bagimliliklarini yukle
echo [1/6] Composer bagimliliklari yukleniyor...
call composer install --optimize-autoloader --no-dev

REM 2. Onbellekleri olustur
echo [2/6] Onbellekler olusturuluyor...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

REM 3. .env.production dosyasini .env olarak kopyala
echo [3/6] Production .env dosyasi hazirlaniyor...
copy /Y .env.production .env

REM 4. Deployment klasoru olustur
echo [4/6] Deployment klasoru olusturuluyor...
if not exist "deployment\htdocs" mkdir deployment\htdocs
if not exist "deployment\app" mkdir deployment\app

REM 5. Gerekli dosyalari kopyala
echo [5/6] Dosyalar kopyalaniyor...

REM Public klasorunu htdocs'a kopyala
xcopy /E /I /Y public deployment\htdocs

REM Diger klasorleri kopyala
xcopy /E /I /Y app deployment\app
xcopy /E /I /Y bootstrap deployment\bootstrap
xcopy /E /I /Y config deployment\config
xcopy /E /I /Y database deployment\database
xcopy /E /I /Y resources deployment\resources
xcopy /E /I /Y routes deployment\routes
xcopy /E /I /Y storage deployment\storage
xcopy /E /I /Y vendor deployment\vendor
copy /Y .env deployment\.env
copy /Y artisan deployment\artisan
copy /Y composer.json deployment\composer.json
copy /Y composer.lock deployment\composer.lock

REM 6. index.php dosyasini duzenle
echo [6/6] index.php dosyasi duzenleniyor...
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
) > deployment\htdocs\index.php

echo.
echo ========================================
echo Hazirlik tamamlandi!
echo ========================================
echo.
echo Simdi yapmaniz gerekenler:
echo 1. FileZilla ile InfinityFree FTP'ye baglanin
echo 2. deployment/htdocs/* dosyalarini htdocs/ klasorune yukleyin
echo 3. deployment/* (htdocs haric) dosyalarini bir ust dizine yukleyin
echo 4. phpMyAdmin'den create_database.sql dosyasini import edin
echo 5. storage ve bootstrap/cache klasorlerine 755 izni verin
echo.
echo FTP Bilgileri:
echo Host: ftpupload.net
echo Username: if0_37354591
echo Port: 21
echo.
echo Veritabani Bilgileri:
echo Host: sql211.infinityfree.com
echo Database: if0_37354591_db_notest
echo Username: if0_37354591
echo.
pause
