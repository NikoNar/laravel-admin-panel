<?php

namespace Codeman\Admin\Services;

use Codeman\Admin\Interfaces\CrudInterface;
use Codeman\Admin\Models\BaseModel;
use Codeman\Admin\Models\Language;
use Codeman\Admin\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Image;
use Illuminate\Support\Str;

class CRUDService implements CrudInterface
{
	/**
	 * The object of model class.
	 *
	 * @var model
	 */
	protected $model;
	protected $default_language;

	/**
	 * model constructor.
	 *
	 * @param  model 
	 */
	public function __construct($model)
	{
		$this->model = $model;
		$this->default_language = Language::orderBy('order')->first();
	}

	/**
	* Select all resources from storage.
	*
	* @return Object
	*/
	public function getAll()
	{
		// dd($this->model->orderBy('order', 'DESC')->where('lang','en')->paginate(10));
		return $this->model->orderBy('order', 'DESC')->where('language_id',$this->default_language->id)->paginate(10);
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

	public function createOrEditTranslation( $id, $lang )
	{

        $model= str_singular($this->model->getTable());
        $page = $this->model->where(['id' => $id, 'language_id' => $lang])->orWhere(['id' => $id])->first();

        if(!$page){
            return ['status' => 'redirect', 'route' => route($model.'-create', $lang) ];
        }

        if($page->language_id != $lang && isset($page->parent_lang_id)){

            $parent_page = $this->model->where(['id' => $page->parent_lang_id, 'language_id' => $lang])->first();

            if($parent_page){
                return ['status' => 'redirect', 'route' => route($model.'-edit', $parent_page->id)];
            }else if(null != $trans_page = $this->model->where(['parent_lang_id' => $page->parent_lang_id, 'language_id' => $lang])->first()){
                return ['status' => 'redirect', 'route' => route($model.'-edit', $trans_page->id)];
            }else{
                $trans_page = $this->model->where('id', $page->parent_lang_id)->first();
                $trans_page['language_id'] = $lang;
                return $trans_page;
            }


        } else if($page->language_id != $lang && !isset($page->parent_lang_id)) {
            $parent_page = $this->model->where(['parent_lang_id' => $page->id, 'language_id' => $lang])->first();
            if($parent_page ){
                return ['status' => 'redirect', 'route' => route($model.'-edit', $parent_page->id)];
            }
            $page['language_id'] = $lang;
            return $page;
        }else{
            $page['language_id'] = $lang;
            return $page;
        }

		// if(null != $parent_lang = $this->model->where('parent_lang_id', $id)->first()){
		// 	$model_date = date('m/d/Y' ,strtotime($parent_lang->created_at));
		// 	$model_time = date('g:i A' ,strtotime($parent_lang->created_at));
		// 	$parent_lang->published_date = $model_date;
		// 	$parent_lang->published_time = $model_time;
		// 	return $parent_lang;

		// }
		// return null;
		
//		if(null != $parent_lang = $this->model->where('parent_lang_id', $id)->first()){
//			// $news_date = date('m/d/Y' ,strtotime($parent_lang->created_at));
//			// $news_time = date('g:i A' ,strtotime($parent_lang->created_at));
//			// $parent_lang->published_date = $news_date;
//			// $parent_lang->published_time = $news_time;
//			return $parent_lang;
//		}
        $resourse = $this->model->find($id);
        $resourse['language_id'] = $lang;

        return $resourse;


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

        if(array_key_exists('slug', $inputs)){
            $inputs['slug'] = getUniqueSlug($this->model, $inputs['slug']);
        } else {
            $inputs['slug'] = getUniqueSlug($this->model, $inputs['title']);
        }

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