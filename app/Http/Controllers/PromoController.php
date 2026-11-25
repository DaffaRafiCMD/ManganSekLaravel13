<?php
namespace App\Http\Controllers;
use App\Models\Promo;
use Illuminate\Http\Request;
class PromoController extends Controller
{
    public function index(Request $request) {
        $filter = $request->query('kategori','');
        if (!in_array($filter,['makanan','minuman','jajan'],true)) $filter = '';
        $promos = Promo::when($filter !== '',fn($q)=>$q->where('kategori',$filter))->get();
        return view('promo',compact('promos','filter'));
    }
}
