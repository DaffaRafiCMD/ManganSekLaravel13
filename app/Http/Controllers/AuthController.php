<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLogin(Request $request) {
        if (Auth::check()) return redirect()->route('dashboard');
        $role = $request->query('role') === 'admin' ? 'admin' : 'user';
        return view('auth.login', compact('role'));
    }
    public function login(Request $request) {
        $data = $request->validate(['email'=>'required|email|max:150','password'=>'required|string','role'=>'required|in:user,admin']);
        $user = User::where('email',$data['email'])->where('role',$data['role'])->first();
        // Akun dummy pada SQL asli memiliki password "!", bukan hash.
        if (!$user || $user->password === '!' || !Hash::check($data['password'],$user->password)) {
            return back()->withErrors(['email'=>'Email, password, atau role tidak sesuai.'])->withInput($request->only('email','role'));
        }
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
    public function showRegister() { return Auth::check() ? redirect()->route('dashboard') : view('auth.register'); }
    public function register(Request $request) {
        $data = $request->validate(['nama'=>'required|string|min:3|max:100','email'=>'required|email|max:150|unique:users,email','password'=>'required|string|min:8|max:72|confirmed']);
        $user = User::create(['nama'=>$data['nama'],'email'=>$data['email'],'password'=>Hash::make($data['password']),'role'=>'user']);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
