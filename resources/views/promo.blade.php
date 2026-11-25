@extends('layout')
@section('title','Info Promo')
@section('active','promo')
@section('content')
@php $chips=[''=>'Semua','makanan'=>'Makanan','minuman'=>'Minuman','jajan'=>'Jajan']; @endphp
<div class="container">
  <div class="page-head">
    <div>
      <h1>Info Promo @if (!auth()->check())<span class="badge badge-green">CRUD: Read</span>@endif</h1>
      <p class="sub">Diskon &amp; promo terbaru buat mahasiswa</p>
    </div>
  </div>

  <nav class="chips" aria-label="Filter kategori promo">
    @foreach ($chips as $val => $label)
      <a class="chip{{ $filter === $val ? ' active' : '' }}"
         href="{{ route('promo.index',$val !== '' ? ['kategori'=>$val] : []) }}"
         {!! $filter === $val ? 'aria-current="true"' : '' !!}>{{ $label }}</a>
    @endforeach
  </nav>

  @if ($promos->isNotEmpty())
    <div class="grid grid-3">
      @foreach ($promos as $p)
        <article class="promo-card">
          <div class="promo-head promo-{{ $p['warna'] }}"><h2>{{ $p['judul'] }}</h2></div>
          <div class="promo-body">
            <h3>{{ $p['nama_tempat'] }}</h3>
            <p>{{ $p['deskripsi'] }}</p>
            <p class="promo-date">{!! \App\Support\ManganSekView::ui_icon('calendar') !!} s/d {{ \App\Support\ManganSekView::tanggal_id($p['berlaku_sampai']) }}</p>
            <button type="button" class="btn btn-outline btn-sm" data-open-dialog="promo-{{ (int) $p['id'] }}">Lihat Detail</button>
          </div>

          <dialog id="promo-{{ (int) $p['id'] }}" aria-labelledby="promo-judul-{{ (int) $p['id'] }}">
            <div class="dialog-head promo-{{ $p['warna'] }}">
              <h2 id="promo-judul-{{ (int) $p['id'] }}">{{ $p['judul'] }}</h2>
            </div>
            <div class="dialog-body">
              <h3>{{ $p['nama_tempat'] }}</h3>
              <p>{{ $p['deskripsi'] }}</p>
              @if (!empty($p['syarat']))<p class="muted">{{ $p['syarat'] }}</p>@endif
              <p class="promo-date">{!! \App\Support\ManganSekView::ui_icon('calendar') !!} Berlaku sampai {{ \App\Support\ManganSekView::tanggal_id($p['berlaku_sampai']) }}</p>
              <button type="button" class="btn btn-primary btn-sm" data-close-dialog>Tutup</button>
            </div>
          </dialog>
        </article>
      @endforeach
    </div>
  @else
    <p class="empty">Belum ada promo di kategori ini.</p>
  @endif
</div>
@endsection
