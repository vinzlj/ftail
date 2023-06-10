<?php

declare(strict_types=1);

namespace FTail\Formatter\Helper;

final class ArrayFormatter
{
    public static function format(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
