# CDrive - Bulut Depolama Sistemi

Modern, güvenli ve kullanıcı dostu bulut depolama çözümü.

## Özellikler

- 📁 Dosya yükleme, indirme ve yönetimi
- 🔗 Özel link oluşturma
- 👥 Kullanıcı yönetimi
- 🎨 Modern siyah-mavi gradyan tema
- 📊 Admin paneli ve istatistikler
- 💰 Reklam yönetimi
- 🔒 Güvenli dosya depolama

## Kurulum

1. Composer bağımlılıklarını yükleyin:
```bash
composer install
```

2. .env dosyasını oluşturun:
```bash
copy .env.example .env
```

3. Uygulama anahtarı oluşturun:
```bash
php artisan key:generate
```

4. Veritabanını oluşturun ve migration'ları çalıştırın:
```bash
php artisan migrate
```

5. Storage linkini oluşturun:
```bash
php artisan storage:link
```

6. Geliştirme sunucusunu başlatın:
```bash
php artisan serve
```

## Gereksinimler

- PHP 8.1+
- MySQL 5.7+ veya MariaDB 10.3+
- Composer
- Laravel 10.x

## Lisans

MIT License
