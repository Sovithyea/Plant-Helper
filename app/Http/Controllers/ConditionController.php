<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Http\Requests\StoreConditionRequest;
use App\Http\Requests\UpdateConditionRequest;
use App\Http\Resources\ConditionCollection;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conditions = Condition::paginate(request('perpage', 15));

        return new ConditionCollection($conditions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConditionRequest $request)
    {
        $condition = new Condition();

            $condition->name = $request->name;
            $condition->avatar = $request->avatar;

        if($condition->save())
        {
            return success();
        }

        return server_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function show(Condition $condition)
    {
        return json_data($condition);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function edit(Condition $condition)
    {
        return json_data([
            'data' => [
                'name' => $condition->name,
                'avatar' => null
            ],
            'additional' => [
                'avatar' => $condition->avatar,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConditionRequest  $request
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConditionRequest $request, Condition $condition)
    {
        $condition->name = $request->name;
        $condition->avatar = $request->avatar;

        if($condition->save())
        {
            return success();
        }

        return server_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condition $condition)
    {
        if($condition->delete())
        {
            return success();
        }

        return server_error();
    }
}
