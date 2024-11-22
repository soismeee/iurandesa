<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login aplikasi'
        ]);
    }

    public function authenticate(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // return redirect()->intended('/home');
            return response()->json(['message' => 'Berhasil login']);
        }
        // return back()->with('loginError', 'Login Failed!!!');
        return response()->json(['message' => 'Gagal melakukan authentikasi'], 404);
    }

    public function store(Request $request)
    {
        // return request()->all();
        $vaslidatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        // $vaslidatedData['password'] = bcrypt($vaslidatedData['password']);
        $vaslidatedData['password'] = Hash::make($vaslidatedData['password']);
        User::create($vaslidatedData);
        // $request->session()->flash('success', 'Registration successfull!! please login');
        return redirect('login')->with('success', 'Registration successfull!! please login');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
