<?php

declare(strict_types=1);

namespace FTail\Configuration;

use FTail\Decoder\Decoder;
use FTail\Formatter\Formatter;
use FTail\Reader\Reader;
use Symfony\Component\ExpressionLanguage\Expression;

final class Configuration
{
    public function __construct(
        private Reader $reader,
        private Decoder $decoder,
        private Formatter $formatter,
        /** @param Expression[] $exclusions */
        private iterable $exclusions,
        /** @param Expression[] $replacements */
        private iterable $replacements,
    ) {
    }

    public function getReader(): Reader
    {
        return $this->reader;
    }

    public function getDecoder(): Decoder
    {
        return $this->decoder;
    }

    public function getFormatter(): Formatter
    {
        return $this->formatter;
    }

    public function getExclusions(): iterable
    {
        return $this->exclusions;
    }

    public function getReplacements(): iterable
    {
        return $this->replacements;
    }
}
