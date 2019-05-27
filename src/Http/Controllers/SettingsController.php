<?php

namespace Codeman\Admin\Http\Controllers;

use Codeman\Admin\Models\Language;
use Illuminate\Http\Request;
use Codeman\Admin\Models\Setting;
use Codeman\Admin\Models\Page;


class SettingsController extends Controller
{
    /**
     * Run constructor
     *
     * @return Response
     */
    public function __construct(Setting $setting)
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
        $settings = $this->settings->pluck('value', 'key');
        $pages = Page::where('lang', 'en')->pluck('title','id');
        $languages = Language::pluck('name', 'id');
//        dd($settings);

        foreach ($settings as $key => $value) {

            if(isJson($value)) {
                $settings[$key] = json_decode($value);
            }
        }

        return view('admin-panel::setting.index', ['settings' => $settings, 'pages'=> $pages, 'languages'=> $languages ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createOrUpdate(Request $request)
    {
//        dd($request->all());
        if($request->site_name == null){
            $request['site_name']  = env('APP_NAME');
        }
        if($request->has('default_lang')){
            config(['app.locale' => Language::where('id', $request->default_lang)->first()->code]);
            $min = 0;
            Language::where('id', $request->default_lang)
                ->update(['order' => $min]);
            $others = Language::where('id', '!=', $request->default_lang)->get();
            $min++;
            foreach($others as $lang){
                $lang->update(['order' => $min]);
                $min++;
            }

        }

        // $index = $request->home_page;
        if($request->has('_token')){
            unset($request['_token']);

            foreach ($request->all() as $key => $value) {
                if(is_array($value)) {
                    // dd($request->all());
                    $value = json_encode($value);
                }
//                 dd($key, $value);
                $this->settings->updateOrCreate(['key' => $key], ['key' => $key, 'value' => $value]);
            }

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
