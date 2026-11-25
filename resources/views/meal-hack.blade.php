@extends('layout')
@section('title','Meal Hack')
@section('active','meal')
@section('content')
<div class="container">
  <div class="page-head">
    <div>
      <h1>Meal Hack</h1>
      <p class="sub">Trik makan kenyang tanpa bikin dompet jebol</p>
    </div>
  </div>

  @if (auth()->check())
    <section class="panel meal-hack-panel" aria-labelledby="judul-bagikan">
      <h2 id="judul-bagikan">Bagikan meal hack-mu</h2>

      @if ($errors->any())
        <div class="alert alert-error" role="alert">
          <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
      @endif

      <form class="hack-form" method="post" action="{{ route('meal.store') }}">
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
          <input type="number" id="hemat" name="hemat" min="0" max="9999999" value="{{ old('hemat') }}" placeholder="5000" required>
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
          <div class="hack-side"><span class="badge badge-green">Hemat Rp {{ \App\Support\ManganSekView::rupiah($h['hemat']) }}</span>
          @if (auth()->user()?->isAdmin())
            <div class="menu-actions"><a class="btn btn-outline btn-sm" href="{{ route('meal.edit',$h) }}">Edit</a>
              <form method="post" action="{{ route('meal.destroy',$h) }}" data-confirm="Hapus meal hack ini?">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Hapus</button></form>
            </div>
          @endif</div>
        </li>
      @endforeach
    </ul>
  @else
    <p class="empty">Belum ada meal hack. Jadi yang pertama berbagi!</p>
  @endif
</div>
@endsection
