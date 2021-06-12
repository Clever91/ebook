<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Lunaweb\Localization\Facades\Localization;

class BaseController extends Controller
{
    protected $_lang = "uz";
    protected $_limit = 20;

    public function __construct(Request $request)
    {
        // set language
        if (Localization::isLocalizedRoute()) {
            $lang = $request->route()->getLocalization();
            if (!is_null($lang))
                $this->_lang = $lang;

            App::setLocale($this->_lang);
        }
    }
}
