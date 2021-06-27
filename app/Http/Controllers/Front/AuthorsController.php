<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Common\GlobalFunc;
use App\Http\Controllers\Front\BaseController;
use App\Models\Admin\Author;
use App\Models\Helpers\Base;
use Illuminate\Http\Request;

class AuthorsController extends BaseController
{
    public function index(Request $request)
    {
        $models = Author::where([
            'status' => Base::STATUS_ACTIVE,
            'deleted' => Base::NO_DELETED,
        ])->get();

        $alphabets = [];
        foreach($models as $author) {
            $alps = $author->getFirstAlphabets();
            if (empty($alps))
                continue;
            $alphabets = array_merge($alphabets, $alps);
        }
        sort($alphabets);
        $alphabets = array_filter($alphabets, fn($value) => !is_null($value) && trim($value) !== '');

        $lang = $this->_lang;
        return view('front.authors.index', [
            'models' => $models,
            'alphabets' => $alphabets,
            'lang' => $lang,
        ]);
    }
}
