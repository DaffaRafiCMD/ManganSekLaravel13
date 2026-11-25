<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ProfilController extends Controller
{
    public function edit(Request $request) { return view('profil',['user'=>$request->user()]); }
    public function update(Request $request) {
        $user = $request->user();
        $data = $request->validate(['nama'=>'required|string|min:3|max:100','email'=>['required','email','max:150',Rule::unique('users')->ignore($user->id)],'telepon'=>'nullable|string|max:20']);
        $user->update($data);
        return back()->with('success','Profil berhasil diperbarui.');
    }
}
