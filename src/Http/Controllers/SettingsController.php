<?php

namespace Codeman\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Models\Setting;
use Settings;

class SettingsController extends Controller
{
    /**
       * Run constructor
       *
       * @return Response
       */
    public function __construct(Settings $setting)
    {
    	$this->middleware('admin');
    	$this->settings =  $setting;
    }

    /**
       * Display a listing of the resource.
       *
       * @return Response
       */
    public function index()
    {
    	$settings = $this->settings::getAll();

    	$settings['social_icon_url'] = json_decode($settings['social_icon_url']);
    	$settings['social_icon_name'] = json_decode($settings['social_icon_name']);
    	
    	return view('admin.setting.index', ['settings' => $settings]);
    }

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function createOrUpdate(Request $request)
	{	

    	foreach ($request->all() as $key => $value) {
            if($key == 'download_program_file_name' && !$request->hasFile('download_program')){
                $key = 'download_program';
                if($value == null){
                    $fileForDelete = $this->settings::get($key);
                    $this->removeFile($fileForDelete);
                }
            }
            if($key == 'download_program'){
                if($request->hasFile('download_program')){
                    $fileForDelete = $this->settings::get($key);
                    $this->removeFile($fileForDelete);
                    $value = $this->uploadDownloadableFile($request->file('download_program'));
                }
            }
    		if(isset($value) && !empty($value) && is_array($value)) {
    			$value = json_encode($value);
    		}
    		$this->settings::set($key, $value);
    	}
    	return redirect()->back()->with('success', 'Settings Successfully Updated.');
	}

    private function uploadDownloadableFile( $file )
    {
        $filename = preg_replace('/\..+$/', '', $file->getClientOriginalName());
        $filename = \Illuminate\Support\Str::slug($filename);

        $filename = $filename.'-'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('files/program/') , $filename );

        return $filename;
    }

    private function removeFile($filename)
    {
        if(\File::exists(public_path('files/program/'.$filename))){

            \File::delete(public_path('files/program/'.$filename));

        }
    }
}
