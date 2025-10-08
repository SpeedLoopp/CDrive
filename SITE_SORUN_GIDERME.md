# 🔧 Site Açılmıyor - Sorun Giderme

## Site: https://crty.gt.tc/cdrive

## ❌ Olası Sorunlar ve Çözümler

### 1. Dosya Yapısı Yanlış

InfinityFree'de dosya yapısı şöyle olmalı:

```
htdocs/
├── cdrive/              ❌ YANLIŞ - Alt klasör olmamalı
│   └── index.php

htdocs/                  ✅ DOĞRU
├── index.php
├── .htaccess
└── css/
```

**Çözüm:** Tüm dosyaları `htdocs/cdrive/` yerine doğrudan `htdocs/` içine taşıyın.

### 2. .htaccess Eksik veya Yanlış

`htdocs/.htaccess` dosyası olmalı:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 3. index.php Yolu Yanlış

`htdocs/index.php` dosyasında yollar şöyle olmalı:

```php
<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

### 4. Laravel Dosyaları Yanlış Yerde

**Doğru Yapı:**
```
/ (root - FTP'de htdocs'un üstü)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
└── artisan

htdocs/ (public klasörü)
├── index.php
├── .htaccess
├── css/
└── favicon.ico
```

## 🔍 Kontrol Listesi

- [ ] MySQL veritabanı oluşturuldu mu?
- [ ] `create_database.sql` import edildi mi?
- [ ] `.env` dosyası root dizinde mi?
- [ ] `htdocs/index.php` var mı?
- [ ] `htdocs/.htaccess` var mı?
- [ ] `storage/` klasörü 755 izinli mi?
- [ ] `bootstrap/cache/` klasörü 755 izinli mi?

## 🚀 Hızlı Çözüm

### Adım 1: Dosya Yapısını Düzeltin

FTP ile bağlanın ve şu yapıyı oluşturun:

1. `htdocs/cdrive/` klasörü varsa, içindeki dosyaları `htdocs/` içine taşıyın
2. URL'yi test edin: https://crty.gt.tc/ (cdrive olmadan)

### Adım 2: .htaccess Ekleyin

`htdocs/.htaccess` dosyası yoksa oluşturun (içeriği aşağıda)

### Adım 3: Veritabanını Kontrol Edin

phpMyAdmin'de:
1. `if0_37354591_db_notest` veritabanını seçin
2. `users` tablosu var mı kontrol edin
3. Yoksa `create_database.sql` dosyasını import edin

## 📝 Gerekli Dosyalar

Aşağıdaki dosyaları FTP ile yükleyin/düzeltin.
