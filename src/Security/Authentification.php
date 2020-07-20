<?php

namespace Framework\Security;

use Framework\Security\Exception\ForbiddenException;
use Framework\Session\Session;

class Authentification
{
    public static function verify()
    {
        if (Session::get('auth') === false) {
            throw new ForbiddenException();
        }
    }
}
