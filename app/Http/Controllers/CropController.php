<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Condition;
use App\Exports\CropsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\CropCollection;
use App\Http\Requests\StoreCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Http\Resources\CropDiseaseCollection;
use App\Http\Resources\CropActivityCollection;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $crops = Crop::with('category')->paginate(request('perpage', 15));

        return new CropCollection($crops);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return json_data($categories);
    }


    public function createCondition()
    {

        $condition = Condition::all();


        return json_data($condition);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function editCondition(Request $request, Crop $crop, Condition $condition)
    {
        // dd($crop);
        // return json_data($crop->with('condition')->where('id', $crop->id)->get());

        $condition = Crop::with('condition')->where('id', $crop->id)->first()->condition->where('id', $condition->id)->first()->pivot;
        $crop = Crop::where('id', $crop->id)->first();
        $crops = Crop::all();
        $conditions = Condition::all();
        return json_data([$condition, $crops, $conditions]);

        // return json_data([
        //     'data' => [
        //         'name' => $condition->name,
        //         'avatar' => null,
        //         'min' => $condition->pivot->min,
        //         'max' => $condition->pivot->max,
        //         'regular' => $condition->pivot->regular
        //     ],
        //     'additional' => [
        //         'avatar' => $condition->avatar,
        //     ],
        //     $crop,
        //     $crops
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCropRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCropRequest $request)
    {
        $crop = Crop::create($request->all());
        if($crop) {
            return success();
        }
        return server_error();
    }


    public function storeConditionCrop(Request $request)
    {
        $request->validate([
            'min' => 'required',
            'max' => 'required',
            'regular' => 'required',
        ]);
        $condition = Condition::find($request->condition_id);
        $has_crop =  $condition->crop()->find($request->crop_id);
        if($has_crop) {
            return server_error();
        }
        $condition->crop()->attach([
            $request->crop_id => array (
                'min' => $request->min,
                'max' => $request->max,
                'regular' => $request->regular
            )
        ]);


        if($condition) {

            return success();
        }
        return server_error();
        // $crop = Crop::find($request->crop_id);
        // $condition = Condition::find($request->condition_id);
        // if($condition) {
        //     $condition->min = $request->min;
        //     $condition->max = $request->max;
        //     $condition->regular = $request->regular;
        //     $condition->save();
        //     $crop->condition()->attach($condition);
        // }

    }

    public function updateCondition(Request $request)
    {

        $request->validate([
            'min' => 'required',
            'max' => 'required',
            'regular' => 'required',
        ]);

        $condition = Condition::find($request->condition_id);
        // dd($condition);
        $condition->crop()->sync([
            $request->crop_id => array (
                'min' => $request->min,
                'max' => $request->max,
                'regular' => $request->regular
            )
        ]);

        if($condition) {
            return success();
        }
        return server_error();
        // $crop = Crop::find($request->crop_id);
        // $condition = Condition::find($request->condition_id);
        // if($condition) {
        //     $condition->min = $request->min;
        //     $condition->max = $request->max;
        //     $condition->regular = $request->regular;
        //     $condition->save();
        //     $crop->condition()->attach($condition);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function show(Crop $crop)
    {
        // $crop_id = $crop->id;

        // $diseases = Disease::with('crop')->where('crop_id', $crop->id)->paginate(request('perpage', 15));
        // return json_data(['crop' => $crop, 'diseases' => new DiseaseCollection(Disease::all())]);
        // return new DiseaseCollection(Disease::where('crop_id',$crop->id)->paginate(request('perpage', 15)));
        //  return new DiseaseCollection(Disease::where('crop_id',$crop->id)->paginate(request('perpage', 15)));
           return json_data($crop);

    }
    public function showDisease($id)
    {
        return new CropDiseaseCollection(Disease::where('crop_id',$id)->paginate(request('perpage', 15)));
    }

    public function showActivity($id)
    {
        return new CropActivityCollection(Activity::where('crop_id',$id)->paginate(request('perpage', 15)));
    }

    public function showCondition(Crop $crop)
    {
        // dd($crop::with('condition')->get());
        // dd($crop);
        return json_data($crop::with('condition')->where('id', $crop->id)->paginate(request('prepage',15)));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function edit(Crop $crop)
    {
        return json_data([
            'data' => [
                'name' => $crop->name,
                'harvest' => $crop->harvest,
                'expire' => $crop->expire,
                'category_id' => $crop->category_id,
                'detail' => $crop->detail,
                'avatar' => null,
            ],
            'additional' => [
                'avatar' => $crop->avatar,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCropRequest  $request
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCropRequest $request, Crop $crop)
    {
        $crop->name = $request->name;
        $crop->harvest = $request->harvest;
        $crop->expire = $request->expire;
        $crop->category_id = $request->category_id;
        $crop->detail = $request->detail;
        $crop->avatar = $request->avatar;
        if ($crop->save()) return success();

        return server_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crop $crop)
    {
        if($crop->delete()) return success();
        return server_error();
    }

    public function export()
    {
        return Excel::download(new CropsExport, 'crops.xlsx');
    }

}
