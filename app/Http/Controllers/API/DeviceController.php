<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DeviceController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'os' => 'required',
            'version' => 'required',
            'uuid' => 'required|unique:devices'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error:', $validator->errors());       
        }

        $input = $request->all();
        $input['status'] = Device::STATUS_ACTIVE;
        $input['token'] = Str::random(32);
        $device = Device::create($input);

        $success['token'] = $device->token;
        $success['name'] = $device->name;
   
        return $this->sendResponse($success, 'Device has registered successfully');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'uuid' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());       
        }

        $device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'token' => $request->input('token'),
            'uuid' => $request->input('uuid'),
        ])->first();

        if (!is_null($device)) {
            $success['token'] =  $device->token; 
            $success['name'] =  $device->name;

            return $this->sendResponse($success, 'Device has logined successfully');
        } 
        else { 
            return $this->sendError('Device Error', ['error'=>'This token does not exists']);
        } 
    }

    public function languages(Request $request)
    {
        $device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'token' => $request->input('token'),
        ])->first();
        
        if (is_null($device))
            return $this->sendError('Device Error', ['error'=>'This token does not exists']); 

        $success['languages'] = config('translatable.locales');
    
        return $this->sendResponse($success, null);
    }
}
