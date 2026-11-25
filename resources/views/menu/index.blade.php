@extends('layout')
@section('title',$kategori === 'jajan' ? 'Jajan' : $judul)
@section('active',$kategori)
@section('content')
@php
[$subjudul,$labelCari,$labelInput,$placeholder,$labelTambah] = match($kategori) {
'makanan'=>['Tempat makan hemat favorit mahasiswa','Cari tempat makan','Nama tempat makan','Contoh: Warung Bu Sari','Makanan'],
'minuman'=>['Segerin hari tanpa bikin kantong kering','Cari minuman','Nama minuman','Contoh: Es Teh Poci','Minuman'],
'jajan'=>['Camilan receh yang bikin happy','Cari jajanan','Nama jajanan','Contoh: Cilok Pak Eko','Jajanan']};
@endphp
<div class="container">
  <div class="page-head">
    <div>
      <h1>{{ $judul }}</h1>
      <p class="sub">{{ $subjudul }}</p>
    </div>
    @if (auth()->user()?->isAdmin())
      <a class="btn btn-primary" href="{{ route('menu.create',['kategori'=>$kategori]) }}">+ Tambah {{ $labelTambah }}</a>
    @endif
  </div>

  @if (auth()->check())
    <section class="panel" aria-labelledby="judul-cari">
      <h2 id="judul-cari">{{ $labelCari }}</h2>
      <form class="search-row" method="get" action="{{ route('kategori',$kategori) }}">
        <div class="field">
          <label for="q">{{ $labelInput }}</label>
          <input type="text" id="q" name="q" value="{{ $q }}" placeholder="{{ $placeholder }}" maxlength="100">
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </section>
  @else
    
  @endif

  @if ($daftar->isNotEmpty())
    <div class="grid grid-4">
      @foreach($daftar as $t) @include('menu.card',['t'=>$t,'showReview'=>true]) @endforeach
    </div>
  @else
    <p class="empty">
      {{ $q !== '' ? 'Tidak ada hasil untuk “' . $q . '”. Coba kata kunci lain.' : 'Belum ada data.' }}
    </p>
  @endif
</div>
@endsection
