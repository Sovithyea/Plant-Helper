<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notice;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use Ramsey\Uuid\Nonstandard\Uuid;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Notifications\TelegramRegister;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(request('perpage', 15));

        return new UserCollection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->avatar = $request->avatar;
        $user->email_verified_at = now();
        $user->password = Hash::make('12345678');
        $user->remember_token = Str::random(10);

        if ($user->save())
        {
            // $notice = new Notice([

            //     'notice' => 'New User Created',
            //     'noticedes' => $user->email."^\n".$user->username,
            //     'noticelink' =>"http://planthelper.info/user",
            //     'telegramid' => Config::get('services.telegram_id')
            // ]);
            // $notice->save();
            // $notice->notify(new TelegramRegister());
            // $user->sendEmailVerificationNotification();
            return success();
        }

        return server_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return json_data($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return json_data([
            'data' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'avatar' => null,
            ],
            'additional' => [
                'avatar' => $user->avatar,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->avatar = $request->avatar;
        if ($user->save()) return success();

        return server_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) return success();

        return server_error();
    }

    public function export()
    {

        $response =  Excel::download(new UsersExport, 'users.xlsx');

        //Cleaning the ouput buffer
        ob_end_clean();

        return $response;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function recovery($id)
    {
        // $user = User::onlyTrashed()->where('id', $id)->get();
        // dd($user);
        if(User::onlyTrashed()->where('id', $id)->restore())
        {
            return success();
        }

        return server_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // dd($user);

        // dd($user);
        if(User::onlyTrashed()->where('id', $id)->forceDelete())
        {
            return success();
        }

        return server_error();
    }

    public function trash()
    {
        $users = User::onlyTrashed()->paginate(request('perpage', 15));

        return new UserCollection($users);
    }
}
