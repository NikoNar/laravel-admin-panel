<?php

namespace Codeman\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Codeman\Admin\Http\Requests\PortfolioRequest;
use Codeman\Admin\Services\CRUDService;
use Codeman\Admin\Http\Controllers\Controller;
use Codeman\Admin\Models\Portfolio;
use Codeman\Admin\Models\Category;
use Illuminate\Support\Facades\Response;

class PortfolioController extends Controller
{

    protected $model;
    /**
       * Run constructor
       *
       * @return Response
       */
    public function __construct(Portfolio $model)
    {
        // $this->settings = $settings;
        // $this->middleware('admin');
        $this->CRUD = new CRUDService($model);
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-panel::portfolio.index', ['portfolios' => $this->CRUD->getAll() , 'dates' => $this->getDatesOfResources($this->model), 'languages' => true]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel::portfolio.create', [
                'order' => $this->CRUD->getMaxOrderNumber(),
                'categories' => Category::where('type', 'portfolio')->get()
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        $this->authorize('create', $this->model);
        // dd($request->all()); 
        $portfolio =  $this->CRUD->store($request->all());
        if(!empty($request->category_id)){
                foreach($request->category_id as $key=>$id){
                    $portfolio->categories()->attach($id); 
                }
            }
     
        return redirect()->route('portfolio-edit', $portfolio->id)->with('success', 'Portfolio Inserted Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Protfolio  $protfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Protfolio $protfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Protfolio  $protfolio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        return view('admin-panel::portfolio.edit', [ 
            'portfolio' => $this->CRUD->getById($id),
            'categories' => Category::where('type', 'portfolio')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Protfolio  $protfolio
     * @return \Illuminate\Http\Response
     */
    public function update(PortfolioRequest $request,  $id)
    {
        
        $this->CRUD->update($id, $request->all());
        Portfolio::find($id)->categories()->sync($request->category_id);
        return redirect()->route('portfolio-edit', $id)->with('success', 'Portfolio Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->CRUD->destroy($id)){
            return redirect()->back()->with('success', 'Portfolio Successfully Deleted.');
        }
    }

    public function categories()
    {
        $categories  = Category::where('type', 'portfolio')->get();
        $type  = 'portfolio';
        return view('admin-panel::category.index',  compact('categories', 'type'));
    }

    public function translate($id)
    {
       
        $translate = $this->CRUD->createOrEditTranslation($id);
        if(isset($translate) && $translate->parent_lang_id != null) {
            $parent_lang_id = null;
        }else {
            $parent_lang_id = $translate->id;
        }
        // dd($parent_lang_id);
        if($translate)
        {
            return view('admin-panel::portfolio.edit', [
                'portfolio' => $translate,
                'parent_lang_id' => $parent_lang_id,
                'categories' => Category::where('type', 'portfolio')->get(),
                'order' => $this->CRUD->getMaxOrderNumber(),
            ]);
        }
    }
}
