<?php

namespace Framework\Session;

class FlashMessage
{
    /**
     * @param string $message
     */
    public static function success(string $message): void
    {
        Session::set('success', $message);
    }

    /**
     * @param string $error
     */
    public static function error(string $error): void
    {
        Session::set('error', $error);
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function haveFlash(string $type):bool
    {
        if (Session::get($type) === false) {
            return false;
        }
        return true;
    }

    /**
     * @param string $type
     * @return string|null
     */
    public static function get(string $type): ?string
    {
        if (Session::get($type)) {
            $session = Session::get($type);
            Session::delete($type);
            return $session;
        }
        return null;
    }

}
