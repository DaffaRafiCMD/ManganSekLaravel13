<?php
namespace App\Http\Controllers;
use App\Models\Tempat;
use App\Models\Review;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    private function authorizeRole(Request $request): void {
        abort_unless(in_array($request->user()?->role, ['admin','user'], true), 403);
    }
    private function authorizeManage(Request $request, Review $review): void {
        $this->authorizeRole($request);
        abort_unless($request->user()->isAdmin() || (int)$review->user_id === (int)$request->user()->id, 403);
    }
    public function index(Request $request, Tempat $tempat) {
        $this->authorizeRole($request);
        $reviews = $tempat->reviews()->with('user')->latest('created_at')->latest('id')->get();
        $editing = null;
        if ($request->filled('edit')) {
            $editing = $reviews->first(fn($r) => (int)$r->id === (int)$request->query('edit'));
            abort_if(!$editing, 404);
            $this->authorizeManage($request, $editing);
        }
        return view('review.index',compact('tempat','reviews','editing'));
    }
    public function store(Request $request, Tempat $tempat) {
        $this->authorizeRole($request);
        $data = $request->validate(['rating'=>'required|integer|between:1,5','komentar'=>'required|string|min:3|max:500']);
        $tempat->reviews()->create($data+['user_id'=>$request->user()->id]);
        return back()->with('success','Review berhasil dikirim.');
    }
    public function update(Request $request, Review $review) {
        $this->authorizeManage($request, $review);
        $review->update($request->validate(['rating'=>'required|integer|between:1,5','komentar'=>'required|string|min:3|max:500']));
        return redirect()->route('review.index',$review->tempat_id)->with('success','Review berhasil diubah.');
    }
    public function destroy(Request $request, Review $review) {
        $this->authorizeManage($request, $review);
        $id = $review->tempat_id;
        $review->delete();
        return redirect()->route('review.index',$id)->with('success','Review berhasil dihapus.');
    }
}
