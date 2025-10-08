<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CDrive - Bulut Depolama')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            color: #fff;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .navbar {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: bold; color: #4facfe; text-decoration: none; }
        .nav-links { display: flex; gap: 20px; list-style: none; }
        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .nav-links a:hover { background: rgba(79, 172, 254, 0.2); }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-size: 14px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-danger { background: #e74c3c; color: #fff; }
        .btn-success { background: #27ae60; color: #fff; }
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert-success { background: rgba(39, 174, 96, 0.2); border: 1px solid #27ae60; }
        .alert-error { background: rgba(231, 76, 60, 0.2); border: 1px solid #e74c3c; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        table th { background: rgba(0, 0, 0, 0.3); }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }
        label { display: block; margin: 10px 0 5px; }
        .ad-container {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(79, 172, 254, 0.3);
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .ad-header {
            background: rgba(79, 172, 254, 0.1);
            padding: 10px;
            margin: -15px -15px 15px -15px;
            border-radius: 8px 8px 0 0;
            font-size: 12px;
            opacity: 0.7;
        }
        .ad-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(15, 12, 41, 0.98);
            border: 2px solid #4facfe;
            border-radius: 15px;
            padding: 30px;
            max-width: 500px;
            z-index: 9999;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }
        .ad-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9998;
        }
        .ad-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
        }
    </style>
</head>
<body>
    @php
        $headerAds = \App\Models\Ad::active()->byType('header')->orderBy('display_order')->get();
        $footerAds = \App\Models\Ad::active()->byType('footer')->orderBy('display_order')->get();
        $popupAds = \App\Models\Ad::active()->byType('popup')->orderBy('display_order')->first();
    @endphp

    <!-- Header Ads -->
    @foreach($headerAds as $ad)
        <div class="ad-container">
            <div class="ad-header">Reklam</div>
            {!! $ad->content !!}
        </div>
    @endforeach
    <nav class="navbar">
        <div class="container">
            <a href="/" class="logo">CDrive</a>
            <ul class="nav-links">
                @auth
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('files.index') }}">Dosyalarım</a></li>
                    <li><a href="{{ route('links.index') }}">Linklerim</a></li>
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Çıkış</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Giriş</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-primary">Kayıt Ol</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <!-- Footer Ads -->
    @foreach($footerAds as $ad)
        <div class="container">
            <div class="ad-container">
                <div class="ad-header">Reklam</div>
                {!! $ad->content !!}
            </div>
        </div>
    @endforeach

    <!-- Popup Ads -->
    @if($popupAds && !session('popup_shown_' . $popupAds->id))
        <div class="ad-popup-overlay" id="adOverlay" onclick="closePopup()"></div>
        <div class="ad-popup" id="adPopup">
            <button class="ad-close" onclick="closePopup()">×</button>
            <div style="margin-top: 20px;">
                {!! $popupAds->content !!}
            </div>
        </div>
        <script>
            function closePopup() {
                document.getElementById('adPopup').style.display = 'none';
                document.getElementById('adOverlay').style.display = 'none';
                fetch('/mark-popup-shown/{{ $popupAds->id }}');
            }
            setTimeout(function() {
                document.getElementById('adPopup').style.display = 'block';
                document.getElementById('adOverlay').style.display = 'block';
            }, 2000);
        </script>
    @endif
</body>
</html>
