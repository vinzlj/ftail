<?php

declare(strict_types=1);

namespace FTail\Replacement;

use FTail\Logs\LogRecord;

class BaseReplacement implements Replacement
{
    public function __construct(
        protected LogRecord $record,
        protected array $configuration,
    ) {
    }

    public function getWhen(): string
    {
        return $this->configuration['when'];
    }

    public function replace(): string
    {
        return $this->configuration['replaceBy'];
    }
}
