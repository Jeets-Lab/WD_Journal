<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLogin(){
        return view('admin.login');
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if(!$admin || ! Hash::check($request->password, $admin->password)) {
            return redirect()->back()->withErrors(['login' => 'Invalid username or password.']);
        }

        session(['admin_id' => $admin->id]);
        return redirect()->route('admin.home');
    }

    public function logout(){
        session()->forget('admin_id');
        return redirect()->route('admin.login');
    }

    public function home(){
        return view('admin.home');
    }

    public function users(){
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function blockUser($id){
        $user = User::findOrFail($id);
        $user->block = true;
        $user->save();

        return redirect()->route('admin.users')->with('success', "User '{$user->username}' has been blocked.");
    }

    public function unblockUser($id){
        $user = User::findOrFail($id);
        $user->block = false;
        $user->save();

        return redirect()->route('admin.users')->with('success', "User '{$user->username}' has been unblocked.");
    }
}
