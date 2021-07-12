<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Admin\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DeviceController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'model' => 'required',
            'type' => 'required|in:I,A,D',
            'os_version' => 'required',
            'app_version' => 'required',
        ];

        $deviceId = null;
        $rules['uuid'] = 'required|unique:devices';
        if ($request->has("device_id")) {
            $deviceId = $request->input("device_id");
            $rules['uuid'] = [
                'required',
                Rule::unique("devices")->ignore($deviceId)
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $input = $request->all();
        if (!is_null($deviceId)) {
            unset($input["uuid"]);
            $device = Device::findOrFail($deviceId);
        }

        $input['status'] = Device::STATUS_ACTIVE;
        $input['token'] = Str::random(32);
        if (is_null($deviceId)) {
            $device = Device::create($input);
            $message = 'Device has registered successfully';
        }
        else {
            $device->update($input);
            $message = 'Device has updated successfully';
        }

        $success['token'] = $device->token;
        $success['name'] = $device->name;
        $success['device_id'] = $device->id;

        return $this->sendResponse($success, $message);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'uuid' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'token' => $request->input('token'),
            'uuid' => $request->input('uuid'),
        ])->first();

        if (!is_null($device)) {
            $success['token'] =  $device->token;
            $success['name'] =  $device->name;

            return $this->sendResponse($success, 'This device has exists in server');
        }
        else {
            return $this->sendError('Device Error', ['error'=>'This token does not exists'], 403);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'uuid' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'token' => $request->input('token'),
            'uuid' => $request->input('uuid'),
        ])->first();

        if (!is_null($device)) {
            $device->makeNotActive();

            $success['token'] =  $device->token;
            $success['name'] =  $device->name;

            return $this->sendResponse($success, 'This device has deleted successfully');
        }
        else {
            return $this->sendError('Device Error', ['error'=>'This token does not exists'], 403);
        }
    }

    public function languages(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $success['languages'] = config('translatable.locales');

        return $this->sendResponse($success, null);
    }
}
