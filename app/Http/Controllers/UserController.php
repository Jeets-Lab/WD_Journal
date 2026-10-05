<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function showRegister()
    {
        $num1=rand(1,9);
        $num2=rand(1,9);

        session(['captcha_answer'=> $num1+$num2]);
        return view('user.register', ['num1'=>$num1, 'num2'=>$num2]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'nullable|digits:10',
            'city' => 'required|string|max:80',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captcha' => 'required|numeric',
        ]);

        if((int)$request->captcha != session('captcha_answer')) {
            return redirect()->back()
            ->withErrors(['captcha' => 'Incorrect captcha answer.Try Again.'])
            ->withInput();
        }

        session()->forget('captcha_answer');
        $profileImagePath = null;

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = public_path('uploads');

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $originalName = basename($_FILES['profile_image']['name']);
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $filename = time() . '.' . uniqueid() . '.' . $extension;
            $destination = $uploadDir . DIRECTORY_SEPARATOR . $filename;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)) {
                $profileImagePath = 'uploads/' . $filename;
            }
        }

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'city' => $request->city,
            'profile_image' => $profileImagePath,
            'block' => false,
        ]);

        return redirect()->route('user.register')->with('success', 'Registration successful! You can now login.');
    }

    public function showLogin()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with(['error', 'Invalid username or password.']);
        }

        if ($user->block) {
            return back()->with(['error', 'Your account has been blocked.']);
        }

        session(['user_id' => $user->id]);
        return redirect()->route('user.home');
    }
    public function logout(){
        session()->forget('user_id');
        return redirect()->route('user.login');
    }

    public function home(){
        return view('user.home');
    }

    public function profile(){
        $user = User::findOrFail(session('user_id'));
        return view('user.profile', compact('user'));
    }
}