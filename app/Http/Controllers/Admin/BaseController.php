<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    private $_locale = "en";

    public function __construct(Request $request)
    {
        $locale = $request->has("locale");
        if ($locale) {
            if (!in_array($locale, config('translatable.locales'))) {
                $this->_locale = $locale;
            }
        }

        App::setLocale($this->_locale);
    }
}
