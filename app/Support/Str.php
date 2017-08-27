<?php

namespace App\Support;

class Str
{
    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int     $limit
     * @param  string  $end
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        $str = rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8'));
        return tidy_repair_string($str, [], 'UTF8').$end;
    }
}