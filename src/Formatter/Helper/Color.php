<?php

declare(strict_types=1);

namespace FTail\Formatter\Helper;

final class Color
{
    public const RESET = "\033[0m";
    public const BLACK = "\033[0;30m";
    public const RED = "\033[0;31m";
    public const GREEN = "\033[0;32m";
    public const YELLOW = "\033[0;33m";
    public const BLUE = "\033[0;34m";
    public const MAGENTA = "\033[0;35m";
    public const CYAN = "\033[0;36m";
    public const WHITE = "\033[0;37m";
    public const LIGHT_BLACK = "\033[1;30m";
    public const LIGHT_RED = "\033[1;31m";
    public const LIGHT_GREEN = "\033[1;32m";
    public const LIGHT_YELLOW = "\033[1;33m";
    public const LIGHT_BLUE = "\033[1;34m";
    public const LIGHT_MAGENTA = "\033[1;35m";
    public const LIGHT_CYAN = "\033[1;36m";
    public const LIGHT_WHITE = "\033[1;37m";

    private function __construct(private string $color)
    {
    }

    public function applyTo(string $text): string
    {
        return $this->color . $text . self::RESET;
    }

    /**
     * @example Color::lightMagenta()->applyWithRegex('/"(.*)"/', '"$1"', $record->message)
     *
     * `foo "bar" foo` becomes `foo "(colored)bar(/colored)" foo`
     */
    public function applyWithRegex(string $regex, string $replacement, string $text): string
    {
        return preg_replace($regex, str_replace('$1', $this->applyTo('$1'), $replacement), $text);
    }

    public static function fromString(string $color): self
    {
        return new self($color);
    }

    public static function fromName(string $name): self
    {
        return new self(match ($name) {
            'black' => self::BLACK,
            'red' => self::RED,
            'green' => self::GREEN,
            'yellow' => self::YELLOW,
            'blue' => self::BLUE,
            'magenta' => self::MAGENTA,
            'cyan' => self::CYAN,
            'white' => self::WHITE,
            'lightBlack' => self::LIGHT_BLACK,
            'lightRed' => self::LIGHT_RED,
            'lightGreen' => self::LIGHT_GREEN,
            'lightYellow' => self::LIGHT_YELLOW,
            'lightBlue' => self::LIGHT_BLUE,
            'lightMagenta' => self::LIGHT_MAGENTA,
            'lightCyan' => self::LIGHT_CYAN,
            'lightWhite' => self::LIGHT_WHITE,
        });
    }

    public static function black(): self
    {
        return new self(self::BLACK);
    }

    public static function red(): self
    {
        return new self(self::RED);
    }

    public static function green(): self
    {
        return new self(self::GREEN);
    }

    public static function yellow(): self
    {
        return new self(self::YELLOW);
    }

    public static function blue(): self
    {
        return new self(self::BLUE);
    }

    public static function magenta(): self
    {
        return new self(self::MAGENTA);
    }

    public static function cyan(): self
    {
        return new self(self::CYAN);
    }

    public static function white(): self
    {
        return new self(self::WHITE);
    }

    public static function lightBlack(): self
    {
        return new self(self::LIGHT_BLACK);
    }

    public static function lightRed(): self
    {
        return new self(self::LIGHT_RED);
    }

    public static function lightGreen(): self
    {
        return new self(self::LIGHT_GREEN);
    }

    public static function lightYellow(): self
    {
        return new self(self::LIGHT_YELLOW);
    }

    public static function lightBlue(): self
    {
        return new self(self::LIGHT_BLUE);
    }

    public static function lightMagenta(): self
    {
        return new self(self::LIGHT_MAGENTA);
    }

    public static function lightCyan(): self
    {
        return new self(self::LIGHT_CYAN);
    }

    public static function lightWhite(): self
    {
        return new self(self::LIGHT_WHITE);
    }
}
