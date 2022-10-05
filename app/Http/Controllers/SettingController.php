<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return json_data($user);
    }

    public function changeProfile(Request $request)
    {
        // dd('lol');
        $request->validate([
            'email' => ['required'],
            'username' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required']
        ]);
        $user = Auth::user();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        // $user->role = $request->role;
        // $user->avatar = $request->avatar;
        if ($user->save()) return success();

        return server_error();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);
        // dd("lol");
        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return server_error();
        }


        #Update the new Password
        $change = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        if(!$change) return server_error();

        return success();
    }
}
