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
     * @param array $errors
     */
    public static function errors(array $errors): void
    {
        Session::set('errors', $errors);
    }

    /**
     * @param string $type
     * @return bool|mixed
     */
    public static function get(string $type)
    {
        return Session::get($type);
    }
}
