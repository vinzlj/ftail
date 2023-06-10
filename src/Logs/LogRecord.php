<?php

declare(strict_types=1);

namespace FTail\Logs;

final class LogRecord
{
    public function __construct(
        public \DateTimeImmutable $datetime,
        public string $channel,
        public Level $level,
        public string $message,
        public array $context = [],
        public array $extra = [],
    ) {
    }
}
