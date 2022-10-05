<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function user()
    {
        // $menus = Menu::whereNull('parent_id')->with('children', function($q){ return $q->orderByRaw('ISNULL(ordering), ordering asc'); })->orderByRaw('ISNULL(ordering), ordering asc')->get();
        // $user = auth()->user();

        // $user->menus = $menus;
        // $user->ability = [
        //     [
        //         'action' => 'manage',
        //         'subject' => 'all',
        //     ],
        // ];

        // dd('lol');
            $user = Auth::user();

        return json_data($user);
    }
}
