<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Activity;
use App\Exports\ActivitiesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\ActivityCollection;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::with('crop')->paginate(request('perpage', 15));

        return new ActivityCollection($activities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $crops = Crop::all();

        return json_data($crops);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreActivityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActivityRequest $request)
    {
        $activity = new Activity();

            $activity->name = $request->name;
            $activity->avatar = $request->avatar;
            $activity->stage = $request->stage;
            $activity->detail = $request->detail;
            $activity->crop_id = $request->crop_id;

        if($activity->save())
        {
            return success();
        }

        else server_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        // $activity->append(['stage_text']);
        // $activity->stage_text;
        // dd($activity);
        return json_data($activity->with('crop')->where('id', $activity->id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        $crops = Crop::all();
        return json_data([
            'data' => [
                'name' => $activity->name,
                'stage' => $activity->stage,
                'crop_id' => $activity->crop_id,
                'detail' => $activity->detail,
                'avatar' => null,
            ],
            'additional' => [
                'avatar' => $activity->avatar,
            ],
            $crops
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateActivityRequest  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->name = $request->name;
        $activity->detail = $request->detail;
        $activity->avatar = $request->avatar;
        $activity->crop_id = $request->crop_id;
        $activity->stage = $request->stage;

        if($activity->save())
        {
            return success();
        }

        return server_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        if($activity->delete())
        {
            return success();
        }

        return server_error();
    }

    public function export()
    {
        return Excel::download(new ActivitiesExport, 'activities.xlsx');
    }
}
