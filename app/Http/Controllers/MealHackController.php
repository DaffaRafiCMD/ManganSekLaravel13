<?php
namespace App\Http\Controllers;
use App\Models\MealHack;
use Illuminate\Http\Request;
class MealHackController extends Controller
{
    private function authorizeRole(Request $request): void {
        abort_unless(in_array($request->user()?->role, ['admin','user'], true), 403);
    }
    public function index(Request $request) {
        $this->authorizeRole($request);
        return view('meal-hack',['hacks'=>MealHack::latest('id')->get()]);
    }
    public function store(Request $request) {
        $this->authorizeRole($request);
        $data = $request->validate(['judul'=>'required|string|min:3|max:100','deskripsi'=>'required|string|min:5|max:255','hemat'=>'required|integer|min:0|max:9999999']);
        $request->user()->mealHacks()->create($data+['ikon'=>'lightbulb']);
        return back()->with('success','Meal Hack berhasil diposting.');
    }
    private function authorizeManage(Request $request): void {
        abort_unless($request->user()?->isAdmin(), 403);
    }
    public function edit(Request $request, MealHack $mealHack) {
        $this->authorizeManage($request);
        return view('meal-hack-edit', compact('mealHack'));
    }
    public function update(Request $request, MealHack $mealHack) {
        $this->authorizeManage($request);
        $data = $request->validate(['judul'=>'required|string|min:3|max:100','deskripsi'=>'required|string|min:5|max:255','hemat'=>'required|integer|min:0|max:9999999']);
        $mealHack->update($data);
        return redirect()->route('meal.index')->with('success','Meal Hack berhasil diperbarui.');
    }
    public function destroy(Request $request, MealHack $mealHack) {
        $this->authorizeManage($request);
        $mealHack->delete();
        return redirect()->route('meal.index')->with('success','Meal Hack berhasil dihapus.');
    }
}
