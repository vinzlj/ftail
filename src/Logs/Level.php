<?php

declare(strict_types=1);

namespace FTail\Logs;

final class Level implements \Stringable
{
    public const DEBUG_VALUE = 100;
    public const INFO_VALUE = 200;
    public const NOTICE_VALUE = 250;
    public const WARNING_VALUE = 300;
    public const ERROR_VALUE = 400;
    public const CRITICAL_VALUE = 500;
    public const ALERT_VALUE = 550;
    public const EMERGENCY_VALUE = 600;

    public const DEBUG_NAME = 'debug';
    public const INFO_NAME = 'info';
    public const NOTICE_NAME = 'notice';
    public const WARNING_NAME = 'warning';
    public const ERROR_NAME = 'error';
    public const CRITICAL_NAME = 'critical';
    public const ALERT_NAME = 'alert';
    public const EMERGENCY_NAME = 'emergency';

    public const NAMES = [
        self::DEBUG_NAME,
        self::INFO_NAME,
        self::NOTICE_NAME,
        self::WARNING_NAME,
        self::ERROR_NAME,
        self::CRITICAL_NAME,
        self::ALERT_NAME,
        self::EMERGENCY_NAME,
    ];

    private function __construct(
        public int $value,
        public string $name,
    ) {
    }

    public static function fromName(string $name): self
    {
        return new self(match ($name) {
            'debug', 'Debug', 'DEBUG' => self::DEBUG_VALUE,
            'info', 'Info', 'INFO' => self::INFO_VALUE,
            'notice', 'Notice', 'NOTICE' => self::NOTICE_VALUE,
            'warning', 'Warning', 'WARNING' => self::WARNING_VALUE,
            'error', 'Error', 'ERROR' => self::ERROR_VALUE,
            'critical', 'Critical', 'CRITICAL' => self::CRITICAL_VALUE,
            'alert', 'Alert', 'ALERT' => self::ALERT_VALUE,
            'emergency', 'Emergency', 'EMERGENCY' => self::EMERGENCY_VALUE,
        }, strtolower($name));
    }

    public static function fromValue(int $value): self
    {
        return new self($value, match ($value) {
            self::DEBUG_VALUE => 'debug',
            self::INFO_VALUE => 'info',
            self::NOTICE_VALUE => 'notice',
            self::WARNING_VALUE => 'warning',
            self::ERROR_VALUE => 'error',
            self::CRITICAL_VALUE => 'critical',
            self::ALERT_VALUE => 'alert',
            self::EMERGENCY_VALUE => 'emergency',
        });
    }

    public function includes(self $level): bool
    {
        return $this->value <= $level->value;
    }

    public function isHigherThan(self $level): bool
    {
        return $this->value > $level->value;
    }

    public function isLowerThan(self $level): bool
    {
        return $this->value < $level->value;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
