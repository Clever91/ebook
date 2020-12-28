<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Setting;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function store(Request $request)
    {
        $rules = Setting::getValidationRules();
        $data = $this->validate($request, $rules);

        $validSettings = array_keys($rules);
        // dd($data, $validSettings);
        foreach ($validSettings as $key) {
            if (in_array($key, array_keys($data))) {
                Setting::add($key, $data[$key], Setting::getDataType($key));
            } else if (in_array($key, $this->getPayments())) {
                Setting::add($key, "off", Setting::getDataType($key));
            }
        }

        Session::flash('status', 'Параметры настройки успешно сохранены');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin.settings');
    }

    private function getPayments()
    {
        return ['payme', 'click', 'telegram'];
    }
}
