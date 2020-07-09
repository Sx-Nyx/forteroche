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
