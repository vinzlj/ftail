<?php

namespace FTail\Formatter;

use FTail\Logs\LogRecord;

interface Formatter
{
    /**
     * @info How to format the entire LogRecord
     */
    public function formatLog(LogRecord $record): string;
}
