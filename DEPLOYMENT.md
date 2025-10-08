# InfinityFree'ye Deployment Rehberi

## 📋 Gereksinimler

- InfinityFree hesabı
- FTP istemcisi (FileZilla önerilir)
- Composer yüklü bilgisayar

## 🚀 Adım Adım Deployment

### 1. Projeyi Hazırlayın

```bash
# Bağımlılıkları yükleyin
composer install --optimize-autoloader --no-dev

# Önbellekleri oluşturun
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. .env Dosyasını Düzenleyin

`.env.production` dosyasını `.env` olarak kopyalayın ve düzenleyin:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.infinityfreeapp.com

DB_HOST=sql211.infinityfree.com
DB_DATABASE=if0_37354591_db_notest
DB_USERNAME=if0_37354591
DB_PASSWORD=eNNrqyMlb4L
```

### 3. Dosyaları FTP ile Yükleyin

**InfinityFree FTP Bilgileri:**
- Host: ftpupload.net
- Username: if0_37354591
- Password: (InfinityFree panelinden alın)
- Port: 21

**Yükleme Yapısı:**
```
htdocs/
├── public/          (tüm public klasörü içeriği buraya)
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
```

**ÖNEMLİ:** `public` klasörünün içeriğini `htdocs` klasörüne kopyalayın, diğer dosyaları bir üst dizine.

### 4. .htaccess Dosyasını Düzenleyin

`htdocs/.htaccess` dosyasını oluşturun:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Laravel'in public klasörüne yönlendir
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ /public/$1 [L]
</IfModule>
```

### 5. index.php Dosyasını Düzenleyin

`htdocs/index.php` dosyasındaki yolları düzeltin:

```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

### 6. Storage İzinlerini Ayarlayın

FTP üzerinden `storage` ve `bootstrap/cache` klasörlerine 755 izni verin.

### 7. Veritabanını Migrate Edin

InfinityFree'de SSH erişimi olmadığı için migration'ları manuel çalıştırmanız gerekir:

**Seçenek A:** phpMyAdmin'den SQL dosyasını import edin
**Seçenek B:** Yerel migration çalıştırıp veritabanını export/import edin

```bash
# Yerel olarak
php artisan migrate:fresh --seed

# Sonra phpMyAdmin'den export edin ve InfinityFree'ye import edin
```

### 8. Önbellekleri Temizleyin

Sunucuda bir kez çalıştırın (SSH yoksa FTP ile):

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## ⚠️ InfinityFree Sınırlamaları

- ❌ SSH erişimi yok
- ❌ Cron job sınırlı
- ❌ Dosya yükleme limiti: 10MB
- ❌ Günlük hit limiti: 50,000
- ❌ CPU kullanımı sınırlı

## 🔧 Alternatif Çözüm: Yerel Geliştirme

Geliştirme için yerel XAMPP/WAMP kullanın:

1. XAMPP'ı indirin ve kurun
2. MySQL'i başlatın
3. phpMyAdmin'den `cdrive` veritabanını oluşturun
4. `.env` dosyasını yerel ayarlara göre düzenleyin:

```env
DB_HOST=127.0.0.1
DB_DATABASE=cdrive
DB_USERNAME=root
DB_PASSWORD=
```

5. Migration'ları çalıştırın:
```bash
php artisan migrate:fresh --seed
```

## 📚 Önerilen Hosting Alternatifleri

Daha iyi performans için:
- **DigitalOcean** ($5/ay)
- **Vultr** ($5/ay)
- **Linode** ($5/ay)
- **Heroku** (Ücretsiz tier)
- **Railway** (Ücretsiz tier)

Bu platformlarda SSH erişimi ve tam Laravel desteği vardır.
