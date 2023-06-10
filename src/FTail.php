<?php

declare(strict_types=1);

namespace FTail;

use FTail\Formatter\Helper\Color;
use FTail\Configuration\ConfigurationFactory;
use FTail\Logs\Level;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class FTail extends Command
{
    protected static $defaultName = 'ftail';

    private SymfonyStyle $io;

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('log-file-path', InputArgument::OPTIONAL, 'The path to the log file to tail');

        $coloredConfigurations = array_map(
            static fn (string $configurationName): string => Color::lightWhite()->applyTo($configurationName),
            ConfigurationFactory::listAll(),
        );

        $coloredLevels = array_map(
            static fn (string $levelName): string => Color::lightWhite()->applyTo(strtolower($levelName)),
            Level::NAMES,
        );

        $coloredChannels = array_map(
            static fn (string $levelName): string => Color::lightWhite()->applyTo(strtolower($levelName)),
            ['app', 'request', 'doctrine'],
        );

        $this->addOption('config', 'c', InputOption::VALUE_REQUIRED, sprintf("A configuration: %s", implode(', ', $coloredConfigurations)), ConfigurationFactory::COLORED);
        $this->addOption('level', 'l', InputOption::VALUE_REQUIRED, sprintf('A minimum logging level: %s', implode(', ', $coloredLevels)), 'debug');
        $this->addOption('channel', 'cn', InputOption::VALUE_REQUIRED, sprintf('A specific logging channel, like: %s', implode(', ', $coloredChannels)));
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $logFilePath = $input->getArgument('log-file-path');

        if (null !== $logFilePath && !is_file($logFilePath)) {
            $this->io->error(sprintf('Cannot open file: %s', $logFilePath));

            return self::INVALID;
        }

        $formatter = ConfigurationFactory::getConfiguration($input->getOption('config'));

        $level = $input->getOption('level');

        if (null !== $level && !in_array($level, Level::NAMES, true)) {
            $this->io->error(sprintf('Invalid level: %s', $level));

            return self::INVALID;
        }

        $channel = $input->getOption('channel');

        $logReader = new Tailer($formatter);
        $logReader->tail($logFilePath, Level::fromName($level), $channel);

        return self::SUCCESS;
    }
}
