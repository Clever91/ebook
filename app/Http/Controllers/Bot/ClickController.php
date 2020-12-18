<?php

namespace App\Http\Controllers\Bot;

use App\Helpers\Common\ClickHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ClickController extends Controller
{
    public function prepare()
    {
        if (request()->isMethod('post')) {
            return ClickHelper::run();
        }

        // success payed
        if (request()->isMethod('get'))
            return redirect()->route('click.success');

        return redirect('login');
    }

    public function complete()
    {
        if (request()->isMethod('post')) {
            return ClickHelper::run();
        }
        
        // success payed
        if (request()->isMethod('get'))
            return redirect()->route('click.success');

        return redirect('login');
    }

    public function success()
    {
        $url = "https://t.me/" . env('TELEGRAM_BOT_USERNAME');
        return view('click.success')->with('url', $url);
    }
}
