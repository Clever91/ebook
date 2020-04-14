<?php

namespace App\Http\Controllers\API;

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
            $success["uid"] = $user->uid;
            $success["email"] = $user->email;

            // create user

            // return user_id
        }

        return $this->sendResponse($success, null);
    }

    public function create(Request $request)
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

        $success = [];
        if ($user) {
            $success["uid"] = $user->uid;
            $success["email"] = $user->email;
        }

        return $this->sendResponse($success, null);
    }
}
