<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\AccountRequest;
use App\Jobs\SendUserCreatedEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(){
        return view('pages.user.index', [
            'title' => 'User List',
            'users' => User::latest()->filter(request(['role']))->get()
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
            'password' => ['required', 'min:5', 'max:12']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $validatedData['remember_token'] = Str::random(10);

        $user = User::create($validatedData);
        
        if ($request->request_id) {
            $decryptedId = decrypt($request->request_id);
            
            $accountRequest = AccountRequest::findOrFail($decryptedId);
            
            $accountRequest->delete();

            $undecryptedPassword = $request->password;

            SendUserCreatedEmail::dispatch($user, $undecryptedPassword);

            return redirect('/users')->with('success', 'User has been added and the data has been sent to ' .$user->email .'.');
        }

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
            'image' => 'nullable|image|file|max:1024'
        ];

        if($request->email != $user->email){
            $rules['email'] = ['required', 'email:dns', 'unique:users'];
        }

        if($request->username != $user->username){
            $rules['username'] = ['required', 'min:5', 'max:20', 'unique:users'];
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')){
            if($user->image){
                Storage::delete($user->image);
            }
            $validatedData['image'] = $request->file('image')->store('user-images');
        }
        else {
            if($user->image){
                Storage::delete($user->image);
            }
            $validatedData['image'] = null;
        }

        $user->update($validatedData);

        return back()->with('success', 'Data updated.');
    }

    public function destroy(User $user){
        User::destroy($user->id);

        return back()->with('success', 'User has been deleted.');
    }
}
