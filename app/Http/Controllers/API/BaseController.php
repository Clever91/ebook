<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use App\Models\Admin\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    protected $_page = 0;
    protected $_limit = 15;
    protected $_offset = 0;
    protected $_text = null;
    protected $_device = null;
    protected $_customer = null;

    public function __construct(Request $request)
    {
        // this is for search
        if ($request->has("text")) {
            $this->_text = $request->input("text");
            $this->_text = trim($this->_text);
            if (empty($this->_text))
                $this->_text = null;
        }

        // check page exists
        if ($request->has("page")) {
            $this->_page = (int) $request->input("page");
            if ($this->_page < 0)
                $this->_page = 0;
        }

        // check limit exists
        if ($request->has("limit")) {
            $this->_limit = (int) $request->input("limit");
            if ($this->_limit < 0)
                $this->_limit = 15;
        }

        // get offset
        $this->_offset = $this->_page * $this->_limit;

        // get language
        $this->_lang = $request->input('lang');
        if (is_null($this->_lang))
            $this->_lang = config('app.locale');

        // set language
        App::setLocale($this->_lang);
    }

    public function authDevice($request)
    {
        // access auth with access_token
        if ($request->has('access_token')) {

            // first check with api token
            $this->authApiDevice($request);

            // secand, check customer
            $this->authCustomer($request);

            return true;
        }

        // else check token for device
        $this->_device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'token' => $request->input('token'),
        ])->first();

        if (is_null($this->_device))
            return $this->sendError('Device Error', ['error' => 'This token does not exists'], 403);

        return true;
    }

    public function authApiDevice($request)
    {
        $access_token = null;
        if ($request->has('access_token'))
            $access_token = trim($request->input('access_token'));

        if (empty($access_token) || is_null($access_token))
            return $this->sendError('Device Error', ['error' => 'This access token must not empty'], 403);

        $this->_device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'api_token' => $request->input('access_token'),
        ])->first();

        if (is_null($this->_device))
            return $this->sendError('Device Error', ['error' => 'This access token does not exists'], 403);

        return true;
    }

    public function authCustomer($request)
    {
        $this->_customer = Customer::find($request->input('user_id'));

        if (is_null($this->_customer))
            return $this->sendError('User Error', ['error' => 'This user does not found'], 403);

        if (!$this->_customer->isActive())
            return $this->sendError('User Error', ['error' => 'This user is not active'], 403);

        return true;
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
