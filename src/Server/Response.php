<?php

namespace Framework\Server;

abstract class Response
{
    /**
     * @param string $url
     */
    public static function redirection(string $url): void
    {
        header('Location: ' . $url);
        exit();
    }
}
