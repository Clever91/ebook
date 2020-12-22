<?php

namespace App\Http\Controllers\Bot;

use App\Helpers\Log\TelegramLog;
use App\Http\Controllers\Controller;

class PaymeController extends Controller
{
    public function complete()
    {
        if (request()->isMethod('post')) {
            $data = request()->all();
            TelegramLog::log($data);
        }

        return redirect('login');
    }

}
