<?php

declare(strict_types=1);

namespace FTail\Formatter;

use Doctrine\SqlFormatter\SqlFormatter;
use FTail\Formatter\Helper\ArrayFormatter;
use FTail\Formatter\Helper\Color;
use FTail\Logs\Level;
use FTail\Logs\LogRecord;

final class ColoredFormatter implements Formatter
{
    protected const LEVEL_COLORS = [
        Level::DEBUG_VALUE => Color::LIGHT_BLUE,
        Level::INFO_VALUE => Color::LIGHT_BLUE,
        Level::NOTICE_VALUE => Color::LIGHT_BLUE,
        Level::WARNING_VALUE => Color::LIGHT_YELLOW,
        Level::ERROR_VALUE => Color::LIGHT_RED,
        Level::CRITICAL_VALUE => Color::RED,
        Level::ALERT_VALUE => Color::RED,
        Level::EMERGENCY_VALUE => Color::RED,
    ];

    public function formatLog(LogRecord $record, bool $prettyPrint = false): string
    {
        $message = $record->message;

        if ($prettyPrint && $record->channel === 'doctrine') {
            $message = (new SqlFormatter())->format($message);
        }

        return sprintf(
            "[%s] [%s.%s] %s%s%s%s%s",
            Color::lightCyan()->applyTo($record->datetime->format('H:i:s')),
            Color::lightGreen()->applyTo($record->channel),
            Color::fromString(self::LEVEL_COLORS[$record->level->value])->applyTo($record->level->name),
            $message,
            !empty($record->context) ? PHP_EOL : '',
            !empty($record->context) ? Color::lightBlack()->applyTo(ArrayFormatter::format($record->context, $prettyPrint)) : '',
            !empty($record->extra) ? PHP_EOL : '',
            !empty($record->extra) ? Color::lightWhite()->applyTo(ArrayFormatter::format($record->extra, $prettyPrint)) : '',
        );
    }
}
