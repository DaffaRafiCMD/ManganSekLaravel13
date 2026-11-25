@extends('layout')
@section('title','Review '.$tempat->nama)
@section('active',$tempat->kategori)
@section('content')
@php
$bolehReview=!auth()->user()->isAdmin();
$form=['komentar'=>old('komentar',$editing?->komentar ?? ''),'rating'=>old('rating',$editing?->rating ?? 5)];
@endphp
<div class="container">
  <a class="btn btn-outline btn-sm back-btn" href="{{ route('kategori',$tempat->kategori) }}">← Kembali</a>

  <div class="page-head">
    <div>
      <h1>Review</h1>
      <p class="sub">{{ $bolehReview ? 'Ceritakan pengalamanmu makan di ' : 'Baca pengalaman pengguna di ' }}{{ $tempat['nama'] }}</p>
    </div>
  </div>

  @if ($bolehReview)
  <section class="compose" aria-label="Tulis review">
    <div class="compose-avatar" aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon('user') !!}</div>
    <div class="compose-main">
      <h2>{{ auth()->user()->nama }}</h2>

      @if ($errors->any())
        <div class="alert alert-error" role="alert">
          <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
      @endif

      <form class="compose-row" method="post" action="{{ $editing ? route('review.update',$editing) : route('review.store',$tempat) }}" novalidate>
        @csrf @if($editing) @method('PATCH') @endif

        <label class="sr-only" for="komentar">Komentar</label>
        <input type="text" id="komentar" name="komentar" value="{{ $form['komentar'] }}" placeholder="Tulis Komentar Anda..." maxlength="500" required>

        <label class="sr-only" for="rating">Rating</label>
        <select id="rating" name="rating" class="select-rating">
          @for ($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}"{!! (int) $form['rating'] === $i ? ' selected' : '' !!}>{{ $i }} bintang</option>
          @endfor
        </select>

        <button type="submit" class="btn btn-primary">{{ $editing ? 'Simpan' : 'Posting' }}</button>
        @if ($editing)<a class="btn btn-outline" href="{{ route('review.index',$tempat) }}">Batal</a>@endif
      </form>
    </div>
  </section>
  @else
    <div class="review-readonly" role="note">
      <span aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon('shield') !!}</span>
      <div><strong>Mode lihat ulasan (Admin)</strong><p>Admin dapat melihat ulasan pengguna, tetapi tidak bisa menulis, mengedit, atau menghapus review. Fitur review hanya untuk akun pengguna.</p></div>
    </div>
  @endif

  <h2 class="block-title">Semua Review</h2>

  @if ($reviews->isNotEmpty())
    <ul class="review-list">
      @foreach($reviews as $r) @php $milikku=$bolehReview && (int)$r->user_id === (int)auth()->id(); @endphp
        <li class="review">
          <span class="avatar" aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon('user') !!}</span>
          <div class="review-body">
            <p class="review-meta"><strong>{{ $r->user?->nama ?? 'Pengguna' }}</strong> · {{ \App\Support\ManganSekView::waktu_lalu($r['created_at']) }}</p>
            {!! \App\Support\ManganSekView::stars_html((int) $r['rating']) !!}
            <p>{{ $r['komentar'] }}</p>
          </div>
          @if ($milikku)
            <div class="review-actions">
              <a class="btn btn-primary btn-sm" href="{{ route('review.index',[$tempat,'edit'=>$r->id]) }}">Edit</a>
              <form method="post" action="{{ route('review.destroy',$r) }}" data-confirm="Hapus review ini?">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline btn-sm btn-delete">Delete</button>
              </form>
            </div>
          @endif
        </li>
      @endforeach
    </ul>
  @else
    <p class="empty">{{ $bolehReview ? 'Belum ada review. Tulis yang pertama di atas.' : 'Belum ada review dari pengguna.' }}</p>
  @endif
</div>
@endsection
