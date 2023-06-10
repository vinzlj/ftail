<?php

declare(strict_types=1);

namespace FTail\Decoder;

use FTail\Logs\Level;
use FTail\Logs\LogRecord;

final class JsonDecoder implements Decoder
{
    public function decode(string $logLine): LogRecord
    {
        $line = json_decode($logLine, true, 512, JSON_THROW_ON_ERROR);

        return new LogRecord(
            \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.uP', $line['datetime']),
            $line['channel'],
            Level::fromValue($line['level']),
            $line['message'],
            $line['context'],
            $line['extra'],
        );
    }
}
