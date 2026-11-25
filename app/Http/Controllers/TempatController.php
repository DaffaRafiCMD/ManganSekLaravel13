<?php
namespace App\Http\Controllers;
use App\Models\Tempat;
use Illuminate\Http\Request;
class TempatController extends Controller
{
    public function home(Request $request) {
        if ($request->user()->isAdmin()) return redirect()->route('dashboard');
        $q = trim((string)$request->query('q',''));
        $daftar = Tempat::withRatings()->when($q !== '',fn($query)=>$query->where('nama','like','%'.$q.'%'),fn($query)=>$query->where('rekomendasi',1)->limit(4))->get();
        return view('menu.home',['daftar'=>$daftar,'q'=>$q,'kategori'=>'home','judul'=>'Rekomendasi untuk Kamu','favoritIds'=>$request->user()->favorites()->pluck('tempat_id')->all()]);
    }
    public function index(Request $request, string $kategori) {
        abort_unless(in_array($kategori,['makanan','minuman','jajan'],true),404);
        $q = trim((string)$request->query('q',''));
        $daftar = Tempat::withRatings()->where('kategori',$kategori)->when($q !== '',fn($query)=>$query->where('nama','like','%'.$q.'%'))->get();
        return view('menu.index',['daftar'=>$daftar,'q'=>$q,'kategori'=>$kategori,'judul'=>ucfirst($kategori),'favoritIds'=>$request->user()->favorites()->pluck('tempat_id')->all()]);
    }
}
