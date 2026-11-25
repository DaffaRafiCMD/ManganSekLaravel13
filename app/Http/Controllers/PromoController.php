<?php
namespace App\Http\Controllers;
use App\Models\Promo;
use Illuminate\Http\Request;
class PromoController extends Controller
{
    private function authorizeAdmin(Request $request): void {
        abort_unless($request->user()?->isAdmin(), 403);
    }
    public function index(Request $request) {
        $filter = $request->query('kategori','');
        if (!in_array($filter,['makanan','minuman','jajan'],true)) $filter = '';
        $promos = Promo::when($filter !== '',fn($q)=>$q->where('kategori',$filter))->latest('id')->get();
        return view('promo',compact('promos','filter'));
    }
    private function data(Request $request): array {
        $data = $request->validate([
            'judul'=>'required|string|min:3|max:100','warna'=>'required|in:yellow,pink,green,blue,purple,peach',
            'nama_tempat'=>'required|string|min:2|max:120','kategori'=>'required|in:makanan,minuman,jajan',
            'deskripsi'=>'required|string|min:5|max:255','syarat'=>'nullable|string|max:255',
            'berlaku_sampai'=>'required|date',
        ]);
        $data['syarat'] = $data['syarat'] ?? '';
        return $data;
    }
    public function create(Request $request) {
        $this->authorizeAdmin($request);
        return view('promo.form',['promo'=>new Promo(['warna'=>'yellow','kategori'=>'makanan'])]);
    }
    public function store(Request $request) {
        $this->authorizeAdmin($request);
        Promo::create($this->data($request));
        return redirect()->route('promo.index')->with('success','Promo berhasil ditambahkan.');
    }
    public function edit(Request $request, Promo $promo) {
        $this->authorizeAdmin($request);
        return view('promo.form',compact('promo'));
    }
    public function update(Request $request, Promo $promo) {
        $this->authorizeAdmin($request);
        $promo->update($this->data($request));
        return redirect()->route('promo.index')->with('success','Promo berhasil diperbarui.');
    }
    public function destroy(Request $request, Promo $promo) {
        $this->authorizeAdmin($request);
        $promo->delete();
        return redirect()->route('promo.index')->with('success','Promo berhasil dihapus.');
    }
}
