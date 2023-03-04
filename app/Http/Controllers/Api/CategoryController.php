<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\category;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Category::all();
        // return Category::select('id', 'name', 'icon')->get();
        return CategoryResource::collection(Category::all());
    }

    public function index_2(Request $request)
    {

        if ($request->has('trashed')) {
            return Category::onlyTrashed()
                ->get();
        } else {
            return Category::select('id', 'name')->get();
        }
        return Category::select('id', 'name')->get();
        // return Category::all();
        // return Category::select('id', 'name', 'icon')->get();
        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
        // return new CategoryResource(Category::create($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_v2(Request $request)
    {

        // $request->validate([
        //     'name' => 'required|max:1',
        //     'icon' => 'required|max:1',
        // ]);

        Category::create($request->all());
        // Category::create($request->only('name','icon'));
        // return Category::create(['name' => $request->name, 'icon' => $request->icon]);
        // return Category::create($request->validated());
        // return new CategoryResource(Category::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        // return $category;
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category);
        // return new CategoryResource(Category::update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
