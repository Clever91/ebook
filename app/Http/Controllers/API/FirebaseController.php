<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Models\CustomerDevice;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class FirebaseController extends BaseController
{
    private $auth;

    public function __construct()
    {
        // $auth = app('firebase.auth');
        $factory = (new Factory)->withServiceAccount(base_path() . '/firebase_credentials.json');
        $this->auth = $factory->createAuth();
    }

    public function index(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;
            
        $uid = $request->input("uid", null);
        if (!$uid) {
            return $this->sendError('Auth Error', ['error' => 'uid is not found'], 400);
        }

        $success = [];
        $user = $this->auth->getUser($uid);

        if ($user) {
            $customer = Customer::where('uid', $user->uid)->first();

            if (is_null($customer)) {
                // create customer
                $customer = Customer::create([
                    'uid' => $user->uid,
                    'email' => $user->email,
                    'photo_url' => $user->photoUrl,
                    'phone_number' => $user->phoneNumber,
                    'display_name' => $user->displayName,
                    'status' => Customer::STATUS_ACTIVE,
                ]);
            }

            if (!$customer->isActive()) {
                return $this->sendError('Auth Error', ['error' => 'This user is not active'], 403);
            }

            // save device
            if (!is_null($this->_device)) {
                $custDevice = CustomerDevice::where([
                    'customer_id' => $customer->id,
                    'device_id' => $this->_device->id
                ])->first();

                if (is_null($custDevice)) {
                    $custDevice = CustomerDevice::create([
                        'customer_id' => $customer->id,
                        'device_id' => $this->_device->id
                    ]);
                }
            }

            $customer->updateApiToken();

            $success["uid"] = $user->uid;
            $success["user_id"] = $customer->id;
            $success["access_token"] = $customer->getApiToken();
        }

        return $this->sendResponse($success, null);
    }

    public function singIn(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        $email = $request->input("email");
        if (!$email) 
            return $this->sendError('Auth Error', ['error' => 'email must not be empty'], 400);

        $password = $request->input("password");
        if (!$password)
            return $this->sendError('Auth Error', ['error' => 'password must not be empty'], 400);

        $this->auth->signInWithEmailAndPassword($email, $password);
        $user = $this->auth->getUserByEmail($email);

        return $this->sendResponse($user, null);
    }

    public function singUp(Request $request)
    {
        if (($error = $this->authDevice($request)) !== true)
            return $error;

        // $email = $request->input("email");
        // if (!$email) 
        //     return $this->sendError('Auth Error', ['error' => 'email must not be empty'], 400);

        // $password = $request->input("password");
        // if (!$password)
        //     return $this->sendError('Auth Error', ['error' => 'password must not be empty'], 400);

        // $phone = $request->input("phone", null);
        // $name = $request->input("name", null);

        // $userProperties = [
        //     'email' => $email,
        //     'emailVerified' => false,
        //     'phoneNumber' => $phone,
        //     'password' => $password,
        //     'displayName' => $name,
        //     'photoUrl' => null,
        //     'disabled' => false,
        // ];
        
        // $createdUser = $this->auth->createUser($userProperties);
        $createdUser = $this->auth->createUser($request);

        return $this->sendResponse($createdUser, null);
    }
}
