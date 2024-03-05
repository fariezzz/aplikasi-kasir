<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:5|max:15',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return redirect()->back()->with('success', 'Password has been changed successfully.');
    }
}
