# 🚀 InfinityFree Hızlı Kurulum Rehberi

## 📋 Gerekli Bilgiler

```
FTP Host: ftpupload.net
FTP Username: if0_37354591
FTP Port: 21

MySQL Host: sql211.infinityfree.com
MySQL Database: if0_37354591_db_notest
MySQL Username: if0_37354591
MySQL Password: eNNrqyMlb4L
```

## 🎯 Hızlı Kurulum (3 Adım)

### Adım 1: Veritabanını Hazırlayın

1. InfinityFree Control Panel'e giriş yapın
2. **MySQL Databases** bölümüne gidin
3. **phpMyAdmin** butonuna tıklayın
4. Sol taraftan `if0_37354591_db_notest` veritabanını seçin
5. Üst menüden **Import** (İçe Aktar) sekmesine tıklayın
6. **Choose File** butonuna tıklayın ve `create_database.sql` dosyasını seçin
7. **Go** (Git) butonuna tıklayın
8. ✅ "Import has been successfully finished" mesajını görmelisiniz

### Adım 2: Dosyaları Hazırlayın

Windows'ta çift tıklayın:
```
infinityfree_setup.bat
```

Linux/Mac'te çalıştırın:
```bash
chmod +x infinityfree_setup.sh
./infinityfree_setup.sh
```

Bu script:
- ✅ Composer bağımlılıklarını yükler
- ✅ Önbellekleri oluşturur
- ✅ Production .env dosyasını hazırlar
- ✅ Deployment klasörünü oluşturur

### Adım 3: FTP ile Yükleyin

#### FileZilla Kurulumu (Eğer yoksa)
1. https://filezilla-project.org/download.php adresinden indirin
2. Kurun ve açın

#### FTP Bağlantısı
1. FileZilla'yı açın
2. Üst kısımda:
   - **Host:** ftpupload.net
   - **Username:** if0_37354591
   - **Password:** (InfinityFree panelinden alın)
   - **Port:** 21
3. **Quickconnect** butonuna tıklayın

#### Dosya Yükleme
1. Sol tarafta (Local site): `deployment` klasörüne gidin
2. Sağ tarafta (Remote site): `htdocs` klasörüne gidin

**Yükleme Sırası:**

**A) htdocs klasörüne:**
- `deployment/htdocs/` içindeki TÜM dosyaları → `htdocs/` klasörüne sürükleyin

**B) Bir üst dizine (htdocs'un dışına):**
- `deployment/app/` → `/app/`
- `deployment/bootstrap/` → `/bootstrap/`
- `deployment/config/` → `/config/`
- `deployment/database/` → `/database/`
- `deployment/resources/` → `/resources/`
- `deployment/routes/` → `/routes/`
- `deployment/storage/` → `/storage/`
- `deployment/vendor/` → `/vendor/`
- `deployment/.env` → `/.env`
- `deployment/artisan` → `/artisan`
- `deployment/composer.json` → `/composer.json`

**Klasör Yapısı Şöyle Olmalı:**
```
/ (root)
├── htdocs/
│   ├── index.php
│   ├── .htaccess
│   ├── css/
│   └── ...
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

## 🔧 Son Ayarlar

### 1. Klasör İzinleri (FileZilla'da)

Sağ tıklayın → **File permissions**:
- `storage/` → 755 (Recursive)
- `bootstrap/cache/` → 755 (Recursive)

### 2. .env Dosyasını Kontrol Edin

FTP ile `/.env` dosyasını açın ve kontrol edin:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.infinityfreeapp.com

DB_HOST=sql211.infinityfree.com
DB_DATABASE=if0_37354591_db_notest
DB_USERNAME=if0_37354591
DB_PASSWORD=eNNrqyMlb4L
```

## 🎉 Test Edin

1. Tarayıcınızda sitenizi açın: `https://yourdomain.infinityfreeapp.com`
2. Giriş yapın:
   - **Admin:** admin@cdrive.com / admin123
   - **Kullanıcı:** user@cdrive.com / user123

## ⚠️ Sorun Giderme

### "500 Internal Server Error"
- `.env` dosyasının doğru yerde olduğundan emin olun
- `storage/` ve `bootstrap/cache/` izinlerini kontrol edin
- `.htaccess` dosyasının `htdocs/` içinde olduğundan emin olun

### "Database connection error"
- `.env` dosyasındaki veritabanı bilgilerini kontrol edin
- phpMyAdmin'de veritabanının oluşturulduğundan emin olun

### "404 Not Found"
- `index.php` dosyasının `htdocs/` içinde olduğundan emin olun
- `.htaccess` dosyasının doğru olduğundan emin olun

### Dosya yüklenmiyor
- InfinityFree'de maksimum dosya boyutu 10MB'dır
- `.htaccess` dosyasında upload limitleri ayarlanmıştır

## 📝 Önemli Notlar

- ✅ InfinityFree ücretsiz hosting'dir, bazı limitler vardır
- ✅ Günlük 50,000 hit limiti
- ✅ Maksimum dosya boyutu: 10MB
- ✅ SSH erişimi yok
- ✅ Cron job sınırlı

## 🔐 Güvenlik

Deployment sonrası:
1. Admin şifresini değiştirin
2. `.env` dosyasında `APP_DEBUG=false` olduğundan emin olun
3. Düzenli yedekleme yapın

## 📞 Destek

Sorun yaşarsanız:
1. `DEPLOYMENT.md` dosyasını okuyun
2. `SECURITY.md` dosyasını kontrol edin
3. InfinityFree forum: https://forum.infinityfree.com/

---

**Başarılar! 🚀**
