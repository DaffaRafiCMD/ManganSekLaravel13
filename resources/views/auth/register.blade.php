@extends('layout')
@section('title','Buat Akun')
@section('active','')
@section('body-class','auth')
@section('content')
<div class="auth-card">
  <h1>Buat Akun</h1>
  <p class="sub">Gabung dan temukan makan hemat</p>

  @if ($errors->any())
    <div class="alert alert-error" role="alert">
      <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="post" action="{{ route('register.submit') }}">
    @csrf
    <div class="field">
      <label for="nama">Nama lengkap</label>
      <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama kamu" autocomplete="name" required>
    </div>
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" required>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" minlength="8" autocomplete="new-password" required>
    </div>
    <div class="field">
      <label for="konfirmasi">Konfirmasi password</label>
      <input type="password" id="konfirmasi" name="password_confirmation" placeholder="Ulangi password" autocomplete="new-password" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
  </form>

  <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
</div>
@endsection
