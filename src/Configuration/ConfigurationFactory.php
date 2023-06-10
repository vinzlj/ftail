<?php

declare(strict_types=1);

namespace FTail\Configuration;

use Symfony\Component\Yaml\Yaml;

final class ConfigurationFactory
{
    private const CONFIGURATION_ROOT_KEY = 'ftail';

    public const PLAIN = 'plain';
    public const COLORED = 'colored';

    private const SHIPPED_CONFIGURATIONS = [
        self::PLAIN,
        self::COLORED,
    ];

    public static function listAll(): array
    {
        $configurations = array_merge(
            glob(sprintf('%s/library/*.yaml', self::getConfigurationDirectoryPath())),
            glob(sprintf('%s/*.yaml', self::getConfigurationDirectoryPath())),
        );

        return array_map(static fn (string $file): string => basename($file, '.yaml'), $configurations);
    }

    public static function getConfiguration(string $configurationName): Configuration
    {
        if (in_array($configurationName, self::SHIPPED_CONFIGURATIONS, true)) {
            $configurationPath = sprintf('%s/library/%s.yaml', self::getConfigurationDirectoryPath(), $configurationName);
        } else {
            $configurationPath = sprintf('%s/%s.yaml', self::getConfigurationDirectoryPath(), $configurationName);
        }

        $parsedConfiguration = Yaml::parseFile($configurationPath)[self::CONFIGURATION_ROOT_KEY];

        return new Configuration(
            new $parsedConfiguration['reader'],
            new $parsedConfiguration['decoder'],
            new $parsedConfiguration['formatter'],
            $parsedConfiguration['exclusions'],
            $parsedConfiguration['replacements'],
        );
    }

    private static function getConfigurationDirectoryPath(): string
    {
        return sprintf('%s/config', dirname(__DIR__, 2));
    }
}
