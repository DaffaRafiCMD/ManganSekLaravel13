@extends('layout')
@section('title','Meal Hack')
@section('active','meal')
@section('content')
<div class="container">
  <div class="page-head">
    <div>
      <h1>Meal Hack @if (!auth()->check())<span class="badge badge-green">CRUD: Create</span>@endif</h1>
      <p class="sub">Trik makan kenyang tanpa bikin dompet jebol</p>
    </div>
  </div>

  @if (auth()->check())
    <section class="panel" aria-labelledby="judul-bagikan">
      <h2 id="judul-bagikan">Bagikan meal hack-mu</h2>

      @if ($errors->any())
        <div class="alert alert-error" role="alert">
          <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
      @endif

      <form class="hack-form" method="post" action="{{ route('meal.store') }}" novalidate>
        @csrf
        <div class="field">
          <label for="judul-hack">Judul</label>
          <input type="text" id="judul-hack" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Nasi telur + kecap" maxlength="100" required>
        </div>
        <div class="field">
          <label for="deskripsi">Deskripsi singkat</label>
          <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Ceritakan triknya..." maxlength="255" required>
        </div>
        <div class="field">
          <label for="hemat">Hemat berapa?</label>
          <input type="text" id="hemat" name="hemat" inputmode="numeric" value="{{ old('hemat') }}" placeholder="Rp 5.000" required>
        </div>
        <button type="submit" class="btn btn-primary">Posting</button>
      </form>
    </section>
  @else
    
  @endif

  @if ($hacks->isNotEmpty())
    <ul class="hack-list">
      @foreach ($hacks as $h)
        <li class="hack">
          <span class="hack-icon" aria-hidden="true">{!! \App\Support\ManganSekView::ui_icon('lightbulb') !!}</span>
          <div class="hack-body">
            <h3>{{ $h['judul'] }}</h3>
            <p>{{ $h['deskripsi'] }}</p>
          </div>
          <span class="badge badge-green">Hemat Rp {{ \App\Support\ManganSekView::rupiah($h['hemat']) }}</span>
        </li>
      @endforeach
    </ul>
  @else
    <p class="empty">Belum ada meal hack. Jadi yang pertama berbagi!</p>
  @endif
</div>
@endsection
