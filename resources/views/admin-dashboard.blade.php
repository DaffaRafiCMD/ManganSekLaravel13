@extends('layout')
@section('title','Dashboard Admin')
@section('active','dashboard')
@section('content')
<div class="container admin-area">
  <div class="admin-welcome">
    <div>
      <span class="admin-eyebrow">ADMIN AREA</span>
      <h1>Halo, Admin!</h1>
      <p>Pantau aktivitas dan konten ManganSek dari satu tempat. Admin dapat mengelola seluruh menu, sedangkan review hanya dapat ditulis oleh pengguna.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('menu.index') }}">Kelola Menu</a>
  </div>

  <div class="admin-stats" aria-label="Statistik aplikasi">
    <div class="admin-stat"><span class="admin-stat-icon">{!! \App\Support\ManganSekView::ui_icon('users') !!}</span><span>Pengguna Terdaftar</span><strong>{{ $counts['Pengguna'] }}</strong></div>
    <div class="admin-stat"><span class="admin-stat-icon">{!! \App\Support\ManganSekView::ui_icon('utensils') !!}</span><span>Tempat Makan</span><strong>{{ $counts['Tempat'] }}</strong></div>
    <div class="admin-stat"><span class="admin-stat-icon">{!! \App\Support\ManganSekView::ui_icon('star') !!}</span><span>Total Ulasan</span><strong>{{ $counts['Review'] }}</strong></div>
    <div class="admin-stat"><span class="admin-stat-icon">{!! \App\Support\ManganSekView::ui_icon('lightbulb') !!}</span><span>Meal Hack</span><strong>{{ $counts['Meal Hack'] }}</strong></div>
  </div>

  <div class="admin-split">
    <section class="admin-box">
      <div class="admin-box-head"><div><h2>Menu terbaru</h2><p>Data menu tersimpan dan bisa dilihat oleh seluruh pengguna.</p></div><a href="{{ route('menu.index') }}">Kelola Semua</a></div>
      <div class="table-wrap admin-table">
        <table><thead><tr><th>Tempat</th><th>Kategori</th><th>Kisaran harga</th><th>Kelola</th></tr></thead><tbody>
        @foreach ($terbaru as $t)
          <tr><td><strong>{{ $t['nama'] }}</strong></td><td>{{ ucfirst($t['kategori']) }}</td><td>{{ 'Rp ' . \App\Support\ManganSekView::rupiah($t['harga_min']) . ' – ' . \App\Support\ManganSekView::rupiah($t['harga_max']) }}</td><td><a href="{{ route('menu.edit',$t) }}">Edit</a></td></tr>
        @endforeach
        </tbody></table>
      </div>
    </section>
    <aside class="admin-box admin-tools">
      <h2>Akses cepat</h2><p>Kelola dan tinjau konten ManganSek.</p>
      <a href="{{ route('menu.index') }}"><span>{!! \App\Support\ManganSekView::ui_icon('grid') !!}</span><span><strong>Kelola Menu</strong><small>Tambah, edit, dan hapus makanan, minuman, jajanan</small></span><span aria-hidden="true">→</span></a>
      <a href="{{ route('menu.create') }}"><span>{!! \App\Support\ManganSekView::ui_icon('plus') !!}</span><span><strong>Tambah menu baru</strong><small>Masukkan rekomendasi baru</small></span><span aria-hidden="true">→</span></a>
      <a href="{{ route('promo.index') }}"><span>{!! \App\Support\ManganSekView::ui_icon('tag') !!}</span><span><strong>Lihat promo</strong><small>{{ $promoCount }} promo tersedia</small></span><span aria-hidden="true">→</span></a>
      <a href="{{ route('meal.index') }}"><span>{!! \App\Support\ManganSekView::ui_icon('lightbulb') !!}</span><span><strong>Meal Hack</strong><small>Lihat tips makan hemat</small></span><span aria-hidden="true">→</span></a>
      <div class="admin-notice">Data ManganSek tersimpan di database MySQL dan dikelola melalui Laravel.</div>
    </aside>
  </div>

  <section class="admin-box" style="margin-top:24px" aria-labelledby="ulasan-admin-title">
    <div class="admin-box-head"><div><h2 id="ulasan-admin-title">Ulasan pengguna terbaru</h2><p>Admin hanya dapat membaca. Penulisan dan pengubahan ulasan khusus user.</p></div></div>
    <div class="table-wrap admin-table">
      <table>
        <thead><tr><th>Pengguna</th><th>Tempat</th><th>Rating</th><th>Ulasan</th><th>Lihat</th></tr></thead>
        <tbody>
        @foreach($reviews as $r) @php $pengulas=$r->user; $lokasi=$r->tempat; @endphp
          <tr>
            <td>{{ $pengulas['nama'] ?? 'Pengguna' }}</td>
            <td>{{ $lokasi['nama'] ?? 'Tidak tersedia' }}</td>
            <td>{!! \App\Support\ManganSekView::stars_html((int) $r['rating']) !!}</td>
            <td>{{ $r['komentar'] }}</td>
            <td><a href="{{ route('review.index',$r->tempat_id) }}">Lihat ulasan</a></td>
          </tr>
        @endforeach
        @if ($reviews->isEmpty())<tr><td colspan="5">Belum ada ulasan pengguna.</td></tr>@endif
        </tbody>
      </table>
    </div>
  </section>
</div>
@endsection
