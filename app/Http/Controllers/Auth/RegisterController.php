<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // DB::beginTransaction();

        // try
        // {
            // dd($request->all());
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->email_verified_at = now();
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(10);
            $user->avatar = $request->avatar;

            if($user->save())
            {
                // $user->sendEmailVerificationNotification();
                return success();
            }

            return server_error();



            // DB::commit();

            // return response()->json([
            //     'message' => 'success',
            //     'data' => [
            //         'user' => $user,
            //     ]
            // ]);
        // } catch (Exception $ex)
        // {

            // DB::rollBack();
            // Log::error($ex);
            // abort(500, 'server.error');
        // }
    }
}


