<?php

namespace App\Http\Controllers\Bot;

use App\Helpers\Common\PaymeHelper;
use App\Http\Controllers\Controller;

class PaymeController extends Controller
{
    public function complete()
    {
        if (request()->isMethod('post')) {
            return PaymeHelper::run();
        }

        return redirect('login');
    }

}
