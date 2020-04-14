<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    protected $_page = 0;
    protected $_limit = 15;
    protected $_offset = 0;
    protected $_text = null;
    protected $_device = null;

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
        $this->_device = Device::where([
            'status' => Device::STATUS_ACTIVE,
            'token' => $request->input('token'),
        ])->first();
        
        if (is_null($this->_device))
            return $this->sendError('Device Error', ['error' => 'This token does not exists'], 403);
            
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
