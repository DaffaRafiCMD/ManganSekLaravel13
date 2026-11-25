@extends('layout')
@section('title','Home')
@section('active','home')
@section('content')
<div class="container">
  <section class="hero">
    <div class="hero-text">
      <h1>Cari tempat makan hemat di sekitarmu!</h1>
      <p>ManganSek membantu kamu menemukan tempat makan terbaik dengan harga terjangkau, cocok untuk mahasiswa.</p>
      <form class="hero-search" action="{{ route('home') }}" method="get" role="search">
        <label class="sr-only" for="q">Cari nama tempat makan</label>
        <div class="search-field">
          <span aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon('search') !!}</span>
          <input type="search" id="q" name="q" value="{{ $q }}" placeholder="Cari nama tempat makan..." maxlength="100">
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </div>
    <div class="hero-art" aria-hidden="true">
      <div class="hero-circle"><img src="{{ \App\Support\ManganSekView::menu_photo_url(['nama' => 'Mie Ayam Pak Slamet']) }}" alt="" referrerpolicy="no-referrer"></div>
      <p>Makan enak harga pas!</p>
    </div>
  </section>

  <div class="section-head">
    <h2>
      @if ($q !== '')Hasil untuk “{{ $q }}”@else Rekomendasi untuk Kamu@endif
      @if (!auth()->check() && $q === '')<span class="badge badge-green">CRUD: Read</span>@endif
    </h2>
    @if ($q !== '')
      <a class="link-muted" href="{{ route('home') }}">Hapus pencarian</a>
    @else
      <a class="link-muted" href="{{ route('kategori','makanan') }}">Lihat Semua →</a>
    @endif
  </div>

  @if ($daftar->isNotEmpty())
    <div class="grid grid-4">
      @foreach($daftar as $t) @include('menu.card',['t'=>$t,'showReview'=>true]) @endforeach
    </div>
  @else
    <p class="empty">Belum ada tempat yang cocok dengan “{{ $q }}”. Coba kata kunci lain.</p>
  @endif
</div>
@endsection
