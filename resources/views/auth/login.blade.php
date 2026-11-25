@extends('layout')
@php $role=old('role',$role)==='admin'?'admin':'user'; @endphp
@section('title',$role === 'admin' ? 'Login Admin' : 'Login Pengguna')
@section('active','')
@section('body-class','auth auth-login')
@section('content')
<div class="auth-layout auth-layout--{{ $role }}">
  <aside class="auth-story" aria-label="Tentang ManganSek">
    <div class="auth-story-top">
      <span class="auth-story-tag">TEMAN MAKAN HEMATMU</span>
      <h1>Cari makan enak, <span>dompet tetap aman.</span></h1>
      <p>Rekomendasi warung, jajanan, dan minuman favorit mahasiswa. Hematnya dapet, enaknya juga!</p>
    </div>
    <div class="food-stage" aria-hidden="true">
      <div class="food-photo food-photo--main"><img src="{{ \App\Support\ManganSekView::menu_photo_url(['nama' => 'Warung Bu Sari']) }}" alt="" referrerpolicy="no-referrer"></div>
      <div class="food-photo food-photo--side"><img src="{{ \App\Support\ManganSekView::menu_photo_url(['nama' => 'Kopi Kenangan (Cab. Kampus)']) }}" alt="" referrerpolicy="no-referrer"></div>
      <div class="food-photo food-photo--snack"><img src="{{ \App\Support\ManganSekView::menu_photo_url(['nama' => 'Mie Ayam Pak Slamet']) }}" alt="" referrerpolicy="no-referrer"></div>
      <div class="food-float"><span>Rating 4.8 / 5</span><strong>Enak dan ramah kantong</strong></div>
    </div>
    <div class="auth-story-footer">
      <span>Harga bersahabat</span><span>Review mahasiswa</span><span>Banyak pilihan</span>
    </div>
  </aside>

  <section class="auth-panel" aria-labelledby="login-title">
    <div class="auth-panel-inner">
      <div class="auth-icon" aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon($role === 'admin' ? 'shield' : 'user') !!}</div>
      <p class="auth-kicker">{{ $role === 'admin' ? 'AKSES PENGELOLA' : 'SELAMAT DATANG KEMBALI' }}</p>
      <h2 id="login-title">{{ $role === 'admin' ? 'Masuk sebagai Admin' : 'Senang kamu balik lagi!' }}</h2>
      <p class="auth-description">{{ $role === 'admin' ? 'Masuk untuk melihat dan mengelola aktivitas ManganSek.' : 'Masuk dulu, yuk! Petualangan makan hematmu menunggu.' }}</p>

      <div class="auth-roles" aria-label="Pilih jenis akun">
        <a href="{{ route('login',['role'=>'user']) }}" class="auth-role {{ $role === 'user' ? 'is-active' : '' }}" {!! $role === 'user' ? 'aria-current="page"' : '' !!}>{!! \App\Support\ManganSekView::ui_icon('user') !!} Pengguna</a>
        <a href="{{ route('login',['role'=>'admin']) }}" class="auth-role {{ $role === 'admin' ? 'is-active' : '' }}" {!! $role === 'admin' ? 'aria-current="page"' : '' !!}>{!! \App\Support\ManganSekView::ui_icon('shield') !!} Admin</a>
      </div>

      @if ($errors->any())<div class="alert alert-error" role="alert">{{ $errors->first() }}</div>@endif
      <form method="post" action="{{ route('login.submit') }}" class="auth-form">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">
        <div class="field">
          <label for="email">Alamat email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ $role === 'admin' ? 'admin@mangansek.test' : 'nama@email.com' }}" autocomplete="email" maxlength="150" required autofocus>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <div class="password-wrap">
            <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
            <button type="button" class="password-toggle" data-toggle-password="password" aria-label="Tampilkan password">Lihat</button>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block auth-submit">Masuk sebagai {{ $role === 'admin' ? 'Admin' : 'Pengguna' }} <span aria-hidden="true">→</span></button>
      </form>
      @if ($role === 'user')
        <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar gratis sekarang</a></p>
      @else
        <p class="auth-info">Hanya akun yang diberi peran admin yang dapat mengakses panel pengelola.</p>
      @endif
    </div>
  </section>
</div>
@endsection
