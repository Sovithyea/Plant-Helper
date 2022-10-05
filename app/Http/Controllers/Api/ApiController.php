<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Crop;
use App\Models\Disease;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function category()
    {
        $categories = Category::select('id', 'name', 'avatar')->get();
        // $crops = Crop::with('category')->get();


        return json_data($categories);
    }

    public function crop($category_id)
    {
        $crops = Crop::where('category_id', $category_id)->select('id', 'name', 'avatar','detail','harvest','expire','category_id')->with('category')->get();

        return json_data($crops);
    }

    public function cropAll()
    {
        $crops = Crop::with('category')->select('id', 'name', 'avatar', 'category_id', 'detail', 'harvest', 'expire')->get();

        return json_data($crops);
    }


    public function cropShow($crop_id)
    {
        $crop = Crop::with(['category', 'condition',])->where('id', $crop_id)->get();

        return json_data($crop);
    }

    public function cropDisease($crop_id)
    {
        $diseases = Disease::select('id', 'name', 'diagnosis', 'avatar', 'crop_id')->where('crop_id', $crop_id)->with('crop')->get();

        return json_data($diseases);
    }

    public function cropGuide($crop_id)
    {
        $guides = Activity::select('id', 'name', 'avatar', 'crop_id')->where('crop_id', $crop_id)->with('crop')->get();

        return json_data($guides);
    }


    public function diseaseShow($disease_id)
    {
        $disease = Disease::with('crop')->where('id', $disease_id)->get();

        return json_data($disease);
    }

    public function activityShow($activity_id)
    {
        $activity = Activity::with('crop')->where('id', $activity_id)->get();

        return json_data($activity);
    }

    public function diseaseAll()
    {
        $diseases = Disease::with('crop')->select('id', 'name', 'avatar', 'diagnosis', 'cause', 'solution', 'crop_id')->get();

        return json_data($diseases);
    }

    public function guideAll()
    {
        $guides = Activity::with('crop')->select('id', 'name', 'avatar', 'detail', 'stage', 'crop_id')->get();
        // dd($guides);
        return json_data($guides);
    }


}
