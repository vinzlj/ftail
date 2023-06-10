<?php

namespace FTail\Decoder;

use FTail\Logs\LogRecord;

interface Decoder
{
    public function decode(string $logLine): LogRecord;
}
