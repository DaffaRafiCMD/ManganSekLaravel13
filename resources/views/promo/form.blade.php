@extends('layout')
@section('title',$promo->exists ? 'Edit Promo' : 'Tambah Promo')
@section('active','promo')
@section('content')
<div class="container">
  <div class="page-head"><div><h1>{{ $promo->exists ? 'Edit Promo' : 'Tambah Promo' }}</h1><p class="sub">Kelola informasi promo yang tampil untuk semua pengunjung.</p></div></div>
  @if ($errors->any())<div class="alert alert-error" role="alert"><ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>@endif
  <section class="panel promo-form-panel"><form class="promo-form" method="post" action="{{ $promo->exists ? route('promo.update',$promo) : route('promo.store') }}">
    @csrf @if($promo->exists) @method('PUT') @endif
    <div class="field"><label for="judul">Judul</label><input id="judul" name="judul" value="{{ old('judul',$promo->judul) }}" maxlength="100" required></div>
    <div class="field"><label for="nama_tempat">Nama tempat</label><input id="nama_tempat" name="nama_tempat" value="{{ old('nama_tempat',$promo->nama_tempat) }}" maxlength="120" required></div>
    <div class="field"><label for="kategori">Kategori</label><select id="kategori" name="kategori" required>@foreach(['makanan'=>'Makanan','minuman'=>'Minuman','jajan'=>'Jajan'] as $key=>$label)<option value="{{ $key }}" @selected(old('kategori',$promo->kategori)===$key)>{{ $label }}</option>@endforeach</select></div>
    <div class="field"><label for="warna">Warna kartu</label><select id="warna" name="warna" required>@foreach(['yellow','pink','green','blue','purple','peach'] as $warna)<option value="{{ $warna }}" @selected(old('warna',$promo->warna)===$warna)>{{ ucfirst($warna) }}</option>@endforeach</select></div>
    <div class="field"><label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi" maxlength="255" required>{{ old('deskripsi',$promo->deskripsi) }}</textarea></div>
    <div class="field"><label for="syarat">Syarat dan ketentuan</label><textarea id="syarat" name="syarat" maxlength="255">{{ old('syarat',$promo->syarat) }}</textarea></div>
    <div class="field"><label for="berlaku_sampai">Berlaku sampai</label><input id="berlaku_sampai" name="berlaku_sampai" type="date" value="{{ old('berlaku_sampai',$promo->berlaku_sampai) }}" required></div>
    <div class="promo-form-actions"><button class="btn btn-primary" type="submit">{{ $promo->exists ? 'Simpan perubahan' : 'Tambah promo' }}</button> <a class="btn btn-outline" href="{{ route('promo.index') }}">Batal</a></div>
  </form></section>
</div>
@endsection
