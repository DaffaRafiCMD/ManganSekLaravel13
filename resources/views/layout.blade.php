@php
$navUser = auth()->user();
$aktif = trim($__env->yieldContent('active'));
$menu = ['home'=>['Home',route('home')], 'makanan'=>['Makanan',route('kategori','makanan')], 'minuman'=>['Minuman',route('kategori','minuman')], 'jajan'=>['Jajan',route('kategori','jajan')], 'meal'=>['Meal Hack',route('meal.index')], 'promo'=>['Promo',route('promo.index')]];
if ($navUser?->isAdmin()) { unset($menu['home']); $menu['kelola-menu']=['Kelola Menu',route('menu.index')]; }
if ($navUser) $menu['dashboard']=[$navUser->isAdmin()?'Dashboard Admin':'Dashboard',route('dashboard')];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','ManganSek') – ManganSek</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/laravel-compat.css') }}">
</head>
<body class="@yield('body-class')">
<header class="nav">
  <div class="container nav-inner">
    <a class="brand" href="{{ route($navUser ? 'dashboard' : 'login') }}" aria-label="ManganSek"><span class="brand-icon" aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon('utensils') !!}</span>Mangan<span>Sek</span></a>

    @if ($navUser)
    <nav class="nav-links" aria-label="Menu utama">
      @foreach ($menu as $key => $item)
        <a href="{{ $item[1] }}"{!! $aktif === $key ? ' class="active" aria-current="page"' : '' !!}>{{ $item[0] }}</a>
      @endforeach
    </nav>
    @endif

    <div class="nav-actions">
      @if ($navUser)
        <details class="user-menu">
          <summary class="user-chip{{ $aktif === 'profil' ? ' active' : '' }}">
            <span class="avatar" aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon('user') !!}</span>
            <span class="user-name">{{ $navUser['nama'] }}</span>
          </summary>
          <div class="menu">
            @if (auth()->user()?->isAdmin())<a href="{{ route('dashboard') }}">Panel Admin</a><a href="{{ route('menu.index') }}">Kelola Menu</a>@endif
            <a href="{{ route('profil.edit') }}">Profil saya</a>
            <form method="post" action="{{ route('logout') }}">@csrf<button class="logout-link" type="submit">Keluar</button></form>
          </div>
        </details>
      @else
        @if (!request()->routeIs('login'))<a class="btn btn-outline btn-sm" href="{{ route('login') }}">Login</a>@endif
        @if (!request()->routeIs('register'))<a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>@endif
      @endif
    </div>
  </div>
</header>

<main>
@if(session('success'))<div class="container"><div class="flash flash-success" role="status">{{ session('success') }}</div></div>@endif
@if(session('error'))<div class="container"><div class="flash flash-error" role="status">{{ session('error') }}</div></div>@endif
@yield('content')
</main>
<footer class="site-footer"><div class="container"><span>ManganSek &middot; Website rekomendasi makan hemat</span><a href="{{ route('credits') }}">Sumber dan kredit foto</a></div></footer>
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
