<?php
namespace App\Http\Controllers;
use App\Models\MealHack;
use Illuminate\Http\Request;
class MealHackController extends Controller
{
    public function index() { return view('meal-hack',['hacks'=>MealHack::latest('id')->get()]); }
    public function store(Request $request) {
        $data = $request->validate(['judul'=>'required|string|min:3|max:100','deskripsi'=>'required|string|min:5|max:255','hemat'=>'required|integer|min:0|max:9999999']);
        $request->user()->mealHacks()->create($data+['ikon'=>'lightbulb']);
        return back()->with('success','Meal Hack berhasil diposting.');
    }
}
