<?php
namespace App\Http\Controllers;
use App\Models\Tempat;
use Illuminate\Http\Request;
class MenuController extends Controller
{
    public function index(Request $request) {
        $categories=['makanan'=>['label'=>'Makanan'],'minuman'=>['label'=>'Minuman'],'jajan'=>['label'=>'Jajanan']];
        $filter=(string)$request->query('kategori','');
        if (!isset($categories[$filter])) $filter='';
        $q=trim((string)$request->query('q',''));
        $counts=Tempat::query()->selectRaw('kategori, count(*) as jumlah')->groupBy('kategori')->pluck('jumlah','kategori')->all()+array_fill_keys(array_keys($categories),0);
        $total=array_sum($counts);
        $items=Tempat::withRatings()->when($filter !== '',fn($query)=>$query->where('kategori',$filter))->when($q !== '',fn($query)=>$query->where('nama','like','%'.$q.'%'))->latest('id')->get();
        return view('menu.manage',compact('categories','filter','q','counts','total','items'));
    }
    public function create(Request $request) { return view('menu.form',['tempat'=>new Tempat(['kategori'=>$request->query('kategori','makanan')])]); }
    private function data(Request $request, ?Tempat $tempat = null): array {
        $data = $request->validate([
            'nama'=>'required|string|min:3|max:100','kategori'=>'required|in:makanan,minuman,jajan','jenis'=>'required|string|min:2|max:30',
            'jarak_km'=>'required|numeric|min:0|max:99','harga_min'=>'required|integer|min:0|max:99999999','harga_max'=>'required|integer|gte:harga_min|max:99999999',
            'foto'=>'nullable|url:https|max:1900','foto_upload'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096','rekomendasi'=>'nullable|boolean'
        ]);
        $data['rekomendasi'] = $request->boolean('rekomendasi');
        $data['foto'] = $data['foto'] ?? $tempat?->foto ?? '';
        if ($request->hasFile('foto_upload')) {
            $data['foto'] = 'storage/'.$request->file('foto_upload')->store('menu','public');
        }
        unset($data['foto_upload']);
        return $data;
    }
    public function store(Request $request) {
        Tempat::create($this->data($request)+['dibuat_oleh'=>$request->user()->id]);
        return redirect()->route('menu.index')->with('success','Menu berhasil ditambahkan.');
    }
    public function edit(Tempat $menu) { return view('menu.form',['tempat'=>$menu]); }
    public function update(Request $request, Tempat $menu) {
        $menu->update($this->data($request,$menu));
        return redirect()->route('menu.index')->with('success','Menu berhasil diubah.');
    }
    public function destroy(Tempat $menu) {
        $menu->delete();
        return redirect()->route('menu.index')->with('success','Menu berhasil dihapus.');
    }
}
