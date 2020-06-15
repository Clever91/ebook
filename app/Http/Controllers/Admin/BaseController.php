<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    protected $_locale = "en";
    protected $_limit = 15;

    public function __construct(Request $request)
    {
        // set language
        $locale = $request->has("locale");
        if ($locale) {
            if (!in_array($locale, config('translatable.locales'))) {
                $this->_locale = $locale;
            }
        }

        App::setLocale($this->_locale);

        // set page limit
        if (env("APP_PAGELIMIT")) {
            $this->_limit = (int) env("APP_PAGELIMIT"); 
        }
    }
}
