<?php
namespace App\Http\Controllers;
use App\Models\{User,Tempat,Review,MealHack,Promo};
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        if ($user->isAdmin()) return view('admin-dashboard',[
            'counts'=>['Pengguna'=>User::where('role','user')->count(),'Tempat'=>Tempat::count(),'Review'=>Review::count(),'Meal Hack'=>MealHack::count()],
            'promoCount'=>Promo::count(), 'terbaru'=>Tempat::latest('id')->limit(6)->get(),'reviews'=>Review::with(['user','tempat'])->latest('created_at')->limit(5)->get()
        ]);
        return view('dashboard',['user'=>$user,'counts'=>['Favorit'=>$user->favorites()->count(),'Review'=>$user->reviews()->count(),'Meal Hack'=>$user->mealHacks()->count()], 'favorit'=>$user->favorites()->with('tempat')->latest('id')->limit(5)->get()]);
    }
}
