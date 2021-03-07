<?php

namespace App\Helpers\Log;

use Dotenv\Exception\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IgnoreException {

    public static function ignoreExeption($exp)
    {
        if ($exp instanceof ValidationException) {
            return true;
        } else if ($exp instanceof NotFoundHttpException) {
            return true;
        } else if ($exp instanceof AuthenticationException) {
            return true;
        } else if ($exp instanceof MethodNotAllowedHttpException) {
            return true;
        }

        return false;
    }
}

?>
