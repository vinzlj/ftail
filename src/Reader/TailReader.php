<?php

declare(strict_types=1);

namespace FTail\Reader;

final class TailReader implements Reader
{
    /** @var resource */
    private $process;

    public function open(?string $filePath = null): void
    {
        $this->process = popen(sprintf('tail -f %s 2>&1', $filePath), 'r');
    }

    public function hasReachedEnd(): bool
    {
        return feof($this->process);
    }

    public function readLine(): string
    {
        return fgets($this->process);
    }

    public function close(): void
    {
        pclose($this->process);
    }
}
