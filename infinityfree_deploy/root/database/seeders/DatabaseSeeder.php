<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin kullanıcı oluştur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@cdrive.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Test kullanıcı oluştur
        User::create([
            'name' => 'Test User',
            'email' => 'user@cdrive.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        // Test reklamları oluştur
        \App\Models\Ad::create([
            'type' => 'header',
            'title' => 'Üst Banner Reklam',
            'content' => '<div style="padding: 20px; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;">
                <h3 style="margin: 0 0 10px 0;">🎉 Hoş Geldiniz!</h3>
                <p style="margin: 0;">CDrive ile dosyalarınızı güvenle saklayın ve paylaşın</p>
            </div>',
            'active' => true,
            'display_order' => 1,
        ]);

        \App\Models\Ad::create([
            'type' => 'footer',
            'title' => 'Alt Banner Reklam',
            'content' => '<div style="padding: 15px; text-align: center; background: rgba(79, 172, 254, 0.1); border-radius: 8px;">
                <p style="margin: 0; font-size: 14px;">💡 Premium üyelik ile sınırsız depolama alanı kazanın!</p>
            </div>',
            'active' => true,
            'display_order' => 1,
        ]);

        \App\Models\Ad::create([
            'type' => 'popup',
            'title' => 'Popup Reklam',
            'content' => '<div style="text-align: center;">
                <h2 style="color: #4facfe; margin-bottom: 15px;">🎁 Özel Teklif!</h2>
                <p style="font-size: 16px; margin-bottom: 20px;">İlk 100 kullanıcıya özel %50 indirim!</p>
                <a href="#" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 5px;">Hemen Başla</a>
            </div>',
            'active' => true,
            'display_order' => 1,
        ]);
    }
}
