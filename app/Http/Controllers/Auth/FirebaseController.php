<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Firebase\Auth\Token\Exception\InvalidToken;

class FirebaseController extends Controller
{
    public function index()
    {
        // $auth = app('firebase.auth');
        $factory = (new Factory)->withServiceAccount(base_path() . '/firebase_credentials.json');

        $database = $factory->createDatabase();
        $reference = $database->getReference('Users');
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        dd($value);
    }

    public function create()
    {
        // $auth = app('firebase.auth');
        $factory = (new Factory)->withServiceAccount(base_path() . '/firebase_credentials.json');

        $auth = $factory->createAuth();

        // $uid = 'first-uid';
        // $customToken = $auth->createCustomToken($uid);

        // dd((string) $customToken);

        $email = "sherzod.usmon.91@gmail.com";
        $clearTextPassword = "usmon91";
        $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
        dd($signInResult->asTokenResponse());
    }

    public function check()
    {
        // $auth = app('firebase.auth');
        $factory = (new Factory)->withServiceAccount(base_path() . '/firebase_credentials.json');

        $auth = $factory->createAuth();

        // $email = "sherzod.usmon.91@gmail.com";
        // $clearTextPassword = "usmon91";
        // $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);

        $customToken = "eyJhbGciOiJSUzI1NiIsImtpZCI6ImRjMGMzNWZlYjBjODIzYjQyNzdkZDBhYjIwNDQzMDY5ZGYzMGZkZWEiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vZWJvb2stMjdmMDEiLCJhdWQiOiJlYm9vay0yN2YwMSIsImF1dGhfdGltZSI6MTU4NjgwOTM5OCwidXNlcl9pZCI6Ikp2anpuWlRMQlBYZ2tSQko5VWtPWkNTV1gydDEiLCJzdWIiOiJKdmp6blpUTEJQWGdrUkJKOVVrT1pDU1dYMnQxIiwiaWF0IjoxNTg2ODA5Mzk4LCJleHAiOjE1ODY4MTI5OTgsImVtYWlsIjoic2hlcnpvZC51c21vbi45MUBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsImZpcmViYXNlIjp7ImlkZW50aXRpZXMiOnsiZW1haWwiOlsic2hlcnpvZC51c21vbi45MUBnbWFpbC5jb20iXX0sInNpZ25faW5fcHJvdmlkZXIiOiJwYXNzd29yZCJ9fQ.HqnXyn5Tsr3qIji7jxeF2WSen2SQR8z_MsNp4HjdMS7wB14hDBQs2auFBDSZ5bJEmQuheC01qsalg0hg2bAYaPoFa5nfW-qHDdWQ5jcF_BSQlsnt6BUvQhoQstZN-hHJYHkrmaLYvnnOLm-GPHLtUJhpRYYQzTYQxwt3G4dvYGUCMaUIiJKztRZb4u5xbczS53mZpyb_YxHYWTNW8_oBVNXvZOdIoXFPzyFYKzL6UMIMA8IIvGS2Eudo4HnsOz2nyME55DVoVXIKGXMmxmlyyMlXoEmKgpTWsKRHeaJZYtb15EfufbhU2kVoNOmZ4JvcAnXdbE6m35n7SZAeBldXZQ";
        $signInResult = $auth->signInWithCustomToken($customToken);
        dd($signInResult->asTokenResponse());

        // $idTokenString = 'JvjznZTLBPXgkRBJ9UkOZCSWX2t1';

        // try {
        //     $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        // } catch (\InvalidArgumentException $e) {
        //     echo 'The token could not be parsed: '.$e->getMessage(); die;
        // } catch (InvalidToken $e) {
        //     echo 'The token is invalid: '.$e->getMessage(); die;
        // }

        // $uid = $verifiedIdToken->getClaim('sub');
        // $user = $auth->getUser($uid);

        // dd($user);
    }

    public function success(Request $request) 
    {
        return $request->all();
    }

}
