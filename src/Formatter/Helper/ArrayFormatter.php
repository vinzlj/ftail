<?php

declare(strict_types=1);

namespace FTail\Formatter\Helper;

final class ArrayFormatter
{
    public static function format(array $data, bool $pretty = false): string
    {
        $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

        if ($pretty) {
            $flags |= JSON_PRETTY_PRINT;
        }

        return json_encode($data, $flags);
    }
}
