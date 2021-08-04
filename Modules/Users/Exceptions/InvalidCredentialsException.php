<?php

namespace Modules\Users\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvalidCredentialsException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('The user was not found.');
    }
}