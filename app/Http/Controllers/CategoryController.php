<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(request('perpage', 15));

        return new CategoryCollection($categories);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $categories = Category::create([
            'name' => $request->name,
            'avatar' => $request->avatar
        ]);

        if ($categories)
        {
            return  success();
        }

        return server_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return json_data($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return json_data([
            'data' => [
                'name' => $category->name,
                'avatar' => null,
            ],
            'additional' => [
                'avatar' => $category->avatar,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->avatar = $request->avatar;
        if ($category->save()) return success();

        return server_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) return success();

        return server_error();
    }
}
