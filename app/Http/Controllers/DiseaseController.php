<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Disease;
use App\Exports\DiseasesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\DiseaseCollection;
use App\Http\Requests\StoreDiseaseRequest;
use App\Http\Requests\UpdateDiseaseRequest;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diseases = Disease::with('crop')->paginate(request('perpage', 15));

        return new DiseaseCollection($diseases);
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
     * @param  \App\Http\Requests\StoreDiseaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiseaseRequest $request)
    {
        $disease = new Disease();

            $disease->name = $request->name;
            $disease->avatar = $request->avatar;
            $disease->diagnosis = $request->diagnosis;
            $disease->cause = $request->cause;
            $disease->solution = $request->solution;
            $disease->crop_id = $request->crop_id;

        if($disease->save())
        {
            return success();
        }

        return server_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function show(Disease $disease)
    {
        $disease_id = $disease->id;
        $disease = Disease::with('crop')->where('id', $disease_id)->get()->first();
        // $disease = Disease::with('crop')->get();
        return json_data($disease);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function edit(Disease $disease)
    {
        // $disease_id = $disease->id;
        // $disease = Disease::with('crops')->where('id', $disease_id)->get();
        $crops = Crop::all();
        return json_data([
            'data' => [
                'name' => $disease->name,
                'diagnosis' => $disease->diagnosis,
                'cause' => $disease->cause,
                'solution' => $disease->solution,
                'crop_id' => $disease->crop_id,
                'crops' => $crops,
                'avatar' => null
            ],
            'additional' => [
                'avatar' => $disease->avatar
            ]
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDiseaseRequest  $request
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiseaseRequest $request, Disease $disease)
    {
            $disease->name = $request->name;
            $disease->avatar = $request->avatar;
            $disease->diagnosis = $request->diagnosis;
            $disease->cause = $request->cause;
            $disease->solution = $request->solution;
            $disease->crop_id = $request->crop_id;

        if($disease->save())
        {
            return success();
        }

        return server_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disease $disease)
    {
        if($disease->delete())
        {
            return success();
        }

        return server_error();
    }

    public function export()
    {
        return Excel::download(new DiseasesExport, 'diseases.xlsx');
    }
}
