<?php

namespace Codeman\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Codeman\Admin\Http\Requests\PageRequest;
use Codeman\Admin\Http\Controllers\Controller;
use Codeman\Admin\Services\CRUDService;
use Codeman\Admin\Interfaces\PageInterface;
use Codeman\Admin\Models\Page;
use Codeman\Admin\Models\Lecturer;
use Illuminate\Support\Facades\Response;

// use Settings;

class PagesController extends Controller
{
	protected $model;
	/**
       * Run constructor
       *
       * @return Response
       */
    public function __construct(Page $model)
    {
    	// $this->settings = $settings;
    	// $this->middleware('admin');
    	$this->CRUD = new CRUDService($model);
    	$this->model = $model;
    }

    /**
       * Display a listing of the resource.
       *
       * @return Response
       */
    public function index()
    {
    	return view('admin-panel::page.index', ['pages' => $this->CRUD->getAll() , 'dates' => $this->getDatesOfResources($this->model), 'languages' => true]);
    }

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create(PageInterface $pageInterface)
	{

		$template = null;

		if(request()->has('template')){
			$template = request()->get('template');
		}
		
		if($template){
			if($template == "graphic" || $template == "interior"){
				$lecturers = Lecturer::pluck('title','id');
				// dd($lecturers);
				return view('admin-panel::page.create_edit', [
    			'template' 	=> $template,
    			'parents' 	=> $pageInterface->getAllPagesTitlesArray(),
    			'order' 	=> $pageInterface->getMaxOrderNumber(),
    			'lecturers' => $lecturers
    		]);
			}
    		return view('admin-panel::page.create_edit', [
    			'template' 	=> $template,
    			'parents' 	=> $pageInterface->getAllPagesTitlesArray(),
    			'order' 	=> $pageInterface->getMaxOrderNumber()			
    		]);

		}else{
    		return view('admin-panel::page.create_edit', [
    			'parents' => $pageInterface->getAllPagesTitlesArray(),
    			'order' => $pageInterface->getMaxOrderNumber(),
    		]);
		}
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store(PageRequest $request, PageInterface $pageInterface )
	{
		dd($request->all());
		$this->authorize('create', $this->model);



		if($request->has('lecturers')){
			$request['lecturers'] = json_encode($request->lecturers);
		} else {
			$request['lecturers'] = "";
		}
		$inputs = $pageInterface->getMaxOrderNumber($request->all());
		
		if(null != $page = $this->CRUD->store($inputs)){
			if($request->has('meta'))
			{
				$pageInterface->createUpdateMeta($page->id, $request->get('meta'));
			}

            // return Response::json([
            //     'error' => false,
            //     'success'=> 'Page Successfully Created.',
            //     'code'  => 200,
            //     'page_id' =>$page->id
            // ], 200);
			return redirect()->route('page-edit', $page->id)->with('success', 'Page Successfully Created.');
		}
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function translate($id, PageInterface $pageInterface)
	{
		$template = null;
		if(request()->has('template')){
			$template = request()->get('template');
		}
		$translate = $pageInterface->createOrEditTranslation($id);
		if(isset($translate) && $translate->parent_lang_id != null) {
	    	$parent_lang_id = null;
		}else {
    		$parent_lang_id = $translate->id;
		}
		// dd($parent_lang_id);
		if($translate)
		{

			if(!$template){
				$template = $translate->template;
			}
			if($template){
				$pagemetas = $pageInterface->getPageMetas($translate->id);
				$decoded_pagemetas = [];

				
		foreach($pagemetas as $key => $value) {
			if(isJson($value)){

				$decoded_pagemetas[$key] = json_decode($value, true); 
			} else {
				$decoded_pagemetas[$key] = $value; 
			}
		} 
		$pagemetas = $decoded_pagemetas;


				$translate->setAttribute('meta', $pagemetas);
			}
    		return view('admin-panel::page.create_edit', [
    			'page' => $translate,
    			'parents' => $pageInterface->getAllPagesTitlesArray(),
    			'template' 	=> $template,
    			'parent_lang_id' => $parent_lang_id,
    		]);
		}
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id, PageInterface $pageInterface)
	{
		$template = null;
		$page = $pageInterface->getById($id);
		
		if($page->template != null){
			$template = $page->template;
		}

		if(request()->has('template')){
			$template = request()->get('template');
		}
		$pagemetas = $pageInterface->getPageMetas($id);

		$decoded_pagemetas = [];
		foreach($pagemetas as $key => $value) {
			if(isJson($value)){

				$decoded_pagemetas[$key] = json_decode($value, true); 
			} else {
				$decoded_pagemetas[$key] = $value; 
			}
		} 
		$pagemetas = $decoded_pagemetas;
	
		$page->setAttribute('meta', $pagemetas);
		if($template){

			if($template == "graphic" || $template == "interior"){
				$selected = json_decode($page->lecturers);
				// dd($lecturersIds);
				$lecturers = Lecturer::pluck('title', 'id')->toArray();
				// dd($lecturers);
				return view('admin-panel::page.create_edit', [
    			'template' 	=> $template,
    			'page' => $page,
    			'parents' => $pageInterface->getAllPagesTitlesArray($id),
    			'lecturers' => $lecturers,
    			'selected'=> $selected
    		]);
			}

    		return view('admin-panel::page.create_edit', [
    			'template' 	=> $template,
    			'page' => $page,
    			'parents' => $pageInterface->getAllPagesTitlesArray($id),
    		]);
		}else{
    		return view('admin-panel::page.create_edit', ['page' => $page, 'parents' => $pageInterface->getAllPagesTitlesArray($id)]);
		}
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id, PageRequest $request, PageInterface $pageInterface)
	{
		// $this_page = $pageInterface->getById($id);
		$this->authorize('update', $this->model);
		// dd(request()->all());
		$request['lecturers'] = json_encode($request->lecturers);
		// dd($request->all()); 
		
		if(null != $page = $pageInterface->update($id, $request->all())){
			if($request->has('meta'))
			{
				$pageInterface->createUpdateMeta($id, $request->get('meta'));
			}else{
				$pageInterface->deleteMetaIfExists($id);
			}
			return redirect()->back()->with('success', 'Page Successfully Updated.');
		}
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id, PageInterface $pageInterface)
	{
		if($pageInterface->destroy($id)){
			return redirect()->back()->with('success', 'Page Successfully Deleted.');
		}
	}
}
