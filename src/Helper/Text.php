<?php

namespace Framework\Helper;

class Text
{
    /**
     * @param string $content
     * @param int $limit
     * @return string
     */
    public static function excerpt(string $content, int $limit = 100)
    {
        if (mb_strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . ' ... Lire la suite';
    }
}
