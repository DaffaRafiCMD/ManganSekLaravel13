<?php
namespace App\Http\Controllers;
use App\Models\Tempat;
use Illuminate\Http\Request;
class FavoritController extends Controller
{
    public function toggle(Request $request, Tempat $tempat) {
        $query = $request->user()->favorites()->where('tempat_id',$tempat->id);
        if ($query->exists()) $query->delete();
        else $request->user()->favorites()->firstOrCreate(['tempat_id'=>$tempat->id]);
        return back()->with('success','Favorit diperbarui.');
    }
}
