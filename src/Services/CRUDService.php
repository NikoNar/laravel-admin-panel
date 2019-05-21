<?php

namespace Codeman\Admin\Services;

use Codeman\Admin\Interfaces\CrudInterface;
use Codeman\Admin\Models\BaseModel;
use Codeman\Admin\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Image;

class CRUDService implements CrudInterface
{
	/**
	 * The object of model class.
	 *
	 * @var model
	 */
	protected $model;

	/**
	 * model constructor.
	 *
	 * @param  model 
	 */
	public function __construct($model)
	{
		$this->model = $model;
	}

	/**
	* Select all resources from storage.
	*
	* @return Object
	*/
	public function getAll()
	{
		// dd($this->model->orderBy('order', 'DESC')->where('lang','en')->paginate(10));
		return $this->model->orderBy('order', 'DESC')->where('lang','en')->paginate(10);
	}

	/**
	* Select the specified resource from storage by id.
	*
	* @param  int  $id
	* @return Object
	*/
	public function getById( $id )
	{
		return $this->model->find($id);
	}

	
	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store( $inputs )
	{
	// dd($this->createInputs( $inputs ));
	 return $this->model->create($this->createInputs( $inputs ));
	}

	public function createOrEditTranslation( $id )
	{

		// if(null != $parent_lang = $this->model->where('parent_lang_id', $id)->first()){
		// 	$model_date = date('m/d/Y' ,strtotime($parent_lang->created_at));
		// 	$model_time = date('g:i A' ,strtotime($parent_lang->created_at));
		// 	$parent_lang->published_date = $model_date;
		// 	$parent_lang->published_time = $model_time;
		// 	return $parent_lang;

		// }
		// return null;
		
		if(null != $parent_lang = $this->model->where('parent_lang_id', $id)->first()){
			// $news_date = date('m/d/Y' ,strtotime($parent_lang->created_at));
			// $news_time = date('g:i A' ,strtotime($parent_lang->created_at));
			// $parent_lang->published_date = $news_date;
			// $parent_lang->published_time = $news_time;
			return $parent_lang;
		}
		return $this->model->find($id);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update( $id, $inputs )
	{
		return $this->getById($id)->update($inputs);
	}



	public function getMaxOrderNumber($inputs = null)
	{
		if($inputs){
			$inputs['order'] = $this->model->max('order') + 1;
			return $inputs;
		}else{
			return $this->model->max('order') + 1;
		}

	}


	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy( $id )
	{	
		$model = $this->getById($id);
		// $model->categories()->detach();
		return $model->delete();
	}

	/**
	* Filtering and checking the data before store
	*
	* @param  int  $id
	* @return Response
	*/
	private function createInputs( $inputs)
	{
		
		$inputs['slug'] = getUniqueSlug($this->model, $inputs['title']);
		$inputs['meta-title'] =  isset($inputs['meta-title']) ? $inputs['meta-title'] : $inputs['title'];

		return $inputs;
	}

	/**
	* Filtering and checking the data before update
	*
	* @param  int  $id
	* @return Response
	*/
	private function updateInputs( $id, $inputs )
	{
		$date  = $inputs['published_date'].' '.$inputs['published_time'];
		$published_full_date = date('Y-m-d H:i:s', strtotime($date));
		if($published_full_date){
			$inputs['created_at'] = $published_full_date;
		}
		if($this->getById($id)->slug !=  $inputs['slug']){
			$inputs['slug'] = getUniqueSlug($this->model, $inputs['slug'], $id);
		}
		$inputs['meta-title'] =  isset($inputs['meta-title']) ? $inputs['meta-title'] : $inputs['title'];
		// if(isset($inputs['thumbnail'])){
		// 	$inputs['thumbnail'] = isset($inputs['thumbnail']) ? $this->uploadImage(request()->file('thumbnail')) : null;
		// }
		return $inputs;
	}

	private function uploadImage( $image ){
		if($image) {
			$filename  = time() . '.' . $image->getClientOriginalExtension();

			$path = public_path('images/model/' . $filename);

			// Image::make($image->getRealPath())->resize(200, 200)->save($path);
			Image::make($image->getRealPath())->save($path);
			// dd($filename);
			return $filename;
        }
	}
}