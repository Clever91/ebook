<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Lunaweb\Localization\Facades\Localization;

class BaseController extends Controller
{
    protected $_lang = "en";
    protected $_limit = 15;

    public function __construct(Request $request)
    {
        // set language
        if (Localization::isLocalizedRoute()) {
            // dd($request->route()); // is null
            $lang = $request->route()->getLocalization();
            if (!is_null($lang))
                $this->_lang = $lang;
    
            App::setLocale($this->_lang);
        }

        // set page limit
        if (env("APP_PAGELIMIT")) {
            $this->_limit = (int) env("APP_PAGELIMIT"); 
        }
    }
}
