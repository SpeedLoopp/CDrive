<?php
/**
 * CDrive Test Dosyası
 * Bu dosyayı htdocs/ klasörüne yükleyin
 * Sonra https://crty.gt.tc/test.php adresine gidin
 */

echo "<h1>CDrive Test Sayfası</h1>";
echo "<hr>";

// 1. PHP Versiyonu
echo "<h2>✅ PHP Versiyonu</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Minimum gereksinim: PHP 8.1+<br>";
if (version_compare(phpversion(), '8.1.0', '>=')) {
    echo "<span style='color: green;'>✓ PHP versiyonu uygun</span><br>";
} else {
    echo "<span style='color: red;'>✗ PHP versiyonu düşük</span><br>";
}

echo "<hr>";

// 2. Dosya Yapısı
echo "<h2>📁 Dosya Yapısı</h2>";

$files = [
    'index.php' => 'Ana dosya',
    '.htaccess' => 'URL yönlendirme',
    '../vendor/autoload.php' => 'Composer autoload',
    '../bootstrap/app.php' => 'Laravel bootstrap',
    '../.env' => 'Konfigürasyon',
    '../storage' => 'Storage klasörü',
];

foreach ($files as $file => $desc) {
    $exists = file_exists(__DIR__ . '/' . $file);
    $icon = $exists ? '✓' : '✗';
    $color = $exists ? 'green' : 'red';
    echo "<span style='color: $color;'>$icon</span> $file - $desc<br>";
}

echo "<hr>";

// 3. Veritabanı Bağlantısı
echo "<h2>🗄️ Veritabanı Bağlantısı</h2>";

if (file_exists(__DIR__ . '/../.env')) {
    $env = file_get_contents(__DIR__ . '/../.env');
    
    // .env dosyasından bilgileri al
    preg_match('/DB_HOST=(.*)/', $env, $host);
    preg_match('/DB_DATABASE=(.*)/', $env, $database);
    preg_match('/DB_USERNAME=(.*)/', $env, $username);
    preg_match('/DB_PASSWORD=(.*)/', $env, $password);
    
    $db_host = trim($host[1] ?? '');
    $db_name = trim($database[1] ?? '');
    $db_user = trim($username[1] ?? '');
    $db_pass = trim($password[1] ?? '');
    
    echo "Host: $db_host<br>";
    echo "Database: $db_name<br>";
    echo "Username: $db_user<br>";
    echo "Password: " . (empty($db_pass) ? '(boş)' : '***') . "<br><br>";
    
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        echo "<span style='color: green;'>✓ Veritabanı bağlantısı başarılı!</span><br>";
        
        // Tabloları kontrol et
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "<br>Tablolar (" . count($tables) . " adet):<br>";
        foreach ($tables as $table) {
            echo "- $table<br>";
        }
    } catch (PDOException $e) {
        echo "<span style='color: red;'>✗ Veritabanı bağlantısı başarısız!</span><br>";
        echo "Hata: " . $e->getMessage() . "<br>";
    }
} else {
    echo "<span style='color: red;'>✗ .env dosyası bulunamadı!</span><br>";
}

echo "<hr>";

// 4. Klasör İzinleri
echo "<h2>🔐 Klasör İzinleri</h2>";

$folders = [
    '../storage' => 'Storage klasörü',
    '../bootstrap/cache' => 'Bootstrap cache',
];

foreach ($folders as $folder => $desc) {
    $path = __DIR__ . '/' . $folder;
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path);
        $icon = $writable ? '✓' : '✗';
        $color = $writable ? 'green' : 'red';
        echo "<span style='color: $color;'>$icon</span> $folder - İzinler: $perms - $desc<br>";
    } else {
        echo "<span style='color: red;'>✗</span> $folder - Klasör bulunamadı!<br>";
    }
}

echo "<hr>";

// 5. URL Yapısı
echo "<h2>🌐 URL Yapısı</h2>";
echo "Şu anki URL: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";

echo "<hr>";

// 6. Öneriler
echo "<h2>💡 Öneriler</h2>";
echo "<ul>";
echo "<li>Tüm dosyalar doğru yerdeyse <a href='/'>Ana Sayfaya Git</a></li>";
echo "<li>Sorun varsa <a href='SITE_SORUN_GIDERME.md'>Sorun Giderme Rehberi</a>ni okuyun</li>";
echo "<li>Test tamamlandıktan sonra bu dosyayı silin (güvenlik)</li>";
echo "</ul>";

echo "<hr>";
echo "<small>CDrive v1.0 - Test Dosyası</small>";
?>
