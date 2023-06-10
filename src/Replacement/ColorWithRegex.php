<?php

declare(strict_types=1);

namespace FTail\Replacement;

final class ColorWithRegex extends BaseReplacement
{
    public function replace(): string
    {
        [$className, $methodName] = explode('::', $this->configuration['color']);

        return call_user_func([$className, $methodName])->applyWithRegex(
            $this->configuration['regex'],
            $this->configuration['replaceBy'],
            $this->record->message,
        );
    }
}
