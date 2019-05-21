<?php

namespace Codeman\Admin\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguagesController extends Controller
{
    public function changeLanguage($lang = 'hy')
    {
        $previous_url = url()->previous();
        $previous_url = explode('/', $previous_url);
        $base_url = url()->to('/');
        $base_url = explode('/', $base_url);

        foreach ($base_url as $key => $value) {
            unset($previous_url[$key]);
        }
        $next_url = [];
        foreach ($previous_url as $key => $value) {
            $next_url[] = $value;
        }
        if($next_url[0] == 'hy' || $next_url[0] == 'en' || $next_url[0] == 'ru'){
            unset($next_url[0]);
        }
        $next_request = implode('/', $next_url);
        session()->put('lang', $lang);
        LaravelLocalization::setLocale($lang);

        if($lang == 'en' )
        {
            return redirect()->to($next_request);
        }
        return redirect()->to('/'.$lang.'/'.$next_request);

    }
}
