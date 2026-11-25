@extends('layout')
@section('title','Kredit Foto')
@section('active','')
@section('content')
@php $credits = [
    ['Warung Bu Sari', 'Inna Safa', 'Unsplash', 'https://unsplash.com/photos/ED9C5fASrBw', 'Unsplash'],
    ['Mie Ayam Pak Slamet', 'Yoseph Syahriel', 'Unsplash', 'https://unsplash.com/photos/6LPo9_fczhI', 'Unsplash'],
    ['Warteg Sederhana', 'Inna Safa', 'Unsplash', 'https://unsplash.com/photos/QUNTcTTCvUk', 'Unsplash'],
    ['Ayam Geprek Mas Dika', 'apan upen', 'Unsplash', 'https://unsplash.com/photos/mAKVQmnEB6k', 'Unsplash'],
    ['Kopi Kenangan (Cab. Kampus)', 'Demi DeHerrera', 'Unsplash', 'https://unsplash.com/photos/L-sm1B4L1Ns', 'Unsplash'],
    ['Es Teh Poci', 'Nia Ramirez', 'Unsplash', 'https://unsplash.com/photos/nWg98QhqbC8', 'Unsplash'],
    ['Jus Buah Bu Wati', 'Greg Rosenke', 'Unsplash', 'https://unsplash.com/photos/IgGFNg-xPJs', 'Unsplash'],
    ['Susu Kedelai Pak Joko', 'LinasD (penyesuaian oleh ReneeWrites)', 'Wikimedia Commons', 'https://commons.wikimedia.org/wiki/File:Soy_milk.jpg', 'CC BY-SA 3.0'],
    ['Cilok Pak Eko', 'MartinThoma', 'Wikimedia Commons', 'https://commons.wikimedia.org/wiki/File:Cilok.jpg', 'CC0 1.0'],
    ['Cireng Isi Mbak Yuni', 'Lintanggantari', 'Wikimedia Commons', 'https://commons.wikimedia.org/wiki/File:Cireng_isi.jpg', 'CC BY-SA 4.0'],
    ['Pisang Goreng Keju', 'Spencer Davis', 'Unsplash', 'https://unsplash.com/photos/izIiiDEuJwI', 'Unsplash'],
    ['Seblak Teh Neng', 'R Eris', 'Unsplash', 'https://unsplash.com/photos/8SRfhNf6z9s', 'Unsplash'],
 ];
 @endphp
<div class="container photo-credits">
  <div class="page-head"><div><h1>Kredit dan sumber foto</h1><p>Dokumentasi penggunaan foto ilustrasi pada ManganSek.</p></div></div>
  <p>Seluruh foto katalog merupakan ilustrasi jenis makanan/minuman, bukan foto produk atau warung asli yang namanya ditampilkan. Foto dari Unsplash digunakan sesuai lisensinya. Foto Wikimedia Commons mengikuti ketentuan lisensi masing-masing; foto cireng isi ditampilkan tanpa modifikasi.</p>
  <div class="table-wrap"><table><thead><tr><th>Menu</th><th>Fotografer</th><th>Sumber</th><th>Lisensi</th></tr></thead><tbody>
    @foreach($credits as $credit)
      <tr><td>{{ $credit[0] }}</td><td>{{ $credit[1] }}</td><td><a href="{{ $credit[3] }}" rel="noopener noreferrer" target="_blank">{{ $credit[2] }}</a></td><td>{{ $credit[4] }}</td></tr>
    @endforeach
  </tbody></table></div>
  <p>Untuk menjaga keakuratan katalog, admin dapat mengganti foto ilustrasi dengan foto milik sendiri atau foto yang sudah mendapat izin penggunaan melalui halaman Tambah/Edit Menu.</p>
</div>
@endsection
