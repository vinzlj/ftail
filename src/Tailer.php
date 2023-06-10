<?php

declare(strict_types=1);

namespace FTail;

use FTail\Decoder\Decoder;
use FTail\Formatter\Formatter;
use FTail\Configuration\Configuration;
use FTail\Logs\Level;
use FTail\Reader\Reader;
use FTail\Replacement\BaseReplacement;
use FTail\Replacement\Replacement;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class Tailer
{
    private Reader $reader;
    private Decoder $decoder;
    private Formatter $formatter;

    private ExpressionLanguage $expressionLanguage;

    public function __construct(private Configuration $configuration)
    {
        $this->reader = $configuration->getReader();
        $this->decoder = $configuration->getDecoder();
        $this->formatter = $configuration->getFormatter();

        $this->expressionLanguage = new ExpressionLanguage();
    }

    public function tail(string $filePath, Level $minimumLevel, ?string $channel = null): void
    {
        $this->reader->open($filePath);

        while (!$this->reader->hasReachedEnd()) {
            $logRecord = $this->decoder->decode($this->reader->readLine());

            if ($logRecord->level->isLowerThan($minimumLevel)) {
                continue;
            }

            if (null !== $channel && $logRecord->channel !== strtolower($channel)) {
                continue;
            }

            foreach ($this->configuration->getExclusions() as $exclusion) {
                if ($this->expressionLanguage->evaluate($exclusion, ['log' => $logRecord])) {
                    continue 2;
                }
            }

            foreach ($this->configuration->getReplacements() as $replacementConfiguration) {
                /** @var Replacement $replacement */
                $replacement = isset($replacementConfiguration['type'])
                    ? new $replacementConfiguration['type']($logRecord, $replacementConfiguration)
                    : new BaseReplacement($logRecord, $replacementConfiguration);

                if ($this->expressionLanguage->evaluate($replacement->getWhen(), ['log' => $logRecord])) {
                    $logRecord->message = $replacement->replace();
                }
            }

            echo sprintf("%s\n", $this->formatter->formatLog($logRecord));
        }

        $this->reader->close();
    }
}
