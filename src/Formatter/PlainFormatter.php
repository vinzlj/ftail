<?php

declare(strict_types=1);

namespace FTail\Formatter;

use FTail\Formatter\Helper\ArrayFormatter;
use FTail\Logs\LogRecord;

final class PlainFormatter implements Formatter
{
    public function formatLog(LogRecord $record): string
    {
        return sprintf(
            "[%s] [%s.%s] %s%s%s%s%s",
            $record->datetime->format('Y-m-d H:i:s'),
            $record->channel,
            $record->level->name,
            $record->message,
            !empty($record->context) ? PHP_EOL : '',
            !empty($record->context) ? ArrayFormatter::format($record->context) : '',
            !empty($record->extra) ? PHP_EOL : '',
            !empty($record->extra) ? ArrayFormatter::format($record->extra) : '',
        );
    }
}
