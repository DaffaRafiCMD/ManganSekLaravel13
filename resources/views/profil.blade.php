@extends('layout')
@section('title','Profil Saya')
@section('active','profil')
@section('content')
<div class="container">
  <div class="page-head">
    <div>
      <h1>Profil Saya</h1>
      <p class="sub">Kelola informasi akunmu</p>
    </div>
  </div>

  <div class="profile-layout">
    <aside class="profile-card">
      <div class="profile-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user['nama'], 0, 1)) }}</div>
      <h2>{{ $user['nama'] }}</h2>
      <p>{{ $user['email'] }}</p>
      <span class="pill">{{ $user->role === 'admin' ? 'Administrator' : 'Mahasiswa' }}</span>
    </aside>

    <section class="form-card" aria-labelledby="judul-edit">
      <h2 id="judul-edit">Edit profil</h2>

      @if ($errors->any())
        <div class="alert alert-error" role="alert">
          <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
      @endif

      <form method="post" action="{{ route('profil.update') }}" novalidate>
        @csrf @method('PATCH')
        <div class="form-grid">
          <div class="field">
            <label for="nama">Nama lengkap</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama',$user->nama) }}" autocomplete="name" required>
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email',$user->email) }}" autocomplete="email" required>
          </div>
          <div class="field">
            <label for="telepon">Nomor telepon</label>
            <input type="tel" id="telepon" name="telepon" value="{{ old('telepon',$user->telepon) }}" placeholder="08123456789" autocomplete="tel">
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <a class="btn btn-outline" href="{{ route('profil.edit') }}">Batal</a>
        </div>
      </form>
    </section>
  </div>
</div>
@endsection
