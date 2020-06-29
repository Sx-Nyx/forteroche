<?php

namespace Framework\Session;

abstract class Session
{
    /**
     * @param string $key
     * @param $value
     */
    public static function set(string $key, $value): void
    {
        self::ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return bool|mixed
     */
    public static function get(string $key)
    {
        self::ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return false;
    }

    public static function delete(string $key): void
    {
        self::ensureStarted();
        unset($_SESSION[$key]);
    }

    private static function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
