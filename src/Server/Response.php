<?php

namespace Framework\Server;

abstract class Response
{
    /**
     * @param string $url
     * @param int $code
     */
    public static function redirection(string $url, int $code = 301): void
    {
        header('Location: ' . $url, $code);
        exit();
    }
}
