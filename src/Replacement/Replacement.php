<?php

namespace FTail\Replacement;

interface Replacement
{
    public function getWhen(): string;

    public function replace(): string;
}
