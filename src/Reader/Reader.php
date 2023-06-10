<?php

namespace FTail\Reader;

interface Reader
{
    public function open(?string $filePath = null): void;

    public function hasReachedEnd(): bool;

    public function readLine(): string;

    public function close(): void;
}
