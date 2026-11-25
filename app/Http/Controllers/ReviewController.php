<?php
namespace App\Http\Controllers;
use App\Models\Tempat;
use App\Models\Review;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    public function index(Request $request, Tempat $tempat) {
        $reviews = $tempat->reviews()->with('user')->latest('created_at')->latest('id')->get();
         $editing = $request->user()->isAdmin() ? null : $reviews->first(fn($r) => (int)$r->id === (int)$request->query('edit') && (int)$r->user_id === (int)$request->user()->id);
        return view('review.index',compact('tempat','reviews','editing'));
    }
    public function store(Request $request, Tempat $tempat) {
        $data = $request->validate(['rating'=>'required|integer|between:1,5','komentar'=>'required|string|min:3|max:500']);
        $tempat->reviews()->create($data+['user_id'=>$request->user()->id]);
        return back()->with('success','Review berhasil dikirim.');
    }
    public function update(Request $request, Review $review) {
        abort_unless((int)$review->user_id === (int)$request->user()->id,403);
        $review->update($request->validate(['rating'=>'required|integer|between:1,5','komentar'=>'required|string|min:3|max:500']));
        return redirect()->route('review.index',$review->tempat_id)->with('success','Review berhasil diubah.');
    }
    public function destroy(Request $request, Review $review) {
        abort_unless((int)$review->user_id === (int)$request->user()->id,403);
        $id = $review->tempat_id;
        $review->delete();
        return redirect()->route('review.index',$id)->with('success','Review berhasil dihapus.');
    }
}
