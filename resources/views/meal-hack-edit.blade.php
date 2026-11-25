@extends('layout')
@section('title','Edit Meal Hack')
@section('active','meal')
@section('content')
<div class="container">
  <div class="page-head"><div><h1>Edit Meal Hack</h1><p class="sub">Perbarui trik hemat yang kamu bagikan.</p></div></div>
  @if ($errors->any())<div class="alert alert-error" role="alert"><ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>@endif
  <section class="panel meal-hack-panel"><form class="hack-form meal-edit-form" method="post" action="{{ route('meal.update',$mealHack) }}">
    @csrf @method('PATCH')
    <div class="field"><label for="judul">Judul</label><input id="judul" name="judul" value="{{ old('judul',$mealHack->judul) }}" maxlength="100" required></div>
    <div class="field"><label for="deskripsi">Deskripsi singkat</label><input id="deskripsi" name="deskripsi" value="{{ old('deskripsi',$mealHack->deskripsi) }}" maxlength="255" required></div>
    <div class="field"><label for="hemat">Hemat berapa?</label><input id="hemat" name="hemat" type="number" min="0" max="9999999" value="{{ old('hemat',$mealHack->hemat) }}" required></div>
    <button class="btn btn-primary" type="submit">Simpan perubahan</button> <a class="btn btn-outline" href="{{ route('meal.index') }}">Batal</a>
  </form></section>
</div>
@endsection
