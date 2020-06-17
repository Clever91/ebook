<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function index(Request $request, $lang)
    {
        if (!in_array($lang, config('translatable.locales'))) {
            abort(400);
        }

        // session('locale', $lang);
        App::setLocale($lang);

        return back();
    }
}
