<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(){
        return view('pages.user.index', [
            'title' => 'User List',
            'users' => User::latest()->filter(request(['search', 'role']))->paginate(5)->withQueryString()
        ]);
    }

    public function create(){
        return view('pages.user.create', [
            'title' => 'Add User'
        ]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:5', 'max:20', 'unique:users'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'role' => 'required',
            'password' => ['required', 'min:5', 'max:255']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $validatedData['remember_token'] = Str::random(10);

        User::create($validatedData);

        return redirect('/users')->with('success', 'User has been added.');
    }

    public function show(){
        return view('pages.user.profile', [
            'title' => 'Profile',
            'user' => User::where('id', auth()->user()->id)
        ]);
    }

    public function update(Request $request, User $user){
        $rules = [
            'name' => 'required|max:255',
        ];

        if($request->email != $user->email){
            $rules['email'] = ['required', 'email:dns', 'unique:users'];
        }

        if($request->username != $user->username){
            $rules['username'] = ['required', 'min:5', 'max:20', 'unique:users'];
        }

        if ($request->name == $user->name && $request->email == $user->email && $request->username == $user->username && !$request->file('image')) {
            return back()->with('error', 'No changes were made.');
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')){
            if($user->image){
                Storage::delete($user->image);
            }
            $validatedData['image'] = $request->file('image')->store('user-images');
        }

        $user->update($validatedData);

        return back()->with('success', 'Data updated');
    }

    public function destroy(User $user){
        User::destroy($user->id);

        return back()->with('success', 'User has been deleted.');
    }
}
