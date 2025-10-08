# CDrive InfinityFree Deployment ZIP Oluşturucu

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "CDrive InfinityFree ZIP Paketi Oluşturuluyor" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Deployment klasörünü temizle
if (Test-Path "infinityfree_deploy") {
    Remove-Item -Recurse -Force "infinityfree_deploy"
}

New-Item -ItemType Directory -Force -Path "infinityfree_deploy\htdocs" | Out-Null
New-Item -ItemType Directory -Force -Path "infinityfree_deploy\root" | Out-Null

Write-Host "[1/6] Composer bağımlılıkları yükleniyor..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev --quiet

Write-Host "[2/6] Önbellekler temizleniyor..." -ForegroundColor Yellow
php artisan config:clear --quiet
php artisan route:clear --quiet
php artisan view:clear --quiet

Write-Host "[3/6] Production .env hazırlanıyor..." -ForegroundColor Yellow
Copy-Item ".env.production" "infinityfree_deploy\root\.env"

Write-Host "[4/6] Dosyalar kopyalanıyor..." -ForegroundColor Yellow

# htdocs klasörüne (public klasörü)
Copy-Item -Path "public\*" -Destination "infinityfree_deploy\htdocs\" -Recurse -Force

# Root klasörüne (Laravel dosyaları)
$folders = @("app", "bootstrap", "config", "database", "resources", "routes", "storage", "vendor")
foreach ($folder in $folders) {
    Copy-Item -Path $folder -Destination "infinityfree_deploy\root\$folder" -Recurse -Force
}

Copy-Item "artisan" "infinityfree_deploy\root\artisan"
Copy-Item "composer.json" "infinityfree_deploy\root\composer.json"
Copy-Item "composer.lock" "infinityfree_deploy\root\composer.lock"

# SQL dosyasını kopyala
Copy-Item "create_database.sql" "infinityfree_deploy\create_database.sql"

Write-Host "[5/6] InfinityFree için özel dosyalar hazırlanıyor..." -ForegroundColor Yellow

# htdocs/index.php - InfinityFree için düzeltilmiş
$indexPhp = @'
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
'@

Set-Content -Path "infinityfree_deploy\htdocs\index.php" -Value $indexPhp

# htdocs/.htaccess
$htaccess = @'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

Options -Indexes

<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>
'@

Set-Content -Path "infinityfree_deploy\htdocs\.htaccess" -Value $htaccess

# Kurulum talimatları
$instructions = @'
========================================
CDrive InfinityFree Kurulum Talimatları
========================================

📋 ADIM 1: VERITABANI KURULUMU
--------------------------------
1. InfinityFree Control Panel'e giriş yapın
2. phpMyAdmin'i açın
3. if0_37354591_db_notest veritabanını seçin
4. Import sekmesine tıklayın
5. create_database.sql dosyasını yükleyin
6. "Import has been successfully finished" mesajını bekleyin

🌐 ADIM 2: FTP BAĞLANTISI
--------------------------------
Host: ftpupload.net
Username: if0_37354591
Port: 21
Password: (InfinityFree panelinden alın)

📤 ADIM 3: DOSYA YÜKLEME
--------------------------------
FileZilla ile bağlandıktan sonra:

A) htdocs/ klasöründeki TÜM dosyaları → FTP'de htdocs/ içine yükleyin
   - index.php
   - .htaccess
   - css/
   - favicon.ico
   - vb.

B) root/ klasöründeki TÜM dosyaları → FTP'de / (root) içine yükleyin
   - app/
   - bootstrap/
   - config/
   - database/
   - resources/
   - routes/
   - storage/
   - vendor/
   - .env
   - artisan
   - composer.json

📁 ADIM 4: DOĞRU KLASÖR YAPISI
--------------------------------
FTP'de şu yapı olmalı:

/ (root)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
└── composer.json

htdocs/
├── index.php
├── .htaccess
├── css/
└── favicon.ico

🔐 ADIM 5: KLASÖR İZİNLERİ
--------------------------------
FileZilla'da sağ tık → File permissions:
- storage/ → 755 (Recursive seçili)
- bootstrap/cache/ → 755 (Recursive seçili)

✅ ADIM 6: TEST
--------------------------------
1. Tarayıcıda açın: https://crty.gt.tc/
2. Giriş yapın:
   - Admin: admin@cdrive.com / admin123
   - Kullanıcı: user@cdrive.com / user123

========================================
📊 Veritabanı Bilgileri
========================================
Host: sql211.infinityfree.com
Database: if0_37354591_db_notest
Username: if0_37354591
Password: eNNrqyMlb4L
Port: 3306

========================================
⚠️ Önemli Notlar
========================================
- .htaccess dosyasının adı tam olarak .htaccess olmalı (başında nokta var)
- .env dosyası root dizinde olmalı (htdocs'un dışında)
- InfinityFree'de maksimum dosya boyutu 10MB'dır
- Günlük 50,000 hit limiti vardır

========================================
🆘 Sorun Giderme
========================================
- 500 Error: storage/ ve bootstrap/cache/ izinlerini kontrol edin
- 404 Error: .htaccess dosyasının htdocs/ içinde olduğundan emin olun
- Database Error: .env dosyasındaki bilgileri kontrol edin

Başarılar! 🚀
'@

Set-Content -Path "infinityfree_deploy\KURULUM_TALIMATLARI.txt" -Value $instructions

Write-Host "[6/6] ZIP dosyası oluşturuluyor..." -ForegroundColor Yellow

# ZIP oluştur
$zipPath = Join-Path (Get-Location) "CDrive_InfinityFree_Deploy.zip"
if (Test-Path $zipPath) {
    Remove-Item $zipPath -Force
}

Compress-Archive -Path "infinityfree_deploy\*" -DestinationPath $zipPath -Force

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "✅ ZIP Paketi Hazır!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "📦 Dosya: CDrive_InfinityFree_Deploy.zip" -ForegroundColor Cyan
Write-Host "📏 Boyut: $([math]::Round((Get-Item $zipPath).Length / 1MB, 2)) MB" -ForegroundColor Cyan
Write-Host ""
Write-Host "Şimdi yapmanız gerekenler:" -ForegroundColor Yellow
Write-Host "1. CDrive_InfinityFree_Deploy.zip dosyasını açın" -ForegroundColor White
Write-Host "2. KURULUM_TALIMATLARI.txt dosyasını okuyun" -ForegroundColor White
Write-Host "3. FileZilla ile dosyaları yükleyin" -ForegroundColor White
Write-Host "4. phpMyAdmin'den create_database.sql'i import edin" -ForegroundColor White
Write-Host ""
Write-Host "Başarılar! 🎉" -ForegroundColor Green
Write-Host ""

# ZIP'i aç
Start-Process "explorer.exe" -ArgumentList "/select,`"$zipPath`""
