#!/bin/bash

# CDrive InfinityFree Deployment Script
# Bu script projeyi InfinityFree'ye yüklemek için hazırlar

echo "🚀 CDrive InfinityFree Deployment Hazırlığı"
echo "============================================"

# 1. Composer bağımlılıklarını yükle (production)
echo "📦 Composer bağımlılıkları yükleniyor..."
composer install --optimize-autoloader --no-dev

# 2. Önbellekleri oluştur
echo "⚡ Önbellekler oluşturuluyor..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. .env.production dosyasını .env olarak kopyala
echo "📝 Production .env dosyası hazırlanıyor..."
cp .env.production .env

# 4. Deployment klasörü oluştur
echo "📁 Deployment klasörü oluşturuluyor..."
mkdir -p deployment/htdocs
mkdir -p deployment/app

# 5. Gerekli dosyaları kopyala
echo "📋 Dosyalar kopyalanıyor..."

# Public klasörünü htdocs'a kopyala
cp -r public/* deployment/htdocs/

# Diğer klasörleri app klasörüne kopyala
cp -r app deployment/
cp -r bootstrap deployment/
cp -r config deployment/
cp -r database deployment/
cp -r resources deployment/
cp -r routes deployment/
cp -r storage deployment/
cp -r vendor deployment/
cp .env deployment/
cp artisan deployment/
cp composer.json deployment/
cp composer.lock deployment/

# 6. index.php dosyasını düzenle
echo "🔧 index.php dosyası düzenleniyor..."
cat > deployment/htdocs/index.php << 'EOF'
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// InfinityFree için yol düzeltmeleri
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
EOF

echo ""
echo "✅ Hazırlık tamamlandı!"
echo ""
echo "📤 Şimdi yapmanız gerekenler:"
echo "1. FileZilla ile InfinityFree FTP'ye bağlanın"
echo "2. deployment/htdocs/* dosyalarını htdocs/ klasörüne yükleyin"
echo "3. deployment/* (htdocs hariç) dosyalarını bir üst dizine yükleyin"
echo "4. phpMyAdmin'den create_database.sql dosyasını import edin"
echo "5. storage ve bootstrap/cache klasörlerine 755 izni verin"
echo ""
echo "🌐 FTP Bilgileri:"
echo "Host: ftpupload.net"
echo "Username: if0_37354591"
echo "Port: 21"
echo ""
echo "📊 Veritabanı Bilgileri:"
echo "Host: sql211.infinityfree.com"
echo "Database: if0_37354591_db_notest"
echo "Username: if0_37354591"
echo ""
