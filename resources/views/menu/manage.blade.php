@extends('layout')
@section('title','Kelola Menu')
@section('active','kelola-menu')
@section('content')
<div class="container admin-area">
  <div class="admin-welcome admin-menu-welcome">
    <div><span class="admin-eyebrow">AKSES KHUSUS ADMIN</span><h1>Kelola Menu ManganSek</h1><p>Tambah, perbarui, dan hapus makanan, minuman, maupun jajanan yang tampil di website.</p></div>
    <a href="{{ route('menu.create') }}" class="btn btn-primary">+ Tambah Menu</a>
  </div>
  <div class="admin-menu-stats">
    <div><strong>{{ $total }}</strong><span>Semua Menu</span></div>
    @foreach ($categories as $key => $cfg)<div><strong>{{ $counts[$key] }}</strong><span>{{ $cfg['label'] }}</span></div>@endforeach
  </div>
  <section class="admin-box admin-menu-box">
    <div class="admin-box-head"><div><h2>Daftar menu</h2><p>Hanya administrator dapat mengelola menu. Pengguna biasa hanya bisa melihat dan memberi review.</p></div></div>
    <form class="admin-menu-filter" method="get" action="{{ route('menu.index') }}">
      <div class="field"><label for="kategori">Kategori</label><select id="kategori" name="kategori"><option value="">Semua kategori</option>@foreach ($categories as $key => $cfg)<option value="{{ $key }}" {{ $filter === $key ? 'selected' : '' }}>{{ $cfg['label'] }}</option>@endforeach</select></div>
      <div class="field"><label for="q">Cari nama</label><input id="q" name="q" type="search" placeholder="Cari nama tempat..." value="{{ $q }}"></div>
      <button class="btn btn-primary" type="submit">Terapkan</button>
      <a href="{{ route('menu.index') }}" class="btn btn-outline">Reset</a>
    </form>
    <div class="table-wrap admin-table">
      <table><thead><tr><th>Foto / Tempat</th><th>Kategori</th><th>Jarak</th><th>Harga</th><th>Rating</th><th>Aksi Admin</th></tr></thead><tbody>
      @foreach ($items as $item)
        <tr>
          <td><div class="menu-admin-item"><img src="{{ \App\Support\ManganSekView::menu_photo_url($item) }}" alt="" loading="lazy" referrerpolicy="no-referrer"><div><strong>{{ $item['nama'] }}</strong><small class="menu-item-kind">{{ $item['jenis'] }}{{ $item['rekomendasi'] ? ' · Rekomendasi Home' : '' }}</small></div></div></td>
          <td>{{ $categories[$item['kategori']]['label'] }}</td>
          <td>{{ number_format((float)$item['jarak_km'], 1) }} km</td>
          <td>{{ \App\Support\ManganSekView::harga_range($item) }}</td>
          <td>{!! \App\Support\ManganSekView::ui_icon('star') !!} {{ number_format((float) $item['rating'], 1) }}</td>
          <td><div class="menu-actions">
            <a class="btn btn-outline btn-sm" href="{{ route('menu.edit',$item) }}">Edit</a>
            <form method="post" action="{{ route('menu.destroy',$item) }}" data-confirm="Hapus {{ $item['nama'] }} beserta semua review dan favoritnya?">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
            </form>
          </div></td>
        </tr>
      @endforeach
      @if ($items->isEmpty())<tr><td colspan="6" class="table-empty">Tidak ada menu yang cocok dengan filter.</td></tr>@endif
      </tbody></table>
    </div>
  </section>
</div>
@endsection
