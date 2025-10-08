# CDrive Kurulum Rehberi

## Gereksinimler

- PHP 8.1 veya üzeri
- Composer
- MySQL 5.7+ veya MariaDB 10.3+
- Apache/Nginx web sunucusu

## Kurulum Adımları

### 1. Composer Bağımlılıklarını Yükleyin

```bash
composer install
```

### 2. Ortam Dosyasını Oluşturun

```bash
copy .env.example .env
```

### 3. .env Dosyasını Düzenleyin

Veritabanı bilgilerinizi girin:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cdrive
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Uygulama Anahtarı Oluşturun

```bash
php artisan key:generate
```

### 5. Veritabanını Oluşturun

MySQL'de yeni bir veritabanı oluşturun:

```sql
CREATE DATABASE cdrive CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Migration'ları Çalıştırın

```bash
php artisan migrate
```

### 7. Seed Verilerini Yükleyin (Opsiyonel)

Admin ve test kullanıcısı oluşturmak için:

```bash
php artisan db:seed
```

**Varsayılan Giriş Bilgileri:**
- Admin: admin@cdrive.com / admin123
- Kullanıcı: user@cdrive.com / user123

### 8. Storage Linkini Oluşturun

```bash
php artisan storage:link
```

### 9. Klasör İzinlerini Ayarlayın

```bash
chmod -R 775 storage bootstrap/cache
```

### 10. Geliştirme Sunucusunu Başlatın

```bash
php artisan serve
```

Tarayıcınızda http://localhost:8000 adresine gidin.

## Üretim Ortamı İçin Ek Ayarlar

### 1. .env Dosyasını Güncelle

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Önbelleği Optimize Et

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Dosya Yükleme Limitlerini Ayarla

php.ini dosyanızda:

```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
memory_limit = 256M
```

### 4. Apache .htaccess

public/.htaccess dosyası zaten mevcut. Apache'de mod_rewrite aktif olmalı.

### 5. Nginx Konfigürasyonu

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/cdrive/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Özellikler

### Kullanıcı Özellikleri
- ✅ Kayıt olma ve giriş yapma
- ✅ Şifre sıfırlama
- ✅ Dosya yükleme, indirme ve silme
- ✅ Klasör oluşturma
- ✅ Özel link oluşturma
- ✅ Link paylaşımı

### Admin Özellikleri
- ✅ Kullanıcı yönetimi (aktif/pasif, silme)
- ✅ Dosya yönetimi (tüm dosyaları görme ve silme)
- ✅ Link yönetimi (tüm linkleri görme ve silme)
- ✅ Reklam yönetimi (ekleme, düzenleme, aktif/pasif)
- ✅ İstatistikler (kullanıcı, dosya, indirme sayıları)

### Güvenlik
- ✅ CSRF koruması
- ✅ XSS koruması
- ✅ SQL injection koruması
- ✅ Şifre hashleme
- ✅ Admin middleware

### Tasarım
- ✅ Siyah-mavi gradyan tema
- ✅ Responsive tasarım
- ✅ Modern UI/UX

## Sorun Giderme

### Composer bulunamadı
Composer'ı yükleyin: https://getcomposer.org/download/

### Storage klasörü yazılabilir değil
```bash
chmod -R 775 storage
```

### Dosya yüklenmiyor
php.ini dosyasında upload_max_filesize ve post_max_size değerlerini artırın.

### Admin paneline erişilemiyor
Veritabanında kullanıcının role alanının 'admin' olduğundan emin olun.

## Destek

Herhangi bir sorun için GitHub Issues kullanabilirsiniz.
