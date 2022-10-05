<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\User;
use App\Models\Disease;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $categories = Category::all();
        $crops = Crop::all();
        $diseases = Disease::all();
        $conditions = Condition::all();
        $users = User::all();
        $guides = Activity::all();
        return json_data([$categories, $crops, $diseases, $conditions, $users, $guides]);
    }

    public function categoryChart()
    {
        $labels = Category::select('name')->get();
        $series = Category::withCount('crop')->get();

        return json_data([$labels, $series]);
    }

    public function diseaseChart()
    {
        $labels = Crop::select('name')->get();
        $series = Crop::withCount('disease')->get();

        return json_data([$labels, $series]);
    }

    public function guideChart()
    {
        $labels = Crop::select('name')->get();
        $series = Crop::withCount('activity')->get();

        return json_data([$labels, $series]);
    }

    public function export()
    {
        return Excel::download(new CategoriesExport, 'dashboardSummary.xlsx');
    }
}
