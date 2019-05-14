<?php

namespace Codeman\Admin\Http\Controllers;

use Codeman\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codeman\Admin\Http\Requests\FileRequest;
use Codeman\Admin\Services\CRUDService;
use Codeman\Admin\Models\File;
use Codeman\Admin\Models\Category;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{

    protected $model;
    /**
     * Run constructor
     *
     * @return Response
     */
    public function __construct(File $model)
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
        return view('admin-panel::file.index', ['files' => $this->CRUD->getAll() , 'dates' => $this->getDatesOfResources($this->model), 'languages' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel::file.create', [
            'order' => $this->CRUD->getMaxOrderNumber(),
            'categories' => Category::where('type', 'file')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        dd($request->all());
        $file =  $this->CRUD->store($request->all());
        if(!empty($request->category_id)){
            foreach($request->category_id as $key=>$id){
                $file->categories()->attach($id);
            }
        }
        return redirect()->route('file-edit', $file->id)->with('success', 'File Inserted Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd(Category::select('title_en as title', 'id', 'type', 'slug')->where('type', 'file')->get());
        return view('admin-panel::file.edit', [
            'file' => $this->CRUD->getById($id),
            'categories' => Category::select('title_en', 'id', 'type', 'slug')->where('type', 'file')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(FileRequest $request,  $id)
    {

        $this->CRUD->update($id, $request->all());
        File::find($id)->categories()->sync($request->category_id);
        return redirect()->route('file-edit', $id)->with('success', 'File Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->CRUD->destroy($id)){
            return redirect()->back()->with('success', 'File Successfully Deleted.');
        }
    }

    public function categories()
    {
        $categories  = Category::where('type', 'file')->get();
        $type  = 'file';
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
            return view('admin-panel::file.edit', [
                'file' => $translate,
                'parent_lang_id' => $parent_lang_id,
                'categories' => Category::select('title_en as title', 'id', 'type', 'slug')->where('type', 'file')->get(),
                'order' => $this->CRUD->getMaxOrderNumber(),
            ]);
        }
    }
}
