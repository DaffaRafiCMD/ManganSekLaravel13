@extends('layout')
@section('title','Dashboard')
@section('active','dashboard')
@section('content')
<div class="container">
  <div class="page-head">
    <div>
      <h1>Halo, {{ explode(' ', $user->nama)[0] }}!</h1>
      <p class="sub">Ringkasan aktivitasmu di ManganSek</p>
    </div>
  </div>

  <div class="grid grid-3 stats">
    <div class="stat"><span class="stat-label">Tempat Favorit</span><strong>{{ $counts['Favorit'] }}</strong></div>
    <div class="stat"><span class="stat-label">Ulasan Ditulis</span><strong>{{ $counts['Review'] }}</strong></div>
    <div class="stat"><span class="stat-label">Meal Hack Dibagikan</span><strong>{{ $counts['Meal Hack'] }}</strong></div>
  </div>

  <h2 class="block-title">Favorit Terbaru</h2>

  <div class="table-wrap">
    <table>
      <thead>
        <tr><th scope="col">Nama tempat</th><th scope="col">Kategori</th><th scope="col">Kisaran harga</th><th scope="col">Rating</th></tr>
      </thead>
      <tbody>
        @if ($favorit->isNotEmpty())
        @foreach ($favorit as $f)
        @php $t=$f->tempat; @endphp
          <tr>
            <td><a href="{{ route('review.index',$t) }}">{{ $t['nama'] }}</a></td>
            <td>{{ $t['jenis'] }}</td>
            <td>{{ \App\Support\ManganSekView::harga_range($t) }}</td>
            <td>{!! \App\Support\ManganSekView::ui_icon('star') !!} {{ number_format((float) $t['rating'], 1) }}</td>
          </tr>
        @endforeach @else
          <tr><td colspan="4" class="table-empty">Belum ada favorit. Gunakan tombol favorit di kartu menu untuk menyimpannya di sini.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endsection
