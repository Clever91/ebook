<?php

namespace App\Http\Controllers\Bot;

use App\Helpers\Common\ClickHelper;
use App\Http\Controllers\Controller;

class ClickController extends Controller
{
    public function prepare()
    {
        if (request()->isMethod('post')) {
            return ClickHelper::run();
        }

        return redirect('login');
    }

    public function complete()
    {
        if (request()->isMethod('post')) {
            return ClickHelper::run();
        }

        return redirect('login');
    }

}
