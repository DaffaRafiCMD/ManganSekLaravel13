@extends('layout')
@section('title',$tempat->exists ? 'Edit Menu' : 'Tambah Menu')
@section('active','kelola-menu')
@section('content')
@php
$editing=$tempat->exists;
$categories=['makanan'=>['label'=>'Makanan'],'minuman'=>['label'=>'Minuman'],'jajan'=>['label'=>'Jajanan']];
$kategori=old('kategori',$tempat->kategori ?? 'makanan');
$cfg=$categories[$kategori] ?? $categories['makanan'];
$old=[];
foreach(['nama','jenis','jarak_km','harga_min','harga_max','foto','rekomendasi'] as $field) $old[$field]=old($field,$tempat->$field ?? '');
$old['kategori']=$kategori;
$preview=$old;
if (!str_starts_with((string)$old['foto'],'https://')) $old['foto']='';
if (session()->hasOldInput()) $old['rekomendasi']=old('rekomendasi',0);
@endphp
<div class="container menu-admin-editor">
  <a class="btn btn-outline btn-sm back-btn" href="{{ route('menu.index') }}">← Kembali ke Kelola Menu</a>
  <div class="page-head">
    <div>
      <span class="admin-eyebrow">PANEL ADMIN / KELOLA MENU</span>
      <h1>{{ $editing ? 'Edit' : 'Tambah' }} {{ $cfg['label'] }}</h1>
      <p class="sub">Kelola informasi tempat, foto menu, harga, kategori, dan rekomendasi ManganSek.</p>
    </div>
  </div>
  <form class="form-card" method="post" action="{{ $editing ? route('menu.update',$tempat) : route('menu.store') }}" enctype="multipart/form-data" novalidate>
    @csrf
    @if($editing) @method('PUT') @endif
    @if ($errors->any())<div class="alert alert-error" role="alert"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="form-grid">
      <div class="field">
        <label for="kategori">Kategori</label>
        <select name="kategori" id="kategori" required>
          @foreach ($categories as $key => $item)
            <option value="{{ $key }}" {{ $kategori === $key ? 'selected' : '' }}>{{ $item['label'] }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label for="nama">Nama tempat / menu</label>
        <input id="nama" name="nama" type="text" maxlength="100" value="{{ $old['nama'] }}" placeholder="Contoh: Warung Bu Sari" required>
      </div>
      <div class="field">
        <label for="jenis">Jenis</label>
        <input id="jenis" name="jenis" type="text" maxlength="30" value="{{ $old['jenis'] }}" placeholder="Contoh: Warung, Teh, Gorengan" required>
      </div>
      <div class="field">
        <label for="jarak_km">Jarak dari kampus (km)</label>
        <input id="jarak_km" name="jarak_km" type="text" inputmode="decimal" value="{{ $old['jarak_km'] }}" placeholder="Contoh: 0.6" required>
      </div>
      <div class="field">
        <label for="harga_min">Harga termurah (Rp)</label>
        <input id="harga_min" name="harga_min" type="text" inputmode="numeric" value="{{ $old['harga_min'] }}" placeholder="8000" required>
      </div>
      <div class="field">
        <label for="harga_max">Harga termahal (Rp)</label>
        <input id="harga_max" name="harga_max" type="text" inputmode="numeric" value="{{ $old['harga_max'] }}" placeholder="15000" required>
      </div>
    </div>

    <div class="menu-photo-editor">
      <div class="field">
        <label for="foto">URL foto menu (opsional)</label>
        <input id="foto" name="foto" type="text" inputmode="url" placeholder="https://images.unsplash.com/..." value="{{ $old['foto'] ?? '' }}" maxlength="1900">
        <small class="field-hint">Gunakan tautan langsung ke foto dari sumber berlisensi, misalnya Unsplash. Jika dikosongkan, dipakai foto ilustrasi kategori.</small>
        <label for="foto-upload" class="menu-photo-upload-label">Atau unggah foto dari perangkat (JPG, PNG, WebP; maksimal 4 MB)</label>
        <input id="foto-upload" type="file" name="foto_upload" accept="image/jpeg,image/png,image/webp">
        <small class="field-hint">Jika mengisi URL dan mengunggah file, foto yang diunggah akan dipakai.</small>
      </div>
      <div class="menu-photo-preview" aria-label="Pratinjau foto menu">
        <img id="foto-preview" alt="Pratinjau foto menu" src="{{ \App\Support\ManganSekView::menu_photo_url($preview) }}" loading="lazy">
        <span class="photo-placeholder">{!! \App\Support\ManganSekView::ui_icon('image') !!} Pratinjau foto</span>
      </div>
    </div>
    <div class="field menu-checkbox">
      <label><input type="checkbox" name="rekomendasi" value="1" {{ !empty($old['rekomendasi']) ? 'checked' : '' }}> Tampilkan di rekomendasi Home</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">{{ $editing ? 'Simpan Perubahan' : 'Tambah Menu' }}</button>
      <a href="{{ route('menu.index') }}" class="btn btn-outline">Batal</a>
    </div>
  </form>
</div>
@endsection
