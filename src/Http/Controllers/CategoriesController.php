<?php

namespace Codeman\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Codeman\Admin\Http\Controllers\Controller;

use Codeman\Admin\Models\Category;


class CategoriesController extends Controller
{
	/**
       * Run constructor
       *
       * @return Response
       */
    public function __construct()
    {
    	// $this->middleware('admin');
    }

    /**
       * Display a listing of the resource.
       *
       * @return Response
       */
    public function index(Category $model)
    {
    	$categories = $model->where('parent_id', '=', 0)->orderBy('order', 'DESC')->get();
    	// dd($categories);
    	// $allCategories = $model->pluck('title_en','id')->all();
    	return view('admin-panel::category.index', ['categories' => $categories, 'languages' => true]);
    }

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create($type, Category $model)
	{
		$categories = $model->where('type', $type)->where('parent_id', '<=', 0)->orderBy('order', 'DESC')->get();
		$returnHTML =  view('admin-panel::category.create_edit', [
			'categories' => $categories,
			'type' => $type,
			'order' => getMaxOrderNumber('Category'),
		])->render();
		return response()->json(array('success' => true, 'html' => $returnHTML));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store( Request $request, Category $category )
	{
		$request['slug'] = getUniqueSlug($category, $request['title']);
		$category->create($request->all());
		return redirect()->back()->with('success', 'Category successfully created.');
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id, $type, Category $category)
	{
		$category = $category->find($id);
		$categories = $category->where('type', $type)->where('parent_id', '<=', 0)->where('id', '!=', $id)->orderBy('order', 'DESC')->get();
		$returnHTML =  view('admin-panel::category.create_edit', [
			'category' => $category,
			'categories' => $categories,
			'type' => $type,
			'order' => getMaxOrderNumber('Category'),
		])->render();
		return response()->json(array('success' => true, 'html' => $returnHTML));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id, Request $request, Category $category)
	{
		$request['slug'] = getUniqueSlug($category, $request['title_eng'], $id);
		$category->find($id)->update($request->all());
		return redirect()->back()->with('success', 'Category successfully updated.');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id, category $category)
	{
		if($category->find($id)->delete()){
			return redirect()->back()->with('success', 'Category Successfully Deleted.');
		}
		return redirect()->back()->with('error', 'Something whent wrong.');

	}
}
